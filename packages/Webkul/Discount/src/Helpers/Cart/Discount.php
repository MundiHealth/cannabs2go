<?php

namespace Webkul\Discount\Helpers\Cart;

use Webkul\Discount\Repositories\CartRuleRepository as CartRule;
use Webkul\Checkout\Repositories\CartItemRepository as CartItem;
use Webkul\Discount\Repositories\CartRuleCartRepository as CartRuleCart;
use Carbon\Carbon;
use Cart;
use Webkul\Sales\Models\Order;

abstract class Discount
{
    /**
     * To hold the cart rule repository instance
     */
    protected $cartRule;

    /**
     * To hold the cart rule cart repository instance
     */
    protected $cartRuleCart;

    /**
     * To hold if end rules are present or not.
     */
    protected $endRuleActive = false;

    /**
     * To hold the rule classes
     */
    protected $rules;

    /**
     * To hold the cartitem repository instance
     */
    protected $cartItem;

    /**
     * To set the percentage columns or not
     */
    protected $setPercentages;

    public function __construct(
        CartRule $cartRule,
        CartRuleCart $cartRuleCart,
        CartItem $cartItem
    )
    {
        $this->cartRule = $cartRule;

        $this->cartRuleCart = $cartRuleCart;

        $this->cartItem = $cartItem;

        $this->rules = config('discount-rules');
    }

    /**
     * Abstract method apply
     */
    abstract public function apply($code);

    /**
     * To find all the suitable rules that can be applied on the current cart
     *
     * @return collection $rules
     */
    public function getApplicableRules($code = null)
    {
        $rules = collect();

        if ($code != null) {
            $eligibleRules = $this->cartRule->findWhere(['use_coupon' => 1, 'status' => 1]);

            foreach($eligibleRules as $rule) {
                if ($rule->coupons->code == $code) {
                    $rules->push($rule);

                    break;
                }
            }
        } else {
            $rules = $this->cartRule->findWhere(['use_coupon' => 0, 'status' => 1]);
        }

        $filteredRules = collect();

        // time based constraints
        foreach ($rules as $rule) {
            if ($this->checkApplicability($rule)) {
                if ($rule->starts_from != null && $rule->ends_till == null) {
                    if (Carbon::parse($rule->starts_from) < now()) {
                        $rule->impact = $this->calculateImpact($rule);

                        $filteredRules->push($rule);
                    }
                } else if ($rule->starts_from == null && $rule->ends_till != null) {
                    if (Carbon::parse($rule->ends_till) > now()) {
                        $rule->impact = $this->calculateImpact($rule);

                        $filteredRules->push($rule);
                    }
                } else if ($rule->starts_from != null && $rule->ends_till != null) {
                    if (Carbon::parse($rule->starts_from) < now() && now() < Carbon::parse($rule->ends_till)) {
                        $rule->impact = $this->calculateImpact($rule);

                        $filteredRules->push($rule);
                    }
                } else {
                    $rule->impact = $this->calculateImpact($rule);

                    $filteredRules->push($rule);
                }
            }
        }

        return $filteredRules;
    }

    /**
     * To find that one rule that is going to be applied on the current cart
     *
     * @param Collection $rules
     *
     * @return CartRule $rule
     */
    public function breakTie($rules)
    {
        $result = $this->sortByLeastPriority($rules);

        if (count($result) > 1) {
            // check for max impact criteria
            if (count($result) > 1) {
                $result = $this->findMaxImpact($result);

                if (count($result) > 1) {
                    $result = $this->findOldestRule($result);

                    return $result;
                } else if (count($result) == 1) {
                    return $result->first();
                } else {
                    return collect();
                }
            } else if (count($result) == 1) {
                return $result->first();
            } else {
                return collect();
            }
        } else if (count($result) == 1) {
            return $result->first();
        } else {
            return collect();
        }

        return collect();
    }

    /**
     * To find the oldes rule
     *
     * @param Collection $rules
     *
     * @return CartRule $oldestRule
     */
    public function findOldestRule($rules)
    {
        $leastID = 999999999999;

        foreach ($rules as $index => $rule) {
            if ($rule->id < $leastID) {
                $leastID = $rule->id;
                $oldestRule = $rule;
            }
        }

        return $oldestRule;
    }

    /**
     * To sort the rules by the least priority
     *
     * @param Collection $rules
     *
     * @return Collection $rule
     */
    public function sortByLeastPriority($rules)
    {
        $sortedRules = collect();

        $minPriority = $rules->min('priority');

        foreach ($rules as $rule) {
            if ($rule->priority == $minPriority)
                $sortedRules->push($rule);
        }

        return $sortedRules;
    }

    /**
     * To check where rule ends other rules
     *
     * @param CartRule $rule
     *
     * @return $rule
     */
    public function isEndRule($rule)
    {
        if ($rule->end_other_rules) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * To find whether rule can be applied or not
     *
     * @param CartRule $rule
     *
     * @return boolean
     */
    public function canApply($rule)
    {
        $cart = \Cart::getCart();

        $alreadyApplied = $this->cartRuleCart->findWhere(['cart_id' => $cart->id]);

        if ($alreadyApplied->count() && $alreadyApplied->first()->cart_rule->id == $rule->id) {
            if ($this->validateRule($alreadyApplied->first()->cart_rule)) {
                $this->reassess($alreadyApplied->first()->cart_rule, $cart);

                return false;
            } else {
                $this->clearDiscount();

                return true;
            }
        } else if ($alreadyApplied->count() && $alreadyApplied->first()->cart_rule->id != $rule->id && ! $alreadyApplied->first()->cart_rule->end_other_rules) {
            if ($rule->use_coupon) {
                if ($alreadyApplied->first()->cart_rule->use_coupon) {
                    $rules = collect();

                    $alreadyAppliedRule = $alreadyApplied->first()->cart_rule;
                    $alreadyAppliedRule->impact = $this->calculateImpact($alreadyAppliedRule);

                    $rule->impact = $this->calculateImpact($alreadyAppliedRule);

                    $rules->push($alreadyAppliedRule);
                    $rules->push($rule);

                    $result = $this->breakTie($rules);

                    if ($result->id == $rule->id) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                // this case will work when non couponable rule is applied and another non couponable rule is created
                // again break tie
                $rules = collect();

                $alreadyAppliedRule = $alreadyApplied->first()->cart_rule;
                $alreadyAppliedRule->impact = $this->calculateImpact($alreadyAppliedRule);

                $rule->impact = $this->calculateImpact($alreadyAppliedRule);

                $rules->push($alreadyAppliedRule);
                $rules->push($rule);

                $result = $this->breakTie($rules);

                if ($result) {
                    if ($result->id != $rule->id) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        } else {
            return true;
        }
    }

    /**
     * To reassess the discount in case no. of items gets changed
     *
     * @return Void
     */
    public function reassess($rule)
    {
        $rule->impact = $this->calculateImpact($rule);

        $this->updateCartItemAndCart($rule);

        return $rule;
    }

    /**
     * To return cart rule which has the max impact
     *
     * @param Collection $rules
     *
     * @return Collection $rule
     */
    public function findMaxImpact($rules)
    {
        $maxImpact = collect();

        $maxDiscount = 0;

        if ($rules->count()) {
            $maxDiscount = $rules->max('impact.discount');

            foreach ($rules as $rule) {
                if ($rule->impact->discount == $maxDiscount)
                    $maxImpact = $maxImpact->push($rule);
            }
        } else {
            return collect();
        }

        return $maxImpact;
    }

    /**
     * To calculate the impact of the rule
     *
     * @return collection
     */
    public function calculateImpact($rule)
    {
        $impact = $this->getActionInstance($rule);

        $outcome = $impact->calculate($rule);

        return $outcome;
    }

    /**
     * Return the instance of the related rule's action type
     *
     * @param CartRule $rule
     *
     * @return Object
     */
    public function getActionInstance($rule)
    {
        $this->rules = config('discount-rules');

        $actionType = new $this->rules['cart'][$rule->action_type]($rule);

        return $actionType;
    }

    /**
     * Checks whether rules is getting applied on current cart instance or not
     *
     * @param CartRule $rule
     *
     * @return Boolean
     */
    public function checkApplicability($rule)
    {
        $cart = \Cart::getCart();

        $timeBased = false;

        $channelBased = false;

        // time based constraints
        if ($rule->starts_from != null && $rule->ends_till == null) {
            if (Carbon::parse($rule->starts_from) < now())
                $timeBased = true;
        } else if ($rule->starts_from == null && $rule->ends_till != null) {
            if (Carbon::parse($rule->ends_till) > now())
                $timeBased = true;
        } else if ($rule->starts_from != null && $rule->ends_till != null) {
            if (Carbon::parse($rule->starts_from) < now() && now() < Carbon::parse($rule->ends_till))
                $timeBased = true;
        } else {
            $timeBased = true;
        }

        // channel based constraints
        foreach ($rule->channels as $channel) {
            if ($channel->channel_id == core()->getCurrentChannel()->id)
                $channelBased = true;
        }

        $customerGroupBased = false;

        // customer groups based constraints
        if (auth()->guard('customer')->check()) {
            foreach ($rule->customer_groups as $customer_group) {
                if (auth()->guard('customer')->user()->group->exists()) {
                    if ($customer_group->customer_group_id == auth()->guard('customer')->user()->group->id)
                        $customerGroupBased = true;
                }
            }
        } else {
            foreach ($rule->customer_groups as $customer_group) {
                if ($customer_group->customer_group->code == 'guest')
                    $customerGroupBased = true;
            }
        }

        if ($cart->coupon_code && $rule->per_customer > 0) {
            $customerOrdersUsage = Order::where('coupon_code', $cart->coupon_code)
                //->whereNotIn('status', ['canceled'])
                ->where('customer_id', $cart->customer_id)
                ->count();

            if ($customerOrdersUsage >= $rule->per_customer)
                return false;

        }

        if ($cart->coupon_code && $rule->usage_limit > 0) {
            $ordersUsage = Order::where('coupon_code', $cart->coupon_code)
                //->whereNotIn('status', ['canceled'])
                ->count();

            if ($ordersUsage >= $rule->usage_limit)
                return false;
        }

        $conditionsBased = true;

        //check conditions
        if ($rule->conditions != null) {
            $conditions = json_decode(json_decode($rule->conditions));

            $test_mode = array_last($conditions);

            if ($test_mode->criteria == 'any_is_true')
                $conditionsBased = $this->testIfAnyConditionIsTrue($conditions, $cart);

            if ($test_mode->criteria == 'all_are_true')
                $conditionsBased = $this->testIfAllConditionAreTrue($conditions, $cart);
        }

        $partialMatch = 0;

        if ($rule->uses_attribute_conditions) {
            $productIDs = explode(',', $rule->product_ids);

            foreach ($productIDs as $productID) {
                foreach ($cart->items as $item) {
                    if ($item->product_id == $productID)
                        $partialMatch = 1;
                }

                $childrens = $item->children;

                foreach ($childrens as $children) {
                    if ($children->product_id == $productID)
                        $partialMatch = 1;
                }
            }
        }

        if ($channelBased && $customerGroupBased && $timeBased && $conditionsBased) {
            if ($rule->uses_attribute_conditions == 1 && $partialMatch) {
                return true;
            } else if ($rule->uses_attribute_conditions == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Save the rule in the CartRule for current cart instance
     *
     * @param CartRule $rule
     *
     * @return Boolean
     */
    public function save($rule)
    {
        $cart = \Cart::getCart();

        $alreadyApplied = $this->cartRuleCart->findWhere(['cart_id' => $cart->id]);

        if ($alreadyApplied->count()) {
            $result = $alreadyApplied->first()->update(['cart_rule_id' => $rule->id]);
        } else {
            $result = $this->cartRuleCart->create(['cart_id' => $cart->id, 'cart_rule_id' => $rule->id]);
        }

        return $result ? true : false;
    }

    /**
     * Apply on shipping
     *
     * @param CartRule $apploedRule
     *
     * @param Cart $cart
     *
     * @return void
     */
    public function applyOnShipping($appliedRule, $cart)
    {
        $cart = \Cart::getCart();

        if (isset($cart->selected_shipping_rate)) {
            if ($appliedRule->free_shipping && $cart->selected_shipping_rate->base_price > 0) {
                $cart->selected_shipping_rate->update(['price' => 0, 'base_price' => 0]);
            } else if ($appliedRule->free_shipping == 0 && $appliedRule->apply_to_shipping && $cart->selected_shipping_rate->base_price > 0) {
                $actionType = config('discount-rules')[$appliedRule->action_type];

                if ($appliedRule->apply_to_shipping) {
                    $actionInstance = new $actionType;

                    $discountOnShipping = $actionInstance->calculateOnShipping($cart);

                    $discountOnShipping = ($discountOnShipping / 100) * $cart->selected_shipping_rate->base_price;

                    $cart->selected_shipping_rate->update([
                        'price' => $cart->selected_shipping_rate->price - core()->convertPrice($discountOnShipping, $cart->cart_currency_code),
                        'base_price' => $cart->selected_shipping_rate->base_price - $discountOnShipping
                    ]);
                }
            }
        }
    }

    public function applyOnTax($appliedRule, $cart)
    {
        if (isset($cart->tax_total) && $cart->tax_total > 0) {
            if($appliedRule->action_type == 'whole_cart_to_percent' && $appliedRule->disc_amount >= 100) {
                $cart->update([
                    'tax_total' => 0,
                    'base_tax_total' => 0
                ]);
            }
        }
    }

    /**
     * Resets the shipping for the current items in the cart
     *
     * @param Cart $cart
     *
     * @return Void
     */
    public function resetShipping($cart)
    {
        $cart = \Cart::getCart();

        if (isset($cart->selected_shipping_rate->carrier)) {
            $shippingRate = config('carriers')[$cart->selected_shipping_rate->carrier]['class'];

            $actualShippingRate = new $shippingRate;
            $actualShippingRate = $actualShippingRate->calculate();

            if (is_array($actualShippingRate)) {
                foreach($actualShippingRate as $actualRate) {
                    if ($actualRate->method == $cart->selected_shipping_rate->method) {
                        $actualShippingRate = $actualRate;

                        break;
                    }
                }
            }

            $actualShippingPrice = $actualShippingRate->price;
            $actualShippingBasePrice = $actualShippingRate->base_price;
            $cartShippingRate = $cart->selected_shipping_rate;

            $cartShippingRate->update(['price' => $actualShippingPrice, 'base_price' => $actualShippingBasePrice]);
        }
    }

    /**
     * Update discount for least worth item
     *
     * @param CartRule $rule
     *
     * @return Boolean
     */
    public function updateCartItemAndCart($rule)
    {
        $cart = Cart::getCart();

        $itemImpacts = $rule->impact;

        foreach ($itemImpacts as $itemImpact) {
            $item = $this->cartItem->findOneWhere(['id' => $itemImpact['item_id']]);

            if (isset($itemImpact['child_items']) && $itemImpact['child_items']->count()) {
                $totalItemDiscount = 0.0000;

                foreach ($itemImpact['child_items'] as $child) {
                    $discount = $child->discount;

                    $totalItemDiscount = $totalItemDiscount + $discount;

                    unset($child->discount);

                    $child->update([
                        'discount_amount' => core()->convertPrice($discount, $cart->cart_currency_code),
                        'base_discount_amount' => $discount
                    ]);

                    if ($rule->action_type == 'percent_of_product') {
                        $child->update(['discount_percent' => $rule->discount_amount]);
                    }

                    if ($rule->use_coupon) {
                        $coupon = $rule->coupons->code;

                        $child->update(['coupon_code' => $coupon]);
                    }

                    $this->updateParent($child, $totalItemDiscount, $cartCurrencyCode = $cart->cart_currency_code);
                }
            } else {
                $item->update([
                    'discount_amount' => core()->convertPrice($itemImpact['discount'], $cart->cart_currency_code),
                    'base_discount_amount' => $itemImpact['discount']
                ]);

                if ($rule->action_type == 'percent_of_product') {
                    $item->update(['discount_percent' => $rule->discount_amount]);
                }

                if ($rule->use_coupon) {
                    $coupon = $rule->coupons->code;

                    $item->update(['coupon_code' => $coupon]);
                }
            }
        }

        if ($rule->use_coupon) {
            $cart->update(['coupon_code' => $rule->coupons->code]);
        }

         if ($rule->free_shipping || $rule->apply_on_shipping) {
             $this->applyOnShipping($rule, $cart);
         }

         $this->applyOnTax($rule, $cart);

        Cart::collectTotals();

        return true;
    }

    /**
     * To update the discount on parent CartItem
     */
    private function updateParent($item, $discount, $currencyCode)
    {
        $parentItem = $this->cartItem->findOneWhere(['id' => $item->parent_id]);

        $parentItem->update([
            'base_discount_amount' => $discount,
            'discount_amount' => core()->convertPrice($discount, $currencyCode)
        ]);
    }

    /**
     * Removes any cart rule from the current cart instance
     *
     * @return Boolean
     */
    public function clearDiscount()
    {
        $cart = Cart::getCart();

        $cartItems = $cart->items;

        // remove all the discount properties from items
        foreach ($cartItems as $item) {
            $item->update([
                'coupon_code' => NULL,
                'discount_percent' => 0,
                'discount_amount' => 0,
                'base_discount_amount' => 0
            ]);
        }

        // remove all the discount properties from cart
        $cart->update([
            'coupon_code' => NULL,
            'discount_amount' => 0,
            'base_discount_amount' => 0
        ]);

        // find & remove cart rule from cart rule cart resource
        $cartRuleCart = $this->cartRuleCart->findWhere(['cart_id' => $cart->id]);

        $cartRuleCart->first()->delete();

        return true;
    }

    /**
     * Validate the currently applied cart rule
     *
     * @param CartRule $rule
     *
     * @return Boolean
     */
    public function validateRule($rule)
    {
        $applicability = $this->checkApplicability($rule);

        if ($applicability && $rule->status) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Will validate already applied rule
     *
     * @return Void
     */
    public function validateIfAlreadyApplied()
    {
        $cart = \Cart::getCart();

        $alreadyAppliedRule = $this->cartRuleCart->findWhere(['cart_id' => $cart->id]);

        if ($alreadyAppliedRule->count()) {
            $alreadyAppliedCartRule = $alreadyAppliedRule->first()->cart_rule;

            $result = $this->validateRule($alreadyAppliedCartRule);

            if (! $result) {
                $this->clearDiscount();

                $alreadyAppliedRule->first()->delete();
            } else {
                $this->reassess($alreadyAppliedCartRule);
            }
        }
    }

    /**
     * Retreives all the payment methods from application config
     *
     * @return Array
     */
    public function getPaymentMethods()
    {
        $paymentMethods = config('paymentmethods');

        return $paymentMethods;
    }

    /**
     * Retreives all the shippin methods from the application config
     *
     * @return array
     */
    public function getShippingMethods()
    {
        $shippingMethods = config('carriers');

        return $shippingMethods;
    }

    /**
     * Checks the rule against the current cart instance whether rule conditions are applicable
     * or not
     *
     * @param Array $conditions
     *
     * @param Cart $cart
     *
     * @return Boolean
     */
    protected function testIfAllConditionAreTrue($conditions, $cart)
    {
        $paymentMethods = $this->getPaymentMethods();

        $shippingMethods = $this->getShippingMethods();

        array_pop($conditions);

        $shipping_address = $cart->getShippingAddressAttribute() ?? null;

        $shipping_method = $cart->selected_shipping_rate->method_title ?? null;

        $shipping_country = $shipping_address->country ?? null;

        $shipping_state = $shipping_address->state ?? null;

        $shipping_postcode = $shipping_address->postcode ?? null;

        $shipping_city = $shipping_address->city ?? null;

        $payment_method = isset($cart->payment) ? $paymentMethods[$cart->payment->method]['title'] : null;

        $sub_total = $cart->base_sub_total;

        $total_items = $cart->items_qty;

        $total_weight = 0;

        foreach ($cart->items as $item) {
            $total_weight = $total_weight + $item->base_total_weight;
        }

        $result = true;

        foreach ($conditions as $condition) {
            $result = true;

            if (! isset($condition->attribute) || ! isset($condition->condition) || ! isset($condition->value) || ! isset($condition->type) || ! $condition->value != []) {
                $result = false;

                continue;
            }

            if (isset($condition->attribute)) {
                $actual_value = ${$condition->attribute};
            } else {
                $result = false;
            }

            if (isset($condition->value)) {
                $test_value = $condition->value;

            } else {
                $result = false;
            }

            if (isset($condition->condition)) {
                $test_condition = $condition->condition;
            }
            else {
                $result = false;
            }

            if ($condition->type == 'string') {
                $actual_value = strtolower($actual_value);

                $test_value = strtolower($test_value);
            }

            if ($test_condition == '=') {
                if ($actual_value != $test_value) {
                    $result = false;

                    break;
                }
            } else if ($test_condition == '>=') {
                if (! ($actual_value >= $test_value)) {
                    $result = false;

                    break;
                }
            } else if ($test_condition == '<=') {
                if (! ($actual_value <= $test_value)) {
                    $result = false;

                    break;
                }
            } else if ($test_condition == '>') {
                if (! ($actual_value > $test_value)) {
                    $result = false;

                    break;
                }
            } else if ($test_condition == '<') {
                if (! ($actual_value < $test_value)) {
                    $result = false;

                    break;
                }
            } else if ($test_condition == '{}') {
                if (! str_contains($actual_value, $test_value)) {
                    $result = false;

                    break;
                }
            } else if ($test_condition == '!{}') {
                if (str_contains($actual_value, $test_value)) {
                    $result = false;

                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Checks the rule against the current cart instance whether rule conditions are applicable
     * or not
     *
     * @param Array $conditions
     *
     * @param Cart $cart
     *
     * @return Boolean
     */
    protected function testIfAnyConditionIsTrue($conditions, $cart)
    {
        $paymentMethods = $this->getPaymentMethods();

        $shippingMethods = $this->getShippingMethods();

        array_pop($conditions);

        $result = false;

        $shipping_address = $cart->getShippingAddressAttribute() ?? null;

        $shipping_method = $cart->selected_shipping_rate->method_title ?? null;

        $shipping_country = $shipping_address->country ?? null;

        $shipping_state = $shipping_address->state ?? null;

        $shipping_postcode = $shipping_address->postcode ?? null;

        $shipping_city = $shipping_address->city ?? null;

        $payment_method = isset($cart->payment) ? $paymentMethods[$cart->payment->method]['title'] : null;

        $sub_total = $cart->base_sub_total;

        $total_items = $cart->items_qty;

        $total_weight = 0;

        foreach($cart->items as $item) {
            $total_weight = $total_weight + $item->base_total_weight;
        }

        foreach ($conditions as $condition) {
            if (! isset($condition->attribute) || ! isset($condition->condition) || ! isset($condition->value)) {
                continue;
            }

            if (isset($condition->attribute)) {
                $actual_value = ${$condition->attribute};
            } else {
                $result = false;
            }

            if (isset($condition->value)) {
                $test_value = $condition->value;
            } else {
                $result = false;
            }

            if (isset($condition->condition)) {
                $test_condition = $condition->condition;
            } else {
                $result = false;
            }

            if ($condition->type == 'numeric' || $condition->type == 'string' || $condition->type == 'text') {
                if ($condition->type == 'string') {
                    $actual_value = strtolower($actual_value);

                    $test_value = strtolower($test_value);
                }

                if ($test_condition == '=') {
                    if ($actual_value == $test_value) {
                        $result = true;

                        break;
                    }
                } else if ($test_condition == '>=') {
                    if ($actual_value >= $test_value) {
                        $result = true;

                        break;
                    }
                } else if ($test_condition == '<=') {
                    if ($actual_value <= $test_value) {
                        $result = true;

                        break;
                    }
                } else if ($test_condition == '>') {
                    if ($actual_value > $test_value) {
                        $result = true;

                        break;
                    }
                } else if ($test_condition == '<') {
                    if ($actual_value < $test_value) {
                        $result = true;

                        break;
                    }
                } else if ($test_condition == '{}') {
                    if (str_contains($actual_value, $test_value)) {
                        $result = true;

                        break;
                    }
                } else if ($test_condition == '!{}') {
                    if (! str_contains($actual_value, $test_value)) {
                        $result = true;

                        break;
                    }
                }
            }
        }

        return $result;
    }
}
<?php

namespace Webkul\Discount\Actions\Cart;

use Webkul\Discount\Actions\Cart\Action;

class FixedAmount extends Action
{
    public function __construct($rule)
    {
        $this->rule = $rule;
    }

    public function calculate($rule)
    {
        $impact = collect();

        $rule->disc_amount = core()->convertToBasePrice($rule->disc_amount, '');

        $totalDiscount = 0;

        if ($this->checkApplicability()) {
            $eligibleItems = $this->getEligibleItems();

            foreach ($eligibleItems as $key => $item) {
                $report = array();

                $report['item_id'] = $item->id;
                $report['child_items'] = collect();


                $itemPrice = $item->base_price;

                $itemQuantity = $item->quantity;

                $discQuantity = $rule->disc_quantity;
                $discQuantity = $itemQuantity <= $discQuantity ? $itemQuantity : $discQuantity;
                $perItemDiscount = $rule->disc_amount / $discQuantity;

                if ($item->product->getTypeInstance()->isComposite()) {
                    $isQtyZero = true;

                    foreach ($item->children as $children) {
                        if ($children->quantity > 0)
                            $isQtyZero = false;
                    }

                    if ($isQtyZero) {
                        // case for configurable products
                        $report['product_id'] = $item->children->first()->product_id;
                    } else {
                        // composites other than configurable
                        $report['product_id'] = $item->product_id;

                        foreach ($item->children as $children) {
                            $childBaseTotal = $children->base_total;

                            $itemDiscount = $childBaseTotal / ($item->base_total / 100);

                            $children->discount = ($itemDiscount / 100) * $perItemDiscount;

                            $children->discount = $children->base_total > $children->discount ? $children->discount : $children->base_total;

                            $report['child_items']->push($children);
                        }
                    }
                } else {
                    $report['product_id'] = $item->product_id;
                }

                $discount = $perItemDiscount * $itemQuantity;
                $discount = $discount <= $itemPrice * $itemQuantity ? $discount : $itemPrice * $itemQuantity;

                if ($rule->disc_amount > 0)
                    $rule->disc_amount -= $discount;

                $report['discount'] = $discount;
                $report['formatted_discount'] = core()->currency($discount);

                $impact->push($report);

                $totalDiscount = $totalDiscount + $discount;

                unset($report);
            }
        }

        $impact->discount = $totalDiscount;
        $impact->formatted_discount = core()->currency($impact->discount);

        return $impact;
    }
}
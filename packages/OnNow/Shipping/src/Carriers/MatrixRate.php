<?php


namespace OnNow\Shipping\Carriers;


use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Core\Repositories\ExchangeRateRepository;
use Webkul\Customer\Models\CustomerAddress;
use Webkul\Shipping\Carriers\AbstractShipping;
use OnNow\Shipping\Models\MatrixRate as MatrixRateModel;

class MatrixRate extends AbstractShipping
{

    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'matrixrate';

    /**
     * Returns rate for flatrate
     *
     * @return array
     */
    public function calculate($zipcode = false)
    {
        if (!$zipcode && request()->has('zipcode')){
            $zipcode = request('zipcode');
        }

        if (!$zipcode && request()->has('billing')){
            $billing = request('billing');
            if (isset($billing['postcode']))
                $zipcode = $billing['postcode'];
        }

        if (!$zipcode && request()->has('shipping.postcode')){
            $zipcode = request('shipping.postcode');
        }

        if (!$zipcode && request()->has('billing.address_id')){
            $address = CustomerAddress::find(request()->has('billing.address_id'));
            $zipcode = $address->postcode;
        }

        if (!$zipcode && request()->has('shipping.address_id')){
            $address = CustomerAddress::find(request()->has('shipping.address_id'));
            $zipcode = $address->postcode;
        }

        $zipcode = str_replace('-', '', $zipcode);

        if (! $this->isAvailable())
            return false;

        $cart = Cart::getCart();

        $matrixrate = MatrixRateModel::select('*')
            ->where('zip_code_from', '<=', $zipcode)
            ->where('zip_code_to', '>=', $zipcode)
            ->first();

        $object = new CartShippingRate;

        $object->carrier = $this->code;
        $object->carrier_title = $this->getConfigData('title');
        $object->method = 'matrixrate_matrixrate';
        $object->method_title = $this->getConfigData('title');
        $object->method_description = $matrixrate->description;
        $object->price = $matrixrate->value;
        $object->base_price = $matrixrate->value;

        $currentCurrency = core()->getCurrentCurrency();
        $exchangeRateRepository = app(ExchangeRateRepository::class);

        $exchangeRate = $exchangeRateRepository->findOneWhere([
            'target_currency' => $currentCurrency->id,
        ]);

        /**
         * Após crise remover essa linha
         */
        $object->price = $object->base_price = ($object->price / $exchangeRate->rate) * 4.5;

        if (core()->getConfigData('sales.orderSettings.freeShipping.active')){
            $amountFreeShipping = core()->getConfigData('sales.orderSettings.freeShipping.value') / $exchangeRate->rate;

            if ($cart->base_sub_total > $amountFreeShipping){
                $object->price = 0;
                $object->base_price = 0;
            }
        }

        return $object;
    }

}
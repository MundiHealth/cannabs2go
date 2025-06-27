<?php

namespace Webkul\Shipping\Carriers;

use Config;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Core\Repositories\ExchangeRateRepository;
use Webkul\Shipping\Facades\Shipping;
use Webkul\Checkout\Facades\Cart;

/**
 * Class Rate.
 *
 */
class FlatRate extends AbstractShipping
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'flatrate';

    /**
     * Returns rate for flatrate
     *
     * @return array
     */
    public function calculate()
    {
        if (! $this->isAvailable())
            return false;

        $cart = Cart::getCart();

        $object = new CartShippingRate;

        $object->carrier = 'flatrate';
        $object->carrier_title = $this->getConfigData('title');
        $object->method = 'flatrate_flatrate';
        $object->method_title = $this->getConfigData('title');
        $object->method_description = $this->getConfigData('description');
        $object->price = 0;
        $object->base_price = 0;

        $currentCurrency = core()->getCurrentCurrency();
        $exchangeRateRepository = app(ExchangeRateRepository::class);

        $exchangeRate = $exchangeRateRepository->findOneWhere([
            'target_currency' => $currentCurrency->id,
        ]);

        if ($this->getConfigData('type') == 'per_unit') {
            foreach ($cart->items as $item) {
                if ($item->product->getTypeInstance()->isStockable()) {
                    //$object->price += core()->convertPrice($this->getConfigData('default_rate')) * $item->quantity;
                    //$object->base_price += $this->getConfigData('default_rate') * $item->quantity;
                    $object->price = $object->base_price = ($this->getConfigData('default_rate') / $exchangeRate->rate)  * $item->quantity;
                }
            }
        } else {
            //$object->price = core()->convertPrice($this->getConfigData('default_rate'));
            //$object->base_price = $this->getConfigData('default_rate');

            if ($cart->channel_id == 10 && $cart->items->whereIn('sku', ['ell10', 'ell11', 'ell12'])->count() > 0) {
                $object->price = $object->base_price = 0;
            } else {
                $object->price = $object->base_price = ($this->getConfigData('default_rate') / $exchangeRate->rate);
            }
        }

        return $object;
    }
}
<?php


namespace OnNow\OneStepCheckout\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Webkul\Checkout\Facades\Cart;

class ShippingController extends \Illuminate\Routing\Controller
{

    protected $rates = [];

    public function estimate(Request $request)
    {
        if (! $cart = Cart::getCart())
            return false;


        foreach (Config::get('carriers') as $shippingMethod) {
            $object = new $shippingMethod['class'];

            if ($rates = $object->calculate()) {
                if (is_array($rates)) {
                    $this->rates = array_merge($this->rates, $rates);
                } else {
                    $rates->price = core()->currency($rates->price);
                    $this->rates[] = $rates;
                }
            }
        }

        return $this->rates;

    }

}
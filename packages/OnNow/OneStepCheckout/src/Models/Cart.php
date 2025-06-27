<?php


namespace OnNow\OneStepCheckout\Models;

use Webkul\Checkout\Models\Cart as CartBaseModel;
use Webkul\Core\Repositories\ExchangeRateRepository;

class Cart extends CartBaseModel
{

    public static function disclaimerFreeShipping()
    {

        if (!core()->getConfigData('sales.orderSettings.freeShipping.active'))
            return false;

        $currentCurrency = core()->getCurrentCurrency();
        $exchangeRateRepository = app(ExchangeRateRepository::class);

        $exchangeRate = $exchangeRateRepository->findOneWhere([
            'target_currency' => $currentCurrency->id,
        ]);

        $amountFreeShipping = core()->getConfigData('sales.orderSettings.freeShipping.value') / $exchangeRate->rate;
        $amountFreeShipping = $amountFreeShipping - cart()->getCart()->base_sub_total;

        if($amountFreeShipping < 0)
            return false;

        return $amountFreeShipping;
    }

}
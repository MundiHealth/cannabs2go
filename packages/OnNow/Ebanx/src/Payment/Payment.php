<?php

namespace OnNow\Ebanx\Payment;

use OnNow\Ebanx\Services\Ebanx;
use \Webkul\Payment\Payment\Payment as PaymentBase;

class Payment extends PaymentBase
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code = 'ebanx';

    public function getRedirectUrl()
    {
        return route('ebanx.redirect');
    }

    /**
     * Checks if payment method is available
     *
     * @return array
     */
    public function isAvailable()
    {
        return $this->getConfigData('sales.paymentmethods.primeiropay.active');
    }

}
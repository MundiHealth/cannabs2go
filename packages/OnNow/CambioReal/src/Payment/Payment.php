<?php

namespace OnNow\CambioReal\Payment;

use \Webkul\Payment\Payment\Payment as PaymentBase;
class Payment extends PaymentBase
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code = 'cambioreal';

    public function getRedirectUrl()
    {
        return route('cambioreal.redirect');
    }
}
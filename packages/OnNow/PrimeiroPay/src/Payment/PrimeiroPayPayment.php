<?php


namespace OnNow\PrimeiroPay\Payment;


use OnNow\PrimeiroPay\Services\PaymentService;
use Webkul\Payment\Payment\Payment;

class PrimeiroPayPayment extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code = 'primeiropay';

    public function getRedirectUrl()
    {
        return route('primeirpay.redirect');
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
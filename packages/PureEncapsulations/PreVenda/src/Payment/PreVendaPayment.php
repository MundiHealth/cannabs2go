<?php


namespace PureEncapsulations\PreVenda\Payment;


use Webkul\Checkout\Facades\Cart;
use Webkul\Payment\Payment\Payment;

class PreVendaPayment extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code = 'code';

    public function getRedirectUrl(){

    }

}
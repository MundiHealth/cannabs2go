<?php

namespace OnNow\Ebanx\Models;

class OrderPayment extends \Webkul\Sales\Models\OrderPayment
{

    protected $fillable = ['ext_transaction_code'];

}
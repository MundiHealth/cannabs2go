<?php

namespace OnNow\CambioReal\Models;

class OrderPayment extends \Webkul\Sales\Models\OrderPayment
{

    protected $fillable = ['ext_transaction_code'];

}
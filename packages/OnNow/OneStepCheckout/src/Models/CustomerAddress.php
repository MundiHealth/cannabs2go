<?php


namespace OnNow\OneStepCheckout\Models;

use Webkul\Customer\Models\CustomerAddress as CustomerAddressBase;

class CustomerAddress extends CustomerAddressBase
{

    protected $fillable = ['customer_id' ,'address1', 'country', 'state', 'city', 'postcode', 'phone', 'default_address', 'taxvat'];

}
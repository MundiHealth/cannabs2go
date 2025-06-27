<?php


namespace OnNow\OneStepCheckout\Models;

use Webkul\Checkout\Models\CartAddress as CartAddressBase;

class CartAddress extends CartAddressBase
{

    protected $fillable = ['first_name', 'last_name', 'email', 'address1', 'city', 'state', 'postcode',  'country', 'phone', 'address_type', 'cart_id', 'taxvat'];

}
<?php


Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {

    //checkout and cart
    //Cart Items(listing)
    Route::get('checkout/cart', 'Webkul\Shop\Http\Controllers\CartController@index')->defaults('_config', [
        'view' => 'shop::checkout.cart.index'
    ])->name('shop.checkout.cart.index');

    Route::post('checkout/check/coupons', 'Webkul\Shop\Http\Controllers\OnepageController@applyCoupon')->name('shop.checkout.check.coupons');

    Route::post('checkout/remove/coupon', 'Webkul\Shop\Http\Controllers\OnepageController@removeCoupon')->name('shop.checkout.remove.coupon');

    //Cart Items Add
    Route::post('checkout/cart/add/{id}', 'OnNow\OneStepCheckout\Http\Controllers\CartController@add')->defaults('_config', [
        'redirect' => 'shop.checkout.cart.index'
    ])->name('cart.add');

    //Cart Items Remove
    Route::get('checkout/cart/remove/{id}', 'Webkul\Shop\Http\Controllers\CartController@remove')->name('cart.remove');

    //Cart Update Before Checkout
    Route::post('/checkout/cart', 'Webkul\Shop\Http\Controllers\CartController@updateBeforeCheckout')->defaults('_config', [
        'redirect' => 'shop.checkout.cart.index'
    ])->name('shop.checkout.cart.update');

    //Cart Items Remove
    Route::get('/checkout/cart/remove/{id}', 'Webkul\Shop\Http\Controllers\CartController@remove')->defaults('_config', [
        'redirect' => 'shop.checkout.cart.index'
    ])->name('shop.checkout.cart.remove');

    //Cart Clear
    Route::get('/checkout/cart/clear', 'OnNow\OneStepCheckout\Http\Controllers\CartController@cartClear')->defaults('_config', [
        'redirect' => 'shop.checkout.cart.index'
    ])->name('shop.checkout.cart.clear');

    //Shipping Estimate
    Route::post('/checkout/shippingEstimate', 'OnNow\OneStepCheckout\Http\Controllers\ShippingController@estimate')->name('osc.checkout.estimate');

    //Checkout Index page
    Route::get('/checkout/onepage', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@index')->defaults('_config', [
        'view' => 'onestepcheckout::checkout.onestepcheckout'
    ])->name('shop.checkout.onepage.index');

    //Checkout Save Order
    Route::get('/checkout/summary', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@summary')->name('shop.checkout.summary');

    //Checkout Save Address Form Store
    Route::post('/checkout/save-address', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@saveAddressCheckout')->name('shop.checkout.save-address');

    //Checkout Save Shipping Address Form Store
    Route::post('/checkout/save-shipping', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@saveShipping')->name('shop.checkout.save-shipping');

    //Checkout Save Payment Method Form
    Route::post('/checkout/save-payment', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@savePayment')->name('shop.checkout.save-payment');

    //Checkout Save Order
    Route::post('/checkout/save-order', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@saveOrder')->name('shop.checkout.save-order');

    //Checkout Save Address Form Store
    Route::get('/checkout/installments', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@getInstallments')->name('shop.checkout.installments');

    //Checkout Order Successfull
    Route::get('/checkout/success', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@success')->defaults('_config', [
        'view' => 'onestepcheckout::checkout.success'
    ])->name('shop.checkout.success');

    //Checkout Order Failure
    Route::get('/checkout/failure', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@failure')->defaults('_config', [
        'view' => 'onestepcheckout::checkout.failure'
    ])->name('shop.checkout.failure');

});
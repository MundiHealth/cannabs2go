<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('primeiropay')->group(function () {

        Route::get('/redirect', 'OnNow\PrimeiroPay\Http\Controllers\PaymentController@callback')->name('primeirpay.redirect');

        Route::get('/success', 'OnNow\PrimeiroPay\Http\Controllers\PaymentController@success')->name('primeirpay.success');

        Route::get('/cancel', 'OnNow\PrimeiroPay\Http\Controllers\PaymentController@cancel')->name('primeirpay.cancel');

        Route::post('/postback', 'OnNow\PrimeiroPay\Http\Controllers\PaymentController@postback')->name('primeirpay.postback');

    });
});
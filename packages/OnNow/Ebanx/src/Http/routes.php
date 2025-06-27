<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('ebanx')->group(function () {

        Route::get('/redirect', 'OnNow\Ebanx\Http\Controllers\PaymentController@callback')->name('ebanx.redirect');

        Route::get('/success', 'OnNow\Ebanx\Http\Controllers\PaymentController@success')->name('ebanx.success');

        Route::get('/cancel', 'OnNow\Ebanx\Http\Controllers\PaymentController@cancel')->name('ebanx.cancel');

        Route::post('/postback', 'OnNow\Ebanx\Http\Controllers\PaymentController@postback')->name('ebanx.postback');

    });
});
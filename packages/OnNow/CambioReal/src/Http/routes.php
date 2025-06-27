<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('cambioreal')->group(function () {

        Route::get('/redirect', 'OnNow\CambioReal\Http\Controllers\PaymentController@callback')->name('cambioreal.redirect');

        Route::get('/success', 'OnNow\CambioReal\Http\Controllers\PaymentController@success')->name('cambioreal.success');

        Route::get('/cancel', 'OnNow\CambioReal\Http\Controllers\PaymentController@cancel')->name('cambioreal.cancel');

        Route::post('/postback', 'OnNow\CambioReal\Http\Controllers\PaymentController@postback')->name('cambioreal.postback');

    });
});

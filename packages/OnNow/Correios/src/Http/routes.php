<?php

Route::post('correios/consultar-cep', 'OnNow\Correios\Http\Controllers\CorreiosController@consultarCep')->name('shop.checkout.address.search');
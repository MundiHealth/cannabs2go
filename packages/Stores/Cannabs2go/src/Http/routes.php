<?php

Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {

//    Route::get('cbd-oil', 'Webkul\Shop\Http\Controllers\ProductController@cannabis_product')
//        ->defaults('_config', [
//            'view' => 'shop::pages.cbd-oil', 'url' => 'cbd-oil'
//        ])->name('cannabis.site.cbd-oil');
//
//    Route::get('cbd-night-oil', 'Webkul\Shop\Http\Controllers\ProductController@cannabis_product')
//        ->defaults('_config', [
//            'view' => 'shop::pages.cbd-night-oil', 'url' => 'cbd-night-oil'
//        ])->name('cannabis.site.cbd-night-oil');
//
//    Route::get('cbd-daily-duo', 'Webkul\Shop\Http\Controllers\ProductController@cannabis_product')
//        ->defaults('_config', [
//            'view' => 'shop::pages.cbd-daily-duo', 'url' => 'cbd-daily-duo'
//        ])->name('cannabis.site.cbd-daily-duo');
//
//    Route::get('cbd-gummies', 'Webkul\Shop\Http\Controllers\ProductController@cannabis_product')
//        ->defaults('_config', [
//            'view' => 'shop::pages.cbd-gummies', 'url' => 'cbd-gummies'
//        ])->name('cannabis.site.cbd-gummies');
//
//    Route::get('cbd-immunity-shot', 'Webkul\Shop\Http\Controllers\ProductController@cannabis_product')
//        ->defaults('_config', [
//            'view' => 'shop::pages.cbd-immunity-shot', 'url' => 'cbd-immunity-shot'
//        ])->name('cannabis.site.cbd-immunity-shot');
//
//    Route::get('educacao', 'PureEncapsulations\Shop\Http\Controllers\HomeController@cannabis_educacao')->defaults('_config', [
//        'view' => 'shop::pages.educacao'
//    ])->name('cannabis.site.educacao');

//    Route::get('mycannabiscode', 'PureEncapsulations\Shop\Http\Controllers\HomeController@cannabis_code')->defaults('_config', [
//        'view' => 'shop::pages.code'
//    ])->name('cannabis.site.code');

    Route::redirect('/mycannabiscode', '/', 301);

    Route::get('faq', 'PureEncapsulations\Shop\Http\Controllers\HomeController@cannabis_faq')->defaults('_config', [
        'view' => 'shop::pages.faq'
    ])->name('cannabis.site.faq');

});
<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('admin')->group(function () {

        // Admin Routes
        Route::group(['middleware' => ['admin']], function () {

            Route::get('xdeasy/purchases', 'OnNow\Xdeasy\Http\Controllers\Purchase\PurchaseController@index')->defaults('_config', [
                'view' => 'xdeasy::xdeasy.index'
            ])->name('admin.xdeasy.index');

            Route::get('xdeasy/pending-items', 'OnNow\Xdeasy\Http\Controllers\Purchase\PurchaseController@pending')->defaults('_config', [
                'view' => 'xdeasy::xdeasy.pending.index'
            ])->name('admin.xdeasy.pendingItems');

            Route::get('xdeasy/picking', 'OnNow\Xdeasy\Http\Controllers\Picking\PickingController@index')->defaults('_config', [
                'view' => 'xdeasy::xdeasy.picking.index'
            ])->name('admin.xdeasy.picking');

            Route::post('xdeasy/picking', 'OnNow\Xdeasy\Http\Controllers\Picking\PickingController@separate')->defaults('_config', [
                'view' => 'xdeasy::xdeasy.picking.index'
            ])->name('admin.xdeasy.picking');

            Route::get('xdeasy/packing', 'OnNow\Xdeasy\Http\Controllers\Packing\PackingController@index')->defaults('_config', [
                'view' => 'xdeasy::xdeasy.packing.index'
            ])->name('admin.xdeasy.packing');

            Route::post('xdeasy/packing', 'OnNow\Xdeasy\Http\Controllers\Packing\PackingController@dispatched')->defaults('_config', [
                'view' => 'xdeasy::xdeasy.packing.index'
            ])->name('admin.xdeasy.packing');

            Route::get('xdeasy/zip', 'OnNow\Xdeasy\Http\Controllers\Packing\PackingController@zip')->name('admin.xdeasy.zip');

            Route::get('xdeasy/mawbGenerate', 'OnNow\Xdeasy\Http\Controllers\Packing\PackingController@mawbGenerate')->name('admin.xdeasy.mawbGenerate');

            Route::get('xdeasy/mawbBringerGenerate', 'OnNow\Xdeasy\Http\Controllers\Packing\PackingController@mawbBringerGenerate')->name('admin.xdeasy.mawbBringerGenerate');

            Route::get('xdeasy/fedex-report', 'OnNow\Xdeasy\Http\Controllers\Packing\PackingController@fedexReport')->defaults('_config', [
                'view' => 'xdeasy::xdeasy.pending.index'
            ])->name('admin.xdeasy.fedex-report');

            Route::get('xdeasy/printHawb/{invoice}', 'OnNow\Xdeasy\Http\Controllers\Hawb\HawbController@print')->name('admin.xdeasy.phx.hawb');

            Route::get('xdeasy/createHawb/{invoice}', 'OnNow\Xdeasy\Http\Controllers\Hawb\HawbController@create')->name('admin.xdeasy.phx.createHawb');

            Route::post('xdeasy/warehouse/import', 'OnNow\Xdeasy\Http\Controllers\Packing\PackingController@warehouseImport')->name('admin.xdeasy.package.warehouseImport');

            Route::post('xdeasy/fedex/import', 'OnNow\Xdeasy\Http\Controllers\Packing\PackingController@fedexTrackingImport')->name('admin.xdeasy.package.fedexTrackingImport');

        });

    });

    Route::prefix('xdeasy')->group(function() {
        Route::get('/documents/zip/{id}', 'OnNow\Xdeasy\Http\Controllers\Packing\PackingController@fedexZipDocuments')->defaults('_config', [
            'view' => 'admin::sales.invoices.zip'
        ])->name('xdeasy.documents.zip');
    });
});
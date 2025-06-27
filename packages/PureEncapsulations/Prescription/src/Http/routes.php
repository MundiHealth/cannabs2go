<?php
Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {

    Route::get('/prescription', 'PureEncapsulations\Prescription\Http\Controllers\PrescriptionController@index')
        ->defaults('_config', [
            'view' => 'prescription::prescription.prescription'
        ])->name('prescription.index');

    Route::post('/prescription','PureEncapsulations\Prescription\Http\Controllers\PrescriptionController@store')
        ->defaults('_config', [
            'redirect' => 'prescription::prescription.prescription'
        ])->name('prescription.store');

    Route::get('/prescription/success', 'PureEncapsulations\Prescription\Http\Controllers\PrescriptionController@success')
        ->defaults('_config', [
            'view' => 'prescription::prescription.success'
        ])->name('prescription.success');

    Route::post('/fedex-tracking-number','Webkul\Admin\Http\Controllers\Sales\ShipmentController@trackingFedex')->name('tracking-number.fedex.store');

});

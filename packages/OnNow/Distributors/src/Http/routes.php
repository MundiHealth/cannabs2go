<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('admin')->group(function () {

        // Admin Routes
        Route::group(['middleware' => ['admin']], function () {

            Route::get('distributors', 'OnNow\Distributors\Http\Controllers\DistributorController@index')
                ->defaults('_config', [
                    'view' => 'distributors::distributor.index'
                ])->name('distributor.index');

            Route::get('distributors/create', 'OnNow\Distributors\Http\Controllers\DistributorController@create')->defaults('_config',[
                'view' => 'distributors::distributor.create'
            ])->name('distributor.create');

            Route::post('distributors/create', 'OnNow\Distributors\Http\Controllers\DistributorController@store')->defaults('_config',[
                'redirect' => 'distributor.index'
            ])->name('distributor.store');

            Route::get('distributors/edit/{id}', 'OnNow\Distributors\Http\Controllers\DistributorController@edit')->defaults('_config',[
                'view' => 'distributors::doctor.edit'
            ])->name('distributor.edit');

            Route::post('distributors/edit/{id}', 'OnNow\Distributors\Http\Controllers\DistributorController@update')->defaults('_config', [
                'redirect' => 'doctor.index'
            ])->name('distributor.update');

            Route::post('distributors/delete/{id}', 'OnNow\Distributors\Http\Controllers\DistributorController@destroy')
                ->name('distributor.delete');

            //massActions
            Route::post('distributors/masssupdate', 'OnNow\Distributors\Http\Controllers\DistributorController@massUpdate')
                ->name('distributor.mass-update');

            Route::post('distributors/masssdelete', 'OnNow\Distributors\Http\Controllers\DistributorController@massDestroy')
                ->name('distributor.mass-delete');

        });
    });

    Route::get('distributors', [\OnNow\Distributors\Http\Controllers\DistributorController::class, 'index'])->name('distributors.get-all');
});
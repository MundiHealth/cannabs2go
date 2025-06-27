<?php


//Route::get('/doctor','doctor::doctor.index');



Route::group(['middleware' => ['web']], function () {
    Route::prefix('admin')->group(function () {

        // Admin Routes
        Route::group(['middleware' => ['admin']], function () {

            Route::get('doctors', 'PureEncapsulations\Doctor\Http\Controllers\DoctorController@index')
                ->defaults('_config', [
                    'view' => 'doctor::doctor.index'
                ])->name('doctor.index');

            Route::get('doctors/create', 'PureEncapsulations\Doctor\Http\Controllers\DoctorController@create')->defaults('_config',[
                'view' => 'doctor::doctor.create'
            ])->name('doctor.create');

            Route::post('doctors/create', 'PureEncapsulations\Doctor\Http\Controllers\DoctorController@store')->defaults('_config',[
                'redirect' => 'doctor.index'
            ])->name('doctor.store');

            Route::get('doctors/edit/{id}', 'PureEncapsulations\Doctor\Http\Controllers\DoctorController@edit')->defaults('_config',[
                'view' => 'doctor::doctor.edit'
            ])->name('doctor.edit');

            Route::post('doctors/edit/{id}', 'PureEncapsulations\Doctor\Http\Controllers\DoctorController@update')->defaults('_config', [
                'redirect' => 'doctor.index'
            ])->name('doctor.update');


            Route::get('doctors/note/{id}', 'PureEncapsulations\Doctor\Http\Controllers\DoctorController@createNote')->defaults('_config',[
                'view' => 'doctor::customers.note'
            ])->name('doctor.note.create');

            Route::put('doctors/note/{id}', 'PureEncapsulations\Doctor\Http\Controllers\DoctorController@storeNote')->defaults('_config',[
                'redirect' => 'doctor.index'
            ])->name('doctor.note.store');

            Route::post('doctors/delete/{id}', 'PureEncapsulations\Doctor\Http\Controllers\DoctorController@destroy')
                ->name('doctor.delete');

            //massActions
            Route::post('doctors/masssupdate', 'PureEncapsulations\Doctor\Http\Controllers\DoctorController@massUpdate')
                ->name('doctor.mass-update');

            Route::post('doctors/masssdelete', 'PureEncapsulations\Doctor\Http\Controllers\DoctorController@massDestroy')
                ->name('doctor.mass-delete');


            //Customer Management Routes
//            Route::get('customers', 'Webkul\Admin\Http\Controllers\Customer\CustomerController@index')->defaults('_config', [
//                'view' => 'admin::customers.index'
//            ])->name('admin.customer.index');
//
//            Route::get('customers/create', 'Webkul\Admin\Http\Controllers\Customer\CustomerController@create')->defaults('_config',[
//                'view' => 'admin::customers.create'
//            ])->name('admin.customer.create');
//
//            Route::post('customers/create', 'Webkul\Admin\Http\Controllers\Customer\CustomerController@store')->defaults('_config',[
//                'redirect' => 'admin.customer.index'
//            ])->name('admin.customer.store');
//
//            Route::get('customers/edit/{id}', 'Webkul\Admin\Http\Controllers\Customer\CustomerController@edit')->defaults('_config',[
//                'view' => 'admin::customers.edit'
//            ])->name('admin.customer.edit');
//
//            Route::get('customers/note/{id}', 'Webkul\Admin\Http\Controllers\Customer\CustomerController@createNote')->defaults('_config',[
//                'view' => 'admin::customers.note'
//            ])->name('admin.customer.note.create');
//
//            Route::put('customers/note/{id}', 'Webkul\Admin\Http\Controllers\Customer\CustomerController@storeNote')->defaults('_config',[
//                'redirect' => 'admin.customer.index'
//            ])->name('admin.customer.note.store');
//
//            Route::put('customers/edit/{id}', 'Webkul\Admin\Http\Controllers\Customer\CustomerController@update')->defaults('_config', [
//                'redirect' => 'admin.customer.index'
//            ])->name('admin.customer.update');
//
//            Route::post('customers/delete/{id}', 'Webkul\Admin\Http\Controllers\Customer\CustomerController@destroy')->name('admin.customer.delete');
//
//            Route::post('customers/masssdelete', 'Webkul\Admin\Http\Controllers\Customer\CustomerController@massDestroy')->name('admin.customer.mass-delete');
//
//            Route::post('customers/masssupdate', 'Webkul\Admin\Http\Controllers\Customer\CustomerController@massUpdate')->name('admin.customer.mass-update');
//
//            Route::get('reviews', 'Webkul\Product\Http\Controllers\ReviewController@index')->defaults('_config',[
//                'view' => 'admin::customers.reviews.index'
//            ])->name('admin.customer.review.index');

        });
    });
});
<?php


Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {

    Route::get('/probioticos', function() {
        return redirect('/nossos-produtos/probioticos-e-prebioticos', 307);
    });

    Route::get('/enzimas', function() {
        return redirect('/nossos-produtos/enzimas', 307);
    });

    //Store front home
    Route::get('/', 'Webkul\Shop\Http\Controllers\HomeController@index')->defaults('_config', [
        'view' => 'shop::home.index'
    ])->name('shop.home.index');

    //Store front header nav-menu fetch
    Route::get('/nossos-produtos/{slug}', 'Webkul\Shop\Http\Controllers\CategoryController@index')->defaults('_config', [
        'view' => 'shop::products.index'
    ])->name('shop.categories.index');

    //Store front search
    Route::get('/search', 'OnNow\Algolia\Http\Controllers\SearchController@index')->defaults('_config', [
        'view' => 'shop::search.search'
    ])->name('shop.search.index');

    //Show Product Details Page(For individually Viewable Product)
    Route::get('/produtos/{slug}', 'Webkul\Shop\Http\Controllers\ProductController@index')->defaults('_config', [
        'view' => 'shop::products.view'
    ])->name('shop.products.index');

    // Show Product Review(listing)
    Route::get('/product/{slug}/review', 'Webkul\Shop\Http\Controllers\ReviewController@create')->defaults('_config', [
        'view' => 'shop::products.reviews.create'
    ])->name('shop.reviews.create');

    // Show Product Review Form
    Route::get('/reviews/{slug}', 'Webkul\Shop\Http\Controllers\ReviewController@show')->defaults('_config', [
        'view' => 'shop::products.reviews.index'
    ])->name('shop.reviews.index');

    //Cart Index page
    Route::get('/checkout/cart', 'OnNow\OneStepCheckout\Http\Controllers\CartController@index')->defaults('_config', [
        'view' => 'shop::checkout.cart.index'
    ])->name('shop.checkout.cart.index');

    //Checkout Order Successfull
    Route::get('/checkout/success', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@success')->defaults('_config', [
        'view' => 'shop::checkout.success'
    ])->name('shop.checkout.success');

    //Checkout Order Failure
    Route::get('/checkout/failure', 'OnNow\OneStepCheckout\Http\Controllers\OneStepCheckoutController@failure')->defaults('_config', [
        'view' => 'shop::checkout.failure'
    ])->name('shop.checkout.failure');

    Route::get('/prevenda', 'PureEncapsulations\PreVenda\Http\Controllers\PreVendaController@index')->defaults('_config', [
        'view' => 'shop::prevenda.index'
    ])->name('prevenda.index');

    Route::post('/prevenda/checkout', 'PureEncapsulations\PreVenda\Http\Controllers\PreVendaController@view')->defaults('_config', [
        'view' => 'onestepcheckout::checkout.onestepcheckout'
    ])->name('prevenda.checkout.onepage.index');

    //customer routes starts here
    Route::prefix('customer')->group(function () {
        // forgot Password Routes
        // Forgot Password Form Show
        Route::get('/forgot-password', 'Webkul\Customer\Http\Controllers\ForgotPasswordController@create')->defaults('_config', [
            'view' => 'shop::customers.signup.forgot-password'
        ])->name('customer.forgot-password.create');

        // Forgot Password Form Store
        Route::post('/forgot-password', 'Webkul\Customer\Http\Controllers\ForgotPasswordController@store')->name('customer.forgot-password.store');

        // Reset Password Form Show
        Route::get('/reset-password/{token}', 'Webkul\Customer\Http\Controllers\ResetPasswordController@create')->defaults('_config', [
            'view' => 'shop::customers.signup.reset-password'
        ])->name('customer.reset-password.create');

        // Reset Password Form Store
        Route::post('/reset-password', 'Webkul\Customer\Http\Controllers\ResetPasswordController@store')->defaults('_config', [
            'redirect' => 'customer.profile.index'
        ])->name('customer.reset-password.store');

        // Login Routes
        // Login form show
        Route::get('login', 'Webkul\Customer\Http\Controllers\SessionController@show')->defaults('_config', [
            'view' => 'shop::customers.session.index',
        ])->name('customer.session.index');

        // Login form store
        Route::post('login', 'Webkul\Customer\Http\Controllers\SessionController@create')->defaults('_config', [
            'redirect' => 'customer.profile.index'
        ])->name('customer.session.create');

        // Registration Routes
        //registration form show
        Route::get('register', 'Webkul\Customer\Http\Controllers\RegistrationController@show')->defaults('_config', [
            'view' => 'shop::customers.signup.index'
        ])->name('customer.register.index');

        //registration form store
        Route::post('register', 'Webkul\Customer\Http\Controllers\RegistrationController@create')->defaults('_config', [
            'redirect' => 'customer.session.index',
        ])->name('customer.register.create');

        //verify account
        Route::get('/verify-account/{token}', 'Webkul\Customer\Http\Controllers\RegistrationController@verifyAccount')->name('customer.verify');

        //resend verification email
        Route::get('/resend/verification/{email}', 'Webkul\Customer\Http\Controllers\RegistrationController@resendVerificationEmail')->name('customer.resend.verification-email');

    });
    //customer routes end here

    Route::get('sitemap.xml', function (){

    })->name('shop.seo.sitemap');

    Route::fallback('PureEncapsulations\Shop\Http\Controllers\HomeController@notFound')->defaults('_config', [
        'view' => 'shop::error'
    ]);

    Route::get('contatos', 'PureEncapsulations\Shop\Http\Controllers\HomeController@contatos')->defaults('_config', [
        'view' => 'shop::pages.contatos'
    ])->name('mypharma.site.contatos');

});
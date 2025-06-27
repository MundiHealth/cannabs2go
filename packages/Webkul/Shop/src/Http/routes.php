<?php

Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {

    Route::get('neuronutricao', 'PureEncapsulations\Shop\Http\Controllers\HomeController@sparkia_neuronutricao')->defaults('_config', [
        'view' => 'shop::pages.neuronutricao'
    ])->name('sparkia.site.neuronutricao');

    Route::get('saude-da-mulher', 'PureEncapsulations\Shop\Http\Controllers\HomeController@sparkia_mulher')->defaults('_config', [
        'view' => 'shop::pages.mulher'
    ])->name('sparkia.site.mulher');

    Route::get('nossa-historia', 'PureEncapsulations\Shop\Http\Controllers\HomeController@peels')->defaults('_config', [
        'view' => 'shop::pages.sobre'
    ])->name('peels.site.sobre');

    Route::get('sobre-a-tru-niagen', 'PureEncapsulations\Shop\Http\Controllers\HomeController@truniagen')->defaults('_config', [
        'view' => 'shop::pages.sobre'
    ])->name('truniagen.site.sobre');

//    Route::get('ciencia', 'PureEncapsulations\Shop\Http\Controllers\HomeController@truniagen_ciencia')->defaults('_config', [
//        'view' => 'shop::pages.ciencia'
//    ])->name('truniagen.site.ciencia');

    Route::get('sobre-a-procare', 'PureEncapsulations\Shop\Http\Controllers\HomeController@procare')->defaults('_config', [
        'view' => 'shop::pages.sobre'
    ])->name('procare.site.sobre');

    Route::get('pesquisa', 'PureEncapsulations\Shop\Http\Controllers\HomeController@procare_pesquisa')->defaults('_config', [
        'view' => 'shop::pages.pesquisa'
    ])->name('procare.site.pesquisa');

    Route::get('cervix-on-a-chip', 'PureEncapsulations\Shop\Http\Controllers\HomeController@procare_cervix')->defaults('_config', [
        'view' => 'shop::pages.cervix'
    ])->name('procare.site.cervix');

    Route::get('sobre-o-neuroaid-ii', 'PureEncapsulations\Shop\Http\Controllers\HomeController@neuroaid')->defaults('_config', [
        'view' => 'shop::pages.sobre'
    ])->name('neuroaid.site.sobre');

    Route::get('diagnostico-de-deficiencia-dao', 'PureEncapsulations\Shop\Http\Controllers\HomeController@diagnostico_dao')->defaults('_config', [
        'view' => 'shop::pages.diagnostico'
    ])->name('drhealthcare.site.diagnostico');

    Route::get('o-que-e-deficiencia-de-dao', 'PureEncapsulations\Shop\Http\Controllers\HomeController@what_dao')->defaults('_config', [
        'view' => 'shop::pages.what'
    ])->name('drhealthcare.site.what');

    Route::get('testes-geneticos', 'PureEncapsulations\Shop\Http\Controllers\HomeController@testes_geneticos')->defaults('_config', [
        'view' => 'shop::pages.testes'
    ])->name('mypharma.site.testes');

    Route::get('lojas', 'PureEncapsulations\Shop\Http\Controllers\HomeController@lojas')->defaults('_config', [
        'view' => 'shop::pages.lojas'
    ])->name('mypharma.site.lojas');

    Route::get('por-que-calocurb', 'PureEncapsulations\Shop\Http\Controllers\HomeController@calocurb_why')->defaults('_config', [
        'view' => 'shop::pages.why'
    ])->name('calocurb.site.why');

    Route::get('tomando-calocurb', 'PureEncapsulations\Shop\Http\Controllers\HomeController@calocurb_taking')->defaults('_config', [
        'view' => 'shop::pages.taking'
    ])->name('calocurb.site.taking');

    Route::get('ciencia-calocurb', 'PureEncapsulations\Shop\Http\Controllers\HomeController@calocurb_science')->defaults('_config', [
        'view' => 'shop::pages.science'
    ])->name('calocurb.site.science');

//    Route::get('promocao', 'PureEncapsulations\Shop\Http\Controllers\HomeController@promocao')->defaults('_config', [
//        'view' => 'shop::pages.promocao'
//    ])->name('mypharma.site.promocao');

    //Store front home
    Route::get('/', 'Webkul\Shop\Http\Controllers\HomeController@index')->defaults('_config', [
        'view' => 'shop::home.index'
    ])->name('shop.home.index');

    //subscription
    //subscribe
    Route::get('/subscribe', 'Webkul\Shop\Http\Controllers\SubscriptionController@subscribe')->name('shop.subscribe');

    //unsubscribe
    Route::get('/unsubscribe/{token}', 'Webkul\Shop\Http\Controllers\SubscriptionController@unsubscribe')->name('shop.unsubscribe');

    //Store front header nav-menu fetch
    Route::get('/categories/{slug}', 'Webkul\Shop\Http\Controllers\CategoryController@index')->defaults('_config', [
        'view' => 'shop::products.index'
    ])->name('shop.categories.index');

    //Store front search
    Route::get('/search', 'Webkul\Shop\Http\Controllers\SearchController@index')->defaults('_config', [
        'view' => 'shop::search.search'
    ])->name('shop.search.index');

    //Country State Selector
    Route::get('get/countries', 'Webkul\Core\Http\Controllers\CountryStateController@getCountries')->defaults('_config', [
        'view' => 'shop::test'
    ])->name('get.countries');

    //Get States When Country is Passed
    Route::get('get/states/{country}', 'Webkul\Core\Http\Controllers\CountryStateController@getStates')->defaults('_config', [
        'view' => 'shop::test'
    ])->name('get.states');

    //checkout and cart
    //Cart Items(listing)
    Route::get('checkout/cart', 'Webkul\Shop\Http\Controllers\CartController@index')->defaults('_config', [
        'view' => 'shop::checkout.cart.index'
    ])->name('shop.checkout.cart.index');

        Route::post('checkout/check/coupons', 'Webkul\Shop\Http\Controllers\OnepageController@applyCoupon')->name('shop.checkout.check.coupons');

        Route::post('checkout/remove/coupon', 'Webkul\Shop\Http\Controllers\OnepageController@removeCoupon')->name('shop.checkout.remove.coupon');

    //Cart Items Add
    Route::post('checkout/cart/add/{id}', 'Webkul\Shop\Http\Controllers\CartController@add')->defaults('_config', [
        'redirect' => 'shop.checkout.cart.index'
    ])->name('cart.add');

    //Cart Items Remove
    Route::get('checkout/cart/remove/{id}', 'Webkul\Shop\Http\Controllers\CartController@remove')->name('cart.remove');

    //Cart Update Before Checkout
    Route::post('/checkout/cart', 'Webkul\Shop\Http\Controllers\CartController@updateBeforeCheckout')->defaults('_config', [
        'redirect' => 'shop.checkout.cart.index'
    ])->name('shop.checkout.cart.update');

    //Cart Items Remove
    Route::get('/checkout/cart/remove/{id}', 'Webkul\Shop\Http\Controllers\CartController@remove')->defaults('_config', [
        'redirect' => 'shop.checkout.cart.index'
    ])->name('shop.checkout.cart.remove');

    //Checkout Index page
    Route::get('/checkout/onepage', 'Webkul\Shop\Http\Controllers\OnepageController@index')->defaults('_config', [
        'view' => 'shop::checkout.onepage'
    ])->name('shop.checkout.onepage.index');

    //Checkout Save Order
    Route::get('/checkout/summary', 'Webkul\Shop\Http\Controllers\OnepageController@summary')->name('shop.checkout.summary');

    //Checkout Save Address Form Store
    Route::post('/checkout/save-address', 'Webkul\Shop\Http\Controllers\OnepageController@saveAddress')->name('shop.checkout.save-address');

    //Checkout Save Shipping Address Form Store
    Route::post('/checkout/save-shipping', 'Webkul\Shop\Http\Controllers\OnepageController@saveShipping')->name('shop.checkout.save-shipping');

    //Checkout Save Payment Method Form
    Route::post('/checkout/save-payment', 'Webkul\Shop\Http\Controllers\OnepageController@savePayment')->name('shop.checkout.save-payment');

    //Checkout Save Order
    Route::post('/checkout/save-order', 'Webkul\Shop\Http\Controllers\OnepageController@saveOrder')->name('shop.checkout.save-order');

    //Checkout Order Successfull
    Route::get('/checkout/success', 'Webkul\Shop\Http\Controllers\OnepageController@success')->defaults('_config', [
        'view' => 'shop::checkout.success'
    ])->name('shop.checkout.success');

    //Shop buynow button action
    Route::get('move/wishlist/{id}', 'Webkul\Shop\Http\Controllers\CartController@moveToWishlist')->name('shop.movetowishlist');

    //Show Product Details Page(For individually Viewable Product)
    Route::get('/products/{slug}', 'Webkul\Shop\Http\Controllers\ProductController@index')->defaults('_config', [
        'view' => 'shop::products.view'
    ])->name('shop.products.index');

    Route::get('/downloadable/download-sample/{type}/{id}', 'Webkul\Shop\Http\Controllers\ProductController@downloadSample')->name('shop.downloadable.download_sample');

    // Show Product Review Form
    Route::get('/reviews/{slug}', 'Webkul\Shop\Http\Controllers\ReviewController@show')->defaults('_config', [
        'view' => 'shop::products.reviews.index'
    ])->name('shop.reviews.index');

    // Show Product Review(listing)
    Route::get('/product/{slug}/review', 'Webkul\Shop\Http\Controllers\ReviewController@create')->defaults('_config', [
        'view' => 'shop::products.reviews.create'
    ])->name('shop.reviews.create');

    // Show Product Review Form Store
    Route::post('/product/{slug}/review', 'Webkul\Shop\Http\Controllers\ReviewController@store')->defaults('_config', [
        'redirect' => 'shop.home.index'
    ])->name('shop.reviews.store');

     // Download file or image
    Route::get('/product/{id}/{attribute_id}', 'Webkul\Shop\Http\Controllers\ProductController@download')->defaults('_config', [
        'view' => 'shop.products.index'
    ])->name('shop.product.file.download');

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

        // for customer login checkout
        Route::post('/customer/exist', 'Webkul\Shop\Http\Controllers\OnepageController@checkExistCustomer')->name('customer.checkout.exist');

        // for customer login checkout
        Route::post('/customer/checkout/login', 'Webkul\Shop\Http\Controllers\OnepageController@loginForCheckout')->name('customer.checkout.login');

        // Auth Routes
        Route::group(['middleware' => ['customer']], function () {

            //Customer logout
            Route::get('logout', 'Webkul\Customer\Http\Controllers\SessionController@destroy')->defaults('_config', [
                'redirect' => 'customer.session.index'
            ])->name('customer.session.destroy');

            //Customer Wishlist add
            Route::get('wishlist/add/{id}', 'Webkul\Customer\Http\Controllers\WishlistController@add')->name('customer.wishlist.add');

            //Customer Wishlist remove
            Route::get('wishlist/remove/{id}', 'Webkul\Customer\Http\Controllers\WishlistController@remove')->name('customer.wishlist.remove');

            //Customer Wishlist remove
            Route::get('wishlist/removeall', 'Webkul\Customer\Http\Controllers\WishlistController@removeAll')->name('customer.wishlist.removeall');

            //Customer Wishlist move to cart
            Route::get('wishlist/move/{id}', 'Webkul\Customer\Http\Controllers\WishlistController@move')->name('customer.wishlist.move');

            //customer account
            Route::prefix('account')->group(function () {
                //Customer Dashboard Route
                Route::get('index', 'Webkul\Customer\Http\Controllers\AccountController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.index'
                ])->name('customer.account.index');

                //Customer Profile Show
                Route::get('profile', 'Webkul\Customer\Http\Controllers\CustomerController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.profile.index'
                ])->name('customer.profile.index');

                //Customer Profile Edit Form Show
                Route::get('profile/edit', 'Webkul\Customer\Http\Controllers\CustomerController@edit')->defaults('_config', [
                    'view' => 'shop::customers.account.profile.edit'
                ])->name('customer.profile.edit');

                //Customer Profile Edit Form Store
                Route::post('profile/edit', 'Webkul\Customer\Http\Controllers\CustomerController@update')->defaults('_config', [
                    'redirect' => 'customer.profile.index'
                ])->name('customer.profile.edit');

                //Customer Profile Delete Form Store
                Route::post('profile/destroy', 'Webkul\Customer\Http\Controllers\CustomerController@destroy')->defaults('_config', [
                    'redirect' => 'customer.profile.index'
                ])->name('customer.profile.destroy');

                /*  Profile Routes Ends Here  */

                /*    Routes for Addresses   */
                //Customer Address Show
                Route::get('addresses', 'Webkul\Customer\Http\Controllers\AddressController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.address.index'
                ])->name('customer.address.index');

                //Customer Address Create Form Show
                Route::get('addresses/create', 'Webkul\Customer\Http\Controllers\AddressController@create')->defaults('_config', [
                    'view' => 'shop::customers.account.address.create'
                ])->name('customer.address.create');

                //Customer Address Create Form Store
                Route::post('addresses/create', 'Webkul\Customer\Http\Controllers\AddressController@store')->defaults('_config', [
                    'view' => 'shop::customers.account.address.address',
                    'redirect' => 'customer.address.index'
                ])->name('customer.address.create');

                //Customer Address Edit Form Show
                Route::get('addresses/edit/{id}', 'Webkul\Customer\Http\Controllers\AddressController@edit')->defaults('_config', [
                    'view' => 'shop::customers.account.address.edit'
                ])->name('customer.address.edit');

                //Customer Address Edit Form Store
                Route::put('addresses/edit/{id}', 'Webkul\Customer\Http\Controllers\AddressController@update')->defaults('_config', [
                    'redirect' => 'customer.address.index'
                ])->name('customer.address.edit');

                //Customer Address Make Default
                Route::get('addresses/default/{id}', 'Webkul\Customer\Http\Controllers\AddressController@makeDefault')->name('make.default.address');

                //Customer Address Delete
                Route::get('addresses/delete/{id}', 'Webkul\Customer\Http\Controllers\AddressController@destroy')->name('address.delete');

                /* Wishlist route */
                //Customer wishlist(listing)
                Route::get('wishlist', 'Webkul\Customer\Http\Controllers\WishlistController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.wishlist.wishlist'
                ])->name('customer.wishlist.index');

                /* Orders route */
                //Customer orders(listing)
                Route::get('orders', 'Webkul\Shop\Http\Controllers\OrderController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.orders.index'
                ])->name('customer.orders.index');

                //Customer downloadable products(listing)
                Route::get('downloadable-products', 'Webkul\Shop\Http\Controllers\DownloadableProductController@index')->defaults('_config', [
                    'view' => 'shop::customers.account.downloadable_products.index'
                ])->name('customer.downloadable_products.index');

                //Customer downloadable products(listing)
                Route::get('downloadable-products/download/{id}', 'Webkul\Shop\Http\Controllers\DownloadableProductController@download')->defaults('_config', [
                    'view' => 'shop::customers.account.downloadable_products.index'
                ])->name('customer.downloadable_products.download');

                //Customer orders view summary and status
                Route::get('orders/view/{id}', 'Webkul\Shop\Http\Controllers\OrderController@view')->defaults('_config', [
                    'view' => 'shop::customers.account.orders.view'
                ])->name('customer.orders.view');

                //Customer orders copy summary and status
                Route::get('orders/copy/{id}', 'Webkul\Shop\Http\Controllers\OrderController@copy')->defaults('_config', [
                    'view' => 'shop::customers.account.orders.copy'
                ])->name('customer.orders.copy');

                //Customer orders copy summary and status
                Route::get('orders/payment/{id}', 'Webkul\Shop\Http\Controllers\OrderController@payment')->defaults('_config', [
                    'view' => 'shop::customers.account.orders.payment'
                ])->name('customer.orders.payment');

                //Prints invoice
                Route::get('orders/print/{id}', 'Webkul\Shop\Http\Controllers\OrderController@print')->defaults('_config', [
                    'view' => 'shop::customers.account.orders.print'
                ])->name('customer.orders.print');

                /* Reviews route */
                //Customer reviews
                Route::get('reviews', 'Webkul\Customer\Http\Controllers\CustomerController@reviews')->defaults('_config', [
                    'view' => 'shop::customers.account.reviews.index'
                ])->name('customer.reviews.index');

                //Customer review delete
                Route::get('reviews/delete/{id}', 'Webkul\Shop\Http\Controllers\ReviewController@destroy')->defaults('_config', [
                    'redirect' => 'customer.reviews.index'
                ])->name('customer.review.delete');

                //Customer all review delete
                Route::get('reviews/all-delete', 'Webkul\Shop\Http\Controllers\ReviewController@deleteAll')->defaults('_config', [
                    'redirect' => 'customer.reviews.index'
                ])->name('customer.review.deleteall');
            });
        });
    });
    //customer routes end here

    Route::get('page/{slug}', 'Webkul\CMS\Http\Controllers\Shop\PagePresenterController@presenter')->name('shop.cms.page');

    Route::fallback('Webkul\Shop\Http\Controllers\HomeController@notFound');

    //redirect
    Route::redirect('/nossos-produtos/suporte-imunologicoo', '/nossos-produtos/suporte-imunologico', 301);

    Route::redirect('/produtos/full-spectrum-cbd-oil-1500mg-cbd-frasco-de-30ml', '/produtos/full-spectrum-biologics-1500mg---frasco-30ml', 301);
    Route::redirect('/produtos/full-spectrum-cbd-oil-3000mg-cbd--frasco-de-30ml', '/produtos/full-spectrum-biologics-3000mg---frasco-30ml', 301);
    Route::redirect('/produtos/full-spectrum-cbd-oil-6000mg-cbd---frasco-de-30ml', '/produtos/full-spectrum-biologics-6000mg---frasco-30ml', 301);
    Route::redirect('/produtos/kit-full-spectrum-cbd-oil-1500-mg-3-pack-10-de-desconto', '/produtos/kit-3x-unid-full-spectrum-biologics-1500mg-30ml---10-desconto', 301);
    Route::redirect('/produtos/kit-full-spectrum-cbd-oil-1500mg-cbd-frasco-de-30ml-5-pack---15-de-desconto', '/produtos/kit-5x-unid-full-spectrum-biologics-1500mg-30ml---15-desconto', 301);
    Route::redirect('/produtos/kit-full-spectrum-cbd-oil-3000mg-cbd--frasco-de-30ml-3-pack---10-de-desconto', '/produtos/kit-3x-unid-full-spectrum-biologics-3000mg-30ml---10-desconto', 301);
    Route::redirect('/produtos/kit-full-spectrum-cbd-oil-3000mg-cbd--frasco-de-30ml-5-pack---15-de-desconto', '/produtos/kit-5x-unid-full-spectrum-biologics-3000mg-30ml---15-desconto', 301);
    Route::redirect('/produtos/kit-full-spectrum-cbd-oil-6000mg-cbd---frasco-de-30ml-3-pack---10-de-desconto', '/produtos/kit-3x-unid-full-spectrum-biologics-6000mg-30ml---10-desconto', 301);
    Route::redirect('/produtos/kit-full-spectrum-cbd-oil-6000mg-cbd---frasco-de-30ml-5-pack---15-de-desconto', '/produtos/kit-5x-unid-full-spectrum-biologics-6000mg-30ml---15-desconto', 301);

    Route::redirect('/page/ajuda-e-suporte', '/page/faq', 301);

    Route::redirect('/produtos/mygut2go-by-biomefx-laudo-em-4-semanas', '/', 301);
    Route::redirect('/produtos/mygut2go-by-biomefx-laudo-em-2-semanas', '/', 301);
    Route::redirect('/produtos/mygut2go-by-biomefx-laudo-em-2-semanas-mundi', '/', 301);
    Route::redirect('/produtos/microbioma-vaginal-by-biomefx', '/', 301);

    Route::redirect('/produtos/enfamil-infant-probiotics-liquid-drops-87ml', 'https://importareser.com/', 301);
    Route::redirect('/produtos/enfamil-breastfed-infant-probiotics-vitamin-d-liquid-drops-87-ml', 'https://importareser.com/', 301);
    Route::redirect('/produtos/kit-enfamil-infant-probiotics-3-pack', 'https://importareser.com/', 301);
    Route::redirect('/produtos/kit-enfamil-breastfed-infant-probiotics-vitamin-d-3-pack', 'https://importareser.com/', 301);

    Route::redirect('/produtos/azo-bladder-control', '/bladder-control', 301);
    Route::redirect('/produtos/azo-complete', '/complete-feminine-balance-probiotic', 301);
    Route::redirect('/produtos/azo-dual-protection', '/dual-protection-urinary', 301);
    Route::redirect('/produtos/azo-urinary', '/urinary-tract-defense', 301);
    Route::redirect('/produtos/azo-yeast-plus', '/yeast-plus', 301);

    Route::redirect('/produtos/cbd-oil', '/cbd-oil', 301);
    Route::redirect('/produtos/cbd-night-oil', '/cbd-night-oil', 301);
    Route::redirect('/produtos/cbd-daily-duo', '/cbd-daily-duo', 301);
    Route::redirect('/produtos/cbd-gummies', '/cbd-gummies', 301);
    Route::redirect('/produtos/cbd-immunity-shot', '/cbd-immunity-shot', 301);

    Route::redirect('/promocao', '/', 301);
});

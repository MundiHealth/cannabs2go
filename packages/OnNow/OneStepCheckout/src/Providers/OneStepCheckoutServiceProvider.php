<?php


namespace OnNow\OneStepCheckout\Providers;


use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Webkul\Checkout\Models\Cart;
use Webkul\Checkout\Models\CartAddress;
use Webkul\Customer\Models\CustomerAddress;
use Webkul\Shop\Http\Middleware\Currency;
use Webkul\Shop\Http\Middleware\Locale;
use Webkul\Shop\Http\Middleware\Theme;

class OneStepCheckoutServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'onestepcheckout');
        $this->loadMigrationsFrom(__DIR__ .'/../Database/Migrations');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/osc/assets'),
        ], 'public');

        $this->app->concord->registerModel(
            Cart::class, \OnNow\OneStepCheckout\Models\Cart::class
        );

        $this->app->concord->registerModel(
            CartAddress::class, \OnNow\OneStepCheckout\Models\CartAddress::class
        );

        $this->app->concord->registerModel(
            CustomerAddress::class, \OnNow\OneStepCheckout\Models\CustomerAddress::class
        );

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'onestepcheckout');

        $router->aliasMiddleware('locale', Locale::class);
        $router->aliasMiddleware('theme', Theme::class);
        $router->aliasMiddleware('currency', Currency::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

}
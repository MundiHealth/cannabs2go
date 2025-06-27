<?php


namespace PureEncapsulations\Shop\Providers;


use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webkul\Shop\Http\Middleware\Currency;
use Webkul\Shop\Http\Middleware\Locale;
use Webkul\Shop\Http\Middleware\Theme;

class PureEncapsulationsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'shop');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/pureencapsulations/assets'),
        ], 'public');

//        $this->loadViewsFrom(__DIR__ . '/../Resources/backup', 'pureencapsulations');

        $router->aliasMiddleware('locale', Locale::class);
        $router->aliasMiddleware('theme', Theme::class);
        $router->aliasMiddleware('currency', Currency::class);

        Event::listen('onnow.osc.checkout.cart.shipping.before', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('shop::checkout.cart.politica-frete');
        });
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
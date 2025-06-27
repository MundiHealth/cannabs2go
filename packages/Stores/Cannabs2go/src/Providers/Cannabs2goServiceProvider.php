<?php


namespace Stores\Cannabs2go\Providers;


use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webkul\Shop\Http\Middleware\Currency;
use Webkul\Shop\Http\Middleware\Locale;
use Webkul\Shop\Http\Middleware\Theme;

class Cannabs2goServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/cannabs2go/assets'),
        ], 'public');

        $router->aliasMiddleware('locale', Locale::class);
        $router->aliasMiddleware('theme', Theme::class);
        $router->aliasMiddleware('currency', Currency::class);

//        Event::listen('onnow.osc.checkout.cart.shipping.before', function($viewRenderEventManager) {
//            $viewRenderEventManager->addTemplate('shop::checkout.cart.politica-frete');
//        });
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
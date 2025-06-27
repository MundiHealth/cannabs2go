<?php


namespace PureEncapsulations\PreVenda\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use PureEncapsulations\PreVenda\Payment;
use Webkul\Payment\Facades\Payment as PaymentFacade;

class PreVendaServiceProvider extends ServiceProvider
{

    public function boot (Router $router)
    {
        $this->loadRoutesFrom(__DIR__ .'/../Http/routes.php');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views','prevenda');

    }

    public function register()
    {
        $this->registerConfig();

        $this->registerFacades();

    }

    public function registerFacades()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('prevenda', PaymentFacade::class);

        $this->app->singleton('prevenda', function () {
            return new PreVenda();
        });


    }

    public function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/paymentmethods.php', 'paymentmethods'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );

    }

}
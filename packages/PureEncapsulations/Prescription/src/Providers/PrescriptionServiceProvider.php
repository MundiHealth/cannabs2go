<?php

namespace PureEncapsulations\Prescription\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/**
 * Prescription service provider
 *
 */
class PrescriptionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ .'/../Http/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views','prescription');

        Event::listen('bagisto.shop.checkout.continue-shopping.before', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('prescription::prescription.index');
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
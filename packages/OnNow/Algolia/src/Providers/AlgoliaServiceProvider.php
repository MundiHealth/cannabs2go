<?php


namespace OnNow\Algolia\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Webkul\Product\Models\ProductFlat;

class AlgoliaServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->app->concord->registerModel(
            ProductFlat::class, \OnNow\Algolia\Models\Product::class
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );

    }

}
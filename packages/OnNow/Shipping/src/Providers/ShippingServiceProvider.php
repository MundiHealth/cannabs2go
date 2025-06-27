<?php


namespace OnNow\Shipping\Providers;


use Illuminate\Support\ServiceProvider;
use OnNow\Shipping\Observers\MatrixRateObserver;
use Webkul\Core\Models\CoreConfigProxy;

class ShippingServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'shipping');
        $this->loadMigrationsFrom(__DIR__ .'/../Database/Migrations');

        CoreConfigProxy::observe(MatrixRateObserver::class);
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
            dirname(__DIR__) . '/Config/carriers.php', 'carriers'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );
    }

}
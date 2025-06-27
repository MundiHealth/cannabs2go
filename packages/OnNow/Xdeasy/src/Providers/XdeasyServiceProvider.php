<?php


namespace OnNow\Xdeasy\Providers;


use Illuminate\Support\ServiceProvider;

class XdeasyServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'xdeasy');
        $this->loadMigrationsFrom(__DIR__ .'/../Database/Migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );

    }

}
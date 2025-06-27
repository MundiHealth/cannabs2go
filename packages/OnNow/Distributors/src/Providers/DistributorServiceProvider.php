<?php

namespace OnNow\Distributors\Providers;

use Illuminate\Support\ServiceProvider;

class DistributorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
    public function register()
    {
        $this->registerBindings();
        $this->registerConfigurations();
        $this->registerRoutes();
        $this->registerViews();
    }

    protected function registerBindings()
    {
        $this->app->bind(
            'OnNow\Distributors\Repositories\DistributorRepositoryInterface',
            'OnNow\Distributors\Repositories\DistributorRepository'
        );
    }

    protected function registerConfigurations()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );
    }

    protected function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'distributors');
    }
}
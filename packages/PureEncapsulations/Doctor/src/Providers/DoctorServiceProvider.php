<?php
namespace PureEncapsulations\Doctor\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webkul\Admin\Providers\EventServiceProvider;

class DoctorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');

        $this->loadViewsFrom(__DIR__.'/../Resources/views','doctor');

//        Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
//            $viewRenderEventManager->addTemplate('admin::doctor.layouts.style');
//        });

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );
    }


}
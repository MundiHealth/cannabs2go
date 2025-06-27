<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //if (App::runningInConsole() === false) {
        //    $this->sleep();
        //}
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    public function sleep()
    {
        $milliseconds = rand(799, 17999);

        usleep($milliseconds * 1000);

        if ($milliseconds > 15999) {
            throw new \Exception('Gateway Timeout! Look for the system administrator.', 504);
        }
    }
}

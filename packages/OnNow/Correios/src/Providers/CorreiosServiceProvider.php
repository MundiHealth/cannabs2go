<?php


namespace OnNow\Correios\Providers;


use Illuminate\Support\ServiceProvider;

class CorreiosServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');
    }

}
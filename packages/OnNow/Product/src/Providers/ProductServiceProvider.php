<?php


namespace OnNow\Product\Providers;


use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            dirname(__DIR__) . '/Config/imagecache.php' => config_path('imagecache.php'),
        ]);

    }

}
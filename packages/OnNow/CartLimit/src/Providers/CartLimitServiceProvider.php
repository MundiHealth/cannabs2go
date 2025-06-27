<?php


namespace OnNow\CartLimit\Providers;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class CartLimitServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Event::listen('checkout.cart.add.before', function($data) {
            dd($data);
        });
    }

}
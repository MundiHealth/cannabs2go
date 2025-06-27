<?php


namespace OnNow\Xdeasy\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('sales.invoice.created.after', 'OnNow\Xdeasy\Listeners\Hawb@sendShipping');
    }

}
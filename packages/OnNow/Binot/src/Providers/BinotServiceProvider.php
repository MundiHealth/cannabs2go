<?php

namespace OnNow\Binot\Providers;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use OnNow\Binot\Observers\CreateShippingObserver;
use Webkul\Sales\Models\Shipment;

class BinotServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views','binot');

        Shipment::observe(CreateShippingObserver::class);

        Event::listen('bagisto.shop.customers.account.orders.view.before', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('binot::tracking.link');
        });
    }

}
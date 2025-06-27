<?php

namespace OnNow\Bringer\Providers;

use Illuminate\Support\ServiceProvider;
use OnNow\Bringer\Observers\CreateShippingObserver;
use Webkul\Sales\Models\Shipment;

class BringerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Shipment::observe(CreateShippingObserver::class);
    }
}
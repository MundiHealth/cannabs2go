<?php

namespace OnNow\Binot\Observers;


use OnNow\Binot\Services\Binot;
use Webkul\Sales\Models\Shipment;

class CreateShippingObserver
{

    public function created(Shipment $shipment)
    {

        $binot = new Binot();
        $binot->send($shipment);

    }

}
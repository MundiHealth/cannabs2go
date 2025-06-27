<?php


namespace OnNow\Xdeasy\Repositories;


use Illuminate\Support\Facades\DB;
use Webkul\Sales\Models\Order;

class PendingItems
{

    public function getOrdersWithPendingItems()
    {
        $orders = Order::where('status', 'invoiced');

        return $orders->get();
    }

}
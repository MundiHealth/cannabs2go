<?php


namespace OnNow\Binot\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompleteOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $orderRepository = resolve('\Webkul\Sales\Repositories\OrderRepository');
        $binot = resolve('OnNow\Binot\Services\Binot');

        $orders = $orderRepository->findWhere(['status' => 'dispatched']);

        foreach ($orders as $order){

            $consult = json_decode($binot->get($order->increment_id));

            foreach ($consult as $event) {

                if (isset($event->status_id) && $event->status_id == 4){
                    $order->status = 'completed';
                    $order->update();
                }
            }

        }

    }

}
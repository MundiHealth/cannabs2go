<?php


namespace Webkul\Sales\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OnNow\Xdeasy\Repositories\PhxCargo\PhxCargo;

class InvoiceGenerateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $orderRepository = resolve('\Webkul\Sales\Repositories\OrderRepository');
        $invoiceRepository = resolve('\Webkul\Sales\Repositories\InvoiceRepository');

        $orders = $orderRepository->findWhere(['status' => 'processing']);

        foreach ($orders as $order){

            if (!$order->canInvoice()){
                continue;
            }

            $data = [];
            foreach ($order->items as $item){
                $data['invoice']['items'][$item->id] = $item->qty_ordered;
            }

            $invoiceRepository->create(array_merge($data, ['order_id' => $order->id]));

            $order->status = 'invoiced';
            $order->update();

            if (env('APP_ENV') == 'production'){
                $phx = new PhxCargo();
                $phx->createAwb($order);
            }

        }
    }
}
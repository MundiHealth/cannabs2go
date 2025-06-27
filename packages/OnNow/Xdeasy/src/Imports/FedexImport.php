<?php

namespace OnNow\Xdeasy\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FedexImport implements ToCollection
{
    protected $shipmentRepository;

    public function __construct()
    {
        $this->shipmentRepository = resolve('\Webkul\Sales\Repositories\ShipmentRepository');
    }

    public function collection(Collection $collection)
    {
        $orderRepository = resolve('\Webkul\Sales\Repositories\OrderRepository');
        $orders = collect();
        foreach ($collection as $key => $row)
        {
            if ($key < 1 || !isset($row[19]))
                continue;

            $orders->push([
                'increment_id' => $row[1],
                'tracking' => $row[19],
                'second_tracking' => $row[20]
            ]);
        }

        $orders->map(function ($row) use ($orderRepository) {
            $order = $orderRepository->findWhere(['increment_id' => $row['increment_id']])->first();

            $invoice = $order->invoices->first();

            if (!$invoice)
                return;

            if ($order) {
                if ($row['second_tracking']) {
                    $row['tracking'] = $row['second_tracking'];
                }

                if ($order->awb_code == $row['tracking'])
                    return;

                $items = [];

                foreach ($order->items as $item){
                    $items[$item->id] = $item->qty_ordered;
                }

                $data = [
                    'order_id' => $order->id,
                    'shipment' => [
                        'carrier_title' => 'FedEx',
                        'track_number' => $row['tracking'],
                        'source' => 1,
                        'items' => $items
                    ]
                ];

                $this->shipmentRepository->create(array_merge($data, ['order_id' => $order->id]));

                $order->awb_code = $row['tracking'];
                $order->status = 'dispatched';
                $order->update();
            }
        });
    }
}
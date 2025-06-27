<?php

namespace OnNow\Xdeasy\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Webkul\Sales\Repositories\OrderRepository;

class WarehouseImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        $orderRepository = resolve('\Webkul\Sales\Repositories\OrderRepository');
        $orders = collect();
        foreach ($collection as $key => $row)
        {
            if ($key < 5 || is_null($row[0]))
                continue;

            $orders->push([
                'increment_id' => $row[0],
                'warehouse_wheight' => $row[1],
                'warehouse_boxsize' => $row[2]
            ]);
        }

        $orders->map(function ($row) use ($orderRepository) {
            $order = $orderRepository->findWhere(['increment_id' => $row['increment_id']])->first();

            if ($order) {
                $order->warehouse_wheight = $row['warehouse_wheight'];
                $order->warehouse_boxsize = $row['warehouse_boxsize'];
                $order->update();
            }
        });
    }

}
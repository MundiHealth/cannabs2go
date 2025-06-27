<?php


namespace OnNow\Xdeasy\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;

class AwbExport implements FromCollection
{

    public $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {

        $collection = collect();
        $collection->push(['Box', 'MagentoOrder', 'Prescription', 'Consignee_Tax_Id', 'Consignee_FirstName', 'Consignee_LastName', 'ConsigneeAddress', 'Consignee_ZipCode', 'Consignee_Country', 'Consignee_State', 'Consignee_Province', 'Weight Kilos', 'ComercialValue (USD)', 'Description', 'Freight Revenue (USD)', 'Quantity']);

        foreach ($this->orders as $order){

            $address = explode(PHP_EOL, $order->shippingAddress->address1);

            $names = [];

            foreach ($order->items as $item) {
                $names[] = $item->name;
            }

            $collection->push([
                null,
                $order->increment_id,
                'W-Prescription',
                $order->shippingAddress->taxvat,
                $order->shippingAddress->first_name,
                $order->shippingAddress->last_name,
                implode(", ", $address),
                $order->shippingAddress->postcode,
                'BR',
                $order->shippingAddress->state,
                $order->shippingAddress->city,
                number_format($order->items()->sum('weight'), 0),
                'USD ' . number_format($order->base_grand_total, '2', ',', ''),
                implode(' / ', $names),
//                'USD ' . number_format($order->base_shipping_amount ?? 14.04, '2', ',', ''),
                'USD 4.50',
                $order->items()->sum('qty_ordered'),
            ]);

        }

        return $collection;
    }

}
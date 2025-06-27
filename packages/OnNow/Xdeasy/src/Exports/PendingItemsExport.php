<?php


namespace OnNow\Xdeasy\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Webkul\Attribute\Models\AttributeOption;
use Webkul\Product\Models\ProductAttributeValue;

class PendingItemsExport implements FromCollection
{

    public $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {

        $collection = collect();
        $collection->push(['order', 'product', 'sku', 'qty', 'pure_code', 'size', 'brand']);

        foreach ($this->orders as $order){

            foreach ($order->all_items()->where('type', 'simple')->get() as $item){

                if (!$item->product){
                    continue;
                }

                $size = $item->product->attribute_values()->where('attribute_id', 24)->first();

                if ($size){
                    $size = AttributeOption::findOrFail($size->integer_value);
                }

                if ($code = $item->product->attribute_values()->where('attribute_id', 27)->first()){
                    $code = $code->text_value;
                }

                if ($brand = $item->product->attribute_values()->where('attribute_id', 25)->first()){
                    $brand = AttributeOption::findOrFail($brand->integer_value);
                }

                if ($sum = $collection->where('sku', $item->sku)->first()){
                    $key = $collection->where('sku', $item->sku)->keys()->first();
                    $orderItem = $collection->where('sku', $item->sku)->first();
                    $orderItem['order'] .= ', ' . $order->increment_id;
                    $orderItem['qty'] += $item->qty_invoiced;
                    $collection->put($key, $orderItem);
                    continue;
                }


                $collection->push([
                    'order' => $order->increment_id,
                    'name' => $item->name,
                    'sku' => $item->sku,
                    'qty' => $item->qty_invoiced,
                    'pure_code' => $code,
                    'size' => $size ? $size->admin_name : null,
                    'brand' => $brand ? $brand->admin_name : null
                ]);

            }

        }

        return $collection->sortBy("brand");
    }
}
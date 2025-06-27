<?php


namespace OnNow\Xdeasy\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Webkul\Product\Models\ProductFlat;

class BringerAwbExport implements FromCollection
{

    public $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        $collection = collect();

        foreach ($this->orders as $order){

            $address = explode(PHP_EOL, $order->shippingAddress->address1);
            $address_line1 = $address[0];
            $address_number = $address[1];

            if(isset($address[3])){
                $address_line2 = $address[2];
                $address_line3 = $address[3];
            }else{
                $address_line2 = null;
                $address_line3 = isset($address[2]) ? $address[2] : null;
            }

            $phone = str_replace("-", " ", $order->shippingAddress->phone);

            $points = array(".", "-", "(", ")");

            $warehouse_boxsize = explode('X', $order->warehouse_boxsize);
            if (count($warehouse_boxsize) < 1) {
                $warehouse_boxsize[0] = 8;
                $warehouse_boxsize[1] = 6;
                $warehouse_boxsize[2] = 4;
            }

            $invoice = $order->invoices[$order->invoices->count() - 1];

            $weight = 0;

            $invoice->items->each(function ($item) use ($invoice, &$weight){
                $product = app(ProductFlat::class);
                $product = $product->where("product_id", $item->product_id)
                    ->where('channel', $invoice->order->channel->code)
                    ->first();

                if (!$product->variants->isEmpty()) {
                    $product->weight = $product->variants->first()->weight;
                }

                $weight += $product->weight * $item->qty;

                if ($product->amount_on_invoice) {
                    $item->base_price = $product->amount_on_invoice;
                    $item->base_total = $product->amount_on_invoice * $item->qty;
                    $item->base_discount_amount = $item->base_total;
                }
            });

            $exchange = ($invoice->sub_total / $invoice->base_sub_total) / 1.83;

            $invoice->base_shipping_amount = 4.70 * ($weight / 250);
            $invoice->total_before_tax = $invoice->base_sub_total - $invoice->base_discount_amount + $invoice->base_shipping_amount;
            if ($invoice->tax_amount > 0) {
                $invoice->base_grand_total = $invoice->grand_total / $exchange;
                $invoice->local_duties_fee_deposit = $invoice->base_grand_total - $invoice->total_before_tax;
            } else {
                $invoice->base_grand_total = $invoice->total_before_tax;
                $invoice->local_duties_fee_deposit = $invoice->tax_amount;
            }

            $invoice_base_sub_total = $invoice->items->sum('base_total');

            $collection->push(['external_customer_id','external_reference_code','destination_country_iso','weight','length','width','height','value','freight_value','insurance_value','service','service_option_id','tax_modality','measurement_unit','weight_unit','parcel_type']);
            $collection->push([
                "'".str_replace($points, "", $order->shippingAddress->taxvat),
                $order->increment_id,
                'BR',
                $order->warehouse_wheight * 1000,
                @$warehouse_boxsize[0],
                @$warehouse_boxsize[1],
                @$warehouse_boxsize[2],
                number_format($invoice_base_sub_total, '2', '.', ''),
                (string)number_format($invoice->base_shipping_amount, 2, '.', ''),
                '0',
                'BPSI-22',
                null,
                'ddp',
                'inches',
                'gram',
                'box'
            ]);
            $collection->push(['', 'sender_type','sender_company_name','sender_first_name','sender_last_name','sender_tax_id','sender_email','sender_phone','sender_website','sender_address_number','sender_address_mailbox','sender_address_address_line_1','sender_address_address_line_2','sender_address_address_line_3','sender_address_address_line_4','sender_address_state','sender_address_city','sender_address_postal_code','sender_address_country_iso_code']);
            $collection->push([
                '',
                'business',
                'MyPharma2GO',
                'Andre',
                'Donato',
                '301090648',
                'atendimento@mypharma2go.com',
                '+55 11 99868 0834',
                'https://www.mypharma2go.com',
                '8601',
                null,
                'Commodity Sir Suite 102',
                null,
                null,
                null,
                'FL',
                'Orlando',
                '32819',
                'US'
            ]);
            $collection->push(['', 'recipient_type','recipient_company_name','recipient_first_name','recipient_last_name','recipient_tax_id','recipient_email','recipient_phone','recipient_website','recipient_address_number','recipient_address_mailbox','recipient_address_address_line_1','recipient_address_address_line_2','recipient_address_address_line_3','recipient_address_address_line_4','recipient_address_state','recipient_address_city','recipient_address_postal_code','recipient_address_country_iso_code']);
            $collection->push([
                '',
                'individual',
                null,
                $order->shippingAddress->first_name,
                $order->shippingAddress->last_name,
                "'".str_replace($points, "", $order->shippingAddress->taxvat),
                $order->shippingAddress->email,
                str_replace($points, "", '+55 '.$phone),
                null,
                $address_number,
                null,
                $address_line1,
                $address_line2,
                $address_line3,
                null,
                $order->shippingAddress->state,
                $order->shippingAddress->city,
                "'".str_replace($points, "", $order->shippingAddress->postcode),
                'BR'
            ]);
            $collection->push(['','sh_code','sku_code','description','quantity','value','weight','contains_battery','contains_perfume','contains_flammable_liquid']);


            foreach ($order->invoices as $invoice) {
                foreach ($invoice->items as $item) {

                    $wheight = ($order->warehouse_wheight / $order->items()->sum('qty_ordered')) * $item->qty;
                    $collection->push([
                        '',
                        '210610',
                        $item->sku,
                        $item->name,
                        $item->qty,
                        number_format($item->base_price, '2', '.', ''),
                        $wheight * 1000,
                        null,
                        null,
                        null
                    ]);
                }
            }
        }

        return $collection;
    }

    public function collectionOld()
    {
        $collection = collect();
        $collection->push(['external_customer_id','external_reference_code','destination_country_iso','weight','length','width','height','value','freight_value','insurance_value','service','service_option_id','tax_modality','measurement_unit','weight_unit','parcel_type','sender_type','sender_company_name','sender_first_name','sender_last_name','sender_tax_id','sender_email','sender_phone','sender_website','sender_address_number','sender_address_mailbox','sender_address_address_line_1','sender_address_address_line_2','sender_address_address_line_3','sender_address_address_line_4','sender_address_state','sender_address_city','sender_address_postal_code','sender_address_country_iso_code','recipient_type','recipient_company_name','recipient_first_name','recipient_last_name','recipient_tax_id','recipient_email','recipient_phone','recipient_website','recipient_address_number','recipient_address_mailbox','recipient_address_address_line_1','recipient_address_address_line_2','recipient_address_address_line_3','recipient_address_address_line_4','recipient_address_state','recipient_address_city','recipient_address_postal_code','recipient_address_country_iso_code','sh_code','sku_code','description','quantity','value','weight','contains_battery','contains_perfume','contains_flammable_liquid']);

        foreach ($this->orders as $order){

            $address = explode(PHP_EOL, $order->shippingAddress->address1);
            $address_line1 = $address[0];
            $address_number = $address[1];

            if(isset($address[3])){
                $address_line2 = $address[2];
                $address_line3 = $address[3];
            }else{
                $address_line2 = null;
                $address_line3 = isset($address[2]) ? $address[2] : null;
            }

            $phone = str_replace("-", " ", $order->shippingAddress->phone);

            $points = array(".", "-", "(", ")");

            foreach ($order->invoices as $invoice) {
                foreach ($invoice->items as $item) {
                    $warehouse_boxsize = explode('X', $order->warehouse_boxsize);
                    if (count($warehouse_boxsize) < 1) {
                        $warehouse_boxsize[0] = 8;
                        $warehouse_boxsize[1] = 6;
                        $warehouse_boxsize[2] = 4;
                    }
                    $collection->push([
                        "'".str_replace($points, "", $order->shippingAddress->taxvat),
                        $order->increment_id,
                        'BR',
                        ($order->warehouse_wheight / $order->items()->sum('qty_ordered')) * $item->qty,
                        @$warehouse_boxsize[0],
                        @$warehouse_boxsize[1],
                        @$warehouse_boxsize[2],
                        number_format($invoice->base_sub_total, '2', '.', ''),
                        '2.50',
                        '0',
                        'BPSI-22',
                        null,
                        'ddp',
                        'inches',
                        'gram',
                        'box',
                        'business',
                        'MyPharma2GO',
                        'Andre',
                        'Donato',
                        '301090648',
                        'atendimento@mypharma2go.com',
                        '+55 11 99868 0834',
                        'https://www.mypharma2go.com',
                        '8601',
                        null,
                        'Commodity Sir Suite 102',
                        null,
                        null,
                        null,
                        'FL',
                        'Orlando',
                        '32819',
                        'US',
                        'individual',
                        null,
                        $order->shippingAddress->first_name,
                        $order->shippingAddress->last_name,
                        "'".str_replace($points, "", $order->shippingAddress->taxvat),
                        $order->shippingAddress->email,
                        str_replace($points, "", '+55 '.$phone),
                        null,
                        $address_number,
                        null,
                        $address_line1,
                        $address_line2,
                        $address_line3,
                        null,
                        $order->shippingAddress->state,
                        $order->shippingAddress->city,
                        "'".str_replace($points, "", $order->shippingAddress->postcode),
                        'BR',
                        '210610',
                        $item->sku,
                        $item->name,
                        $item->qty,
                        number_format($item->base_price, '2', '.', ''),
                        '100',
                        null,
                        null,
                        null
                    ]);
                }
            }
        }

        return $collection;
    }

}
<?php

namespace OnNow\Xdeasy\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
class FedexExport implements FromCollection
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }
    public function collection()
    {
        $collection = collect();
        $collection->push(['PRIORITY', 'PEDIDO', 'DATA', 'PRODUTO', 'DOSAGEM', 'QUANTIDADE', 'PACKAGE', 'CLIENTE',  'EMAIL CLIENTE', 'EMAIL ENTREGA', 'ENDERECO', 'COMPLEMENTO', 'UF', 'CIDADE', 'CEP', 'CPF', 'TELEFONE', 'LINK', 'NOTES', 'TRACKING NUMBER 1', 'TRACKING NUMBER 2']);

        foreach ($this->orders as $order) {

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

            $invoice = $order->invoices->first();
            $itemsValidate = $order->items()->where('name', 'like', '%Mounjaro%');

            if ($itemsValidate->count() == 0) {
                continue;
            }

            foreach ($itemsValidate->get() as $item) {
                $collection->push([
                    'PRIORITY' => NULL,
                    'PEDIDO' => $order->increment_id,
                    'DATA' => $order->created_at->format('d-m-Y'),
                    'PRODUTO' => $item->name,
                    'DOSAGEM' => '',
                    'QUANTIDADE' => $item->qty_ordered,
                    'PACKAGE' => '',
                    'CLIENTE' => $order->customer_first_name . ' ' . $order->customer_last_name,
                    'EMAIL CLIENTE' => $order->customer_email,
                    'EMAIL ENTREGA' => 'tracking@mypharma2go.com',
                    'ENDERECO' => $address_line1 . ', ' . $address_number,
                    'COMPLEMENTO' => $address_line2 ?: '',
                    'UF' => $order->shippingAddress->state,
                    'CIDADE' => $order->shippingAddress->city,
                    'CEP' => $order->shippingAddress->postcode,
                    'CPF' => $order->shippingAddress->taxvat,
                    'TELEFONE' => '+55 11 99868-0834',
                    'LINK' => $invoice ? route('xdeasy.documents.zip', $invoice->id) : null,
                    'NOTES' => '',
                    'TRACKING NUMBER 1' => '',
                    'TRACKING NUMBER 2' => ''
                ]);
            }
        }

        return $collection;
    }
}
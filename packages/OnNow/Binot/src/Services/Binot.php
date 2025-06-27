<?php

namespace OnNow\Binot\Services;

use Carbon\Carbon;
use Webkul\Sales\Models\Shipment;

class Binot
{

    private $company = 1001;
    private $shippingCompany = 1006;

    public function get($order_number)
    {
        $curl = curl_init('http://api.binot.me/api/public/shipping/' . $this->company . '/' . $order_number);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Token: 54085202-7ce2-4c01-9af6-acb2e8182e80"
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($curl);

        return $response;
    }


    public function send(Shipment $shipment)
    {
        $dataPostagem = date('Y-m-d');
        $dataPrazoComercial = $this->comercialDate($shipment->order);

        $request = [
            'companyId' => $this->company,
            'shippingCompanyId' => $this->shippingCompany,
            'orderNumber' => $shipment->order->increment_id,
            'invoiceNumber' => $shipment->order->increment_id,
            'invoiceSerialNumber' => '001',
            'trackingNumber' => $shipment->track_number,
            'customerName' => $shipment->order->customer_first_name . ' ' . $shipment->order->customer_last_name,
            'customerEmail' => $shipment->order->customer_email,
            'postDate' => $dataPostagem,
            'expectedDate' => $dataPrazoComercial,
        ];

        $this->exec($request);
    }

    public function comercialDate($order)
    {
        $invoice = $order->invoices->first();
        if ($order->channel_name == 'Cannabs2GO') {
            $comercialDate = $invoice->created_at->addDays(45)->format('Y-m-d');
            #$comercialDate = date('Y-m-d', strtotime('+45 days'));
        } else {
            $comercialDate = $invoice->created_at->addWeekdays(25)->format('Y-m-d');
            #$comercialDate = date('Y-m-d', strtotime('+25 weekdays'));
        }

        return$comercialDate;
    }

    protected function exec($request)
    {
        $curl = curl_init('http://api.binot.me/api/public/shipping/create');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Token: 54085202-7ce2-4c01-9af6-acb2e8182e80"
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($request));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($curl);

        return $response;
    }

}
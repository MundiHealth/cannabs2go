<?php
namespace OnNow\CambioReal\Services;

use CambioReal\Config;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;

class CambioReal
{
    public $response;

    private function config()
    {
        Config::set([
            'appId' => core()->getConfigData('sales.paymentmethods.cambioreal.app_id'),
            'appSecret' => core()->getConfigData('sales.paymentmethods.cambioreal.app_secret'),
            'testMode' => core()->getConfigData('sales.paymentmethods.cambioreal.mode')
        ]);
    }

    public function pay($paymentData, $method, $order)
    {
        $this->config();

        if ($method == 'bankslip') {
            $this->response = $this->boleto($paymentData, $order);
        } elseif ($method == 'pix') {
            $this->response = $this->pix($paymentData, $order);
        } elseif ($method == 'link') {
            $this->response = $this->link($order);
        } else {
            $this->response = $this->card($paymentData, $order, $method);
        }
    }

    public function cancel()
    {

    }

    public function get($id, $token)
    {
        $this->config();

        $this->response = \CambioReal\CambioReal::get([
            'id' => $id,
            'token' => $token
        ]);
    }

    private function card($paymentData, $order, $brand)
    {
        $request = $this->request($paymentData, $order);
        $getToken = $this->getCardToken($paymentData);
        $request['payment_method'] = 'credit_card';
        $cardRequest = [
            "card" => [
                "bin" => (int) substr(filter_var($paymentData['number'], FILTER_SANITIZE_NUMBER_INT), 0, 6),
                "brand" => $brand,
                "country" => "BR",
                "event_uuid" => $paymentData['event_uuid'],
                "holder" => $paymentData['holder'],
                "installments" => (int) $paymentData['installment'],
                "token" => json_decode($getToken)->token,
                "type" => "credit"
            ]
        ];
        $request = array_merge($request, $cardRequest);

        Log::info("CambioReal Card Request: " . json_encode($request));
        return $this->doRequest($request);
    }

    private function pix($paymentData, $order)
    {
        $request = $this->request($paymentData, $order);
        $request['payment_method'] = 'pix';

        return $this->doRequest($request);
    }

    private function boleto($paymentData, $order)
    {
        $request = $this->request($paymentData, $order);
        $request['payment_method'] = 'boleto';

        return $this->doRequest($request);
    }

    private function link($order)
    {
        $billingAddress = $order->billingAddress;
        $request = [
            "order_id" => $order->increment_id,
            "amount" => $order->grand_total,
            "currency" => "BRL",
            "url_callback" => "",
            "url_error" => "",
            "client" => [
                "name" => $order->customer_first_name . ' '. $order->customer_last_name,
                "email" => $order->customer_email,
                "document" => $billingAddress->taxvat
            ],
            "due_date" => 2,
            "duplicate" => false,
            "products" => $order->items->map(function ($item){
                return [
                    "descricao" => $item->name,
                    "base_value" => $item->base_price,
                    "valor" => $item->price,
                    "qty" => $item->qty_ordered,
                    "ref" => $item->sku
                ];
            })
        ];

        return \CambioReal\CambioReal::request($request);
    }

    private function request($paymentData, $order)
    {
        $billingAddress = $order->billingAddress;
        $address =  explode(PHP_EOL, $billingAddress->address1);
        $products = [];

        foreach ($order->items as $item) {
            $products[] = [
                "descricao" => $item->name,
                "base_value" => $item->price,
                "valor" => $item->price * $item->qty_ordered,
                "qty" => $item->qty_ordered,
                "ref" => $item->sku
            ];
        }

        $products[] = [
            "descricao" => "Frete",
            "base_value" => $order->shipping_amount,
            "valor" => $order->shipping_amount,
            "qty" => 1,
            "ref" =>'FRETE',
        ];

        $products[] = [
            "descricao" => "Impostos",
            "base_value" => $order->tax_amount,
            "valor" => $order->tax_amount,
            "qty" => 1,
            "ref" => 'IMPOSTOS',
        ];

        if ($order->discount_amount > 0) {
            $products[] = [
                "descricao" => "Desconto",
                "base_value" => $order->discount_amount,
                "valor" => $order->discount_amount * -1,
                "qty" => 1,
                "ref" => 'DESCONTO',
            ];
        }

        $request = [
            "order_id" => $order->increment_id,
            "amount" => $order->grand_total,
            "currency" => "BRL",
            "payment_method" => false,
            "take_rates" => true,
            "client" => [
                "name" => $order->customer_first_name . ' '. $order->customer_last_name,
                "email" => $order->customer_email,
                "document" => $billingAddress->taxvat,
                "birth_date" => "2000-01-20",
                "phone" => $billingAddress->phone,
                "ip" => "127.0.0.1",
                "address" => [
                    "state" => $billingAddress->state,
                    "city" => $billingAddress->city,
                    "zip_code" => $billingAddress->postcode,
                    "district" => $billingAddress->address3 ?: $address[3],
                    "street" => explode("\n", $billingAddress->address1)[0],
                    "number" => (int) preg_match('/\d+/', $billingAddress->address1, $matches) ? $matches[0] : 0
                ]
            ],
            "products" => $products
        ];

        return $request;
    }

    private function getCardBrand($method){
        $brand = '';
        switch ($method){
            case 'mastercard':
                $brand = 'master';
                break;
            case 'AMERICAN-EXPRESS':
            case 'american-express':
                $brand = 'amex';
                break;
            default:
                $brand = strtolower($method);
        }
        return $brand;
    }

    private function doRequest($request)
    {
        return \CambioReal\CambioReal::requestV2($request);
    }

    private function getCardToken($cardData, $apiKey = "dc6a2a1e-bbd2-4910-9433-4777d2172022")
    {
        $request = [
            "expiration_month" => str_pad($cardData['month'], 2, 0, STR_PAD_LEFT),
            "expiration_year" => $cardData['year'],
            "holder_name" => $cardData['holder'],
            "pan" => (int) filter_var($cardData['number'], FILTER_SANITIZE_NUMBER_INT),
            "key" => $apiKey,
            "country_code" => "BR",
            "cvv" => filter_var($cardData['cvv'], FILTER_SANITIZE_NUMBER_INT),
        ];

        $curl = curl_init('https://ppmcc.dlocal.com/cvault/credit-card/temporal');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        return curl_exec($curl);
    }
}
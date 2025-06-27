<?php

namespace OnNow\Bringer\Services;

use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;
use Webkul\Sales\Models\Order;

class Bringer
{

    protected $headers = [];
    protected $body = [];
    protected $endpoint;

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param mixed $endpoint
     */
    public function setEndpoint($endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    public function parcelCreate(Order $order)
    {
        $auth = self::auth();
        $this->setHeaders([
            'Authorization: Bearer ' . $auth->accessToken
        ]);

        $points = array(".", "-", "(", ")");
        $phone = str_replace("-", " ", $order->shippingAddress->phone);

        $invoice = $order->invoices->first();

        $this->setBody([
            'external_customer_id' => str_replace($points, "", $order->shippingAddress->taxvat),
            'external_reference_code' => $order->increment_id,
            'items' => $order->items()->map(function ($item) {
                return [
                    'description' => $item->name,
                    'quantity' => $item->qty,
                    'sh_code' => '210610',
                    'value' => number_format($item->base_price, '2', '.', ''),
                    'sku_code' => $item->sku,
                    'weight' => '100',
                    'item_details' => [
                        'contains_battery' => null,
                        'contains_flammable_liquid' => null,
                        'contains_perfume' => null
                    ]
                ];
            }),
            'parcel_details' => [
                'destination_country_iso',
                'freight_value',
                'height' => 4,
                'insurance_value',
                'length' => 8,
                'measurement_unit',
                'parcel_type',
                'service_code',
                'tax_modality',
                'value' => number_format($invoice->base_sub_total, '2', '.', ''),
                'weight' => $order->items()->sum('qty_ordered') * 100,
                'weight_unit',
                'width' => 4,
                'apply_min_dimension_override',
                'domestic_required'
            ],
            'recipient' => [
                'address' => [
                    'address_line_1',
                    'city',
                    'country',
                    'number',
                    'postal_code',
                    'state',
                    'mailbox' => $order->shippingAddress->email,
                    'address_line_2',
                    'address_line_3'
                ],
                'first_name' => $order->shippingAddress->first_name,
                'last_name' => $order->shippingAddress->last_name,
                'phone' => str_replace($points, "", '+55 '.$phone),
                'tax_id' => str_replace($points, "", $order->shippingAddress->taxvat),
                'type' => 'individual'
            ],
            'sender' => [
                'address' => [
                    'address_line_1' => 'Commodity Sir Suite 102',
                    'city' => 'Orlando',
                    'country' => 'US',
                    'number' => '8601',
                    'postal_code' => '32819',
                    'state' => 'FL',
                    'mailbox' => null,
                    'address_line_2' => null,
                    'address_line_3' => null
                ],
                'company_name' => 'MyPharma2GO',
                'email' => 'atendimento@mypharma2go.com',
                'phone' => '+55 11 99868 0834',
                'tax_id' => '301090648',
                'type' => 'business',
                'website' => 'https://www.mypharma2go.com'
            ],
            'is_humanitarian'
        ]);
    }

    protected function auth()
    {

        $this->setBody([
            'username' => 'acdonato@mypharma2go.com',
            'password' => 'MUNDIHEALTH123',
        ]);

        $response = $this->exec('POST', '/auth/token.json');

        Log::info('Bringer Auth Response: ' . json_encode($response));

        return $response;
    }



    protected function exec($method, $path)
    {
        $response = Curl::to($this->getEndpoint() . $path);

        if ($method == 'POST') {
            $response = Curl::to($this->getEndpoint() . $path);
            $response->withData($this->getBody());

            $response->asJson();
        }

        if ($method == 'GET') {
            $queryString = http_build_query($this->getBody());
            $response = Curl::to($this->getEndpoint() . $path . '?' . $queryString);
        }

        if (count($this->getHeaders()) > 0) {
            $response->withHeaders($this->getHeaders());
        }

        if ($method == 'GET') {
            return $response->get();
        }

        if ($method == 'POST') {
            return $response->post();
        }
    }

}
<?php

    namespace OnNow\Xdeasy\Repositories\PhxCargo;


    use Carbon\Carbon;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;
    use Ixudra\Curl\Facades\Curl;
    use Webkul\Sales\Models\Order;

    class PhxCargo
    {

        public $headers = [];
        public $body = [];

        public $endpoint = 'https://api.phxcargo.net';

        public function getMawb($code)
        {
            $request = [
                'id' => $code
            ];

            $auth = $this->auth();

            $this->setHeaders([
                'Authorization: Bearer ' . $auth->access_token,
                "Content-Type: application/json"
            ]);
            $this->setBody($request);

            $response = $this->download('POST', '/airwaybills/house/export', 'hawb/' . $code . '/' . $code . '.pdf');

            return $response;
        }

        public function createAwb(Order $order)
        {
            $request = $this->request($order);
            $auth = $this->auth();

            $headers = [
                'Authorization: Bearer ' . $auth->access_token
            ];

            Log::info('Request Headers PHXCargo: ' . json_encode($headers));

            $this->setHeaders($headers);
            $this->setBody($request);

            Log::info("Request Data PHXCargo: " . json_encode($request));
            $response = $this->exec('POST', '/airwaybills/house');
            Log::info("Response Data PHXCargo: " . json_encode($response));

            if (isset($response->errors)){
                foreach ($response->errors as $error){
                    session()->flash('error', $error);
                }

                return;
            }

            if ($response->data){
                $order->awb_id = $response->data->id;
                $order->awb_code = $response->data->code;
                $order->update();
            }

        }

        protected function request($order)
        {

            $description = 'VITAMINS';
            $address =  explode(PHP_EOL, $order->shippingAddress->address1);

            $items = $order->items->map(function ($item){
                return [
                    'description' => $item->name,
                    'commercial_value' => $item->base_price * 0.6,
                    'weight' => $item->weight,
                    'quantity' => $item->qty_ordered,
                    'length' => 0,
                    'width' => 0,
                    'height' => 0
                ];
            });

            return [
                "company" => [
                    'code' => 'MP2GO',
                ],
                "consolidator_code" => $this->generateCode('CON'),
                "tax_class_code" => 11,
                "customs_adm" => 1,
                "external_identifiers" => [$order->increment_id],
                "description" => $description,
                "amount_freight" => $order->base_shipping_amount > 0 ? $order->base_shipping_amount * 0.6 : 14.04,
                "gross_weight" => $house->weight ?? '0',
                "shipper_id" => 1,
                "importer" => [
                    'name' => $order->shippingAddress->first_name . ' ' . $order->shippingAddress->last_name,
                    'documents' => [
                        ['number' => $order->shippingAddress->taxvat]
                    ],
                    'addresses' => [
                        [
                            'number' => (int) filter_var($address[1], FILTER_SANITIZE_NUMBER_INT),
                            'additional_info' => count($address) > 3 ? $address[2] : null,
                            'zip_code' => $order->shippingAddress->postcode,
                            'address' => $address[0],
                            'city' => [
                                'name' => $order->shippingAddress->city,
                                'uf' => $order->shippingAddress->state,
                            ],
                            'state' => $order->shippingAddress->state,
                            'neighborhood' => count($address) > 3 ? $address[3] : $address[2],
                            'country' => [
                                'code' => 105,
                                'initials' => 'BR'
                            ]
                        ]
                    ],
                ],
                "items" => $items->toArray()
            ];
        }

        private function generateCode($prefix)
        {
            $now = Carbon::now();
            $currentTime = $now->format('Ym');
            $weekNumberInMonth = $now->weekNumberInMonth;
            return "MP2GO{$currentTime}W{$weekNumberInMonth}" . $prefix;
        }

        protected function auth()
        {
            $this->setBody([
                'grant_type' => 'password',
                'client_id' => 1,
                'client_secret' => '1VZlziQ8J2obtEg1NByxxnC4DJqq6BeXs2Lxgkry',
                'username' => 'atendimento@mypharma2go.com',
                'password' => 'phx@mypharma',
                'scope' => '*'
            ]);

            $response = $this->exec('POST', '/oauth/token');

            Log::info('PHX Auth Response: ' . json_encode($response));

            return $response;
        }

        public function setHeaders($headers)
        {
            $this->headers = $headers;
        }

        public function getHeaders()
        {
            return $this->headers;
        }

        public function setBody($body)
        {
            $this->body = $body;
        }

        public function getBody()
        {
            return $this->body;
        }

        protected function download($method, $path, $filename)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->endpoint . $path,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($this->getBody()),
                CURLOPT_HTTPHEADER => $this->getHeaders(),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            Storage::disk('public')->put($filename, $response);

            return Storage::disk('public')->url($filename);
        }

        protected function exec($method, $path)
        {
            $response = Curl::to($this->endpoint . $path);
            $response->withData($this->getBody());
            $response->asJson();

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
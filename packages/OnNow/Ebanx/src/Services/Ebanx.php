<?php

namespace OnNow\Ebanx\Services;

use Ebanx\Config;
use Illuminate\Support\Facades\Log;

class Ebanx
{
    public $response;

    public function pay($paymentData, $method, $order)
    {
        if ($method == 'bankslip'){
            $this->response = $this->boleto($paymentData, $order);
        } elseif ($method == 'pix') {
            $this->response = $this->pix($paymentData, $order);
        } elseif ($method == 'link') {
            $this->response = $this->link($paymentData, $order);
        } else {
            $this->response = $this->card($paymentData, $order, $method);
        }
    }

    public function cancel($hash)
    {
        Config::set([
            'integrationKey' => core()->getConfigData('sales.paymentmethods.ebanx.integration_key'),
            'testMode'       => core()->getConfigData('sales.paymentmethods.ebanx.mode')
        ]);

        $response = \Ebanx\Ebanx::doCancel(array(
            'hash' => $hash
        ));

        Log::info("Ebanx Cancel: " . json_encode($response));

        return $response;
    }

    public function query($hash){
        Config::set([
            'integrationKey' => core()->getConfigData('sales.paymentmethods.ebanx.integration_key'),
            'testMode'       => core()->getConfigData('sales.paymentmethods.ebanx.mode')
        ]);

        return \Ebanx\Ebanx::doQuery([
            'hash' => $hash
        ]);

    }

    private function card($paymentData, $order, $method)
    {
        $billingAddress = $order->billingAddress;
        $brand = $this->getCardBrand($method);
        $request = array(
            'mode'      => 'full',
            'operation' => 'request',
            'payment'   => array(
                'merchant_payment_code' => time(),
                'order_number' => $order->increment_id,
                'amount_total'      => $this->applyInstallmentTax($order->grand_total, $paymentData['installment']),
                'currency_code'     => 'BRL',
                'name'              => $order->customer_first_name . ' '. $order->customer_last_name,
                'email'             => $order->customer_email,
                'document'          => $billingAddress->taxvat,
                'address'           => $billingAddress->address1,
                'street_number'     => (int) filter_var($billingAddress->address1, FILTER_SANITIZE_NUMBER_INT),
                'street_complement' => '',
                'city'              => $billingAddress->city,
                'state'             => $billingAddress->state,
                'zipcode'           => $billingAddress->postcode,
                'country'           => 'br',
                'phone_number'      => $billingAddress->phone,
                'payment_type_code' => $brand,
                'instalments' => $paymentData['installment'],
                'creditcard'        => array(
                    'card_number'   => (int) filter_var($paymentData['number'], FILTER_SANITIZE_NUMBER_INT),
                    'card_name'     => $paymentData['holder'],
                    'card_due_date' => str_pad($paymentData['month'], 2, 0, STR_PAD_LEFT) . '/' . $paymentData['year'],
                    'card_cvv'      => filter_var($paymentData['cvv'], FILTER_SANITIZE_NUMBER_INT),
                    'auto_capture'  => true
                ),
            )
        );

        return  $this->doRequest($request);
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

    private function boleto($paymentData, $order)
    {
        $billingAddress = $order->billingAddress;
        $request = array(
            'mode'      => 'full',
            'operation' => 'request',
            'payment'   => array(
                'merchant_payment_code' => time(),
                'order_number' => $order->increment_id,
                'amount_total'      => $order->grand_total,
                'currency_code'     => 'BRL',
                'name'              => $order->customer_first_name . ' '. $order->customer_last_name,
                'email'             => $order->customer_email,
                //'birth_date'        => '12/04/1979',
                'document'          => $billingAddress->taxvat,
                'address'           => $billingAddress->address1,
                'street_number'     => (int) filter_var($billingAddress->address1, FILTER_SANITIZE_NUMBER_INT),
                'street_complement' => '',
                'city'              => $billingAddress->city,
                'state'             => $billingAddress->state,
                'zipcode'           => $billingAddress->postcode,
                'country'           => 'br',
                'phone_number'      => $billingAddress->phone,
                'payment_type_code' => 'boleto'
            )
        );

        return $this->doRequest($request, "boleto");
    }

    private function pix($paymentData, $order)
    {
        $billingAddress = $order->billingAddress;
        $request = array(
            'mode'      => 'full',
            'operation' => 'request',
            'payment'   => array(
                'merchant_payment_code' => time(),
                'order_number' => $order->increment_id,
                'amount_total'      => $order->grand_total,
                'currency_code'     => 'BRL',
                'name'              => $order->customer_first_name . ' '. $order->customer_last_name,
                'email'             => $order->customer_email,
                'document'          => $billingAddress->taxvat,
                'address'           => $billingAddress->address1,
                'street_number'     => (int) filter_var($billingAddress->address1, FILTER_SANITIZE_NUMBER_INT),
                'street_complement' => '',
                'city'              => $billingAddress->city,
                'state'             => $billingAddress->state,
                'zipcode'           => $billingAddress->postcode,
                'country'           => 'br',
                'phone_number'      => $billingAddress->phone,
                'payment_type_code' => 'pix',
                'expiration_time_in_seconds' => 3600
            )
        );

        return $this->doRequest($request, "pix");
    }

    public function link($paymentData, $order)
    {
        $request = array(
            'integration_key' => core()->getConfigData('sales.paymentmethods.ebanx.integration_key'),
            'merchant_payment_code' => time(),
            'order_number' => $order->increment_id,
            'name' => $order->customer_first_name . ' '. $order->customer_last_name,
            'email' => $order->customer_email,
            'currency_code' => 'BRL',
            'amount' => $order->grand_total,
            'payment_type_code' => '_all',
            'country' => 'br',
            'instalments' => '1-12'
        );

        return $this->doRequest($request, 'link');
    }

    protected function doRequest($requestData, $method = "card")
    {
        Config::set([
            'integrationKey' => core()->getConfigData('sales.paymentmethods.ebanx.integration_key'),
            'testMode'       => core()->getConfigData('sales.paymentmethods.ebanx.mode'),
            'directMode'     => $method == 'link' ? false :  true
        ]);

        $response = $request = \Ebanx\Ebanx::doRequest($requestData);

        return $response;
    }

    protected function applyInstallmentTax($amount, $installments)
    {
        $tax = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 8.5,
            5 => 9.10,
            6 => 9.70,
            7 => 10.75,
            8 => 11.35,
            9 => 11.95,
            10 => 12.50,
            11 => 13.10,
            12 => 13.65
        ];

        $tax = $tax[$installments] / 100;
        $total = $amount * (1 + $tax);

        return $total;
    }

}
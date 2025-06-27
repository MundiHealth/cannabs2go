<?php


namespace OnNow\PrimeiroPay\Services;


use Carbon\Carbon;
use Ixudra\Curl\Facades\Curl;

class PaymentService
{

    public function pay($requestData, $order)
    {

        if($requestData['payment']['payment']['brand'] == 'bankslip'){
            $request = $this->bankSlip($requestData['payment'], $order);
        } else {
            $request = $this->creditCard($requestData['payment'], $order);
        }

        return $this->exec($request);

    }

    protected function creditCard($payment, $order)
    {
        switch ($payment['payment']['brand']){
            case 'mastercard':
                $payment['payment']['brand'] = 'MASTER';
                break;
            case 'AMERICAN-EXPRESS':
            case 'american-express':
                $payment['payment']['brand'] = 'AMEX';
                break;
            default:
                strtoupper($payment['payment']['brand']);
        }

        $request = [
            'amount' => number_format($this->applyInstallmentTax($order->grand_total, $payment['payment']['installment']), 2, '.', ''),
            'currency' => $order->order_currency_code,
            'paymentBrand' => strtoupper($payment['payment']['brand']),
            'paymentType' => 'DB',
            'entityId' => core()->getConfigData('sales.paymentmethods.primeiropay.entityIDCreditCard'),
            'card.number' => (int) filter_var($payment['payment']['number'], FILTER_SANITIZE_NUMBER_INT),
            'card.holder' => $payment['payment']['holder'],
            'card.expiryMonth' => str_pad($payment['payment']['month'], 2, 0, STR_PAD_LEFT),
            'card.expiryYear' => $payment['payment']['year'],
            'card.cvv' => filter_var($payment['payment']['cvv'], FILTER_SANITIZE_NUMBER_INT),
            'recurring.numberOfInstallments' => $payment['payment']['installment'],
            'merchantTransactionId' => $order->increment_id,
        ];

        $request['customer.identificationDocType'] = 'TAXSTATEMENT';
        $request['customer.identificationDocId'] = $payment['payment']['taxvat'];

        return $request;
    }

    public function applyInstallmentTax($amount, $installments)
    {
        $tax = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
        ];

        $tax = $tax[$installments] / 100;
        $total = $amount * (1 + $tax);

        return $total;
    }

    protected function bankSlip($payment, $order)
    {
        $billingAddress = $order->billingAddress;
        $request = [
            'amount' => number_format($order->grand_total, 2, '.', ''),
            'currency' => $order->order_currency_code,
            'paymentBrand' => 'BOLETO',
            'paymentType' => 'PA',
            'entityId' => core()->getConfigData('sales.paymentmethods.primeiropay.entityIDBankSlip'),
            'customer.givenName' => $order->customer_first_name,
            'customer.surname' => $order->customer_last_name,
            'customer.email' => $order->customer_email,
            'billing.street1' => $billingAddress->address1,
            'billing.street2' => $billingAddress->address2,
            'billing.city' => $billingAddress->city,
            'billing.state' => $billingAddress->state,
            'billing.postcode' => $billingAddress->postcode,
            'billing.country' => 'BR',
            'customParameters[CUSTOM_due_date]' => Carbon::now()->addDays(5)->format('dmY'),
            'merchantTransactionId' => $order->increment_id,
            'shopperResultUrl' => url('/'),
            'notificationUrl' => url('/primeiropay/postback')
        ];

        $request['customer.identificationDocType'] = 'TAXSTATEMENT';
        $request['customer.identificationDocId'] = $billingAddress->taxvat;

        return $request;
    }

    protected function getHeaders()
    {
        return [
            "Authorization: Bearer " . core()->getConfigData('sales.paymentmethods.primeiropay.token'),
        ];
    }

    protected function getEndpoint()
    {
        if(!core()->getConfigData('sales.paymentmethods.primeiropay.endpoint')){
            return 'https://test.oppwa.com/v1/payments';
        }

        return 'https://oppwa.com/v1/payments';
    }

    protected function exec($request)
    {
        $response = Curl::to($this->getEndpoint())
            ->withData($request)
            ->withHeaders($this->getHeaders())
            ->post();

        return $response;
    }

}
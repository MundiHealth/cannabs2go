<?php

namespace OnNow\CambioReal\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use OnNow\CambioReal\Models\OrderPayment;
use OnNow\CambioReal\Services\CambioReal;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\OrderRepository;

class PaymentController extends Controller
{
    /**
     * OrderRepository object
     *
     * @var array
     */
    protected $orderRepository;

    /**
     * OrderPayment object
     *
     * @var OrderPayment
     */
    protected $orderPaymentModel;

    /**
     * @param OrderRepository $orderRepository
     * @param OrderPayment $orderPaymentModel
     */
    public function __construct(
        OrderRepository $orderRepository,
        OrderPayment $orderPaymentModel
    )
    {
        $this->orderRepository = $orderRepository;

        $this->orderPaymentModel = $orderPaymentModel;
    }

    public function callback()
    {
        $cart = Cart::getCart();
        $orderExists = Order::query()
            ->where('cart_id', $cart->id)
            ->where('status', 'pending_payment')
            ->first();

        $requestData = session()->all();
        $paymentData = $requestData['payment'];
        $paymentDataInfo = $requestData['payment']['payment'];
        $method = $paymentDataInfo['brand'];

        if($orderExists){
            $order = $orderExists;
        } else {
            $order = $this->orderRepository->create(Cart::prepareDataForOrder());
        }

        Log::info('Customer Data: ' . json_encode([
                "first_name" => $order->customer->first_name,
                "last_name" => $order->customer->last_name,
                "order_number" => $order->increment_id,
                "ip_address" => request()->ip(),
            ]));

        $link_groups = [7, 2];

        if ($method == 'link' && !in_array($order->customer->customer_group_id, $link_groups)){
            $this->orderRepository->cancel($order->id);
            return redirect(route('shop.checkout.failure'));
        }

        $order->payment->method_title = $method;
        $order->payment->update();

        $orderPayment = $this->orderPaymentModel->find($order->payment->id);

        $payment = new CambioReal();

        if($orderExists){
            $payment->cancel($orderPayment->ext_transaction_code);
        }

        $payment->pay($paymentDataInfo, $method, $order);

        Log::info('CambioReal Payment Response: ' . json_encode($payment->response));

        if($payment->response->status == 'success'){

            $orderPayment->ext_transaction_code = $payment->response->data->id;
            $orderPayment->update();

            $order->status = 'pending_payment';
            $order->update();

            if ($method == 'link'){
                return redirect($payment->response->data->checkout);
            }

            session()->flash('order', $order);
            session()->flash('payment', $payment->response->data->transaction);

            return redirect(route('shop.checkout.success'));
        } else {

            $order->cart_id = null;
            $order->status = 'pending_payment';
            $order->update();

            session()->flash('error', $payment->response->status.': '.$payment->response->message);

            return redirect(route('shop.checkout.failure'));
        }

    }

    public function postback(){
        Log::info('CambioReal Postback Started');

        $id = request()->get('id');
        $token = request()->get('token');

        $transaction = new CambioReal();
        $transaction->get($id, $token);

        Log::info('CambioReal Postback Query Response: ' . json_encode($transaction->response));

        if ($transaction->response->status == 'success') {
            $orderPayment = $this->orderPaymentModel->where('ext_transaction_code', $token)->first();
            $order = $this->orderRepository->findOrFail($orderPayment->order_id);

            if ($transaction->response->data->status == 'SOLICITACAO_PAGO') {
                $order->status = 'processing';
                $order->update();
            }

            if ($transaction->response->data->status == 'REFUNDED') {
                $this->orderRepository->cancel($order->id);
            }

            if ($transaction->response->data->status == 'BOLETO_CANCELADO' ||
                $transaction->response->data->status == 'BOLETO_EXPIRADO' ||
                $transaction->response->data->status == 'SOLICITACAO_CANCELADA' ||
                $transaction->response->data->status == 'SOLICITACAO_RECUSADA') {
                $order->status = 'canceled';
                $order->update();
            }
        }

        Log::info('CambioReal Postback Ended');

        return response([])->setStatusCode(200);
    }

    public function blockAtack($order)
    {
        preg_match('/^\((\d{2})\)/', $order->billingAddress->phone, $output);

        $cepBlackList = [
            "88220-000",
            "85867-400"
        ];

        if ($output[1] == 45 && in_array($order->billingAddress->postcode, $cepBlackList)) {
            return true;
        }

        return false;
    }

}
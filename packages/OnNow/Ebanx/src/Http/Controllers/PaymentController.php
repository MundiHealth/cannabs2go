<?php

namespace OnNow\Ebanx\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use OnNow\Ebanx\Models\OrderPayment;
use OnNow\Ebanx\Services\Ebanx;
use Webkul\Admin\Mail\RefusedPaymentNotification;
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

        //$link_groups = [8, 10];

        //if ($method == 'link' && !in_array($order->customer->customer_group_id, $link_groups)){
        //    $this->orderRepository->cancel($order->id);
        //    $order->delete();
        //    return redirect(route('shop.checkout.failure'));
        //}

        if($this->freeOrder($order)) {
            $order->payment->method_title = 'Free';
            $order->payment->update();

            $order->status = 'processing';
            $order->update();

            session()->flash('order', $order);

            return redirect(route('shop.checkout.success'));
        }

        $order->payment->method_title = $method;
        $order->payment->update();

        $orderPayment = $this->orderPaymentModel->find($order->payment->id);

        $payment = new Ebanx();

        if($orderExists){
            $payment->cancel($orderPayment->ext_transaction_code);
        }

        $payment->pay($paymentDataInfo, $method, $order);

        if($payment->response->status == 'SUCCESS'){

            $orderPayment->ext_transaction_code = $payment->response->payment->hash;
            $orderPayment->update();

            $order->status = 'pending_payment';
            $order->update();

            if ($method == 'link'){
                return redirect($payment->response->redirect_url);
            }

            session()->flash('order', $order);
            session()->flash('payment', $payment->response->payment);

            return redirect(route('shop.checkout.success'));
        } else {

            $order->cart_id = null;
            $order->status = 'pending_payment';
            $order->update();

            Mail::queue(new RefusedPaymentNotification($order));

            session()->flash('error', $payment->response->status.': '.$payment->response->status_message);

            return redirect(route('shop.checkout.failure'));
        }

    }

    public function postback(){
        Log::info('Ebanx Postback Started');
        $hash = request()->get('hash_codes');
        $operation = request()->get('operation');
        Log::info('Ebanx Postback Operation: ' . $operation);

        if ($operation != 'payment_status_change')
            return;

        $ebanx = new Ebanx();
        $query = $ebanx->query($hash);
        Log::info('Ebanx Postback Query Response: ' . json_encode($query));

        if ($query->payment->status == 'CO') {
            $orderPayment = $this->orderPaymentModel->where('ext_transaction_code', $hash)->first();
            $order = $this->orderRepository->findOrFail($orderPayment->order_id);

            if ($order->status == 'pending_payment'){
                $order->status = 'processing';
                $order->update();
                $order->payment->update();
            }
        }

        if ($query->payment->status == 'CA') {
            $orderPayment = $this->orderPaymentModel->where('ext_transaction_code', $hash)->first();

            if (!$orderPayment)
                return;

            $order = $this->orderRepository->findOrFail($orderPayment->order_id);

            if($order->grand_total == 0 || $order->grand_total_invoiced > 0)
                return;

            if($order->status == 'canceled' || $order->status == 'invoiced' || $order->status == 'separation' || $order->status == 'dispatched')
                return;

            $order->status = 'pending_payment';
            $order->update();

            if (isset($query->payment->transaction_status) && $query->payment->transaction_status->code == 'NOK'){

                Mail::queue(new RefusedPaymentNotification($order));

                $this->orderRepository->cancel($order->id);
                Log::info('Ebanx Postback Cancellation: ' . $query->payment->transaction_status->description);
            }
        }

        Log::info('Ebanx Postback Ended');
        return;
    }

    public function freeOrder($order)
    {
        if ($order->base_grand_total == 0) {
            return true;
        }

        return false;
    }

}
<?php


namespace OnNow\PrimeiroPay\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use OnNow\PrimeiroPay\Models\PpayTransaction;
use OnNow\PrimeiroPay\Services\PaymentService;
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

    protected $ppayTransactionModel;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\OrderRepository  $orderRepository
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        PpayTransaction $ppayTransaction
    )
    {
        $this->orderRepository = $orderRepository;
        $this->ppayTransactionModel = $ppayTransaction;
    }

    public function callback()
    {
        $cart = Cart::getCart();
        $orderExists = Order::query()
            ->where('cart_id', $cart->id)
            ->where('status', 'pending_payment')
            ->first();

        $requestData = session()->all();

        if($orderExists){
            $order = $orderExists;
        } else {
            $order = $this->orderRepository->create(Cart::prepareDataForOrder());
        }

        $order->payment->method_title = $requestData['payment']['payment']['brand'];
        $order->payment->update();

        $payment = new PaymentService();
        $response = $payment->pay($requestData, $order);

        $this->ppayTransactionModel::create([
            'order_id' => $order->id,
            'response' => $response
        ]);

        $response = json_decode($response);

        $successfullyProcessedTransactions = '/^(000\.000\.|000\.100\.1|000\.[36])/';
        $successfullyProcessedTransactionsmanuallyReviewed = '/^(000\.400\.0|000\.400\.100)/';
        $pendingTransactions = '/^(000\.200)/';
        $failureTransactions = '/^(100\.100)/';
        $errorTransactions = '/^(200\.300)/';
        $otherErrorTransactions = '/^(600\.200)/';

        if(preg_match($successfullyProcessedTransactions, $response->result->code)){


            if($requestData['payment']['payment']['brand'] == 'bankslip'){
                $order->status = 'pending_payment';
                $order->update();
            } else {
                $order->status = 'processing';
                $order->update();
            }

            session()->flash('order', $order);
            session()->flash('payment', $response);

            return redirect(route('shop.checkout.success'));
        } elseif (
            preg_match($successfullyProcessedTransactionsmanuallyReviewed, $response->result->code) ||
            preg_match($pendingTransactions, $response->result->code) ||
            preg_match($failureTransactions, $response->result->code) ||
            preg_match($errorTransactions, $response->result->code) ||
            preg_match($otherErrorTransactions, $response->result->code)
        ) {

            $order->cart_id = null;
            $order->status = 'pending_payment';
            $order->update();

//            $this->orderRepository->cancel($order->id);

            session()->flash('error', $response->result->code.': '.$response->result->description);

            return redirect(route('shop.checkout.failure'));
        } else {

            $order->cart_id = null;
            $order->status = 'pending_payment';
            $order->update();

//            $this->orderRepository->cancel($order->id);

            session()->flash('error', $response->result->code.': '.$response->result->description);

            return redirect(route('shop.checkout.failure'));
        }

    }

    public function postback()
    {

        $headers = getallheaders();
        $body = file_get_contents('php://input');

        Log::info('Body: ' . json_encode($body));
        Log::info('Headers: ' . json_encode($headers));

        /* Please refer Using Libsodium in PHP Projects */
        $key_from_configuration = "BA55561248CF58CCE3D06ED5A1BD18C717B5CD81128B5E9379003AAA3575BDB4";
        $iv_from_http_header = $headers['X-Initialization-Vector'];
        $auth_tag_from_http_header = $headers['X-Authentication-Tag'];
        $http_body = $body;

        $key = hex2bin($key_from_configuration);
        $iv = hex2bin($iv_from_http_header);
        $cipher_text = hex2bin($http_body . $auth_tag_from_http_header);

        $result = sodium_crypto_aead_aes256gcm_decrypt($cipher_text, NULL, $iv, $key);
        $response = json_decode($result);

        $increment_id = $response->payload->merchantTransactionId;

        $order = Order::where('increment_id', $increment_id)
            ->where('status', 'pending_payment')
            ->first();

        Log::info($order);

        Log::info('PaymentType: ' . $response->payload->paymentType);

        if($response->payload->paymentType === 'RC'){

            $order->status = 'processing';
            $order->update();

            $this->ppayTransactionModel::create([
                'order_id' => $order->id,
                'response' => $response
            ]);

        }

    }

}
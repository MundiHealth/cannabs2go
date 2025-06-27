<?php

namespace Webkul\API\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use OnNow\Ebanx\Services\Ebanx;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Sales\Models\OrderPayment;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Checkout\Repositories\CartItemRepository;
use Webkul\API\Http\Resources\Sales\Order as OrderResource;
use Webkul\API\Http\Resources\Checkout\Cart as CartResource;
use Cart;
use Webkul\Shipping\Facades\Shipping;

class OrderController extends Controller
{
    protected $cartRepository;
    protected $cartItemRepository;
    protected $orderRepository;
    protected $customerRepository;
    protected $customerAddressRepository;
    protected $orderPaymentModel;

    public function __construct(
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository,
        OrderRepository $orderRepository,
        CustomerRepository $customerRepository,
        CustomerAddressRepository $customerAddressRepository,
        OrderPayment $orderPayment
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->customerAddressRepository = $customerAddressRepository;
        $this->orderPaymentModel = $orderPayment;
    }

    public function createOrder(Request $request)
    {
        $customerData = $request->input('customer');
        $items = $request->input('items');
        $documents = $request->input('documents');
        $paymentMethod = "link";

        $customer = $this->customerRepository->findOneByField('email', $customerData['email']);
        if (!isset($customerData['id']) && !$customer) {
            $customer = $this->customerRepository->create([
                'first_name' => $customerData['first_name'],
                'last_name' => $customerData['last_name'],
                'email' => $customerData['email'],
                'cpf' => $customerData['cpf']
            ]);
        }

        $customerData['billing_address']['customer_id'] = $customer->id;
        $customerData['shipping_address']['customer_id'] = $customer->id;

        // Anexar documentos (exemplo)
        foreach ($documents as $document) {
            //$document->store('documents');
        }

        // Criar carrinho
        foreach ($items as $item) {
            Cart::addProduct($item['product_id'], [
                'quantity' => $item['quantity'],
                'variant_id' => $item['variant_id'] ?? null,
            ]);
        }

        $cart = Cart::getCart();

        $cart->customer_id = $customer->id;
        $cart->customer_email = $customer->email;
        $cart->customer_first_name = $customer->first_name;
        $cart->customer_last_name = $customer->last_name;

        $billing_address = $this->customerAddressRepository->create($customerData['billing_address']);
        $shipping_address = $this->customerAddressRepository->create($customerData['shipping_address']);


        Cart::saveCustomerAddress([
            "billing" => array_merge($customerData['billing_address'], ['address_id' => $billing_address->id, 'first_name' => $customer->first_name, 'last_name' => $customer->last_name, 'email' => $customer->email]),
            "shipping" => array_merge($customerData['shipping_address'], ['address_id' => $shipping_address->id, 'first_name' => $customer->first_name, 'last_name' => $customer->last_name, 'email' => $customer->email]),
        ]);


        $carrier = Shipping::collectRates($shipping_address->postcode);
        $method = $carrier['shippingMethods']['matrixrate']['rates'][0];

        Cart::saveShippingMethod($method->method);

        Cart::savePaymentMethod([
            "method" => "ebanx"
        ]);

        Cart::collectTotals();

        $this->validateOrder();

        $order_data = Cart::prepareDataForOrder();
        $order_data['channel_id'] = "";

        $order = $this->orderRepository->create($order_data);

        $order->payment->method_title = $paymentMethod;
        $order->payment->update();

        $orderPayment = $this->orderPaymentModel->find($order->payment->id);

        // Configurar EBANX
        $payment = new Ebanx();
        $payment->pay([], $paymentMethod, $order);

        if($payment->response->status == 'SUCCESS'){

            $orderPayment->ext_transaction_code = $payment->response->payment->hash;
            $orderPayment->update();

            $order->status = 'pending_payment';
            $order->update();

            return response()->json([
                'success' => true,
                'order' => [
                    'order_id' => $order->increment_id,
                    'status' => $order->status,
                    'total' => $order->grand_total,
                ],
                'payment_url' => $payment->response->redirect_url,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $payment->response->status_message,
            ], 400);
        }
    }

    public function refreshLink($id)
    {
        $order = $this->orderRepository->findOrFail($id);

        $payment = new Ebanx();
        $payment->pay([], "link", $order);

        if($payment->response->status == 'SUCCESS'){

            $orderPayment = $this->orderPaymentModel->find($order->payment->id);
            $orderPayment->ext_transaction_code = $payment->response->payment->hash;
            $orderPayment->update();

            return response()->json([
                'success' => true,
                'order' => [
                    'order_id' => $order->increment_id,
                    'status' => $order->status,
                    'total' => $order->grand_total,
                ],
                'payment_url' => $payment->response->redirect_url,
            ]);
        }
    }

    /**
     * Validate order before creation
     *
     * @return mixed
     */
    private function validateOrder()
    {
        $cart = Cart::getCart();

        if (! $cart->shipping_address) {
            throw new \Exception(trans('Please check shipping address.'));
        }

        if (! $cart->billing_address) {
            throw new \Exception(trans('Please check billing address.'));
        }

        if (! $cart->selected_shipping_rate) {
            throw new \Exception(trans('Please specify shipping method.'));
        }

        if (! $cart->payment) {
            throw new \Exception(trans('Please specify payment method.'));
        }
    }
}
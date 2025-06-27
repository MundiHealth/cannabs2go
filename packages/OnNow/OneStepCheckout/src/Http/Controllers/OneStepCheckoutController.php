<?php


namespace OnNow\OneStepCheckout\Http\Controllers;

use OnNow\OneStepCheckout\Http\Requests\CustomerAddressForm;
use Webkul\Checkout\Facades\Cart;
use Webkul\Payment\Facades\Payment;
use Webkul\Sales\Models\Order;
use Webkul\Shipping\Facades\Shipping;
use Webkul\Shop\Http\Controllers\OnepageController;

class OneStepCheckoutController extends OnepageController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Cart::hasError())
            return redirect()->route('shop.checkout.cart.index');

        $cart = Cart::getCart();

        if (! auth()->guard('customer')->check() || $cart->haveDownloadableItems())
            return redirect()->route('customer.session.index', ['checkout']);

        $this->nonCoupon->apply();

        Cart::collectTotals();

        return view($this->_config['view'], compact('cart'));
    }

    public function estimate()
    {
        return [];
    }

    /**
     * Return order short summary
     *
     * @return \Illuminate\View\View
     */
    public function summary()
    {
        $cart = Cart::getCart();

        return response()->json([
            'html' => view('onestepcheckout::checkout.total.summary', compact('cart'))->render()
        ]);
    }

    /**
     * Order success page
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        if (! $order = session('order'))
            return redirect()->route('shop.checkout.cart.index');

        session()->forget('cart');

        $payment = session('payment');
        session()->put('payment', $payment);


        return view($this->_config['view'], compact('order', 'payment'));
    }

    /**
     * Order failure page
     *
     * @return \Illuminate\Http\Response
     */
    public function failure()
    {
        if (! $error = session('error'))
            return redirect()->route('shop.checkout.cart.index');

        return view($this->_config['view'], compact('error'));
    }

    /**
     * Saves payment method.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePayment()
    {
        $payment = request()->get('payment');

        if (Cart::hasError() || ! $payment || ! Cart::savePaymentMethod($payment))
            return response()->json(['redirect_url' => route('shop.checkout.cart.index')], 403);

        $this->nonCoupon->apply();

        Cart::collectTotals();

        $cart = Cart::getCart();

        return response()->json([
            'jump_to_section' => 'review',
            'html' => view('shop::checkout.onepage.review', compact('cart'))->render()
        ]);
    }

    /**
     *
     * Saves customer address.
     *
     * @param CustomerAddressForm $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function saveAddressCheckout(CustomerAddressForm $request)
    {
        $data = request()->all();

        $data['billing']['address1'] = implode(PHP_EOL, array_filter($data['billing']['address1']));
        $data['shipping']['address1'] = implode(PHP_EOL, array_filter($data['shipping']['address1']));

        if (Cart::hasError() || ! Cart::saveCustomerAddress($data)) {
            return response()->json(['redirect_url' => route('shop.checkout.cart.index')], 403);
        } else {
            $cart = Cart::getCart();

            $this->nonCoupon->apply();

            Cart::collectTotals();

            if ($cart->haveStockableItems()) {
                if (! $rates = Shipping::collectRates())
                    return response()->json(['redirect_url' => route('shop.checkout.cart.index')], 403);
                else
                    return response()->json($rates);
            } else {
                return response()->json(Payment::getSupportedPaymentMethods());
            }
        }
    }

    public function getInstallments()
    {
        $installments = collect();
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
            12 => 13.65,
        ];

        $cart = Cart::getCart();


        array_walk($tax, function ($tax, $inst) use ($cart, $installments){
            $tax = $tax / 100;
            $total = ($cart->base_grand_total * (1 + $tax)) / $inst;

            $installments->push([
                'qty' => $inst,
                'value' => core()->formatPrice(core()->convertPrice($total), core()->getCurrentCurrency()->code),
                'total' => core()->formatPrice(core()->convertPrice($total * $inst), core()->getCurrentCurrency()->code),
            ]);

        });

        return response()->json($installments);
    }

    /**
     * Saves order.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveOrder()
    {

        if (Cart::hasError())
            return response()->json(['redirect_url' => route('shop.checkout.cart.index')], 403);

        Cart::collectTotals();

        $this->validateOrder();

        $cart = Cart::getCart();

        $data = request()->get('data');
        parse_str($data, $parsed);
        session()->flash('payment', $parsed);

        if ($redirectUrl = Payment::getRedirectUrl($cart)) {
            return response()->json([
                'success' => true,
                'redirect_url' => $redirectUrl
            ]);
        }

        $order = $this->orderRepository->create(Cart::prepareDataForOrder());

        Cart::deActivateCart();

        session()->flash('order', $order);

        return response()->json([
            'success' => true,
        ]);
    }

}
<?php

namespace Webkul\Shop\Http\Controllers;

use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Illuminate\Support\Facades\Event;
use OnNow\OneStepCheckout\Facades\Cart;
use PDF;

/**
 * Customer controlller for the customer basically for the tasks of customers
 * which will be done after customer authenticastion.
 *
 * @author    Prashant Singh <prashant.singh852@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class OrderController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * OrderrRepository object
     *
     * @var Object
     */
    protected $orderRepository;

    /**
     * InvoiceRepository object
     *
     * @var Object
     */
    protected $invoiceRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Order\Repositories\OrderRepository   $orderRepository
     * @param  \Webkul\Order\Repositories\InvoiceRepository $invoiceRepository
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        InvoiceRepository $invoiceRepository
    )
    {
        $this->middleware('customer');

        $this->_config = request('_config');

        $this->orderRepository = $orderRepository;

        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
    */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $order = $this->orderRepository->findOneWhere([
            'customer_id' => auth()->guard('customer')->user()->id,
            'id' => $id
        ]);

        if (! $order)
            abort(404);

        return view($this->_config['view'], compact('order'));
    }

    /**
     * Print and download the for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $invoice = $this->invoiceRepository->findOrFail($id);

        $pdf = PDF::loadView('shop::customers.account.orders.pdf', compact('invoice'))->setPaper('a4');

        return $pdf->download('invoice-' . $invoice->created_at->format('d-m-Y') . '.pdf');
    }

    public function copy($id)
    {
        try {
            $order = $this->orderRepository->findOneWhere([
                'customer_id' => auth()->guard('customer')->user()->id,
                'id' => $id
            ]);

            if ($order->status == 'pending_payment'){
                session()->flash('error', 'Esse pedido não pode ser copiado, efetue o pagamento do mesmo!');

                return redirect()->back();
            }

            Event::fire('checkout.cart.delete.before');
            Cart::deActivateCart();
            Event::fire('checkout.cart.delete.after');

            session()->put('cart', Cart::create([]));

            foreach($order->items as $item) {
                $productId = $item->product_id;
//                $orderedQty = $item->qty_ordered;
                $data = $item->additional;

                $result = Cart::addProduct($productId, $data);

//                for($i = 1; $i <= $orderedQty; $i++) {
//                    $result = Cart::addProduct($productId, $data);
//                }
            }

            Event::fire('checkout.cart.item.add.after', $result);

//            Cart::collectTotals();
//
//            $cart = Cart::getCart();
//
//            $order->cart_id = $cart->id;
//            $order->update();

            return redirect(route('shop.checkout.onepage.index'));
        } catch (\Exception $e) {
            session()->flash('error', trans($e->getMessage()));

            return redirect()->back();
        }

    }

    public function payment($id)
    {
        try {


            $orderId = $id;

            $order = $this->orderRepository->findOneByField('id', $orderId);


            if ($order->status != 'pending_payment'){
                session()->flash('error', 'Esse pedido não pode mais ser pago!');

                return redirect()->back();
            }

            Event::fire('checkout.cart.delete.before');
            Cart::deActivateCart();
            Event::fire('checkout.cart.delete.after');

            session()->put('cart', Cart::create([]));

            foreach($order->items as $item) {

                $productId = $item->product_id;
                //dd($item->additional['quantity']);

//                $orderedQty = $item->qty_ordered;
                $data = $item->additional;
                $data['quantity'] = $item->qty_ordered;
                //   dd($data['quantity']);

                $result = Cart::addProduct($productId, $data);

//                for($i = 1; $i <= $orderedQty; $i++) {
//                    $result = Cart::addProduct($productId, $data);
//                }
            }

            $result['items_qty'] = $order->total_qty_ordered;

            Event::fire('checkout.cart.item.add.after', $result);

            Cart::collectTotals();

            $cart = Cart::getCart();

            $order->cart_id = $cart->id;
            $order->update();

            return redirect(route('shop.checkout.onepage.index'));
        } catch (\Exception $e) {
            session()->flash('error', trans($e->getMessage()));

            return redirect()->back();
        }
    }
}
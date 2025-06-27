<?php


namespace PureEncapsulations\PreVenda\Http\Controllers;


use Illuminate\Support\Facades\Event;
use OnNow\OneStepCheckout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;

class PreVendaController extends Controller
{
    protected $_config;

    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->_config = request('_config');

        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function view()
    {
        try {
            $this->validate(request(), [
                'order' => 'required'
            ]);

            $orderId = request(['order']);

            $order = $this->orderRepository->findOneByField('increment_id', $orderId);

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
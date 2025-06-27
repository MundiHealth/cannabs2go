<?php


namespace OnNow\OneStepCheckout\Http\Controllers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Models\Order;
use Webkul\Shop\Http\Controllers\CartController as WebkulCartController;

class CartController extends WebkulCartController
{

    /**
     * Method to populate the cart page which will be populated before the checkout process.
     *
     * @return Mixed
     */
    public function index()
    {
        return view($this->_config['view'])->with('cart', Cart::getCart());
    }

    /**
     * Function for guests user to add the product in the cart.
     *
     * @return Mixed
     */
    public function add($id)
    {

        $cart = Cart::getCart();

        if ($cart){
            $orderExists = Order::query()->where('cart_id', $cart->id)->first();

            if ($orderExists){
                session()->flash('error', 'Seu carrinho não pode ser editado por se tratar de uma pré-venda.');
                return redirect()->back();
            }
        } else{
            session()->put('cart', Cart::create([]));
        }
        try {
            $result = Cart::addProduct($id, request()->all());

            if ($result) {
                session()->flash('success', trans('shop::app.checkout.cart.item.success'));

                if ($customer = auth()->guard('customer')->user())
                    $this->wishlistRepository->deleteWhere(['product_id' => $id]);

                if (request()->get('is_buy_now'))
                    return redirect()->route('shop.checkout.onepage.index');
            } else {
                session()->flash('warning', trans('shop::app.checkout.cart.item.error-add'));
            }
        } catch(\Exception $e) {
            session()->flash('error', trans($e->getMessage()));

            $product = $this->productRepository->find($id);

            return redirect()->route('shop.products.index', ['slug' => $product->url_key]);
        }

        return redirect()->back();
    }


    public function cartClear()
    {
        session()->forget('cart');

        return redirect()->back();
    }

}
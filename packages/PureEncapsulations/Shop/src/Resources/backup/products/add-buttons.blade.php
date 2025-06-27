<div class="product-action">
    @if ($product->type == "configurable")

        <a href="{{ route('shop.products.index', $product->url_key) }}"><i class="fas fa-shopping-cart"></i> <span>Comprar</span></a>
    @else

        <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" value="false" name="is_configurable">
            <button  {{ $product->isSaleable() ? '' : 'disabled' }}><i class="fas fa-shopping-cart"></i> <span>Comprar</span></button>
        </form>
    @endif
</div>
{!! view_render_event('bagisto.shop.products.price.before', ['product' => $product]) !!}

@inject ('priceHelper', 'Webkul\Product\Helpers\Price')

<div class="pro-price">

    @if ($product->type == 'configurable')
        {!! $product->getTypeInstance()->getPriceHtml() !!}
    @else
        @if ($priceHelper->haveSpecialPrice($product))
            <span class="regular-price">{{ core()->currency($product->price, $product) }}</span>
            <span class="special-price">{{ core()->currency($priceHelper->getSpecialPrice($product), $product) }}</span>
        @else
            <span>{{ core()->currency($product->price, $product) }}</span>
        @endif
    @endif
</div>

{!! view_render_event('bagisto.shop.products.price.after', ['product' => $product]) !!}
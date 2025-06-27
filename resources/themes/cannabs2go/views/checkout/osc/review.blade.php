@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
<ul class="widget-products">
    @foreach ($cart->items as $item)
        @php
            $productBaseImage = $productImageHelper->getProductBaseImage($item->product)
        @endphp

        <li>
            <div class="widget-products-image">
                <img src="{{ $productBaseImage['medium_image_url'] }}">
            </div>
            <div class="widget-products-body">
                <h6 class="widget-products-title">{{ $item->product->name }}</h6>
                <p class="widget-products-price"><b>{{ core()->currency($item->base_price, $item->product) }}</b></p>
                <div class="widget-products-quantity"><b>{{ __('shop::app.checkout.onepage.quantity') }}:</b>  {{ $item->quantity }}</div>
                @if (isset($item->additional['attributes']))
                <div class="widget-products-variations">
                    @foreach ($item->additional['attributes'] as $attribute)
                        <b>{{ $attribute['attribute_name'] }}: </b>{{ $attribute['option_label'] }}</br>
                    @endforeach
                </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
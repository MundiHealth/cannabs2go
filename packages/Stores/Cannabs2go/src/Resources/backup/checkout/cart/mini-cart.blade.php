@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')

<?php $cart = cart()->getCart(); ?>

@if ($cart)
    <li class="cart-icon">
        <a href="{{ route('shop.checkout.cart.index') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-shopping-cart"></i></a> <span>{{ $cart->items()->sum('quantity') }}</span>

        <div class="dropdown-menu dropdown-menu-right">
            <div class="widget">
                <?php $items = $cart->items; ?>
                <ul class="widget-products">
                    @foreach ($items as $item)

                        @php
                            $productBaseImage = $productImageHelper->getProductBaseImage($item->product)
                        @endphp

                        <li>
                            <div class="widget-products-image">
                                <a href="{{ route('shop.products.index', $item->product->url_key) }}"><img src="{{ $productBaseImage['small_image_url'] }}" alt="{{ $item->name }}"></a>
                            </div>
                            <div class="widget-products-body">
                                {!! view_render_event('bagisto.shop.checkout.cart-mini.item.name.before', ['item' => $item]) !!}

                                <h6 class="widget-products-title">
                                    <a href="{{ route('shop.products.index', $item->product->url_key) }}">{{ $item->name }}</a>
                                </h6>

                                {!! view_render_event('bagisto.shop.checkout.cart-mini.item.name.after', ['item' => $item]) !!}

                                {!! view_render_event('bagisto.shop.checkout.cart-mini.item.price.before', ['item' => $item]) !!}

                                <p class="widget-products-price"><b>{{ core()->currency($item->base_total) }}</b></p>

                                {!! view_render_event('bagisto.shop.checkout.cart-mini.item.price.after', ['item' => $item]) !!}

                                {!! view_render_event('bagisto.shop.checkout.cart-mini.item.quantity.before', ['item' => $item]) !!}

                                {!! view_render_event('bagisto.shop.checkout.cart-mini.item.quantity.after', ['item' => $item]) !!}

                                {!! view_render_event('bagisto.shop.checkout.cart-mini.item.options.before', ['item' => $item]) !!}

                                @if (isset($item->additional['attributes']))
                                    <div class="widget-products-variations">
                                        @foreach ($item->additional['attributes'] as $attribute)
                                            <b>{{ $attribute['attribute_name'] }}: </b>{{ $attribute['option_label'] }}</br>
                                        @endforeach
                                    </div>
                                @endif

                                {!! view_render_event('bagisto.shop.checkout.cart-mini.item.options.after', ['item' => $item]) !!}

                            </div>

                            <div class="widget-products-qty"><b>Qtde:</b> {{ $item->quantity }}</div>
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('shop.checkout.cart.index') }}" class="btn">{{ __('shop::app.minicart.view-cart') }}</a>
                <a href="{{ route('shop.checkout.onepage.index') }}" class="btn">{{ __('shop::app.minicart.checkout') }}</a>
            </div>
        </div>
    </li>
@else
    <li class="cart-icon">
        <a href="{{ route('shop.checkout.cart.index') }}"><i class="fas fa-shopping-cart"></i></a>
    </li>
@endif
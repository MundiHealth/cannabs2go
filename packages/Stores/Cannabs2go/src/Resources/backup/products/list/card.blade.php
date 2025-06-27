
@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
@php($productBaseImage = $productImageHelper->getProductBaseImage($product))

<div class="col-6 col-md-3">
    <div class="product-wrapper text-center mb-15 mt-15">
        <div class="product-img">
            <a href="{{ route('shop.products.index', $product->url_key) }}">
                <img src="{{ $productBaseImage['medium_image_url'] }}"  onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'" alt="{{ $product->name }}" />
            </a>

            <div class="product-action">
                @include('shop::products.wishlist')

                <a href="{{ route('shop.products.index', $product->url_key) }}" title="Saiba Mais"><i class="fas fa-search"></i></a>
            </div>

        </div>
        <div class="product-text">
            <h4>
                <a href="{{ route('shop.products.index', $product->url_key) }}">{{ $product->name }}</a>
            </h4>
            <div class="pro-rating">
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
            </div>
            @include ('shop::products.price', ['product' => $product])

            @if($product->available == 0)
                @include('shop::products.add-buttons', ['product' => $product])
            @else
                <p class="available">{{ __('shop::app.products.available') }}</p>
            @endif

        </div>


    </div>
</div>
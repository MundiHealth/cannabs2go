@php($productRepository = app('PureEncapsulations\Product\Repositories\ProductRepository'))
<div class="row">
    <div class="col-xl-12">

        <div class="products">
            @foreach($productRepository->getAll('34') as $product)
                @include ('shop::products.list.card', ['product' => $product])
            @endforeach
        </div>

    </div>
</div>
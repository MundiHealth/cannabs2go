@if (app('Webkul\Product\Repositories\ProductRepository')->getDestaqueProducts()->count())
    <section class="featured-products">
        <div class="products">

            @foreach (app('Webkul\Product\Repositories\ProductRepository')->getDestaqueProducts() as $productFlat)

                @include ('shop::products.list.card', ['product' => $productFlat])

            @endforeach

        </div>

    </section>
@endif
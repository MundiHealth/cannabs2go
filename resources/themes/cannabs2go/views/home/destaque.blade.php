@php($productRepository = app('PureEncapsulations\Product\Repositories\ProductRepository'))

@foreach($productRepository->getByAttributeValue('destaque_home', '1') as $product_dest)
    <div class="categories-item">
        @switch($product_dest->sku)
            @case('1171')
            <div class="categories-wrapper text-center mb-30" style="background-image: url('{{ bagisto_asset('img/home/destaque-pure.png') }}')">
                <a href="{{url()->to('/produtos/hemp-extract-vesisorb')}}">
                        <span class="price">
                            @if ($product_dest->type == 'configurable')
                                {!! $product_dest->getTypeInstance()->getPriceHtml() !!}
                            @else
                                por <br> {{ core()->currency($product_dest->price) }}
                            @endif
                        </span>
                </a>
            </div>
            @break;

            @case('gar227')
            <div class="categories-wrapper text-center mb-30" style="background-image: url('{{ bagisto_asset('img/home/destaque-garden.png') }}')">
                <a href="{{url()->to('/produtos/dr-formulated-cbd-sleep-30-softgels')}}">
                        <span class="price">
                            @if ($product_dest->type == 'configurable')
                                {!! $product_dest->getTypeInstance()->getPriceHtml() !!}
                            @else
                                por <br> {{ core()->currency($product_dest->price) }}
                            @endif
                        </span>
                </a>
            </div>
            @break;

            @case('hea08')
            <div class="categories-wrapper text-center mb-30" style="background-image: url('{{ bagisto_asset('img/home/destaque-healist.png') }}')">
                <a href="{{url()->to('/produtos/relief-drops')}}">
                        <span class="price">
                            @if ($product_dest->type == 'configurable')
                                {!! $product_dest->getTypeInstance()->getPriceHtml() !!}
                            @else
                                por <br> {{ core()->currency($product_dest->price) }}
                            @endif
                        </span>
                </a>
            </div>
            @break;
        @endswitch
    </div>
@endforeach
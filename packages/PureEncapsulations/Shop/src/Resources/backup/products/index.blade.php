@extends('shop::layouts.master')

@section('page_title')
    {{ $category->meta_title ?? $category->name }}
@stop

@section('seo')
    <meta name="description" content="{{ $category->meta_description }}"/>
    <meta name="keywords" content="{{ $category->meta_keywords }}"/>
@stop

@section('body_class')
    page-categorie
@stop

@section('content-wrapper')
    @inject ('productRepository', 'PureEncapsulations\Product\Repositories\ProductRepository')

    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>{{ $category->name }}</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="/">Home</a></li>
                            <li><span>{{ $category->name }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @switch($category->name)
        @case('PureGI™')
            @php($img = 'puregi.png')
            @php($pdf = 'protocolo-de-otimizacao-de-microbiomas-puregi.pdf')
            @break

        @case('PureWoman™')
            @php($img = 'purewoman.png')
            @php($pdf = 'protocolo-destoxificacao-purewoman.pdf')
            @break

       @case('PureGenomics®™')
            @php($img = 'puregenomics.png')
            @php($pdf = 'puregenomics.pdf')
            @break

        @case('PureHeart®')
            @php($img = 'pureheart.png')
            @php($pdf = '')
            @break

        @case('PureLean®')
            @php($img = 'purelean.png')
            @php($pdf = 'protocolo-de-gerenciamento-de-peso-saudavel-purelean.pdf')
            @break

        @case('PureSYNAPSE™')
            @php($img = 'puresynapse.png')
            @php($pdf = 'protocolo-de-gerenciamento-de-stress-puresynapse.pdf')
            @break

        @case('PureResponse™')
            @php($img = 'pureresponse.png')
            @php($pdf = 'protocolo-suporte-imunologico.pdf')
            @break

        @default
            @php($img = '')
            @php($pdf = '')
            @break
     @endswitch

    @if(!empty($img) or !empty($pdf))
     <div class="protocol-download">
        <div class="container" style="background-image: url('{{ bagisto_asset('img/protocols/'.$img) }}')">
            <div class="col-lg-12">
                <div class="row">
                    <div>
                    <a href="{{ bagisto_asset('files/protocols/'.$pdf) }}" class="btn" target="_blank">Faça o download do Protocolo {{$category->name}}.</a>
                    </div>
                </div>
            </div>
        </div>
     </div>
     @endif

     <div class="product-area pos-relative pt-40 pb-60 fix">
        <div class="container">
            <div class="row">

                @php($products = $productRepository->getAll($category->id))

                @if ($products->count())
                <div class="col-lg-3">
                    @if (in_array($category->display_mode, [null, 'products_only', 'products_and_description']))
                        @include ('shop::products.list.layered-navigation')
                    @endif
                </div>
                <div class="col-lg-9">

                    @include ('shop::products.list.toolbar')

                    <div class="row">
                        @foreach ($products as $productFlat)

                            @include ('shop::products.list.card', ['product' => $productFlat])

                        @endforeach
                    </div>
                </div>
                @else

                @endif

            </div>
            <div class="row">

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="basic-pagination basic-pagination-2 text-center mt-20">
                        {{ $products->links('shop::products.list.pagination') }}
                    </div>
                </div>
            </div>
        </div>
     </div>
@stop

@push('scripts')
<script>
$(document).ready(function() {
    $('.filter-title .fa-chevron-down').on('click', function(event) {
        $('.filter-content').stop().slideToggle('slow');
        event.stopPropagation();
    });

    $('.pro-filter-title .fa-chevron-down').on('click', function(event) {
        $('.pro-filter').stop().slideToggle('slow');
        event.stopPropagation();
    });

    $('.responsive-layred-filter').css('display','none');
    $(".sort-icon, .filter-icon").on('click', function(e){
        var currentElement = $(e.currentTarget);
        if (currentElement.hasClass('sort-icon')) {
            currentElement.removeClass('sort-icon');
            currentElement.addClass('icon-menu-close-adj');
            currentElement.next().removeClass();
            currentElement.next().addClass('icon filter-icon');
            $('.responsive-layred-filter').css('display','none');
            $('.pager').css('display','flex');
            $('.pager').css('justify-content','space-between');
        } else if (currentElement.hasClass('filter-icon')) {
            currentElement.removeClass('filter-icon');
            currentElement.addClass('icon-menu-close-adj');
            currentElement.prev().removeClass();
            currentElement.prev().addClass('icon sort-icon');
            $('.pager').css('display','none');
            $('.responsive-layred-filter').css('display','block');
            $('.responsive-layred-filter').css('margin-top','10px');
        } else {
            currentElement.removeClass('icon-menu-close-adj');
            $('.responsive-layred-filter').css('display','none');
            $('.pager').css('display','none');
            if ($(this).index() == 0) {
                currentElement.addClass('sort-icon');
            } else {
                currentElement.addClass('filter-icon');
            }
        }
    });
});
</script>
@endpush
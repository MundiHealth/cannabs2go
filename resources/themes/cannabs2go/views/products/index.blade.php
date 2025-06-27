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

     <div class="product-area pos-relative pt-30 pb-60 fix">
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

    $('.brands').slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 300,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-right"></i></button>',
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 460,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
});
</script>
@endpush
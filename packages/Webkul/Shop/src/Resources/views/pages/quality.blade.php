@extends('shop::layouts.master')

@php
    $channel = core()->getCurrentChannel();

    $homeSEO = $channel->home_seo;

    if (isset($homeSEO)) {
        $homeSEO = json_decode($channel->home_seo);

        $metaTitle = $homeSEO->meta_title;

        $metaDescription = $homeSEO->meta_description;

        $metaKeywords = $homeSEO->meta_keywords;
    }
@endphp

@section('seo')
    <meta name="description" content="{{ isset($metaDescription) ? $metaDescription : "" }}"/>
@stop

@section('page_title')
    {{ isset($metaTitle) ? $metaTitle : "" }}
@endsection

@section('head')

    @if (isset($homeSEO))
        @isset($metaTitle)
            <meta name="title" content="{{ $metaTitle }}" />
        @endisset

        @isset($metaDescription)
            <meta name="description" content="{{ $metaDescription }}" />
        @endisset

        @isset($metaKeywords)
            <meta name="keywords" content="{{ $metaKeywords }}" />
        @endisset
    @endif
@endsection

@section('body_class')
page-home
@stop

@section('content-wrapper')
    {!! view_render_event('bagisto.shop.home.content.before') !!}

{{--    {!! DbView::make($channel)->field('home_page_content')->with(['sliderData' => $sliderData])->render() !!}--}}

    <!-- slider-start -->
    <div class="slider-area">
        <div class="main-slider">
            <div class="item -bariatric d-flex align-items-center" style="background-image: url('{{ bagisto_asset('img/slider/healist-01.jpg') }}')">
                <div class="container">
                    <div class="col-12 col-sm-6 col-md-5">
                        <div class="slider-content">
                            <h1 data-animation="fadeInUp" data-delay=".6s">Adquira<br>Bariatric Advantage</h1>
                            <p data-animation="fadeInUp" data-delay=".8s">Nossos suplementos são cientificamente projetados para pacientes em cirurgia bariátrica.</p>
                            <a href="{{url()->to('/nossos-produtos/produtos-a-z?sort=name&order=asc')}}" class="btn">Comprar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- slider-end -->

    <!-- categories-area-start -->
    <div class="categories-area pb-80">
        <div class="container">
            <div class="categories">
                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30">
                        <div class="categories-text">
                            <h4>Multivitaminas</h4>
                            <p>Bariatric Advantage possui uma linha abrangente de multivitaminas projetadas especificamente para as demandas nutricionais únicas de pacientes bariátricos.</p>
                            <a href="{{url()->to('/nossos-produtos/multivitamnico')}}" class="btn">Comprar</a>
                        </div>
                    </div>
                </div>

                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30">
                        <div class="categories-text">
                            <h4>Cálcio</h4>
                            <p>Bariatric Advantage possui uma linha completa de cálcio em comprimidos mastigáveis e em pó, projetados para apoiar a absorção de cálcio.</p>
                            <a href="{{url()->to('/nossos-produtos/calcio')}}" class="btn">Comprar</a>
                        </div>
                    </div>
                </div>

                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30">
                        <div class="categories-text">
                            <h4>Substitutos de Refeição e Proteína</h4>
                            <p>Nossa mistura de bebidas em pó para reposição de refeições de alta proteína é enriquecida com mais de 20 vitaminas e minerais essenciais.</p>
                            <a href="{{url()->to('/nossos-produtos/protena')}}" class="btn">Comprar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- categories-area-end -->


    <!-- product-area-start -->
    <div class="product-area pos-relative pt-80 pb-80 fix">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section-title text-center section-circle mb-50">
                        <h1>Mais Vendidos</h1>
                    </div>
                </div>
            </div>
            @include('shop::home.flag-products')
        </div>
    </div>
    <!-- product-area-end -->

    <!-- deficiencies-area-start -->
    <div class="deficiencies-area pt-80 pb-80">
        <div class="container">
            <div class="col-xl-12">
                <div class="section-title text-center section-circle mb-70">
                    <h1>Deficiências Nutricionais</h1>
                </div>
            </div>

            <div class="deficiencies">
                <div class="deficiencies-item">
                    <div class="deficiencies-wrapper text-center mb-30">
                        <div class="deficiencies-text">
                            <img src="{{ bagisto_asset('img/icon/sleeve.png') }}" alt="">
                            <h4>Sleeve</h4>
                            <a href="{{url()->to('/nossos-produtos/')}}">Veja mais</a>
                        </div>
                    </div>
                </div>
                <div class="deficiencies-item">
                    <div class="deficiencies-wrapper text-center mb-30">
                        <div class="deficiencies-text">
                            <img src="{{ bagisto_asset('img/icon/gastric-bypass.png') }}" alt="">
                            <h4>Bypass</h4>
                            <a href="{{url()->to('/nossos-produtos/')}}">Veja mais</a>
                        </div>
                    </div>
                </div>
                <div class="deficiencies-item">
                    <div class="deficiencies-wrapper text-center mb-30">
                        <div class="deficiencies-text">
                            <img src="{{ bagisto_asset('img/icon/band.png') }}" alt="">
                            <h4>Band</h4>
                            <a href="{{url()->to('/nossos-produtos/')}}">Veja mais</a>
                        </div>
                    </div>
                </div>
                <div class="deficiencies-item">
                    <div class="deficiencies-wrapper text-center mb-30">
                        <div class="deficiencies-text">
                            <img src="{{ bagisto_asset('img/icon/bpd.png') }}" alt="">
                            <h4>BPD/DS</h4>
                            <a href="{{url()->to('/nossos-produtos/')}}">Veja mais</a>
                        </div>
                    </div>
                </div>
                <div class="deficiencies-item">
                    <div class="deficiencies-wrapper text-center mb-30">
                        <div class="deficiencies-text">
                            <img src="{{ bagisto_asset('img/icon/gastric-balloon.png') }}" alt="">
                            <h4>Gastric Balloon</h4>
                            <a href="{{url()->to('/nossos-produtos/')}}">Veja mais</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- deficiencies-area-end -->

    <!-- text-area-start -->
    <div class="text-area pos-relative pt-150 pb-150 fix" style="background-image: url('{{ bagisto_asset('img/home/bg.jpg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <h1>Vamos guiá-lo para o produto perfeito</h1>
                    <p>Use nosso filtro de produtos para identificar produtos nutricionais que abordam as deficiências de vitaminas, minerais e proteínas associadas a procedimentos específicos, por cápsula ou forma para mastigar ou por categoria específica, como multis, cálcio, substitutos / proteína de refeição.</p>
                    <a href="{{url()->to('/nossos-produtos/produtos-a-z?sort=name&order=asc')}}" class="btn">Encontre um produto</a>
                </div>
            </div>
        </div>
    </div>
    <!-- text-area-end -->

    {{ view_render_event('bagisto.shop.home.content.after') }}

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // main slider
            $('.main-slider').on('init', function(e, slick) {
                var $firstAnimatingElements = $('div.item:first-child').find('[data-animation]');
                doAnimations($firstAnimatingElements);
            });

            $('.main-slider').slick({
                autoplay: true,
                autoplaySpeed: 10000,
                dots: false,
                fade: true,
                arrows:true,
                prevArrow: '<button type="button" class="slick-prev"> <i class="fas fa-angle-left"></i> </button>',
                nextArrow: '<button type="button" class="slick-next"> <i class="fas fa-angle-right"></i></button>'
            });

            $('.main-slider').on('beforeChange', function(e, slick, currentSlide, nextSlide) {
                var $animatingElements = $('div.item[data-slick-index="' + nextSlide +'"]').find('[data-animation]');
                doAnimations($animatingElements);
            });

            function doAnimations(elements) {
                var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                elements.each(function() {
                    var $this = $(this);
                    var $animationDelay = $this.data('delay');
                    var $animationType = 'animated ' + $this.data('animation');
                    $this.css({
                        'animation-delay': $animationDelay,
                        '-webkit-animation-delay': $animationDelay
                    });
                    $this.addClass($animationType).one(animationEndEvents, function() {
                        $this.removeClass($animationType);
                    });
                });
            }

            $('.categories').slick({
                dots: false,
                arrows: true,
                infinite: true,
                speed: 300,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-right"></i></button>',
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 580,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            // $('.free-from .box-left .section-image span').on('click', function(event) {
            //     $('.free-from .box-right').slideToggle('slow');
            //     event.stopPropagation();
            // });

            $('.products').slick({
                dots: false,
                arrows: true,
                infinite: true,
                speed: 300,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
                slidesToShow: 4,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1024,
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
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.deficiencies').slick({
                dots: false,
                arrows: true,
                infinite: true,
                speed: 300,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
                slidesToShow: 5,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 2
                        }
                    }
                ]
            });
        });
    </script>
@endpush


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

            <div class="item -cbdmd d-flex align-items-center" style="background-image: url('{{ bagisto_asset('img/slider/bg_cbdmd.jpg') }}')">
                <div class="container">
                    <div class="col-12">
                        <div class="slider-content">
                            <div>
                                <img data-animation="fadeInLeft" data-delay=".8s" src="{{ bagisto_asset('img/brands/cbdMD.svg') }}" alt="cbdMD">
                                <p data-animation="fadeInDown" data-delay=".8s">Confira todos os produtos da cbdMD disponíveis em nosso site.</p>

                                <a data-animation="fadeInUp" data-delay=".8s" href="{{ route('shop.categories.index', ['levon']) }}" class="btn">Veja aqui!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider-end -->

    <!-- info-start -->
    <div class="info-area pt-40 pb-40">
        <div class="container">
            <p>Nossos serviços de atendimento e importação de produtos derivados de Cannabis para pessoas físicas e com prescrição válida seguem normalmente.</p>
            <p><a href="javascript:;" data-fancybox data-src="#cannabis" class="btn">Saiba mais!</a></p>
        </div>
    </div>

    <div style="display: none;" id="cannabis">
        <p>O grupo MyPharma2Go, através de seu canal dedicado <b>Cannabs2Go</b>, reforça sua total aderência à Resolução da Diretoria Colegiada da Anvisa 660/22 e mantém sua missão com pacientes e prescritores.</p>

        <p>Os serviços de atendimento aos pacientes, bem como importação de produtos derivados de Cannabis, por pessoa física, para seu próprio uso, com embasamento prescricional de profissionais de saúde legalmente habilitados e respectiva autorização individual emitida pela Anvisa, seguem normalmente. Procedimento com o qual a MyPharma2Go mantém plena aderência e compliance, não apenas na rigidez na qualidade de seu vasto portfólio de produtos derivados de Cannabis para fins estritamente medicinais, mas, principalmente sendo uma entidade legalmente habilitada fora do Brasil, licenciada pelo FDA (Food and Drug Administration), exigência regulatória do modelo de crossborder de produtos para saúde.</p>

        <p>Todos os nossos canais de atendimento estão à disposição de pacientes e prescritores.</p>

        <p>Seguimos no nosso propósito de atender às necessidades dos pacientes, impactando positivamente na sua qualidade de vida e apoiamos e respeitamos o ATO MÉDICO em sua integralidade.</p>

        <p>Atenciosamente, <br>
            <b>Equipe MyPharma2Go</b></p>
    </div>
    <!-- info-end -->

    <!-- intro-start -->
    <div class="intro-area pt-30 pb-30">
        <div class="container">
            <h1>Seu Marketplace de CBD na América Latina</h1>

            <p><strong>Cannabs2go reune marcas renomadas de CBD direto dos EUA para sua casa.</strong></p>

            <p>Ingredientes potentes tirados da natureza através da ciência, com soluções que realmente
            funcionam para manter a qualidade de vida e o bem-estar com o prática diária.</p>
        </div>
    </div>
    <!-- intro-end -->

    <!-- product-area-start -->
    <div class="product-area pos-relative pt-40 pb-40">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section-title text-center">
                        <h2>Mais Vendidos</h2>
                    </div>
                </div>
            </div>
            @include('shop::home.featured-products')
        </div>
    </div>
    <!-- product-area-end -->

    <!-- brands-area-start -->
    <div class="brands-area">
        <div class="container">
            <div class="section-title text-center">
                <h2>Compre por Marca</h2>
            </div>
            <div class="brands">

                <div class="brands-item">
                    <div class="brands-wrapper text-center mb-30">
                        <a href="{{ route('shop.categories.index', ['cbd-md-cannabis']) }}">
                            <img src="{{ bagisto_asset('img/brands/cbdMD.svg') }}" alt="cbdMD" />
                        </a>
                    </div>
                </div>

                <div class="brands-item">
                    <div class="brands-wrapper text-center mb-30">
                        <a href="{{ route('shop.categories.index', ['garden-of-life-cannabis']) }}">
                            <img src="{{ bagisto_asset('img/brands/garden-of-life.svg') }}" alt="Garden Of Life" />
                        </a>
                    </div>
                </div>

                <div class="brands-item">
                    <div class="brands-wrapper text-center mb-30">
                        <a href="{{ route('shop.categories.index', ['designs-for-health-cannabis']) }}">
                            <img src="{{ bagisto_asset('img/brands/designsforhealth.svg') }}" alt="Designs For Health" />
                        </a>
                    </div>
                </div>

                <div class="brands-item">
                    <div class="brands-wrapper text-center mb-30">
                        <a href="{{ route('shop.categories.index', ['panacea-life-sciences']) }}">
                            <img src="{{ bagisto_asset('img/brands/panacea.jpg') }}" alt="Panacea Life Sciences" />
                        </a>
                    </div>
                </div>

                <div class="brands-item">
                    <div class="brands-wrapper text-center mb-30">
                        <a href="{{ route('shop.categories.index', ['foria']) }}">
                            <img src="{{ bagisto_asset('img/brands/foria.png') }}" alt="Foria" />
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- brands-area-end -->

    <!-- pages-start -->
    <div class="pages-area pt-30 pb-30">
        <div class="container">
            <div class="pages">
                <div class="educacao">
                   <div style="background-image: url('{{ bagisto_asset('img/home/banner-educacao.png') }}')">
                       <a href="{{ route('cannabis.site.faq') }}">
                           <span>FAQ</span>
                       </a>
                   </div>
                </div>
                <div class="produtos">
                    <div style="background-image: url('{{ bagisto_asset('img/home/banner-produtos.png') }}')">
                        <a href="{{ route('shop.categories.index', ['produtos-cannabis']) }}">
                            <span>Produtos</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- pages-end -->

    <!-- categories-area-start -->
{{--    <div class="categories-area pt-40 pb-40 clearfix">--}}
{{--        <div class="container">--}}
{{--            <h2>Aproveite</h2>--}}

{{--            <div class="categories">--}}

{{--                @include('shop::home.destaque')--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- categorias-end -->

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

            $('.products').slick({
                autoplay: true,
                autoplaySpeed: 3500,
                dots: false,
                arrows: true,
                infinite: true,
                speed: 300,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-right"></i></button>',
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




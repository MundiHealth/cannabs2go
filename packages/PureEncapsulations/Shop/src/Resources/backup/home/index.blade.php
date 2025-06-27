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
            <div class="item -recomended d-flex align-items-center" style="background-image: url('{{ bagisto_asset('img/slider/slider-01.jpg') }}')">
                <div class="container">
                    <div class="col-11 col-md-9">
                        <div class="slider-content">
                            <img src="{{ bagisto_asset('img/slider/selo.png') }}" class="selo" alt="Pure Encapsulations - Selo">
                            <h1 data-animation="fadeInUp" data-delay=".6s">Chegou Pure Encapsulations</h1>
                            <p data-animation="fadeInUp" data-delay=".8s">A marca de suplementos mais recomendada pelos médicos.</p>
                            <small>*Nutrition Business Journal® 2016</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item -delivery d-flex align-items-center" style="background-image: url('{{ bagisto_asset('img/slider/frete-gratis.jpg') }}')">
                <div class="container">
                    <div class="col-md-8">
                        <div class="slider-content">
                            <img src="{{ bagisto_asset('img/slider/selo-entrega.png') }}" class="selo" alt="Selo - Entrega Garantida">
                            <h1 data-animation="fadeInUp" data-delay=".6s"><b>Frete grátis</b> em compras acima de R$ 300.</h1>
                            <p data-animation="fadeInUp" data-delay=".8s">Parcelamento em até <b>6x sem juros.</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider-end -->

    <!-- categories-area-start -->
    <div class="categories-area pt-80 pb-80">
        <div class="container">
            <div class="col-xl-12">
                <div class="section-title text-center section-circle mb-70">
                    <h1>Áreas de Saúde</h1>
                    <p>Fabricamos uma linha de produtos hipoalergênicos de alta qualidade, para todas as necessidades de saúde de seus pacientes.</p>
                    <p>Os produtos Pure Encapsulations® são fabricados com ingredientes de alta pureza, cientificamente testados e desenvolvidos para fornecer os resultados esperados.</p>
                </div>
            </div>

            <div class="categories">
                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30" style="background: url('{{ bagisto_asset('img/categories/suporte-imunologico.jpg') }}')">
                        <div class="categories-text">
                            <h4>Suporte Imunológico</h4>
                            <a href="{{url()->to('/nossos-produtos/suporte-imunologico')}}">ver produtos</a>
                        </div>
                    </div>
                </div>

                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30" style="background: url('{{ bagisto_asset('img/categories/gastrointestinal.jpg') }}')">
                        <div class="categories-text">
                            <h4>Gastrointestinal</h4>
                            <a href="{{url()->to('/nossos-produtos/gastrointestinal')}}">ver produtos</a>
                        </div>
                    </div>
                </div>

                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30" style="background: url('{{ bagisto_asset('img/categories/figado-destoxificacao.jpg') }}')">
                        <div class="categories-text">
                            <h4>Fígado & Destoxificação</h4>
                            <a href="{{url()->to('/nossos-produtos/figado-destoxificacao')}}">ver produtos</a>
                        </div>
                    </div>
                </div>

                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30" style="background: url('{{ bagisto_asset('img/categories/coracao-e-metabolismo.jpg') }}')">
                        <div class="categories-text">
                            <h4>Coração e Metabolismo</h4>
                            <a href="{{url()->to('/nossos-produtos/coracao-e-metabolismo')}}">ver produtos</a>
                        </div>
                    </div>
                </div>

                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30" style="background: url('{{ bagisto_asset('img/categories/memoria-e-humor.jpg') }}')">
                        <div class="categories-text">
                            <h4>Memória e Humor</h4>
                            <a href="{{url()->to('/nossos-produtos/memoria-e-humor')}}">ver produtos</a>
                        </div>
                    </div>
                </div>

                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30" style="background: url('{{ bagisto_asset('img/categories/hormonio.jpg') }}')">
                        <div class="categories-text">
                            <h4>Hormônio</h4>
                            <a href="{{url()->to('/nossos-produtos/hormonio')}}">ver produtos</a>
                        </div>
                    </div>
                </div>

                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30" style="background: url('{{ bagisto_asset('img/categories/performance-esportiva.jpg') }}')">
                        <div class="categories-text">
                            <h4>Performance Esportiva</h4>
                            <a href="{{url()->to('/nossos-produtos/performance-esportiva')}}">ver produtos</a>
                        </div>
                    </div>
                </div>

                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30" style="background: url('{{ bagisto_asset('img/categories/ossos-articulacoes.jpg') }}')">
                        <div class="categories-text">
                            <h4>Ossos, articulações e músculos</h4>
                            <a href="{{url()->to('/nossos-produtos/ossos-articulacoes-e-musculos')}}">ver produtos</a>
                        </div>
                    </div>
                </div>



                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30" style="background: url('{{ bagisto_asset('img/categories/dormir.jpg') }}')">
                        <div class="categories-text">
                            <h4>Dormir</h4>
                            <a href="{{url()->to('/nossos-produtos/dormir')}}">ver produtos</a>
                        </div>
                    </div>
                </div>

                <div class="categories-item">
                    <div class="categories-wrapper text-center mb-30" style="background: url('{{ bagisto_asset('img/categories/visao.jpg') }}')">
                        <div class="categories-text">
                            <h4>Visão</h4>
                            <a href="{{url()->to('/nossos-produtos/visao')}}">ver produtos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- categories-area-end -->

    <!-- free-from-area-start -->
    <div class="free-from-area pt-90 pb-90 clearfix">
        <div class="container">
            <div class="free-from">
                <div class="section-title">
                    <h2><b>Isentos de -</b> Ingredientes Artificiais, Contaminantes e Alérgenos Comuns</h2>
                </div>

                <div class="section-image">
                    <img src="{{ bagisto_asset('img/free-from.png') }}" alt="Suplementos Isentos de Ingredientes Artificiais, Contaminantes e Alérgenos Comuns">
                </div>

{{--                    <div class="box-left">--}}
{{--                        <div class="section-title">--}}
{{--                            <h2><b>Isentos de -</b> Ingredientes Artificiais, Contaminantes e Alérgenos Comuns</h2>--}}
{{--                        </div>--}}
{{--                        <div class="section-image">--}}
{{--                            <img src="{{ bagisto_asset('img/free-from.png') }}" alt="Medicamentos Isentos de Ingredientes Artificiais, Contaminantes e Alérgenos Comuns" />--}}

{{--                            <span>saiba mais <i class="fas fa-arrow-circle-down"></i></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="box-right">--}}
{{--                        <div class="section-text">--}}
{{--                            <p>Nossos produtos hipoalergênicos são isentos de:</p>--}}
{{--                            <ul>--}}
{{--                                <li>Farinha e Glúten</li>--}}
{{--                                <li>Ovos</li>--}}
{{--                                <li>Amendoim</li>--}}
{{--                                <li>Gordura Trans e Oléos Hidrogenados</li>--}}
{{--                                <li>Organismos Geneticamente Modificados (OGMs)</li>--}}
{{--                                <li>Estearato de Magnésio</li>--}}
{{--                                <li>Revestimentos e Gomas</li>--}}
{{--                                <li>Corantes, aromas e edulcorantes artificiais</li>--}}
{{--                                <li>E outros ingredientes desnecessários, como conservantes, espessantes</li>--}}
{{--                            </ul>--}}

{{--                            <p class="small">Por favor, visite a seção de Garantia de Qualidade do nosso site para mais informações sobre a nossa política de OGMs e certificação sem glúten.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    <!-- free-from-area-end -->

    <!-- product-area-start -->
    <div class="product-area pos-relative pt-80 pb-80 fix">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 offset-lg-2 offset-xl-2">
                    <div class="section-title text-center section-circle mb-50">
                        <h1>Mais Vendidos</h1>
                        <p>Pure Encapsulations oferece uma ampla seleção de suplementos hipoalergênicos de alta qualidade.</p>
                    </div>
                </div>
            </div>
            @include('shop::home.flag-products')
        </div>
    </div>
    <!-- product-area-end -->

    <!-- protocols-area-start -->
    <div class="protocols-area pt-80 pb-80">
        <div class="container">
            <div class="col-xl-6 col-lg-6 offset-lg-3 offset-xl-3">
                <div class="section-title text-center section-circle mb-70">
                    <h1>Protocolos</h1>
                    <p>Nossos protocolos são atualizados com os mais novos produtos e avanços de pesquisa, portanto, verifique com frequência.</p>
                </div>
            </div>

            <div class="protocols">
                <div class="protocols-item">
                    <div class="protocols-wrapper text-center mb-30">
                        <div class="protocols-text">
                            <h4>Gerenciamento de Peso</h4>
                            <p><strong>PureLean® - Protocolo de Gestão de Peso Saudável</strong></p>
                            <p><i>Desenvolvido com Caroline Cederquist, M.D.</i></p>
                            <a href="{{url()->to('/nossos-produtos/purelean')}}">Ver Protocolo <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="protocols-item">
                    <div class="protocols-wrapper text-center mb-30">
                        <div class="protocols-text">
                            <h4>Trato Gastrointestinal</h4>
                            <p><strong>PureGI® - Protocolo de GI Superior</strong></p>
                            <p><i>Desenvolvido com Daniel Kalish, D.C.</i></p>
                            <a href="{{url()->to('/nossos-produtos/puregi')}}">Ver Protocolo <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="protocols-item">
                    <div class="protocols-wrapper text-center mb-30">
                        <div class="protocols-text">
                            <h4>Destoxificação</h4>
                            <p><strong>PureWoman™ - Protocolo de Destoxificação</strong></p>
                            <p><i>Desenvolvido com Felice Gersh, M.D.</i></p>
                            <a href="{{url()->to('/nossos-produtos/purewoman')}}">Ver Protocolo <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="protocols-item">
                    <div class="protocols-wrapper text-center mb-30">
                        <div class="protocols-text">
                            <h4>Saúde da Mulher</h4>
                            <p><strong>PureWoman™ - Pós-Menopausa Metabólica</strong></p>
                            <p><i>Desenvolvido com Felice Gersh, M.D.</i></p>
                            <a href="{{url()->to('/nossos-produtos/purewoman')}}">Ver Protocolo <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="protocols-item">
                    <div class="protocols-wrapper text-center mb-30">
                        <div class="protocols-text">
                            <h4>Humor e Cérebro</h4>
                            <p><strong>PureSYNAPSE™ - Gestão do Stress & Protocolo de Relaxamento</strong></p>
                            <p><i>Desenvolvido com James Greenblatt, M.D.</i></p>
                            <a href="{{url()->to('/nossos-produtos/puresynapse')}}">Ver Protocolo <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="protocols-item">
                    <div class="protocols-wrapper single-protocols text-center mb-30">
                        <div class="protocols-text">
                            <h4>Imunidade</h4>
                            <p><strong>PureResponse™ - Protocolo de Apoio Imune</strong></p>
                            <p><i>Desenvolvido com Samuel F. Yanuck, D.C., FACFN, FIAMA</i></p>
                            <a href="{{url()->to('/nossos-produtos/pureresponse')}}">Ver Protocolo <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{url()->to('/nossos-produtos/protocolos')}}" class="btn">Ver Todos os Protocolos</a>

        </div>
    </div>
    <!-- protocols-area-end -->

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
                        breakpoint: 768,
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

            $('.protocols').slick({
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
                        breakpoint: 769,
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


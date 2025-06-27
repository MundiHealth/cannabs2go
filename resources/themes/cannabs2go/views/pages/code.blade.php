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
    page-code
@stop

@section('content-wrapper')
    {!! view_render_event('bagisto.shop.home.content.before') !!}

    {{--    {!! DbView::make($channel)->field('home_page_content')->with(['sliderData' => $sliderData])->render() !!}--}}

    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>MyCannabisCode</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="/">Home</a></li>
                            <li><span>MyCannabisCode</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- code-area-start -->
    <div class="introcode-area">
        <div class="container">
            <div class="intro">
                <div class="-img">
                    <img src="{{ bagisto_asset('img/code/mycannabiscode.png') }}" alt="MyCannabisCode">
                </div>
                <h2>O teste pioneiro no Brasil para avaliar
                    o melhor canabinoide para você. </h2>
            </div>
        </div>
    </div>

    <div class="code-area pt-60 pb-60">
        <div class="container">
            <div class="mycannabis">
                <p>O <strong>MyCannabisCode</strong> auxilia a prescrição assertiva de canabinoides. Ajuda o médico a escolher
                    a melhor composição e dose adequadas ao paciente.</p>

                <p>Conhecer o perfil genético do paciente é uma ferramenta-chave para melhorar a prescrição de
                    canabinoides, acelerando em muito o tempo de ajuste de dose.</p>

                <p>Economiza tempo e dinheiro, tornando a escolha do produto muito mais assertiva.</p>

                <a href="{{ url()->to('/produtos/mycannabiscode') }}" class="btn">Peça seu teste agora</a>
            </div>

            <div class="beneficios">
                <h2>Benefícios comprovados:</h2>
                <ul>
                    <li>Conheça o metabolismo do CBD e THC pelo seu organismo</li>
                    <li>Conheça a sua vulnerabilidade aos potenciais efeitos adversos</li>
                    <li>Defina a dose ideal para início de tratamento com segurança</li>
                    <li>Defina a melhor composição de produto e posologia para o tratamento</li>
                </ul>
            </div>

            <div class="icones">
                <div class="icone">
                    <img src="{{ bagisto_asset('img/code/1.svg') }}" alt="">
                    <p>Potenciais efeitos adversos</p>
                </div>

                <div class="icone">
                    <img src="{{ bagisto_asset('img/code/2.svg') }}" alt="">
                    <p>Dosagem ideal</p>
                </div>

                <div class="icone">
                    <img src="{{ bagisto_asset('img/code/3.svg') }}" alt="">
                    <p>Metabolismo dos canabinoides</p>
                </div>

                <div class="icone">
                    <img src="{{ bagisto_asset('img/code/4.svg') }}" alt="">
                    <p>Tipos ideais de canabinoides para o seu perfil genético</p>
                </div>

                <div class="icone">
                    <img src="{{ bagisto_asset('img/code/5.svg') }}" alt="">
                    <p>Predisposição para problemas associados ao uso crônico de canabinoides</p>
                </div>
            </div>

            <div class="avalia">
                <h2>O que o MyCannabisCode avalia:</h2>
                <ul>
                    <li>O <strong>MyCannabisCode</strong> avaliar o seu “perfil canabinoides” através
                        dos polimorfismos, as variações genéticas naturais que todos
                        possuímos no nosso DNA;</li>
                    <li>Através da definição dos polimorfismos-alvo, que são relevante
                        para a resposta fisiológica aos canabinoides, realizamos uma
                        genotipagem por array para definir o seu perfil genético específico;</li>
                    <li>Com essa tecnologia, iremos conhecer o seu eu metabolismo do
                        canabidiol (CBD), delta-9-tetrahidrocannabinol (THC) e seus
                        metabólitos;</li>
                    <li>Sua vulnerabilidade aos potenciais efeitos adversos associados à
                        cognição (memória), comportamento (ansiedade, psicose), uso
                        crônico (dependência) e impacto na funcionalidade cotidiana;</li>
                    <li>Com o <strong>MyCannabisCode</strong>, seu médico será capaz de fazer a melhor
                        escolha de produto, de acordo com a sua genética, definindo o
                        tratamento de maneira individualizada.</li>
                </ul>
            </div>

            <div class="frase">
                <p>O <strong><em>MyCannabisCode</em></strong> é uma ferramenta essencial para a otimização
                    terapêutica de maneira individualizada.</p>

                <p>Evite os <b><em>“fantasmas”</em></b> associados à prescrição dos canabinoides e faça uso
                    destas substâncias de maneira segura e sem surpresas.</p>
            </div>

            <div class="code">
                <div class="-img">
                    <a href="">
                        <img src="{{ bagisto_asset('img/home/my-cannabis-code.jpeg') }}" alt="MyCannabisCode" />
                    </a>
                </div>
                <div class="-text">
                    <a href="{{ url()->to('/produtos/mycannabiscode') }}">
                        <h2>Veja como é fácil e prático fazer
                            o teste genético:</h2>

                        <ul>
                            <li>Adicione o teste ao carrinho de compras;</li>
                            <li>Faça o cadastro e realize a compra;</li>
                            <li>O teste chegará em sua casa com entrega rápida
                                e garantida;</li>
                            <li>Faça a auto coleta em casa seguindo as instruções;</li>
                            <li>Envio a coleta para o laborátorio sem custo adicional;</li>
                            <li>Acesse os resultados completos online e compartilhe
                                com o seu médico.</li>
{{--                            <li>Entre em contato no número (11) 97075-5951 para agendar a retirada da coleta.</li>--}}
                        </ul>

                        <p class="btn">Peça seu teste agora</p>
                    </a>

                </div>
            </div>

            <div class="duvidas">
                <div class="-text">

                    <h3>Ainda está com dúvidas?</h3>

                    <p>Entre em contato para falar com nosso atendimento e solicite
                        um report de exemplo.</p>

{{--                    <a href="https://api.whatsapp.com/send?phone=5511970755951" target="_blank" class="btn">--}}
{{--                        Enviar mensagem--}}
{{--                    </a>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- code-area-start -->

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
        });
    </script>
@endpush


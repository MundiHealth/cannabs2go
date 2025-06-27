@extends('shop::layouts.master')

@section('page_title')
    {{ 'FAQ' }}
@endsection

@section('seo')
    <meta name="description" content="{{ '' }}"/>
@stop

@section('body_class')
    page-faq
@stop

@section('content-wrapper')
    {!! view_render_event('bagisto.shop.home.content.before') !!}

    {{--    {!! DbView::make($channel)->field('home_page_content')->with(['sliderData' => $sliderData])->render() !!}--}}

        <div class="breadcrumb-area pt-30 pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="breadcrumb-text text-center">
                            <h1>FAQ Cannabs2GO</h1>
                            <ul class="breadcrumb-menu">
                                <li><a href="/">Home</a></li>
                                <li><span>FAQ Cannabs2GO</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- faq-area-start -->
    <div class="faq-area pt-80 pb-80">
        <div class="container">
            <h2>FAQ</h2>

            <div class="faq">

                <div class="accordion">
                    <div class="question">
                        <h3>Como posso comprar Cannabis?</h3>

                        <div class="-text">
                            <p>O produto chegará de 30 a 45 dias corridos após a confirmação da compra e autorização da ANVISA. Para obtenção da autorização é necessário: foto legível da receita, documento com foto (RG ou CNH) e comprovante de endereço (foto). Caso tenha interesse, entre em contato conosco e envie as informações listadas acima.</p>
                            <ul>
                                <li>E-mail: <a href="mailto:angelica@mypharma2go.com">angelica@mypharma2go.com</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="question">
                        <h3>Como rastrear o seu pedido? </h3>

                        <div class="-text">
                            <p>O código de rastreio do seu pedido será gerado após a liberação do envio para o Brasil, o que leva em torno de 7-13 dias depois da aprovação do pedido. Você receberá um e-mail com esse código e com o link de rastreio assim que ele for gerado.</p>
                            <p>Se você tiver dificuldade ou continuar com dúvidas, entre em contato com <a href="mailto:angelica@mypharma2go.com">angelica@mypharma2go.com</a>.</p>
                        </div>
                    </div>

                    <div class="question">
                        <h3>Qual é o prazo de entrega do produto?</h3>

                        <div class="-text">
                            <p>O prazo de entrega é de 30-45 dias. Veja <a href="javascript:;" class="comprar">"Como posso comprar Cannabis?"</a> para entender os passos envolvidos. </p>
                        </div>
                    </div>

                    <div class="question">
                        <h3>Como fazer sua compra?</h3>

                        <div class="-text">
                            <p>Você pode fazer sua compra diretamente no site acessando <a href="https://cannabs2go.com/" target="_blank">https://cannabs2go.com/</a>.</p>
                            <p><strong>Não esqueça da sua prescrição, sem ela, sua compra não será liberada.</strong></p>
                            <p>Como enviar a prescrição:</p>
                            <ul>
                                <li>E-mail: <a href="mailto:angelica@mypharma2go.com">angelica@mypharma2go.com</a></li>
                                <li>Se você realizar a compra no site, você pode anexar a prescrição na tela de conclusão da compra.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="question">
                        <h3>Quer fazer um orçamento?</h3>

                        <div class="-text">
                            <p>Você pode fazer diretamente no site acessando <a href="https://cannabs2go.com/" target="_blank">https://cannabs2go.com/</a>.</p>
                            <p><strong>Não esqueça da sua prescrição, sem ela, sua compra não será liberada.</strong></p>
                            <p>Como enviar a prescrição:</p>
                            <ul>
                                <li>E-mail: <a href="mailto:angelica@mypharma2go.com">angelica@mypharma2go.com</a></li>
                                <li>Se você realizar a compra no site, você pode anexar a prescrição na tela de conclusão da compra.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="question">
                        <h3>Quais as condições de pagamento? </h3>

                        <div class="-text">
                            <p>Cartão parcelado em até 12x, transferência via pix e boleto.</p>
                        </div>
                    </div>
                    <div class="question">
                        <h3>Como posso entrar em contato com a empresa? </h3>

                        <div class="-text">
                            <ul>
                                <li>E-mail: <a href="mailto:angelica@mypharma2go.com">angelica@mypharma2go.com</a>.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ingredients-area-end -->

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

            // accordion
            $('.accordion > .question:eq(0) h3').addClass('active').next().slideDown();

            $('.accordion h3').click(function(j) {
                var dropDown = $(this).closest('.question').find('.-text');

                $(this).closest('.accordion').find('.-text').not(dropDown).slideUp();

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    $(this).closest('.accordion').find('h3.active').removeClass('active');
                    $(this).addClass('active');
                }

                dropDown.stop(false, true).slideToggle();

                j.preventDefault();
            });

            $('.comprar').click(function () {
                $('.accordion > .question:eq(2) h3').removeClass('active').next().slideUp();

                // Handler for .ready() called.
                $('html, body').animate({
                    scrollTop: $('.accordion > .question:eq(0) h3').addClass('active').next().slideDown().offset().top-136
                }, 'slow');
            });
        });
    </script>
@endpush


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
    page-faq
@stop

@section('content-wrapper')
    {!! view_render_event('bagisto.shop.home.content.before') !!}

    {{--    {!! DbView::make($channel)->field('home_page_content')->with(['sliderData' => $sliderData])->render() !!}--}}

    <!-- slider-start -->
    <div class="slider-area">
        <div class="main-slider">
            <div class="item -healist1 d-flex align-items-center" style="background-image: url('{{ bagisto_asset('img/slider/faq.jpg') }}')">
                <div class="container">
                    <div class="col-12 col-sm-7 col-md-5 col-lg-4">
                        <div class="slider-content">
                            <h1 data-animation="fadeInLeft" data-delay=".6s">Conheça o CBD</h1>
                            <p data-animation="fadeInRight" data-delay=".8s">Um dos ingredientes mais importantes em saúde e bem-estar, mas muitas vezes acompanhados de estigma e desinformação. É hora de esclarecer os fatos sobre o CBD.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider-end -->

    <!-- faq-area-start -->
    <div class="faq-area pt-80 pb-80">
        <div class="container">
            <h1>CBD Faq:</h1>

            <div class="cbd">
                <h2>CBD</h2>

                <div class="accordion">
                    <div class="question">
                        <h3>O que é CBD?</h3>

                        <p>O CBD ou o canabidiol é um dos mais de 80 ﬁtocanabinóides naturais (compostos que ocorrem naturalmente) encontrados e extraídos do cânhamo, uma planta pertencente à espécie Cannabis sativa.</p>
                    </div>
                    <div class="question">
                        <h3>O que é um canabinóide?</h3>

                        <p>Os canabinóides promovem o equilíbrio e o bem-estar geral, moderando a comunicação entre as células do seu corpo.* Existem dois tipos de canabinóides: endocanabinóides, que seu corpo cria naturalmente e ﬁtocanabinóides, derivados da maconha e do cânhamo.</p>
                    </div>
                    <div class="question">
                        <h3>Quais são os efeitos do CBD?</h3>

                        <p>O CBD é conhecido por promover o equilíbrio e o bem-estar geral, ajudando a regular a comunicação entre as células do seu corpo. * É conhecido por fazer isso suplementando e vinculando naturalmente ao Sistema Endocanabinóide (ECS) do seu corpo.</p>
                    </div>
                    <div class="question">
                        <h3>Endocana - o que?</h3>

                        <p>O sistema endocanabinóide é o seu sistema regulatório que ajuda a manter o equilíbrio em sua mente e corpo, mesmo quando fatores externos e certas opções de estilo de vida tentam desequilibrá-lo. Você encontrará endocanabinóides em todo lugar, desde o sistema imunológico, cérebro e sistema nervoso central até os principais órgãos, tecidos conjuntivos e glândulas.</p>

                        <p>Incrivelmente, esse sistema só foi descoberto na década de 1990 e é considerado essencial para a capacidade do seu corpo de cultivar uma boa saúde. Afetando processos como sono, apetite, digestão, metabolismo, humor, memória, hormônios e envelhecimento, a função principal do ECS é manter a homeostase ou sua estabilidade interna, apesar dos desaﬁos inesperados da vida cotidiana.</p>
                    </div>
                    <div class="question">
                        <h3>Qual é a diferença entre cânhamo e maconha?</h3>

                        <p>Embora o cânhamo e a maconha sejam tecnicamente a mesma espécie, eles são legalmente deﬁnidos por quais tipos canabinóides produzem. Mais importante ainda, o cânhamo não contém mais de 0,3% de THC, o composto psicoativo encontrado em concentrações mais altas na maconha. Simplesmente, você não ﬁca doidão.</p>

                        <p>O cânhamo contém naturalmente níveis mais altos de CBD, um composto não psicoativo conhecido por ajudar o corpo humano a restaurar o equilíbrio e apoiar o bem-estar geral. *</p>
                    </div>
                    <div class="question">
                        <h3>Que tipo de extrato de cânhamo é usado nos produtos Healist?</h3>

                        <p>Nos produtos Healist, optamos por usar o extrato de cânhamo orgânico de amplo espectro da mais alta qualidade. Como o próprio nome sugere, o extrato de cânhamo de amplo espectro não contém apenas altos níveis de CBD, mas inclui outros canabinóides como CBDA, CBG, CBN, CBC* e compostos terapêuticos como terpenos, aminoácidos, vitaminas e minerais que trabalham em sinergia para alimentar seu corpo, como a natureza pretendia. Isso é conhecido como o "efeito entourage" desejado.</p>

                        <p>Ao contrário do extrato de cânhamo de espectro completo, que contém cerca de 0,3% de THC, nossos extratos de cânhamo de amplo espectro não são psicoativos com níveis indetectáveis de THC.</p>
                    </div>
                    <div class="question">
                        <h3>O extrato de cânhamo (óleo) é o mesmo que o óleo de semente de cânhamo?</h3>

                        <p>Em suma, não. Os termos geralmente são confundidos entre si, mas há uma diferença distinta entre os dois tipos de óleo. O óleo de semente de cânhamo é composto principalmente de gorduras alimentares, o que signiﬁca que pode acalmar e hidratar a pele, mas não inclui CBD e outros ﬁtocanabinóides. Se você está procurando produtos que contenham CBD, veriﬁque cuidadosamente se ele não contém apenas óleo de semente de cânhamo.</p>
                    </div>
                    <div class="question">
                        <h3>Os produtos CBD aparecerão em um teste de drogas?</h3>

                        <p>O CBD não aparecerá em um teste de drogas. Muitos produtos CBD, no entanto, contêm vestígios de THC, o principal ingrediente ativo da maconha. Se houver THC suﬁciente, ele aparecerá em um teste de drogas.</p>

                        <p>É por isso que é essencial conhecer a qualidade e a composição de qualquer produto CBD que você compra.</p>

                        <p>Na Healist, usamos apenas CBD de amplo espectro, que contém 0,0% de THC (níveis indetectáveis) e publicamos testes de laboratório para todos os produtos que produzimos, para que você possa ter certeza de saber exatamente o que está usando no produto.</p>
                    </div>
                </div>
            </div>
            <div class="oil-cbd">
                <h2>Como uso óleo de CBD?</h2>

                <div class="accordion">
                    <div class="question">
                        <h3>Qual é a dose certa para mim?</h3>

                        <p>É completamente pessoal. Quando você começa a tomar o CBD, recomendamos começar com uma dose baixa e aumentar a dose até começar a sentir os resultados desejados. Pode afetar as pessoas de maneira diferente, com diferentes massas corporais exigindo níveis diferentes para experimentar os seus efeitos.</p>

                        <p>Não há ingestão diária padrão recomendada (RDI), mas consulte o guia abaixo como um ponto de referência.*</p>

                        <p>Mantenha o controle usando um por dia para poder reﬂetir sobre os benefícios ao longo do tempo e ajustar sua dose de acordo. É o seu corpo e você o conhece melhor do que ninguém.</p>

                    </div>

                    <div class="question">
                        <h3>Como sei quanto CBD há no produto que estou comprando?</h3>

                        <p>Isso pode ser complicado, pois existem muitas marcas que fazem alegações enganosas e a categoria ainda não foi regulamentada.</p>

                        <p>Nossas dicas sobre o que procurar:</p>

                        <ol>
                            <li>Veriﬁque se o produto que você está comprando inclui um extrato de cânhamo canabinóide, não um óleo de semente de cânhamo. Como mencionado acima, o óleo de cânhamo pode ser ótimo para a pele, mas não contém CBD.</li>
                            <li>Procure o mg de CBD no produto e não apenas o mg de extrato de cânhamo. O extrato de cânhamo pode ter diferentes concentrações de CBD variando de 20 a 90%. Um produto que reivindica 1000 mg de extrato de cânhamo pode na verdade conter entre 20 mg de CBD e 900 mg de CBD. Essa é uma das maneiras comuns pelas quais muitas marcas enganam os consumidores quanto à quantidade percebida de CBD nos produtos. É por esse motivo que os produtos Healist informam explicitamente o mg de CBD por porção na frente de cada uma de nossas embalagens.</li>
                            <li>Veriﬁque o Certiﬁcado de Análise para garantir que o que o produto alega está realmente no produto! Uma amostra cega mostrou que 70% das empresas de CBD não correspondem realmente ao que reivindicam no rótulo. Fizemos um pacto de total transparência para nossos produtos e publicamos relatórios de laboratório para cada lote fabricado pela Healist.</li>
                        </ol>

                    </div>
                    <div class="question">
                        <h3>Qual é o formato certo para mim?</h3>

                        <p>Nossa linha de benefícios com CBD + oferece vários formatos para atender a diferentes necessidades de uso e estilo de vida, desde tinturas e gomas à adesivos transdérmicos e loções tópicas.</p>
                    </div>

                    <div class="question">
                        <h3>Há algum efeito colateral?</h3>

                        <p>O CBD é geralmente bem tolerado e provado ter poucos efeitos colaterais. Em todas as composições Healist, tomamos o máximo cuidado para não apenas garantir a pureza do nosso CBD, mas também selecionar especialmente nossos ingredientes ativos naturais de apoio para sua eﬁcácia e segurança.</p>

                        <p>Como com qualquer outro suplemento, há sempre a chance de causar reações adversas para algumas pessoas ou interagir com certos medicamentos. Por favor, consulte seu médico antes de usar.</p>
                    </div>
                </div>
            </div>
            <div class="fluency-cbd">
                <h2>Encontre sua ﬂuência</h2>

                <div class="accordion">
                    <div class="question">
                        <h3>Glossário de Termos (CBD)</h3>

                        <p><strong>Óleo de semente de cânhamo -</strong> Óleo produzido por sementes de cânhamo prensadas a frio com alto teor de antioxidantes, ácidos graxos ômega-3 e 6, mas não contém CBD ou outros ﬁtocanabinóides.</p>

                        <p><strong>Isolado de CBD -</strong> CBD puriﬁcado que é livre de THC, mas não contém outros canabinóides benéﬁcos, ﬂavonóides, terpenos e ácidos graxos.</p>

                        <p><strong>Biodisponibilidade -</strong> O grau de absorção de uma substância na corrente sanguínea.</p>

                        <p><strong>Óleo de cânhamo de amplo espectro -</strong> Extrato de óleo de cânhamo que contém CBD, outros canabinóides, ﬂavonóides, terpenos e ácidos graxos que trabalham em sincronia com o corpo, conforme a natureza. É importante ressaltar que ele contém níveis indetectáveis de THC.</p>

                        <p><strong>Canabinóide -</strong> Moléculas que promovem o equilíbrio e o bem-estar geral, moderando a comunicação entre as células do corpo.* Existem três tipos de canabinóides: endocanabinóides, que nosso corpo cria naturalmente, ﬁtocanabinóides, derivados de plantas como o cânhamo e canabinóides sintéticos, que são criados em laboratórios.</p>

                        <p><strong>Tetra-hidrocanabinol (THC) -</strong> O canabinóide mais conhecido na planta de cannabis. O THC se liga aos receptores CB1, o que ajuda a produzir um efeito psicoativo no corpo (sensação elevada). Também pode afetar a memória, a percepção e outras funções.</p>

                        <p><strong>Canabidiol (CBD) -</strong> O CBD, o segundo canabinóide mais comum que possui vários benefícios à saúde relatados e não é psicoativo (não é alto).</p>

                        <p><strong>Ácido Canabidiolico (CBDA) -</strong> A forma ácida bruta do CBD produzida na planta do cânhamo que possui vários benefícios à saúde que são diferentes do CBD.</p>

                        <p><strong>Canabichromene (CBC) -</strong> O terceiro canabinóide mais comum, com uma inﬁnidade de benefícios relatados para a saúde e bem-estar, e não é psicoativo (não é alto).</p>

                        <p><strong>Canabigerol (CBG) -</strong> Um canabinóide menor, encontrado em níveis mais baixos do que os outros, mas com potenciais benefícios para o intestino.</p>

                        <p><strong>Ácido Canabigerólico (CBGA) -</strong> O canabinóide mãe é o precursor de todos os canabinóides da planta e é convertido por enzimas da planta em CBD ou THC.</p>

                        <p><strong>Canabinol (CBN) -</strong> Um canabinóide menor que foi relatado como tendo efeitos indutores do sono no corpo.</p>

                        <p><strong>Canabidivarina (CBDV) -</strong> Um canabinóide não psicoativo calmante que se assemelha muito ao canabidiol (CBD) na estrutura.</p>

                        <p><strong>Receptor canabinóide tipo 1 (CB1) -</strong> Os receptores CB1 são encontrados em todo o cérebro e corpo e ajudam a modular vários processos ﬁsiológicos, incluindo a percepção da dor e o processamento da memória. Esses receptores também são responsáveis pela euforia ou "alta" causada pelo uso de produtos de maconha ricos em THC.</p>

                        <p><strong>Receptor canabinóide tipo 2 (CB2) -</strong> Os receptores CB2 são enriquecidos no sistema imunológico, intestino e pele, onde modulam a inﬂamação.</p>

                        <p><strong>Extração de CO2 -</strong> Método de extração que separa o óleo em temperatura ambiente, permitindo um processo mínimo para preservar os compostos naturais.</p>

                        <p><strong>Efeito Entourage -</strong> É descrito como o efeito que a combinação de canabinóides naturais, terpenos e ﬂavonóides do cânhamo têm um sobre o outro - criando mais benefícios sinérgicos coletivamente do que individualmente.</p>

                        <p><strong>Endocanabinóides -</strong> Canabinóides produzidos pelo corpo humano.</p>

                        <p><strong>Óleo de cânhamo de espectro total -</strong> Extrato de óleo de cânhamo que contém CBD, outros canabinóides, ﬂavonóides, terpenos e ácidos graxos que trabalham em sincronia com o corpo, conforme a natureza. Ao contrário do Broad Spectrum Oil, ele contém níveis detectáveis de THC (geralmente 0,3% ou menos)</p>

                        <p><strong>Ato de cultivo de cânhamo de 2018 -</strong> Uma lei dos EUA aprovada em 2018 que remove o cânhamo das `` substâncias controladas do cronograma I '' para torná-lo legal em todos os 50 estados como um produto agrícola. No momento, isso está em andamento.</p>

                        <p><strong>Homeostase -</strong> Um estado de ótimo equilíbrio e equilíbrio dentro do corpo.</p>

                        <p><strong>Sistema Endocanabinóide Humano (ECS) -</strong> O maior sistema de neurotransmissores presente no cérebro e no corpo dos humanos e de todos os outros animais. É responsável por regular nossos processos biológicos, incluindo apetite, sistema imunológico, digestão, sono, humor, memória, metabolismo, hormônios e envelhecimento.</p>

                        <p><strong>Cânhamo Industrial -</strong> Uma planta de baixa qualidade que é cultivada especiﬁcamente por suas sementes e ﬁbras para uso industrial e, portanto, não é produzida por altos níveis de canabinóides e terpenos.</p>

                        <p><strong>Fitocanabinóides -</strong> Canabinóides naturais produzidos pelas plantas.</p>

                        <p><strong>Terpenos -</strong> Terpenos são encontrados naturalmente nas plantas e são o principal ingrediente funcional dos óleos essenciais. Eles conferem às plantas suas propriedades aromáticas e de sabor e são conhecidos por oferecer benefícios terapêuticos únicos por si próprios. Quando combinados com o CBD e outros canabinóides, acredita-se que eles aumentam os benefícios gerais de bem-estar (ou seja, efeito entourage). Pensa-se que os terpenos funcionem agindo diretamente no cérebro ou na pele para moderar a atividade.</p>

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
            $('.accordion > .product:eq(0) h2').addClass('active').next().slideDown();

            $('.accordion h2').click(function(j) {
                var dropDown = $(this).closest('.product').find('ul');

                $(this).closest('.accordion').find('ul').not(dropDown).slideUp();

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    $(this).closest('.accordion').find('h2.active').removeClass('active');
                    $(this).addClass('active');
                }

                dropDown.stop(false, true).slideToggle();

                j.preventDefault();
            });
        });
    </script>
@endpush


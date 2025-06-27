@extends('shop::layouts.master')

@section('page_title')
    {{ 'CBD Gummies - Gomas de CBD sem THC' }}
@endsection

@section('seo')
    <meta name="description" content="{{ '' }}"/>
@stop

@section('body_class')
    page-products -gummies
@stop

@inject ('productVRepository', 'PureEncapsulations\Product\Repositories\ProductRepository')
@inject ('attributeOptionReposotory', 'Webkul\Attribute\Repositories\AttributeOptionRepository')

@section('content-wrapper')

    {!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}

    <div class="product-shop-area pt-40 pb-40">
        <div class="container">
            <div class="row">
                @include ('shop::products.view.gallery')

                <div class="col-xl-6 col-lg-6">
                    <div class="product-details">
                        <div class="product-details-title">
                            <span>20mg CBD por goma</span>

                            <h1>CBD Gummies</h1>
                            <div class="sku mb-20">
                                <small>Ref#: {{ $product->sku }}</small>
                            </div>
                        </div>

                        <div class="short_description mb-20">
                            {!! $product->description !!}
                        </div>

                        <div class="details-price mb-20">
                            @include ('shop::products.price', ['product' => $product])
                        </div>

                        <div class="product-details-action">
                            @if($product->available == 0 and $product->new == 0)
                                <product-view></product-view>
                            @else
                                @if($product->available == 1)
                                    <p class="available">{{ __('shop::app.products.available') }}</p>
                                @endif

                                @if($product->new == 1)
                                    <p class="launch">{{ __('shop::app.products.launch') }}</p>
                                @endif
                            @endif
                        </div>

                        <div class="products-info">
                            <div class="questions">
                                <div class="accordion">
                                    <div class="question">
                                        <h3>Ingredientes</h3>

                                        <div class="-text">
                                            @php($details = $productVRepository->getAttributes($product)->where('code', 'details')->first())

                                            @if($details && ($details->value != ''))
                                                {!! $details->value !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="question">
                                        <h3>Tabela Nutricional</h3>

                                        <div class="-text">
                                            @php($nutritionalTable = $productVRepository->getAttributes($product)->where('code', 'nutritional_table')->first())

                                            @if($nutritionalTable && ($nutritionalTable->value != ''))
                                                <img src="{{ asset('/storage/'.$nutritionalTable->value) }}" alt="{{ __('shop::app.products.nutritional-table') }}" class="responsive-img">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="question">
                                        <h3>Resultados Laboratoriais</h3>

                                        <div class="-text">
                                            @php($downloadFile = $productVRepository->getAttributes($product)->where('code', 'download_file')->first())
                                            @if($downloadFile && !is_null($downloadFile->value))
                                                <a href="{{ route('shop.product.file.download', [$product->product_id, 30]) }}" target="_blank">
                                                    <i class="fas fa-download"></i> Faça download dos resultados laboratoriais
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- posologia-area-start -->
    <div class="posologia-area pt-60 pb-60">
        <div class="container">
            <h2>Posologia</h2>

            <div class="posologia">
                <div class="-item">
                    <img src="{{ bagisto_asset('img/produtos/icon-mente.svg') }}" alt="Manhã">
                    <h4>Manhã</h4>
                    <p>Melhore sua clareza mental e seu foco.</p>
                </div>
                <div class="-item">
                    <img src="{{ bagisto_asset('img/produtos/icon-corpo.svg') }}" alt="Durante o Dia">
                    <h4>Durante o Dia </h4>
                    <p>Gestão de dor e redução do estresse.</p>
                </div>
                <div class="-item">
                    <img src="{{ bagisto_asset('img/produtos/icon-weight.png') }}" alt="Durante o Dia">
                    <h4>Durante o Dia </h4>
                    <p>Pré-treino para otimizar performance, pós-treino para auxiliar na recuperação.</p>
                </div>
                <div class="-item">
                    <img src="{{ bagisto_asset('img/produtos/icon-sono.svg') }}" alt="Noite">
                    <h4>Noite</h4>
                    <p>Melhore seu sono REM e conquiste mais ZZZZ's.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- posologia-area-end -->

    <!-- info-area-start -->
    <div class="info-area pt-60 pb-60">
        <div class="container">
            <div class="info">
                <div class="-text">
                    <h2>Uma fatia fresca de autocuidado</h2>

                    <p>O CBD da Peels foi feito para garantir que você se sinta seu melhor e alcance seu desempenho máximo todos os dias, não importa onde você esteja. Nossas gomas de CBD puro são perfeitas para o bem-estar na rua, em casa, em viagens. Carregue com você sempre e facilite a manutenção dos seus hábitos saudáveis!</p>
                </div>
                <div class="-img">
                    <img src="{{ bagisto_asset('img/produtos/cbd-gummies/autocuidado.jpg') }}" alt="Uma fatia fresca de autocuidado" />
                </div>
            </div>
        </div>
    </div>
    <!-- info-area-end -->

    <!-- uso-area-start -->
    <div class="uso-area pt-60 pb-60">
        <div class="container">
            <div class="uso">
                <div class="-text">
                    <h2>Melhore o sabor e a qualidade do seu tratamento de CBD</h2>

                    <p>O isolado de CBD da Peels é o mais puro do mundo, com pureza incomparável de 99,5%+. Feito de terpenos encontrados em cascas de frutas cítricas, o gosto é absolutamente delicioso (terpenos são o que dão as laranjas o seu aroma)! Combine isso com ingredientes orgânicos totalmente naturais presentes em nossas gomas e obtenha todos os benefícios holísticos do CBD sem as preocupações atreladas ao THC, ingredientes psicoativos, pesticidas, toxinas ou metais pesados. </p>
                </div>
                <div class="-img">
                    <img src="{{ bagisto_asset('img/produtos/cbd-gummies/qualidade.gif') }}" alt="Melhore o sabor e a qualidade do seu tratamento de CBD" />
                </div>
            </div>
        </div>
    </div>
    <!-- uso-area-end -->

    <!-- not-area-start -->
    <div class="not-area pt-60 pb-60">
        <div class="container">
            <h2>Você sabe o que há em suas gomas de CBD? <br>Vamos começar com o que não tem nas nossas.</h2>

            <div class="not">
                <div class="-item">
                    <h3>Puro até a última gota</h3>

                    <p>A Peels cria, de forma consistente, óleo CBD puro sem THC. Ao criar CBD biologicamente idêntico derivado de frutas cítricas, encontramos uma maneira de eliminar completamente toda e qualquer variação. Não existem dois frascos que diferem em pureza ou desempenho, o que não pode ser dito sobre gomas de THC. Você pode contar com a Peels para ter as melhores gomas de CBD. Não se arrisque na otimização do seu bem-estar. Nunca deixe seus dias nas mãos da sorte.</p>

                    <p>Compre suas gomas de CBD online hoje. Independente da sua necessidade, temos o que você precisa! Desde o melhor óleo de CBD, às melhores gomas de CBD ou um shot de imunidade de CBD, a Peels tem o que você precisa.</p>
                </div>
                <div class="-item">
                    <ul>
                        <li>Sem OGMs</li>
                        <li>Sem glúten</li>
                        <li>Zero calorias</li>
                        <li>Sem cheiro (na forma crua)</li>
                        <li>Sem gosto (na forma crua)</li>
                        <li>Sem variação em qualidade</li>
                    </ul>
                </div>
                <div class="-item">
                    <ul>
                        <li>Sem THC. Sempre.</li>
                        <li>Sem alucinógenos</li>
                        <li>Sem neurotoxinas</li>
                        <li>Sem pesticidas</li>
                        <li>Sem metais pesados</li>
                        <li>Sem micotoxinas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- uso-area-end -->

    {!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}

@endsection

@include('shop::products.push')
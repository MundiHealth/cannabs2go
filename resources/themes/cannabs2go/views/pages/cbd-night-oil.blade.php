@extends('shop::layouts.master')

@section('page_title')
    {{ 'CBD Night Oil - Óleo de CBD para dormir' }}
@endsection

@section('seo')
    <meta name="description" content="{{ '' }}"/>
@stop

@section('body_class')
    page-products -nightoil
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
                            <span>30mL / 1000mg / 1mL por porção </span>

                            <h1>CBD Night Oil</h1>
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
                    <img src="{{ bagisto_asset('img/produtos/icon-sono.svg') }}" alt="Sono">
                    <h4>Sono</h4>
                    <p>Melhore seu ciclo de sono e conquiste mais ZZZZ's 34mg.</p>
                </div>
                <div class="-item">
                    <img src="{{ bagisto_asset('img/produtos/icon-alma.svg') }}" alt="Alma">
                    <h4>Alma</h4>
                    <p>Equilibre sua tranquilidade e bem-estar geral 8mg.</p>
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
                    <h2>O sono dos seus sonhos</h2>

                    <p>Com mudanças de horários, viagens globais e telas constantes, às vezes nossas vidas modernas prejudicam nosso ritmo circadiano, bagunçam nossa produção de melatonina e causam estresse e ansiedade que levam à má qualidade do sono. Às vezes, nossos corpos e mentes precisam de ajuda para voltar à rotina de sono saudável.</p>

                    <p>Por isso, criamos um aliado de CBD para sua rotina de sono. Aqui para te apoiar quando você precisar, o CBD Night Oil da peels vai te ajudar a conquistar o sono que você precisa, para você abandonar o sono e o cansaço e acordar restaurado, alerta, e pronto para enfrentar seu dia.</p>
                </div>
                <div class="-img">
                    <img src="{{ bagisto_asset('img/produtos/cbd-oil-night/sono.jpg') }}" alt="O sono dos seus sonhos" />
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
                    <h2>Como usar</h2>

                    <ol>
                        <li>Respire profundamente: inspire e expire*</li>
                        <li>Posicione o conta-gotas abaixo da sua língua para absorção ideal</li>
                        <li>Segure as gotas embaixo da língua durante 30-60 segundos antes de engolir</li>
                    </ol>

                    <p>*Respiração não exigida, apenas sugerida para maximizar a experiência.</p>
                </div>
                <div class="-img">
                    <img src="{{ bagisto_asset('img/produtos/cbd-oil-night/como-usar.gif') }}" alt="Como usar o CBD Oil da Peels" />
                </div>
            </div>
        </div>
    </div>
    <!-- uso-area-end -->

    <!-- not-area-start -->
    <div class="not-area pt-60 pb-60">
        <div class="container">
            <h2>Você sabe o que há no seu óleo de CBD para dormir? <br>Vamos começar com o que não tem no nosso.</h2>

            <div class="not">
                <div class="-item">
                    <h3>Puro até a última gota</h3>

                    <p>A Peels cria, de forma consistente, óleo CBD puro sem THC. Ao criar CBD biologicamente idêntico derivado de frutas cítricas, encontramos uma maneira de eliminar completamente toda e qualquer variação. Não há dois frascos de nossos óleos noturnos CBD que diferem em pureza ou desempenho. Você pode contar com a Peels para ter o que precisa e, mais importante, para não ter o que não quer. Não se arrisque na otimização do seu bem-estar. Nunca deixe seus dias nas mãos da sorte.</p>
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
@extends('shop::layouts.master')

@section('page_title')
    {{ 'CBD Oil - Óleo de CBD sem THC, derivado de frutas cítricas' }}
@endsection

@section('seo')
    <meta name="description" content="{{ '' }}"/>
@stop

@section('body_class')
    page-products -oil
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
                            <span>30mL / 1000mg / 1mL por porção</span>

                            <h1>CBD Oil</h1>
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
                    <img src="{{ bagisto_asset('img/produtos/icon-mente.svg') }}" alt="Mente">
                    <h4>Mente</h4>
                    <p>Melhore sua clareza mental e seu foco 17mg.</p>
                </div>
                <div class="-item">
                    <img src="{{ bagisto_asset('img/produtos/icon-corpo.svg') }}" alt="Corpo">
                    <h4>Corpo</h4>
                    <p>Otimize sua performance e recuperação e gerencie sua dor 25mg.</p>
                </div>
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
                    <h2>A diferença entre uma rotina e um ritual é a intenção.</h2>

                    <p>30 dias é o prazo mágico para formar um ritual consistente com o CBD; os benefícios do óleo de CBD da Peels vão ficar mais aparentes a cada dia. Cada frasco dura 30 dias.</p>
                </div>
                <div class="-img">
                    <img src="{{ bagisto_asset('img/produtos/cbd-oil/diferenca.jpg') }}" alt="A diferença entre uma rotina e um ritual é a intenção" />
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
                    <h2>Como usar o CBD Oil da Peels</h2>

                    <ol>
                        <li>Respire profundamente: inspire e expire*</li>
                        <li>Posicione o conta-gotas abaixo da sua língua para absorção ideal</li>
                        <li>Segure as gotas embaixo da língua durante 30-60 segundos antes de engolir</li>
                    </ol>

                    <p>*Respiração não exigida, apenas sugerida para maximizar a experiência.</p>
                </div>
                <div class="-img">
                    <img src="{{ bagisto_asset('img/produtos/cbd-oil/como-usar.gif') }}" alt="Como usar o CBD Oil da Peels" />
                </div>
            </div>
        </div>
    </div>
    <!-- uso-area-end -->

    <!-- not-area-start -->
    <div class="not-area pt-60 pb-60">
        <div class="container">
            <h2>Você sabe o que há no seu óleo de CBD? <br>Vamos começar com o que não tem nas nossas.</h2>

            <div class="not">
                <div class="-item">
                    <h3>Puro até a última gota</h3>

                    <p>A Peels cria, de forma consistente, óleo CBD puro sem THC. Ao criar CBD biologicamente idêntico derivado de frutas cítricas, encontramos uma maneira de eliminar completamente toda e qualquer variação. Não existem dois frascos que diferem em pureza ou desempenho. Você pode contar com a Peels para ter o que precisa e, mais importante, para não ter o que não quer. Não se arrisque na otimização do seu bem-estar. Nunca deixe seus dias nas mãos da sorte.</p>

                    <p>Conheça nossa coleção de óleo de CBD Peels e você terá a garantia de encontrar o melhor óleo de CBD para você e suas necessidades. Confira nossos outros produtos de CBD, incluindo gomas e tinturas.</p>
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
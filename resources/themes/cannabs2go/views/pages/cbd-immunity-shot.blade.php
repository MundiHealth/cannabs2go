@extends('shop::layouts.master')

@section('page_title')
    {{ 'CBD Immunity Shot - Apoio à imunidade e ao bem-estar nas suas mãos' }}
@endsection

@section('seo')
    <meta name="description" content="{{ '' }}"/>
@stop

@section('body_class')
    page-products -immunity
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
                            <span>12 x mini-garrafas de 60ml / 20mg CBD</span>

                            <h1>CBD Immunity Shot </h1>
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

    <!-- info-area-start -->
    <div class="info-area pt-60 pb-60">
        <div class="container">
            <div class="info">
                <div class="-text">
                    <h2>A melhor defesa é um bom ataque</h2>

                    <p>Dieta, sono, viagens, estresse e clima afetam até mesmo os sistemas imunológicos mais fortes. O nosso CBD Immunity Shot serve para te apoiar quando você precisar de suporte adicional. Otimize sua resposta imunológica e sinta-se pronto para se defender com vitaminas essenciais, minerais e o CBD mais puro do mundo, sem THC e sem preocupações. </p>
                </div>
                <div class="-img">
                    <img src="{{ bagisto_asset('img/produtos/cbd-immunity-shot/defesa.jpg') }}" alt="A melhor defesa é um bom ataque" />
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

                    <ul>
                        <li><b>Opção 1:</b> Leve a garrafa à boca. Incline a cabeça para trás. Continue a inclinar a cabeça e a garrafa no mesmo ângulo. Consumir em um único gole.</li>
                        <li><b>Opção 2:</b> Desfrute de alguns goles. Tem gosto de creme de laranja, então é bom saborear.</li>
                    </ul>
                </div>
                <div class="-img">
                    <img src="{{ bagisto_asset('img/produtos/cbd-immunity-shot/como-usar.jpg') }}" alt="Como usar o CBD Immunity da Peels" />
                </div>
            </div>
        </div>
    </div>
    <!-- uso-area-end -->

    <!-- not-area-start -->
    <div class="not-area pt-60 pb-60">
        <div class="container">
            <h2>Você sabe o que há no seu CBD? <br>Vamos começar com o que não tem no nosso.</h2>

            <div class="not">
                <div class="-item">
                    <h3>Puro até a última gota</h3>

                    <p>A Peels cria, de forma consistente, óleo CBD puro sem THC. Ao criar CBD biologicamente idêntico derivado de frutas cítricas, encontramos uma maneira de eliminar completamente toda e qualquer variação. Não existem dois frascos que diferem em pureza ou desempenho. Você pode contar com a Peels para ter o que precisa e, mais importante, para não ter o que não quer. Não se arrisque na otimização do seu bem-estar. Nunca deixe seus dias nas mãos da sorte.</p>
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
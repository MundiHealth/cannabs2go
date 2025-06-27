@extends('shop::layouts.master')

@section('page_title')
    {{ trim($product->meta_title) != "" ? $product->meta_title : $product->name }}
@stop

@section('seo')
    <meta name="description" content="{{ trim($product->meta_description) != "" ? $product->meta_description : str_limit(strip_tags($product->description), 120, '') }}"/>
    <meta name="keywords" content="{{ $product->meta_keywords }}"/>
@stop

@inject ('productVRepository', 'PureEncapsulations\Product\Repositories\ProductRepository')
@inject ('attributeOptionReposotory', 'Webkul\Attribute\Repositories\AttributeOptionRepository')

@section('content-wrapper')

    {!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}

    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>Detalhes do Produto</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="/">Home</a></li>
                            <li><span>{{ $product->name }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="product-shop-area pt-80 pb-60">
        <div class="container">
            <div class="row">
                @include ('shop::products.view.gallery')

                <div class="col-xl-6 col-lg-6">
                    {{--                    <product-view>--}}
                    <div class="product-details mb-30">
                        <div class="product-details-title">
                            <h1>{{ $product->name }}</h1>
                            <div class="sku mb-20">
                                <small>Ref#: {{ $product->sku }}</small>
                            </div>
                            <div class="details-price mb-20">
                                @include ('shop::products.price', ['product' => $product])
                            </div>
                        </div>

                        {!! view_render_event('bagisto.shop.products.view.short_description.before', ['product' => $product]) !!}

                        <p class="short_description">
                            {!! $product->short_description !!}
                        </p>

                        {!! view_render_event('bagisto.shop.products.view.short_description.after', ['product' => $product]) !!}

{{--                        @php($flags = $productVRepository->getAttributes($product)->where('code', 'flag')->first())--}}
{{--                        @php($size = $productVRepository->getAttributes($product)->where('code', 'capsule_size')->first())--}}
                        @php($type = $productVRepository->getAttributes($product)->where('code', 'capsule_type')->first())

{{--                        @if($flags && !is_null($flags->value) || $size && $size->value)--}}
{{--                            <ul class="product-flags mb-30">--}}

{{--                                @if($flags && !is_null($flags->value))--}}
{{--                                    @foreach($flags->value as $flag)--}}
{{--                                        @php($option = $attributeOptionReposotory->find($flag))--}}
{{--                                        <li data-toggle="tooltip" data-placement="bottom" title="{{ $option->label }}">--}}
{{--                                            <img src="{{ bagisto_asset('img/icon/' . $flag . '.png') }}" alt="">--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}

{{--                                @if($size->value)--}}
{{--                                    <li data-toggle="tooltip" data-placement="bottom" title="Tamanho da Cápsula">--}}
{{--                                        <img src="{{ bagisto_asset('img/icon/sizes/' . $size->value . '.png') }}" alt="Cápsula {{ $size->value }}">--}}
{{--                                    </li>--}}
{{--                                @endif--}}

{{--                                <a data-toggle="modal" data-target="#modalSize"><i class="fas fa-hand-point-up"></i> {{ __('shop::app.products.icons') }}</a>--}}
{{--                            </ul>--}}
{{--                        @endif--}}

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

                            @php($downloadFile = $productVRepository->getAttributes($product)->where('code', 'download_file')->first())
                            @if($downloadFile && !is_null($downloadFile->value))
                                <div class="mt-30">
                                    <a href="{{ route('shop.product.file.download', [$product->product_id, 30]) }}" target="_blank">
                                        @if($product->sku == 'cannabs')
                                            <i class="fas fa-download"></i> {{ 'Download do Termo de Consentimento' }}
                                        @elseif($product->sku == 'ell01' || $product->sku == 'ell02' || $product->sku == 'ell03' || $product->sku == 'ell04' ||
                                        $product->sku == 'ell05' || $product->sku == 'ell06' || $product->sku == 'ell07' || $product->sku == 'ell08' || $product->sku == 'ell09')
                                            <i class="fas fa-download"></i> {{ 'CoA - Certificado de Análise' }}
                                        @else
                                            <i class="fas fa-download"></i> {{ __('shop::app.products.download-info') }}
                                        @endif
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>
                    {{--                    </product-view>--}}
                </div>

            </div>

            @php($details = $productVRepository->getAttributes($product)->where('code', 'details')->first())
            @php($nutritionalTable = $productVRepository->getAttributes($product)->where('code', 'nutritional_table')->first())
            @php($commonQuestions = $productVRepository->getAttributes($product)->where('code', 'common_questions')->first())
            @php($video = $productVRepository->getAttributes($product)->where('code', 'video')->first())
            <div class="row mt-50">
                <div class="col-xl-12">
                    <div class="product-review">
                        <ul class="nav review-tab" id="myTab1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab11" data-toggle="tab" href="#home11" role="tab" aria-controls="home11"
                                   aria-selected="true">{{ __('shop::app.products.description') }} </a>
                            </li>

                            @if($details && ($details->value != ''))
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab11" data-toggle="tab" href="#profile11" role="tab" aria-controls="profile"
                                       aria-selected="false">{{ __('shop::app.products.details') }}</a>
                                </li>
                            @endif

                            @if($video && ($video->value != ''))
                                <li class="nav-item">
                                    <a class="nav-link" id="table-tab11" data-toggle="tab" href="#video" role="tab" aria-controls="table"
                                       aria-selected="false">{{ __('shop::app.products.video') }}</a>
                                </li>
                            @endif

                            @if($nutritionalTable && ($nutritionalTable->value != ''))
                                <li class="nav-item">
                                    <a class="nav-link" id="table-tab11" data-toggle="tab" href="#table11" role="tab" aria-controls="table"
                                       aria-selected="false">{{ __('shop::app.products.nutritional-table') }}</a>
                                </li>
                            @endif

                            @if($commonQuestions && ($commonQuestions->value != ''))
                                <li class="nav-item">
                                    <a class="nav-link" id="questions-tab11" data-toggle="tab" href="#questions11" role="tab" aria-controls="questions"
                                       aria-selected="false">{{ __('shop::app.products.common-questions') }}</a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab11" data-toggle="tab" href="#review11" role="tab" aria-controls="profile"
                                   aria-selected="false">{{ __('shop::app.products.reviews-title') }}</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane fade show active" id="home11"  aria-labelledby="home-tab11">
                                <div class="review-text mt-30">
                                    {!! $product->description !!}
                                </div>
                            </div>

                            @if($details && ($details->value != ''))
                                <div class="tab-pane fade" id="profile11">
                                    <div class="review-text mt-30">
                                        {!! $details->value !!}
                                    </div>
                                </div>
                            @endif

                            @if($video && ($video->value != ''))
                                <div class="tab-pane fade" id="video">
                                    <div class="review-text mt-30">
                                        <iframe width="560" height="315" src="{!! $video->value !!}" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endif

                            @if($nutritionalTable && ($nutritionalTable->value != ''))
                                <div class="tab-pane fade" id="table11">
                                    <div class="review-text mt-30">
                                        <img src="{{ asset('/storage/'.$nutritionalTable->value) }}" alt="{{ __('shop::app.products.nutritional-table') }}" class="responsive-img">
                                    </div>
                                </div>
                            @endif

                            @if($commonQuestions && ($commonQuestions->value != ''))
                                <div class="tab-pane fade" id="questions11">
                                    <div class="review-text mt-30">
                                        {!! nl2br($commonQuestions->value) !!}
                                    </div>
                                </div>
                            @endif

                            <div class="tab-pane fade" id="review11">
                                <div class="review-text mt-30">
                                    @include ('shop::products.view.reviews')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}

    <!-- Modal -->
{{--    <div class="modal fade" id="modalSize" tabindex="-1" role="dialog" aria-labelledby="sizeModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="sizeModalLabel">{{ __('shop::app.products.icons') }}</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <p>Ícones de <b>{{ $product->name }}</b>:</p>--}}
{{--                    @if($flags && !is_null($flags->value) || $size && $size->value)--}}
{{--                        <ul class="product-flags">--}}

{{--                            @if($flags && !is_null($flags->value))--}}
{{--                                @foreach($flags->value as $flag)--}}
{{--                                    @php($option = $attributeOptionReposotory->find($flag))--}}
{{--                                    <li data-toggle="tooltip" data-placement="bottom" title="{{ $option->label }}">--}}
{{--                                        <img src="{{ bagisto_asset('img/icon/' . $flag . '.png') }}" alt="">--}}
{{--                                        <span>{{ $option->label }}</span>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}

{{--                            @if($size->value)--}}
{{--                                <li data-toggle="tooltip" data-placement="bottom" title="{{ __('shop::app.products.capsule_size') }}">--}}
{{--                                    <img src="{{ bagisto_asset('img/icon/sizes/' . $size->value . '.png') }}" alt="{{ __('shop::app.products.capsule') }} {{ $size->value }}">--}}
{{--                                    <span>{{ __('shop::app.products.size') }}</span>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                        </ul>--}}
{{--                    @endif--}}

{{--                    @if($size->value && $type && $type->value)--}}
{{--                        <div class="mt-20">--}}
{{--                            @if($type->value == 'Vegetariana')--}}
{{--                                <img src="{{ bagisto_asset('img/capsulas-vegetarianas.jpg') }}" alt="{{ __('shop::app.products.icons') }}">--}}
{{--                            @else--}}
{{--                                <img src="{{ bagisto_asset('img/capsulas-softgel.jpg') }}" alt="{{ __('shop::app.products.icons') }}">--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection

@push('scripts')

    <script type="text/x-template" id="product-view-template">

        <form method="POST" id="product-form" action="{{ route('cart.add', $product->product_id) }}" @submit="onSubmit($event)">
            @csrf()

            @include ('shop::products.view.configurable-options')

            <div class="plus-minus">
                <div class="cart-plus-minus"><input type="text" name="quantity" value="1" /></div>
            </div>

            @if ($product->type == 'configurable')
                <input type="hidden" value="true" name="is_configurable">
            @else
                <input type="hidden" value="false" name="is_configurable">
            @endif

            <input type="hidden" name="product_id" value="{{ $product->product_id }}">

            <button class="btn btn-black" type="submit">Comprar</button>
        </form>

    </script>

    <script>

        Vue.component('product-view', {

            template: '#product-view-template',

            inject: ['$validator'],

            data: function() {
                return {
                    is_buy_now: 0,
                }
            },

            methods: {
                onSubmit: function(e) {
                    // if (e.target.getAttribute('type') != 'submit')
                    //     return false;

                    e.preventDefault();

                    var this_this = this;

                    this.$validator.validateAll().then(function (result) {
                        if (result) {
                            this_this.is_buy_now = e.target.classList.contains('buynow') ? 1 : 0;

                            setTimeout(function() {
                                document.getElementById('product-form').submit();
                            }, 0);
                        }
                    });
                }
            }
        });

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
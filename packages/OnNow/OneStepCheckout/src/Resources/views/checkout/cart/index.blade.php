@extends('onestepcheckout::layouts.default')

@section('page_title')
    {{ __('shop::app.checkout.cart.title') }}
@stop

@section('body_class')
    page-checkout
@endsection

@section('content-wrapper')
    @inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')

    @if (!$cart)
    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>Carrinho</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="/">Home</a></li>
                            <li><span>Carrinho</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <section class="cart-area gray-bg pt-60 pb-60">
        <div class="container">
            <div class="row">
                @if ($cart)
                    <div class="col-lg-8">
                        <div class="alert alert-warning">
                            <b>Lembre-se!</b> Ao final de sua compra, é necessário o envio da cópia da prescrição médica digital para que a mesma seja finalizada!
                            <a href="{{url()->to('/institucional/prescricao-medica')}}">Saiba mais.</a>
                        </div>

                        <div class="widget mb-40">
                            <div class="widget-title-box mb-30">
                                <h3 class="widget-title">{{ __('shop::app.checkout.cart.title') }}</h3>
                            </div>

                            <form action="{{ route('shop.checkout.cart.update') }}" method="POST" @submit.prevent="onSubmit">
                                @csrf
                                <ul class="widget-products">
                                    @foreach ($cart->items as $key => $item)

                                        @php($productBaseImage = $productImageHelper->getProductBaseImage($item->product))

                                        <li>
                                            <div class="widget-products-image">
                                                <a href="{{ route('shop.products.index', $item->product->url_key) }}"><img src="{{ $productBaseImage['medium_image_url'] }}" alt="{{ $item->product->name }}"></a>
                                            </div>
                                            <div class="widget-products-body">
                                                <h6 class="widget-products-title"><a href="{{ route('shop.products.index', $item->product->url_key) }}">{{ $item->product->name }}</a></h6>
                                                <p class="widget-products-sku">Ref#: {{ $item->product->sku }}</p>
                                                <p class="widget-products-price"><b>{{ core()->currency($item->base_price, $item->product) }}</b></p>

                                                {!! view_render_event('bagisto.shop.checkout.cart.item.options.before', ['item' => $item]) !!}

                                                @if (isset($item->additional['attributes']))
                                                    <div class="widget-products-variations">

                                                        @foreach ($item->additional['attributes'] as $attribute)
                                                            <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                                                        @endforeach

                                                    </div>
                                                @endif

                                                {!! view_render_event('bagisto.shop.checkout.cart.item.options.after', ['item' => $item]) !!}
                                            </div>
                                            <div class="widget-products-action">
                                                <div class="misc">
                                                    <quantity-changer
                                                        :control-name="'qty[{{$item->id}}]'"
                                                        quantity="{{$item->quantity}}">
                                                    </quantity-changer>

                                                    <span class="remove">
                                                        <a href="{{ route('shop.checkout.cart.remove', $item->id) }}" onclick="removeLink('{{ __('shop::app.checkout.cart.cart-remove-action') }}')"><i class="fas fa-trash"></i></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <button class="btn btn-black" type="submit">{{ __('shop::app.checkout.cart.update-cart') }}</button>

                                <a href="{{ route('shop.checkout.cart.clear') }}" class="btn-default -delete">{{ __('shop::app.checkout.cart.clean-cart') }}</a>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        {!! view_render_event('bagisto.shop.checkout.cart.summary.after', ['cart' => $cart]) !!}

                        @include('onestepcheckout::checkout.total.summary', ['cart' => $cart])

                        {!! view_render_event('bagisto.shop.checkout.cart.summary.before', ['cart' => $cart]) !!}
                    </div>
                @else
                    <div class="col-lg-12">

                        <div class="cart-content" style="text-align: center;">
                            <h4>
                                {{ __('shop::app.checkout.cart.empty') }}
                            </h4>

                            <p>{{ __('shop::app.checkout.cart.empty-msg') }}</p>

                            <p style="display: inline-block;">
                                <a style="display: inline-block;" href="{{ route('shop.home.index') }}" class="btn btn-lg btn-primary">{{ __('shop::app.checkout.cart.continue-shopping') }}</a>
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection

@push('scripts')

    <script type="text/x-template" id="quantity-changer-template">
        <div class="plus-minus quantity control-group" :class="[errors.has(controlName) ? 'has-error' : '']">
            <div class="wrap">

                <div class="cart-plus-minus">
                    <label><small>{{ __('shop::app.products.quantity') }}</small></label>

                    <button type="button" class="decrease" @click="decreaseQty()">-</button>

                    <input :name="controlName" class="control" :value="qty" v-validate="'required|numeric|min_value:1'" data-vv-as="&quot;{{ __('shop::app.products.quantity') }}&quot;" readonly>

                    <button type="button" class="increase" @click="increaseQty()">+</button>
                </div>

                <span class="control-error" v-if="errors.has(controlName)">@{{ errors.first(controlName) }}</span>
            </div>
        </div>
    </script>

    <script>
        Vue.component('quantity-changer', {
            template: '#quantity-changer-template',

            inject: ['$validator'],

            props: {
                controlName: {
                    type: String,
                    default: 'quantity'
                },

                quantity: {
                    type: [Number, String],
                    default: 1
                }
            },

            data: function() {
                return {
                    qty: this.quantity
                }
            },

            watch: {
                quantity: function (val) {
                    this.qty = val;

                    this.$emit('onQtyUpdated', this.qty)
                }
            },

            methods: {
                decreaseQty: function() {
                    if (this.qty > 1)
                        this.qty = parseInt(this.qty) - 1;

                    this.$emit('onQtyUpdated', this.qty)
                },

                increaseQty: function() {
                    this.qty = parseInt(this.qty) + 1;

                    this.$emit('onQtyUpdated', this.qty)
                }
            }
        });

        function removeLink(message) {
            if (!confirm(message))
                event.preventDefault();
        }

        function updateCartQunatity(operation, index) {
            var quantity = document.getElementById('cart-quantity'+index).value;

            if (operation == 'add') {
                quantity = parseInt(quantity) + 1;
            } else if (operation == 'remove') {
                if (quantity > 1) {
                    quantity = parseInt(quantity) - 1;
                } else {
                    alert('{{ __('shop::app.products.less-quantity') }}');
                }
            }
            document.getElementById('cart-quantity'+index).value = quantity;
            event.preventDefault();
        }
    </script>
@endpush
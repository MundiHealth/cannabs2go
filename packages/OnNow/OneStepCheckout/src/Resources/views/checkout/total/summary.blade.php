@if (request()->is('checkout/cart'))
<div class="widget mb-40">

    <div class="widget-title-box mb-30">
        <h3 class="widget-title">{{ __('shop::app.checkout.total.order-summary') }}</h3>
    </div>
    <ul class="summary mb-30">
        <li>
            {{ __('shop::app.checkout.total.sub-total') }} <span class="f-right">{{ core()->currency($cart->base_sub_total) }}</span>
        </li>

        <estimate></estimate>

        @if($freeShipping = $cart->disclaimerFreeShipping())
            <div class="alert alert-success">
                Adicione <b>{{ core()->currency($freeShipping) }}</b> ao seu carrinho e ganhe <b>FRETE GRÁTIS</b>.
            </div>
        @endif

        <div class="widget-button mt-30 mb-30">
            <a href="{{ route('shop.home.index') }}" class="btn-continue">{{ __('shop::app.checkout.cart.continue-shopping') }}</a>
        </div>

        @if ($cart->base_discount_amount && $cart->base_discount_amount > 0)
        <li>
            {{ __('shop::app.checkout.total.disc-amount') }} @if ($cart->coupon_code)({{ $cart->coupon_code }})@endif  <span class="f-right">{{ core()->currency($cart->base_discount_amount) }}</span>
        </li>
        @endif

        <li>
            {{ __('shop::app.checkout.total.grand-total') }} <span class="f-right">{{ core()->currency($cart->base_grand_total) }}</span>
        </li>
    </ul>

    <div class="widget-button mt-30">
        <a href="{{ route('shop.checkout.onepage.index') }}" class="btn theme-btn">{{ __('shop::app.checkout.cart.proceed-to-checkout') }}</a>
    </div>
</div>
@else
    <div class="widget mb-40 summary">

        <div class="widget-title-box mb-30">
            <h3 class="widget-title">Resumo do Pedido</h3>
        </div>

        @include('onestepcheckout::checkout.osc.review')

        <ul class="summary">
            <li>
                {{ __('shop::app.checkout.total.sub-total') }} <span class="f-right">{{ core()->currency($cart->base_sub_total) }}</span>
            </li>
            @if ($cart->selected_shipping_rate)
            <li>
                {{ __('shop::app.checkout.total.delivery-charges') }} <span class="f-right">{{ core()->currency($cart->selected_shipping_rate->base_price) }}</span>
            </li>
            @endif
            @if ($cart->base_tax_total)
            <li>
                {{ __('shop::app.checkout.total.tax') }} <span class="f-right">{{ core()->currency($cart->base_tax_total) }}</span>
            </li>
            @endif
            @if ($cart->base_discount_amount && $cart->base_discount_amount > 0)
                <li>
                    {{ __('shop::app.checkout.total.disc-amount') }} <span class="f-right">{{ core()->currency($cart->base_discount_amount) }}</span>
                    <span class="fa fa-trash" title="{{ __('shop::app.checkout.total.remove-coupon') }}" v-on:click="removeCoupon"></span>
                </li>
            @endif
            <li>
                {{ __('shop::app.checkout.total.grand-total') }} <span class="f-right"> {{ core()->currency($cart->base_grand_total) }}</span>
            </li>
        </ul>
    </div>
@endif

@push('scripts')
    <script type="text/html" id="estimate-template" v-if="!estimates">
        <li class="delivery">
            {{ __('shop::app.checkout.total.delivery-charges') }}
            <span class="f-right" v-if="!calculate">
                <a href="#" @click="onCalculate">calcular</a>
            </span>
            <div class="f-right" v-if="calculate">
                <form @submit.prevent="onSubmit" class="form" v-if="!estimates">

                        {!! view_render_event('onnow.osc.checkout.cart.shipping.after', ['cart' => $cart]) !!}

                        <input type="text" v-validate="'required'" v-model="zipcode" class="control cep" placeholder="Digite aqui seu CEP" autofocus />

                        {!! view_render_event('onnow.osc.checkout.cart.shipping.before', ['cart' => $cart]) !!}

                        <button class="btn theme-btn" type="submit">
                            Calcular
                        </button>
                </form>
                <form @submit.prevent="onSubmit" class="form" v-if="estimates">
                    <div class="col-xl-12 col-md-12">
                        <ul class="shipping">
                            <li v-for="estimate in estimates">
                                <div class="form-check">
                                    <label for="metodo1" class="form-check-label">
                                        @{{ estimate.method_title }}
                                    </label>
                                    <span class="f-right" v-if="estimate.base_price > 0">@{{ estimate.price }}</span>
                                    <span class="f-right" style="text-decoration: line-through;" v-if="estimate.base_price == 0">R$ 0,00</span>
                                    <p><b>Prazo de Entrega:</b> @{{ estimate.method_description }}</p>
                                    <p class="free" v-if="estimate.base_price == 0">{{ __('admin::app.promotion.general-info.free-shipping') }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </li>
    </script>
    <script>

        Vue.component('estimate', {
            template: '#estimate-template',
            inject: ['$validator'],
            data() {
                return {
                    estimates: null,
                    selected_shipping_method: '',
                    disable_button: false,
                    zipcode: null,
                    calculate: false
                }
            },
            methods: {
                onSubmit: function onSubmit(e) {
                    this.$http.post('{{ route('osc.checkout.estimate') }}', {
                        zipcode: this.zipcode,
                        '_token': "{{ csrf_token() }}"
                    })
                        .then(response => (
                            this.estimates = response.data
                        ))
                },
                onCalculate(){
                    this.calculate = true;
                    return false;
                }
            }
        })
    </script>
@endpush
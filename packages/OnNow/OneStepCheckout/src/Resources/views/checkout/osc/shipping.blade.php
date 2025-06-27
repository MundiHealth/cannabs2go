<form data-vv-scope="shipping-form">
    <h6>Escolha o seu frete</h6>

    <ul class="summary shipping" :class="[errors.has('shipping-form.shipping_method') ? 'has-error' : '']">
        @foreach ($shippingRateGroups as $rateGroup)

            {!! view_render_event('bagisto.shop.checkout.shipping-method.before', ['rateGroup' => $rateGroup]) !!}

            @foreach ($rateGroup['rates'] as $rate)
            <li>
                <div class="form-check">
                    <input class="form-check-input" v-validate="'required'" type="radio" id="{{ $rate->method }}" name="shipping_method" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.shipping-method') }}&quot;" value="{{ $rate->method }}" v-model="selected_shipping_method" @change="methodSelected()" >
                    <label class="form-check-label" for="metodo1">
                        {{ $rate->method_title }} {{ count($rateGroup['rates']) }}
                    </label>
                    <span class="f-right">{{ core()->currency($rate->base_price) }}</span>
                </div>
            </li>
            @endforeach

            {!! view_render_event('bagisto.shop.checkout.shipping-method.after', ['rateGroup' => $rateGroup]) !!}

        @endforeach
    </ul>


    <span class="control-error" v-if="errors.has('shipping-form.shipping_method')">
        @{{ errors.first('shipping-form.shipping_method') }}
    </span>

</form>
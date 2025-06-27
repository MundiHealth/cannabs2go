<form data-vv-scope="address-form" class="form">

    <div class="widget-title-box mb-30">
        <h3 class="widget-title">{{ __('shop::app.checkout.onepage.shipping-method') }}</h3>
    </div>

    <ul class="widget-products" v-if="!this.new_billing_address">
        <h6 class="widget-products-title">{{ __('shop::app.checkout.onepage.shipping-address') }}</h6>
        <li v-for='(addresses, index) in this.allAddress'  v-show="current_step == 1 || address.billing.address_id == addresses.id ">
            <div class="widget-products-body">
                <div class="widget-products-variations">
                    @{{ allAddress.first_name }} @{{ allAddress.last_name }}<br>
                    @{{ addresses.address1 }}, @{{ addresses.address2 }},<br>
                    @{{ addresses.address3 }}<br>
                    @{{ addresses.city }} - @{{ addresses.state }}, @{{ addresses.postcode }}<br>
                    <b>{{ __('shop::app.customer.account.address.index.contact') }}</b> : @{{ addresses.phone }}
                </div>
            </div>
            <div class="widget-products-action">
                <a href="javascript:;" class="btn btn-black" @click="selectBillingAddress(addresses.id)" v-show="current_step == 1">{{ __('shop::app.checkout.onepage.use_for_shipping') }}</a>
            </div>
            <div class="control-group" :class="[errors.has('address-form.billing[address_id]') ? 'has-error' : '']">
                <span class="control-error" v-if="errors.has('address-form.billing[address_id]')">
                    @{{ errors.first('address-form.billing[address_id]') }}
                </span>
            </div>
        </li>
    </ul>

    <div class="form-container" v-if="!this.new_billing_address" v-show="current_step == 1">
        <div class="mt-25">
            <a class="btn-default" @click = newBillingAddress()>
                {{ __('shop::app.checkout.onepage.new-address') }}
            </a>
        </div>

        @if ($cart->haveStockableItems())
            <div class="control-group mt-5" style="display: none;">
                <span class="checkbox">
                    <input type="checkbox" id="billing[use_for_shipping]" name="billing[use_for_shipping]" v-model="address.billing.use_for_shipping"/>
                        <label class="checkbox-view" for="billing[use_for_shipping]"></label>
                        {{ __('shop::app.checkout.onepage.use_for_shipping') }}
                </span>
            </div>
        @endif
    </div>

    <div class="form-container" v-if="this.new_billing_address">

        <div class="form-header">
            <h4>{{ __('shop::app.checkout.onepage.billing-address') }}</h4>

            @auth('customer')
                @if(count(auth('customer')->user()->addresses))
                    <a class="btn-default -back" @click = backToSavedBillingAddress()>
                        {{ __('shop::app.checkout.onepage.back') }}
                    </a>
                @endif
            @endauth
        </div>

        <div class=" col-xl-12 col-md-12">
            <div class="row">
                <div class=" col-xl-6 col-md-6" :class="[errors.has('address-form.billing[first_name]') ? 'has-error' : '']">
                    <label for="billing[first_name]" class="required">
                        {{ __('shop::app.checkout.onepage.first-name') }}
                    </label>

                    <input type="text" v-validate="'required'" class="control" id="billing[first_name]" name="billing[first_name]" v-model="address.billing.first_name" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.first-name') }}&quot;"/>

                    <span class="control-error" v-if="errors.has('address-form.billing[first_name]')">
                        @{{ errors.first('address-form.billing[first_name]') }}
                    </span>
                </div>
                <div class=" col-xl-6 col-md-6" :class="[errors.has('address-form.billing[last_name]') ? 'has-error' : '']">
                    <label for="billing[last_name]" class="required">
                        {{ __('shop::app.checkout.onepage.last-name') }}
                    </label>

                    <input type="text" v-validate="'required'" class="control" id="billing[last_name]" name="billing[last_name]" v-model="address.billing.last_name" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.last-name') }}&quot;"/>

                    <span class="control-error" v-if="errors.has('address-form.billing[last_name]')">
                        @{{ errors.first('address-form.billing[last_name]') }}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class=" col-xl-12 col-md-12" :class="[errors.has('address-form.billing[date_of_birth]') ? 'has-error' : '']">
                    <label for="billing[date_of_birth]" class="required">
                        Data de nascimento
                    </label>

                    <input type="date" v-validate="'required'" class="control" id="billing[date_of_birth]" name="billing[date_of_birth]" v-model="address.billing.date_of_birth" data-vv-as="&quot;Data de nascimento&quot;"/>

                    <span class="control-error" v-if="errors.has('address-form.billing[date_of_birth]')">
                        @{{ errors.first('address-form.billing[date_of_birth]') }}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12" :class="[errors.has('address-form.billing[email]') ? 'has-error' : '']">
                    <label for="billing[email]" class="required">
                        {{ __('shop::app.checkout.onepage.email') }}
                    </label>

                    <input type="text" v-validate="'required|email'" class="control" id="billing[email]" name="billing[email]" v-model="address.billing.email" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.email') }}&quot;"/>

                    <span class="control-error" v-if="errors.has('address-form.billing[email]')">
                        @{{ errors.first('address-form.billing[email]') }}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-md-4" :class="[errors.has('address-form.billing[postcode]') ? 'has-error' : '']">
                    <label for="billing[postcode]" class="required">
                        {{ __('shop::app.checkout.onepage.postcode') }}
                    </label>

                    <input type="text" v-validate="'required'" class="control" id="billing[postcode]" name="billing[postcode]" @keyup="searchAddress('billing')" v-model="address.billing.postcode" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.postcode') }}&quot;"/>

                    <span class="control-error" v-if="errors.has('address-form.billing[postcode]')">
                        @{{ errors.first('address-form.billing[postcode]') }}
                    </span>
                </div>

                <div class="col-xl-8 col-md-8">
                    <label for="billing_address_0" class="required">
                        {{ __('shop::app.checkout.onepage.address1') }}
                    </label>

                    <input type="text" v-validate="'required'" class="control" id="billing_address_0" name="billing[address1][]" v-model="address.billing.address1[0]" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.address1') }}&quot;"/>

                    <span class="control-error" v-if="errors.has('address-form.billing[address1][]')">
                        @{{ errors.first('address-form.billing[address1][]') }}
                    </span>
                </div>
                @if (core()->getConfigData('customer.settings.address.street_lines') && core()->getConfigData('customer.settings.address.street_lines') > 1)

                    @for ($i = 1; $i < core()->getConfigData('customer.settings.address.street_lines'); $i++)
                        <div class="col-xl-4 col-md-4">
                            @if($i == 1)
                            <label for="billing_address_0">
                                {{ __('shop::app.checkout.onepage.number') }}
                            </label>
                            <input v-validate="'required'" type="text" class="control" name="billing[address1][{{ $i }}]" id="billing_address_{{ $i }}" v-model="address.billing.address1[{{$i}}]"  data-vv-as="&quot;{{ __('shop::app.checkout.onepage.number') }}&quot;">
                            @elseif($i == 2)
                                <label for="billing_address_0">
                                    {{ __('shop::app.checkout.onepage.complement') }}
                                </label>
                                <input type="text" class="control" name="billing[address1][{{ $i }}]" id="billing_address_{{ $i }}" v-model="address.billing.address1[{{$i}}]"  data-vv-as="&quot;{{ __('shop::app.checkout.onepage.complement') }}&quot;">
                            @elseif($i == 3)
                                <label for="billing_address_0">
                                    {{ __('shop::app.checkout.onepage.neighborhood') }}
                                </label>
                                <input type="text" class="control" name="billing[address1][{{ $i }}]" id="billing_address_{{ $i }}" v-model="address.billing.address1[{{$i}}]"  data-vv-as="&quot;{{ __('shop::app.checkout.onepage.neighborhood') }}&quot;">
                            @else
                                <input type="text" class="control" name="billing[address1][{{ $i }}]" id="billing_address_{{ $i }}" v-model="address.billing.address1[{{$i}}]">
                            @endif
                        </div>
                    @endfor
                @endif
            </div>
            <div class="row">
                <div class="col-xl-6 col-md-6" :class="[errors.has('address-form.billing[city]') ? 'has-error' : '']">
                    <label for="billing[city]" class="required">
                        {{ __('shop::app.checkout.onepage.city') }}
                    </label>

                    <input type="text" v-validate="'required'" class="control" id="billing[city]" name="billing[city]" v-model="address.billing.city" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.city') }}&quot;"/>

                    <span class="control-error" v-if="errors.has('address-form.billing[city]')">
                        @{{ errors.first('address-form.billing[city]') }}
                    </span>
                </div>
                <div class="col-xl-6 col-md-6" :class="[errors.has('address-form.billing[state]') ? 'has-error' : '']">
                    <label for="billing[state]" class="required">
                    {{ __('shop::app.checkout.onepage.state') }}
                    </label>

                    <input type="text" v-validate="'required'" class="control" id="billing[state]" name="billing[state]" v-model="address.billing.state" v-if="!haveStates('billing')" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.state') }}&quot;"/>

                    <span class="control-error" v-if="errors.has('address-form.billing[state]')">
                        @{{ errors.first('address-form.billing[state]') }}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-md-6" :class="[errors.has('address-form.billing[phone]') ? 'has-error' : '']">
                    <label for="billing[phone]" class="required">
                        {{ __('shop::app.checkout.onepage.phone') }}
                    </label>

                    <input type="text" v-validate="'required'" class="control" id="billing[phone]" v-mask="['(##) ####-####', '(##) #####-####']" name="billing[phone]" v-model="address.billing.phone" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.phone') }}&quot;"/>

                    <span class="control-error" v-if="errors.has('address-form.billing[phone]')">
                        @{{ errors.first('address-form.billing[phone]') }}
                    </span>
                </div>
                <div class="col-xl-6 col-md-6" :class="[errors.has('address-form.billing[taxvat]') ? 'has-error' : '']">
                    <label for="billing[taxvat]" class="required">
                        {{ __('shop::app.checkout.onepage.taxvat') }}
                    </label>

                    <input type="text" v-validate="'required'" class="control" id="billing[taxvat]" v-mask="['###.###.###-##']" name="billing[taxvat]" v-model="address.billing.taxvat" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.taxvat') }}&quot;"/>

                    <span class="control-error" v-if="errors.has('address-form.billing[taxvat]')">
                        @{{ errors.first('address-form.billing[taxvat]') }}
                    </span>
                </div>
            </div>
            @if ($cart->haveStockableItems())
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <span class="checkbox">
                    <input type="checkbox" id="billing[use_for_shipping]" name="billing[use_for_shipping]" v-model="address.billing.use_for_shipping"/>
                    <label class="checkbox-view" for="billing[use_for_shipping]">{{ __('shop::app.checkout.onepage.use_for_shipping') }}</label>
                </span>
                </div>
            </div>
            @endif
        </div>

        @auth('customer')
            <div class="control-group">
                <span class="checkbox">
                    <input type="checkbox" id="billing[save_as_address]" name="billing[save_as_address]" v-model="address.billing.save_as_address" checked />
                    <label class="checkbox-view" for="billing[save_as_address]"></label>
                    {{ __('shop::app.checkout.onepage.save_as_address') }}
                </span>
            </div>
        @endauth

    </div>

    @if ($cart->haveStockableItems())
        <div class="form-container" v-if="!address.billing.use_for_shipping && !this.new_shipping_address">
            <div class="form-header mt-30 mb-30">
                <span class="checkout-step-heading">{{ __('shop::app.checkout.onepage.shipping-address') }}</span>

                <a class="btn-default" style="float: right;" @click=newShippingAddress()>
                    {{ __('shop::app.checkout.onepage.new-address') }}
                </a>
            </div>

            <div class="address-holder">
                <div class="address-card" v-for='(addresses, index) in this.allAddress'>
                    <div class="checkout-address-content" style="display: flex; flex-direction: row; justify-content: space-between; width: 100%;">
                        <label class="radio-container" style="float: right; width: 5%;">
                            <input v-validate="'required'" type="radio" id="shipping[address_id]" name="shipping[address_id]" v-model="address.shipping.address_id" :value="addresses.id"
                            data-vv-as="&quot;{{ __('shop::app.checkout.onepage.shipping-address') }}&quot;">
                            <span class="checkmark"></span>
                        </label>

                        <ul class="address-card-list" style="float: right; width: 90%;">
                            <li class="mb-10">
                                <b>@{{ allAddress.first_name }} @{{ allAddress.last_name }},</b>
                            </li>

                            <li>
                                @{{ addresses.address1 }},
                            </li>

                            <li class="mb-10">
                                @{{ addresses.city }} / @{{ addresses.state }}
                            </li>

                            <li>
                                <b>{{ __('shop::app.customer.account.address.index.contact') }}</b>: @{{ addresses.phone }}
                            </li>

                            <li>
                                <b>{{ __('shop::app.customer.account.address.index.taxvat') }}</b>: @{{ addresses.taxvat }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="control-group" :class="[errors.has('address-form.shipping[address_id]') ? 'has-error' : '']">
                    <span class="control-error" v-if="errors.has('address-form.shipping[address_id]')">
                        @{{ errors.first('address-form.shipping[address_id]') }}
                    </span>
                </div>

            </div>
        </div>

        <div class="form-container" v-if="!address.billing.use_for_shipping && this.new_shipping_address">
            <div class="form-header mt-30 mb-30">

                <span class="checkout-step-heading">{{ __('shop::app.checkout.onepage.shipping-address') }}</span>
                @auth('customer')
                    @if(count(auth('customer')->user()->addresses))
                        <a class="btn-default -back" @click = backToSavedShippingAddress()>
                            {{ __('shop::app.checkout.onepage.back') }}
                        </a>
                    @endif
                @endauth
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class=" col-xl-6 col-md-6" :class="[errors.has('address-form.shipping[first_name]') ? 'has-error' : '']">
                        <label for="shipping[first_name]" class="required">
                            {{ __('shop::app.checkout.onepage.first-name') }}
                        </label>

                        <input type="text" v-validate="'required'" class="control" id="shipping[first_name]" name="shipping[first_name]" v-model="address.shipping.first_name" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.first-name') }}&quot;"/>

                        <span class="control-error" v-if="errors.has('address-form.shipping[first_name]')">
                        @{{ errors.first('address-form.shipping[first_name]') }}
                    </span>
                    </div>
                    <div class=" col-xl-6 col-md-6" :class="[errors.has('address-form.shipping[last_name]') ? 'has-error' : '']">
                        <label for="shipping[last_name]" class="required">
                            {{ __('shop::app.checkout.onepage.last-name') }}
                        </label>

                        <input type="text" v-validate="'required'" class="control" id="shipping[last_name]" name="shipping[last_name]" v-model="address.shipping.last_name" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.last-name') }}&quot;"/>

                        <span class="control-error" v-if="errors.has('address-form.shipping[last_name]')">
                        @{{ errors.first('address-form.shipping[last_name]') }}
                    </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12" :class="[errors.has('address-form.shipping[email]') ? 'has-error' : '']">
                        <label for="shipping[email]" class="required">
                            {{ __('shop::app.checkout.onepage.email') }}
                        </label>

                        <input type="text" v-validate="'required|email'" class="control" id="shipping[email]" name="shipping[email]" v-model="address.shipping.email" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.email') }}&quot;"/>

                        <span class="control-error" v-if="errors.has('address-form.shipping[email]')">
                        @{{ errors.first('address-form.shipping[email]') }}
                    </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12" :class="[errors.has('address-form.shipping[postcode]') ? 'has-error' : '']">
                        <label for="shipping[postcode]" class="required">
                            {{ __('shop::app.checkout.onepage.postcode') }}
                        </label>

                        <input type="text" v-validate="'required'" class="control" id="shipping[postcode]" name="shipping[postcode]" v-model="address.shipping.postcode" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.postcode') }}&quot;"/>

                        <span class="control-error" v-if="errors.has('address-form.shipping[postcode]')">
                    @{{ errors.first('address-form.shipping[postcode]') }}
                </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <label for="shipping_address_0" class="required">
                            {{ __('shop::app.checkout.onepage.address1') }}
                        </label>

                        <input type="text" v-validate="'required'" class="control" id="shipping_address_0" name="shipping[address1][]" v-model="address.shipping.address1[0]" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.address1') }}&quot;"/>

                        <span class="control-error" v-if="errors.has('address-form.shipping[address1][]')">
                        @{{ errors.first('address-form.shipping[address1][]') }}
                    </span>
                    </div>
                    @if (core()->getConfigData('customer.settings.address.street_lines') && core()->getConfigData('customer.settings.address.street_lines') > 1)
                        <div class="col-xl-12 col-md-12">
                            @if($i == 1)
                                <label for="billing_address_0">
                                    {{ __('shop::app.checkout.onepage.number') }}
                                </label>
                                <input v-validate="'required'" type="text" class="control" name="billing[address1][{{ $i }}]" id="billing_address_{{ $i }}" v-model="address.billing.address1[{{$i}}]"  data-vv-as="&quot;{{ __('shop::app.checkout.onepage.number') }}&quot;">
                            @elseif($i == 2)
                                <label for="billing_address_0">
                                    {{ __('shop::app.checkout.onepage.complement') }}
                                </label>
                                <input type="text" class="control" name="shipping[address1][{{ $i }}]" id="shipping_address_{{ $i }}" v-model="address.shipping.address1[{{$i}}]"  data-vv-as="&quot;{{ __('shop::app.checkout.onepage.complement') }}&quot;">
                            @elseif($i == 3)
                                <label for="billing_address_0">
                                    {{ __('shop::app.checkout.onepage.neighborhood') }}
                                </label>
                                <input type="text" class="control" name="shipping[address1][{{ $i }}]" id="shipping_address_{{ $i }}" v-model="address.shipping.address1[{{$i}}]"  data-vv-as="&quot;{{ __('shop::app.checkout.onepage.neighborhood') }}&quot;">
                            @else
                                <input type="text" class="control" name="shipping[address1][{{ $i }}]" id="shipping_address_{{ $i }}" v-model="address.shipping.address1[{{$i}}]">
                            @endif
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-6" :class="[errors.has('address-form.shipping[city]') ? 'has-error' : '']">
                        <label for="shipping[city]" class="required">
                            {{ __('shop::app.checkout.onepage.city') }}
                        </label>

                        <input type="text" v-validate="'required'" class="control" id="shipping[city]" name="shipping[city]" v-model="address.shipping.city" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.city') }}&quot;"/>

                        <span class="control-error" v-if="errors.has('address-form.shipping[city]')">
                        @{{ errors.first('address-form.shipping[city]') }}
                    </span>
                    </div>
                    <div class="col-xl-6 col-md-6" :class="[errors.has('address-form.shipping[state]') ? 'has-error' : '']">
                        <label for="shipping[state]" class="required">
                            {{ __('shop::app.checkout.onepage.state') }}
                        </label>

                        <input type="text" v-validate="'required'" class="control" id="shipping[state]" name="shipping[state]" v-model="address.shipping.state" v-if="!haveStates('shipping')" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.state') }}&quot;"/>

                        <span class="control-error" v-if="errors.has('address-form.shipping[state]')">
                        @{{ errors.first('address-form.shipping[state]') }}
                    </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-6" :class="[errors.has('address-form.shipping[phone]') ? 'has-error' : '']">
                        <label for="shipping[phone]" class="required">
                            {{ __('shop::app.checkout.onepage.phone') }}
                        </label>

                        <input type="text" v-validate="'required'" class="control" id="shipping[phone]" v-mask="['(##) ####-####', '(##) #####-####']" name="shipping[phone]" v-model="address.shipping.phone" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.phone') }}&quot;"/>

                        <span class="control-error" v-if="errors.has('address-form.shipping[phone]')">
                        @{{ errors.first('address-form.shipping[phone]') }}
                    </span>
                    </div>
                </div>
            </div>

            @auth('customer')
                <div class="control-group">
                    <span class="checkbox">
                        <input type="checkbox" id="shipping[save_as_address]" name="shipping[save_as_address]" v-model="address.shipping.save_as_address"/>
                        <label class="checkbox-view" for="shipping[save_as_address]"></label>
                        {{ __('shop::app.checkout.onepage.save_as_address') }}
                    </span>
                </div>
            @endauth

        </div>
    @endif

</form>
@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.customers.addresses.edit-title') }}
@stop


@section('content-wrapper')

    <edit-address></edit-address>
    @push('scripts')
        <script type="text/x-template" id="edit-address-template">
            <section class="account-area white-bg border-top pt-60 pb-60">
                <div class="container">

                    <div class="content full-page">
                        {!! view_render_event('admin.customer.addresses.edit.before', ['address' => $address]) !!}
                        <form method="post" action="{{ route('admin.customer.addresses.update', $address->id) }}" @submit.prevent="onSubmit">
                            <div class="page-header">
                                <div class="page-title">
                                    <h1>{{ __('admin::app.customers.addresses.edit-title') }}</h1>
                                </div>

                                <div class="page-action">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        {{ __('admin::app.customers.addresses.save-btn-title') }}
                                    </button>
                                </div>
                            </div>

                            <div class="page-content">
                                @csrf()

                                <input type="hidden" name="_method" value="PUT">

                                <input type="hidden" name="customer_id" value="{{ $address->customer_id }}">

                                <accordian :title="'{{ __('admin::app.customers.addresses.general') }}'" :active="true">
                                    <div slot="body">

                                        <?php $addresses = explode(PHP_EOL, $address->address1); ?>

                                        <div class="control-group" :class="[errors.has('postcode') ? 'has-error' : '']">
                                            <label for="postcode" class="required">{{ __('shop::app.customer.account.address.create.postcode') }}</label>
                                           {{-- <input type="text" class="control" name="postcode" v-validate="'required'" value="{{ $address->postcode }}" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.postcode') }}&quot;">--}}
                                            <input type="text" class="control cep" id="postcode" name="postcode" v-validate="'required'"
                                                   value="{{ $address->postcode }}"
                                                   data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.postcode') }}&quot;" @keyup="searchAddress()">
                                            <span class="control-error" v-if="errors.has('postcode')">@{{ errors.first('postcode') }}</span>
                                        </div>

                                        <div class="control-group" :class="[errors.has('address1[]') ? 'has-error' : '']">
                                            <label for="address_0" class="required">{{ __('shop::app.customer.account.address.create.street-address') }}</label>
                                            <input type="text" class="control" name="address1[]" id="address_0" v-validate="'required'" value="{{ isset($addresses[0]) ? $addresses[0] : '' }}" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.street-address') }}&quot;">
                                            <span class="control-error" v-if="errors.has('address1[]')">@{{ errors.first('address1[]') }}</span>
                                        </div>

                                        @if (core()->getConfigData('customer.settings.address.street_lines') && core()->getConfigData('customer.settings.address.street_lines') > 1)
                                            <div class="control-group">
                                                @for ($i = 1; $i < core()->getConfigData('customer.settings.address.street_lines'); $i++)
                                                    @if($i == 1)
                                                        <label for="address1[{{ $i }}" class="required">{{ __('shop::app.customer.account.address.create.number') }}</label>
                                                    @elseif($i == 2)
                                                        <label for="address1[{{ $i }}">{{ __('shop::app.customer.account.address.create.complement') }}</label>
                                                    @elseif($i == 3)
                                                        <label for="address1[{{ $i }}" class="required">{{ __('shop::app.customer.account.address.create.neighborhood') }}</label>
                                                    @endif

                                                    <input type="text" class="control" name="address1[{{ $i }}]" id="address_{{ $i }}" @if( $i != 2) required="required" @endif value="{{ isset($addresses[$i]) ? $addresses[$i] : '' }}">
                                                @endfor
                                            </div>
                                        @endif

                                        @include ('shop::customers.account.address.country-state', ['countryCode' => old('country') ?? $address->country, 'stateCode' => old('state') ?? $address->state])

                                        <div class="control-group" :class="[errors.has('city') ? 'has-error' : '']">
                                            <label for="city" class="required">{{ __('shop::app.customer.account.address.create.city') }}</label>
                                            <input type="text" class="control" name="city" id="city" v-validate="'required|alpha_spaces'" value="{{ $address->city }}" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.city') }}&quot;">
                                            <span class="control-error" v-if="errors.has('city')">@{{ errors.first('city') }}</span>
                                        </div>

                                        <div class="control-group" :class="[errors.has('state') ? 'has-error' : '']">
                                            <label for="state" class="required">{{ __('shop::app.customer.account.address.create.state') }}</label>
                                            <input type="text" class="control" id="state" name="state" v-validate="'required|alpha_spaces'" value="{{ $address->state }}" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.state') }}&quot;">
                                            <span class="control-error" v-if="errors.has('state')">@{{ errors.first('state') }}</span>
                                        </div>

                                        <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                                            <label for="phone" class="required">{{ __('shop::app.customer.account.address.create.phone') }}</label>
                                            <input type="text" class="control" name="phone" v-validate="'required'" value="{{ $address->phone }}" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.phone') }}&quot;">
                                            <span class="control-error" v-if="errors.has('phone')">@{{ errors.first('phone') }}</span>
                                        </div>

                                        <div class="control-group" :class="[errors.has('taxvat') ? 'has-error' : '']">
                                            <label for="taxvat" class="required">{{ __('shop::app.customer.account.address.create.taxvat') }}</label>
                                            <input type="text" class="control cpf" name="taxvat" v-validate="'required'" value="{{ $address->taxvat }}" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.taxvat') }}&quot;">
                                            <span class="control-error" v-if="errors.has('taxvat')">@{{ errors.first('taxvat') }}</span>
                                        </div>

                                        <div class="control-group">
                                <span class="checkbox">
                                    <input type="checkbox" class="control" id="default_address" name="default_address" {{ $address->default_address ? 'checked' : '' }} >

                                    <label class="checkbox-view" for="default_address"></label>
                                    {{ __('admin::app.customers.addresses.default-address') }}
                                </span>
                                        </div>
                                    </div>
                            </div>
                            </accordian>
                        </form>
                        {!! view_render_event('admin.customer.addresses.edit.after', ['address' => $address]) !!}

                    </div>

                </div>
            </section>
        </script>
        <script>
            Vue.component('edit-address', {

                template: '#edit-address-template',

                inject: ['$validator'],

                data() {
                    return {
                        address: {

                        }
                    }
                },

                methods: {
                    onSubmit: function (e) {
                        this.toggleButtonDisable(true);

                        if(typeof tinyMCE !== 'undefined')
                            tinyMCE.triggerSave();

                        this.$validator.validateAll().then(result => {
                            if (result) {
                                e.target.submit();
                            } else {
                                this.toggleButtonDisable(false);
                            }
                        });
                    },
                    toggleButtonDisable (value) {
                        var buttons = document.getElementsByTagName("button");

                        for (var i = 0; i < buttons.length; i++) {
                            buttons[i].disabled = value;
                        }
                    },

                    addServerErrors: function (scope = null) {
                        for (var key in serverErrors) {
                            var inputNames = [];
                            key.split('.').forEach(function(chunk, index) {
                                if(index) {
                                    inputNames.push('[' + chunk + ']')
                                } else {
                                    inputNames.push(chunk)
                                }
                            })

                            var inputName = inputNames.join('');

                            const field = this.$validator.fields.find({
                                name: inputName,
                                scope: scope
                            });
                            if (field) {
                                this.$validator.errors.add({
                                    id: field.id,
                                    field: inputName,
                                    msg: serverErrors[key][0],
                                    scope: scope
                                });
                            }
                        }
                    },

                    addFlashMessages: function () {
                        const flashes = this.$refs.flashes;

                        flashMessages.forEach(function (flash) {
                            flashes.addFlash(flash);
                        }, this);
                    },

                    responsiveHeader: function () { },

                    showModal(id) {
                        this.$set(this.modalIds, id, true);
                    },
                    searchAddress: function () {
                        var self = this;
                        self.$http.post('{{ route('shop.checkout.address.search') }}', {
                            zipcode: document.getElementById('postcode').value,
                            '_token': "{{ csrf_token() }}"
                        })
                            .then(function (response) {
                                if(!response.data.error) {
                                    document.getElementById('address_0').value = response.data.street;
                                    document.getElementById('address_3').value = response.data.district;
                                    document.getElementById('city').value = response.data.city;
                                    document.getElementById('state').value = response.data.uf;

                                    $('#address_0').focus();

                                    return;
                                }
                            })
                    }
                }
            });
        </script>
    @endpush
@stop
<edit-address></edit-address>
@push('scripts')
    <script type="text/x-template" id="edit-address-template">
        <section class="account-area white-bg border-top pt-60 pb-60">
            <div class="container">
                {{--        <div class="row">--}}

                <div class="account-content">
                    @include('shop::customers.account.partials.sidemenu')

                    <div class="account-layout">
                        <div class="account-head mb-15">
                            <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="fas fa-chevron-left"></i></a></span>
                            <span class="account-heading">{{ __('shop::app.customer.account.address.edit.title') }}</span>
                            <span></span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.account.address.edit.before', ['address' => $address]) !!}

                        <form method="post" class="form" action="{{ route('customer.address.edit', $address->id) }}" @submit.prevent="onSubmit">

                            <div class="account-table-content">
                                @method('PUT')
                                @csrf

                                {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.before', ['address' => $address]) !!}

                                <?php $addresses = explode(PHP_EOL, $address->address1); ?>

                                <div class="control-group" :class="[errors.has('postcode') ? 'has-error' : '']">
                                    <label for="postcode"
                                           class="required">{{ __('shop::app.customer.account.address.create.postcode') }}</label>
                                    <input type="text" class="control cep" id="postcode" name="postcode" v-validate="'required'"
                                           value="{{ $address->postcode }}"
                                           data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.postcode') }}&quot;" @keyup="searchAddress()">
                                    <span class="control-error" v-if="errors.has('postcode')">@{{ errors.first('postcode') }}</span>
                                </div>

                                <div class="control-group" :class="[errors.has('address1[]') ? 'has-error' : '']">
                                    <label for="address_0" class="required">{{ __('shop::app.customer.account.address.create.street-address') }}</label>
                                    <input type="text" class="control" name="address1[]" id="address_0" v-validate="'required'" value="{{ isset($addresses[0]) ? $addresses[0] : '' }}"
                                           data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.street-address') }}&quot;">
                                    <span class="control-error" v-if="errors.has('address1[]')">@{{ errors.first('address1[]') }}</span>
                                </div>

                                @if (core()->getConfigData('customer.settings.address.street_lines') && core()->getConfigData('customer.settings.address.street_lines') > 1)
                                    <div class="control-group">
                                        @for ($i = 1; $i < core()->getConfigData('customer.settings.address.street_lines'); $i++)
                                            @if($i == 1)
                                                <label for="address1[{{ $i }}">{{ __('shop::app.customer.account.address.create.number') }}</label>
                                            @elseif($i == 2)
                                                <label for="address1[{{ $i }}">{{ __('shop::app.customer.account.address.create.complement') }}</label>
                                            @elseif($i == 3)
                                                <label for="address1[{{ $i }}">{{ __('shop::app.customer.account.address.create.neighborhood') }}</label>
                                            @endif

                                            <input type="text" class="control" name="address1[{{ $i }}]"
                                                   id="address_{{ $i }}"
                                                   value="{{ isset($addresses[$i]) ? $addresses[$i] : '' }}"  @if("address_{{ $i }}"!="address1_2") required="required" @endif>
                                        @endfor
                                    </div>
                                @endif

                                @include ('shop::customers.account.address.country-state', ['stateCode' => old('state') ?? $address->state])

                                <div class="control-group" :class="[errors.has('city') ? 'has-error' : '']">
                                    <label for="city"
                                           class="required">{{ __('shop::app.customer.account.address.create.city') }}</label>
                                    <input type="text" class="control" id="city" name="city" v-validate="'required|alpha_spaces'"
                                           value="{{ $address->city }}"
                                           data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.city') }}&quot;">
                                    <span class="control-error" v-if="errors.has('city')">@{{ errors.first('city') }}</span>
                                </div>

                                <div class="control-group" :class="[errors.has('state') ? 'has-error' : '']">
                                    <label for="state"
                                           class="required">{{ __('shop::app.customer.account.address.create.state') }}</label>
                                    <input type="text" class="control" id="state" name="state" v-validate="'required|alpha_spaces'"
                                           value="{{ $address->state }}"
                                           data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.state') }}&quot;">
                                    <span class="control-error" v-if="errors.has('state')">@{{ errors.first('state') }}</span>
                                </div>

                                <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                                    <label for="phone"
                                           class="required">{{ __('shop::app.customer.account.address.create.phone') }}</label>
                                    <input type="text" class="control telefone" name="phone" v-validate="'required'"
                                           value="{{ $address->phone }}"
                                           data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.phone') }}&quot;">
                                    <span class="control-error"
                                          v-if="errors.has('phone')">@{{ errors.first('phone') }}</span>
                                </div>

                                <div class="control-group" :class="[errors.has('taxvat') ? 'has-error' : '']">
                                    <label for="taxvat"
                                           class="required">{{ __('shop::app.customer.account.address.create.taxvat') }}</label>
                                    <input type="text" class="control cpf" name="taxvat" v-validate="'required'"
                                           value="{{ $address->taxvat }}"
                                           data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.taxvat') }}&quot;" readonly>
                                    <span class="control-error"
                                          v-if="errors.has('taxvat')">@{{ errors.first('taxvat') }}</span>
                                </div>

                                {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.after', ['address' => $address]) !!}

                                <div class="button-group">
                                    <button class="btn btn-primary btn-lg" type="submit">
                                        {{ __('shop::app.customer.account.address.create.submit') }}
                                    </button>
                                </div>
                            </div>

                        </form>

                        {!! view_render_event('bagisto.shop.customers.account.address.edit.after', ['address' => $address]) !!}

                    </div>
                </div>

                {{--        </div>--}}
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
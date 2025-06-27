@extends('onestepcheckout::layouts.default')

@section('page_title')
    {{ __('shop::app.checkout.onepage.title') }}
@stop

@section('body_class')
    page-checkout
@endsection

@section('content-wrapper')
    <checkout></checkout>
@endsection

<?php $cart = cart()->getCart(); ?>

@push('scripts')
    <script type="text/x-template" id="checkout-template">
        <section class="checkout-area gray-bg pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="widget mb-40 clearfix">

                            <div class="widget-products step-content information" v-show="current_step >= 1" id="address-section">

                                @include('onestepcheckout::checkout.osc.customer-info')

                                <div class="widget-products-action" v-if="new_billing_address">
                                    <button type="button" class="btn btn-black" @click="validateForm('address-form')" :disabled="disable_button" id="checkout-address-continue-button">
                                        {{ __('shop::app.checkout.onepage.continue') }}
                                    </button>
                                </div>
                            </div>

                            <div id="shipping"></div>
                            <div class="step-content shipping mt-40" v-show="current_step >= 2" id="shipping-section">
                                <shipping-section v-if="current_step >= 2" @onShippingMethodSelected="shippingMethodSelected($event)"></shipping-section>
                            </div>

                        </div>

                        <coupon-section
                            v-show="current_step == 3"
                            @onApplyCoupon="getOrderSummary"
                            @onRemoveCoupon="getOrderSummary"
                        ></coupon-section>

                        <div class="widget payment mb-40" id="payment">
                            <div class="widget-title-box mb-30">
                                <h3 class="widget-title">Pagamento</h3>
                            </div>

                            <div v-show="current_step != 3">
                                <p>Aguardando informações de frete.</p>
                            </div>

                            <payment-section
                                v-if="current_step == 3"
                                @onPaymentMethodSelected="paymentMethodSelected($event)"
                                @onApplyCoupon="getOrderSummary"
                                @onRemoveCoupon="getOrderSummary"
                            ></payment-section>

                            <div class="widget-products-action" v-show="current_step == 3">
                                <button type="button" class="btn btn-lg btn-primary" @click="validateForm('payment-form')" :disabled="disable_button" id="checkout-place-order-button">
                                    Concluir Compra
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <summary-section
                            discount="1"
                            :key="summeryComponentKey"
                            @onApplyCoupon="getOrderSummary"
                            @onRemoveCoupon="getOrderSummary"
                        ></summary-section>
                    </div>

                </div>
            </div>
        </section>
    </script>

    <script type="text/x-template" id="coupon-template">
        @if (!$cart->coupon_code)
        <div class="widget payment mb-40" id="coupon" v-show="!couponApplied">
            <div class="widget-title-box mb-30">
                <h3 class="widget-title">Cupom de Desconto</h3>
            </div>

            <div class="mb-60">
                <form class="form" method="post" @submit.prevent="onSubmit">
                    <div class="row">
                        <div class="col-lg-12" :class="[errors.has('code') ? 'has-error' : '']" >
                            <label for="cupom"><b>Possui cupom de desconto?</b> Digite o código aqui!</label>
                            <input type="text" name="code" v-model="coupon_code" v-validate="'required'" @change="changeCoupon">

                        </div>

                        <div class="col-lg-12"><div v-if="error_message != null" class="control-error">* @{{ error_message }}</div></div>

                        <div class="col-lg-12 d-flex align-items-center">
                            <button type="submit" class="btn">{{ __('shop::app.checkout.onepage.apply-coupon') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </script>

    <script>
        var shippingHtml = '';
        var paymentHtml = '';
        var reviewHtml = '';
        var summaryHtml = '';
        var customerAddress = '';
        var shippingMethods = '';
        var paymentMethods = '';
        var selectedAddress = '';

        @auth('customer')
            @if(auth('customer')->user()->addresses)
            customerAddress = @json(auth('customer')->user()->addresses);
        customerAddress.email = "{{ auth('customer')->user()->email }}";
        customerAddress.first_name = "{{ auth('customer')->user()->first_name }}";
        customerAddress.last_name = "{{ auth('customer')->user()->last_name }}";
        @endif
        @endauth

        Vue.component('checkout', {
            template: '#checkout-template',
            inject: ['$validator'],

            data: function() {
                return {
                    step_numbers: {
                        'information': 1,
                        'shipping': 2,
                        'payment': 3,
                        'review': 4
                    },

                    current_step: 1,

                    completed_step: 0,

                    address: {
                        billing: {
                            address1: [''],

                            use_for_shipping: true,
                        },

                        shipping: {
                            address1: ['']
                        },
                    },

                    selected_shipping_method: '',

                    selected_payment_method: {
                        'method': 'ebanx'
                    },

                    disable_button: false,

                    new_shipping_address: false,

                    new_billing_address: false,

                    allAddress: {},

                    countryStates: @json(core()->groupedStatesByCountries()),

                    country: @json(core()->countries()),

                    summeryComponentKey: 0,

                    reviewComponentKey: 0
                }
            },

            created: function() {

                this.getOrderSummary();

                if(! customerAddress) {
                    this.new_shipping_address = true;
                    this.new_billing_address = true;
                } else {
                    this.address.billing.first_name = this.address.shipping.first_name = customerAddress.first_name;
                    this.address.billing.last_name = this.address.shipping.last_name = customerAddress.last_name;
                    this.address.billing.email = this.address.shipping.email = customerAddress.email;

                    if (customerAddress.length < 1) {
                        this.new_shipping_address = true;
                        this.new_billing_address = true;
                    } else {
                        this.allAddress = customerAddress;

                        for (var country in this.country) {
                            for (var code in this.allAddress) {
                                if (this.allAddress[code].country) {
                                    if (this.allAddress[code].country == this.country[country].code) {
                                        this.allAddress[code]['country'] = this.country[country].name;
                                    }
                                }
                            }
                        }
                    }
                }
            },

            methods: {
                haveStates: function(addressType) {
                    if (this.countryStates[this.address[addressType].country] && this.countryStates[this.address[addressType].country].length)
                        return true;

                    return false;
                },

                validateForm: function(scope) {
                    var this_this = this;

                    if (scope == 'payment-form' && $('#' + scope).find('#payment_brand').val() == 'bankslip'){
                        this_this.placeOrder();

                        return;
                    }

                    this.$validator.validateAll(scope).then(function (result) {
                        if (result) {
                            if (scope == 'address-form') {
                                this_this.saveAddress();
                            } else if (scope == 'shipping-form') {
                                this_this.saveShipping();
                            } else if (scope == 'payment-form') {
                                this_this.placeOrder();
                            }
                        }
                    });
                },

                getOrderSummary () {
                    var this_this = this;

                    this.$http.get("{{ route('shop.checkout.summary') }}")
                        .then(function(response) {
                            summaryHtml = Vue.compile(response.data.html)

                            this_this.summeryComponentKey++;
                            this_this.reviewComponentKey++;
                        })
                        .catch(function (error) {})
                },

                saveAddress: function() {
                    var this_this = this;

                    this.disable_button = true;

                    this_this.address.billing.save_as_address = true;

                    this.$http.post("{{ route('shop.checkout.save-address') }}", this.address)
                        .then(function(response) {
                            this_this.disable_button = false;

                            if (this_this.step_numbers[response.data.jump_to_section] == 2)
                                shippingHtml = Vue.compile(response.data.html)
                            else
                                paymentHtml = Vue.compile(response.data.html)

                            this_this.completed_step = this_this.step_numbers[response.data.jump_to_section] + 1;
                            this_this.current_step = this_this.step_numbers[response.data.jump_to_section];

                            this_this.getOrderSummary();
                        })
                        .catch(function (error) {
                            this_this.disable_button = false;

                            this_this.handleErrorResponse(error.response, 'address-form')
                        })
                },

                saveShipping: function() {
                    var this_this = this;

                    this.disable_button = true;

                    this.$scrollTo('#payment', 600, { offset: -140 });

                    this.$http.post("{{ route('shop.checkout.save-shipping') }}", {'shipping_method': this.selected_shipping_method})
                        .then(function(response) {

                            paymentHtml = Vue.compile(response.data.html)
                            this_this.completed_step = this_this.step_numbers[response.data.jump_to_section] + 1;
                            this_this.current_step = 3;

                            this_this.savePayment()
                            this_this.getOrderSummary();

                            // this_this.disable_button = false;
                        })
                        .catch(function (error) {
                            this_this.disable_button = false;

                            this_this.handleErrorResponse(error.response, 'shipping-form')
                        })
                },

                savePayment: function() {
                    var this_this = this;

                    this.disable_button = true;

                    this.$http.post("{{ route('shop.checkout.save-payment') }}", {'payment': this.selected_payment_method})
                        .then(function(response) {
                            this_this.disable_button = false;

                            reviewHtml = Vue.compile(response.data.html)

                        })
                        .catch(function (error) {
                            this_this.disable_button = false;

                            this_this.handleErrorResponse(error.response, 'payment-form')
                        });
                },

                placeOrder: function() {
                    var this_this = this;

                    this.disable_button = true;

                    var data = $('#payment-form').serialize();

                    this.$http.post("{{ route('shop.checkout.save-order') }}", {'_token': "{{ csrf_token() }}", "data": data})
                        .then(function(response) {

                            if (response.data.success) {
                                if (response.data.redirect_url) {
                                    window.location.href = response.data.redirect_url;
                                } else {
                                    window.location.href = "{{ route('shop.checkout.success') }}";
                                }
                            }
                        })
                        .catch(function (error) {
                            this_this.disable_button = true;

                            window.flashMessages = [{'type': 'alert-error', 'message': "{{ __('shop::app.common.error') }}" }];

                            this_this.$root.addFlashMessages()
                        })
                },

                handleErrorResponse: function(response, scope) {
                    if (response.status == 422) {
                        serverErrors = response.data.errors;
                        this.$root.addServerErrors(scope)
                    } else if (response.status == 403) {
                        if (response.data.redirect_url) {
                            window.location.href = response.data.redirect_url;
                        }
                    }
                },

                shippingMethodSelected: function(shippingMethod) {
                    this.selected_shipping_method = shippingMethod;
                    this.validateForm('shipping-form');
                },

                paymentMethodSelected: function(paymentMethod) {
                    this.selected_payment_method = paymentMethod;
                },

                newBillingAddress: function() {
                    this.new_billing_address = true;
                },

                newShippingAddress: function() {
                    this.new_shipping_address = true;
                },

                backToSavedBillingAddress: function() {
                    this.new_billing_address = false;
                },

                backToSavedShippingAddress: function() {
                    this.new_shipping_address = false;
                },
                selectBillingAddress: function (id) {
                    this.$scrollTo('#shipping', 600, { offset: -380 });

                    this.address.billing.address_id = id;
                    this.validateForm('address-form');
                },
                searchAddress: function (type) {
                    var self = this;
                    self.$http.post('{{ route('shop.checkout.address.search') }}', {
                        zipcode: type == 'billing' ? this.address.billing.postcode : this.address.shipping.postcode,
                        '_token': "{{ csrf_token() }}"
                    })
                    .then(function (response) {
                        if(!response.data.error) {
                            if (type == 'billing') {
                                self.address.billing.address1[0] = response.data.street;
                                self.address.billing.address1[3] = response.data.district;
                                self.address.billing.city = response.data.city;
                                self.address.billing.state = response.data.uf;

                                document.getElementById('billing_address_0').value = response.data.street;
                                document.getElementById('billing_address_3').value = response.data.district;
                                document.getElementById('billing[city]').value = response.data.city;
                                document.getElementById('billing[state]').value = response.data.uf;

                                $('#billing_address_0').focus();

                                return;
                            } else {
                                self.address.shipping.address1[0] = response.data.street;
                                self.address.shipping.address1[3] = response.data.district;
                                self.address.shipping.city = response.data.city;
                                self.address.shipping.state = response.data.uf;

                                document.getElementById('shipping_address_0').value = response.data.street;
                                document.getElementById('shipping_address_3').value = response.data.district;
                                document.getElementById('shipping[city]').value = response.data.city;
                                document.getElementById('shipping[state]').value = response.data.uf;

                                $('#shipping_address_0').focus();

                                return;
                            }
                        }
                    })
                }
            }
        })

        var shippingTemplateRenderFns = [];

        Vue.component('shipping-section', {
            inject: ['$validator'],

            data: function() {
                return {
                    templateRender: null,

                    selected_shipping_method: '',

                    first_iteration : true,
                }
            },

            staticRenderFns: shippingTemplateRenderFns,

            mounted: function() {
                for (method in shippingMethods) {
                    if (this.first_iteration) {
                        for (rate in shippingMethods[method]['rates']) {
                            this.selected_shipping_method = shippingMethods[method]['rates'][rate]['method'];
                            alert(this.first_iteration);
                            this.first_iteration = false;
                            this.methodSelected();
                        }
                    }
                }

                this.templateRender = shippingHtml.render;
                for (var i in shippingHtml.staticRenderFns) {
                    shippingTemplateRenderFns.push(shippingHtml.staticRenderFns[i]);
                }

                eventBus.$emit('after-checkout-shipping-section-added');
            },

            render: function(h) {
                return h('div', [
                    (this.templateRender ?
                        this.templateRender() :
                        '')
                ]);
            },

            methods: {
                methodSelected: function() {
                    this.$emit('onShippingMethodSelected', this.selected_shipping_method)

                    eventBus.$emit('after-shipping-method-selected');
                }
            }
        })

        var paymentTemplateRenderFns = [];

        Vue.component('payment-section', {
            inject: ['$validator'],

            data: function() {
                return {
                    templateRender: null,

                    payment: {
                        method: "ebanx"
                    },

                    creditCard: {
                        info: {}
                    },

                    first_iteration : true,

                    installmentsList: null,

                    installment: null,

                    brand: ''
                }
            },

            staticRenderFns: paymentTemplateRenderFns,

            mounted: function() {
                for (method in paymentMethods) {
                    if (this.first_iteration) {
                        this.payment.method = paymentMethods[method]['method'];
                        this.first_iteration = false;
                        this.methodSelected();
                    }
                }

                this.templateRender = paymentHtml.render;
                for (var i in paymentHtml.staticRenderFns) {
                    paymentTemplateRenderFns.push(paymentHtml.staticRenderFns[i]);
                }

                this.installments();

                eventBus.$emit('after-checkout-payment-section-added');
            },

            render: function(h) {
                return h('div', [
                    (this.templateRender ?
                        this.templateRender() :
                        '')
                ]);
            },

            methods: {
                methodSelected: function() {
                    this.$emit('onPaymentMethodSelected', this.payment)
                    eventBus.$emit('after-payment-method-selected');
                },
                validCreditCard: function(e){
                    var validation = valid.number(this.creditCard.info.number);

                    if(validation.card){

                        $('.creditcard_type label').each(function(item, obj){
                            if(!$(obj).hasClass('grayscale')){
                                $(obj).addClass('grayscale')
                            }
                        });
                        $('.creditcard_type label[for="' + validation.card.type + '"]').removeClass('grayscale')

                        this.selectPaymentBrand(validation.card.type);
                        this.installments();
                    }
                },
                defineInstallment: function(){
                    var self = this;
                    $('#payment_installments').val(self.installment);
                },
                installments: function(){
                    var self = this;
                    self.$http.get('{{ route('shop.checkout.installments') }}')
                        .then(function(response) {
                            self.installmentsList = response.data;
                        })
                },
                selectPaymentBrand: function (brand) {
                    var self = this;
                    self.brand = brand;

                    $('#payment_brand').val(brand);
                }
            }
        })

        var reviewTemplateRenderFns = [];

        Vue.component('review-section', {
            data: function() {
                return {
                    templateRender: null,

                    error_message: ''
                }
            },

            staticRenderFns: reviewTemplateRenderFns,

            render: function(h) {
                return h('div', [
                    (this.templateRender ?
                        this.templateRender() :
                        '')
                ]);
            },

            mounted: function() {
                this.templateRender = reviewHtml.render;

                for (var i in reviewHtml.staticRenderFns) {
                    // reviewTemplateRenderFns.push(reviewHtml.staticRenderFns[i]);
                    reviewTemplateRenderFns[i] = reviewHtml.staticRenderFns[i];
                }

                this.$forceUpdate();
            }
        });

        Vue.component('coupon-section', {
            template: '#coupon-template',
            inject: ['$validator'],

            props: {
                discount: {
                    type: [String, Number],

                    default: 0,
                }
            },

            data: function() {
                return {
                    coupon_code: null,

                    error_message: null,

                    couponChanged: false,

                    changeCount: 0,

                    couponApplied: false
                }
            },

            methods: {
                onSubmit: function() {
                    var this_this = this;

                    axios.post('{{ route('shop.checkout.check.coupons') }}', {code: this_this.coupon_code})
                        .then(function(response) {
                            this_this.$emit('onApplyCoupon');

                            this_this.couponChanged = true;

                            this_this.couponApplied = true;

                            this_this.getOrderSummary();

                            this_this.installments();
                        })
                        .catch(function(error) {
                            this_this.couponChanged = true;

                            this_this.couponApplied = false;

                            this_this.error_message = error.response.data.message;
                        });
                },

                changeCoupon: function() {
                    var this_this = this;
                    this_this.coupon_code = this.coupon_code.toUpperCase();

                    if (this_this.couponChanged == true && this_this.changeCount == 0) {
                        this_this.changeCount++;

                        this_this.error_message = null;

                        this_this.couponChanged = false;

                        this_this.couponApplied = false;
                    } else {
                        this.changeCount = 0;
                    }
                },

                removeCoupon: function () {
                    var this_this = this;

                    axios.post('{{ route('shop.checkout.remove.coupon') }}')
                        .then(function(response) {
                            this_this.$emit('onRemoveCoupon');

                            this_this.getOrderSummary();

                            this_this.couponApplied = false;
                        })
                        .catch(function(error) {
                            window.flashMessages = [{'type' : 'alert-error', 'message' : error.response.data.message}];

                            this_this.couponApplied = false;

                            this_this.$root.addFlashMessages();
                        });
                },

                getOrderSummary () {
                    this.$http.get("<?php echo e(route('shop.checkout.summary')); ?>")
                        .then(function(response) {
                            summaryHtml = Vue.compile(response.data.html)
                        })
                        .catch(function (error) {})
                },

                defineInstallment: function(){
                    var self = this;
                    $('#payment_installments').val(self.installment);
                },
                installments: function(){
                    var self = this;
                    self.$http.get('{{ route('shop.checkout.installments') }}')
                        .then(function(response) {
                            self.installmentsList = response.data;
                        })
                },
            }
        })

        var summaryTemplateRenderFns = [];

        Vue.component('summary-section', {
            inject: ['$validator'],

            props: {
                discount: {
                    type: [String, Number],

                    default: 0,

                    couponApplied: false
                }
            },

            data: function() {
                return {
                    templateRender: null,

                    coupon_code: null,

                    error_message: null,

                    couponChanged: false,

                    changeCount: 0
                }
            },

            staticRenderFns: summaryTemplateRenderFns,

            mounted: function() {
                this.templateRender = summaryHtml.render;

                for (var i in summaryHtml.staticRenderFns) {
                    // summaryTemplateRenderFns.push(summaryHtml.staticRenderFns[i]);
                    summaryTemplateRenderFns[i] = summaryHtml.staticRenderFns[i];
                }

                this.$forceUpdate();
            },

            render: function(h) {
                return h('div', [
                    (this.templateRender ?
                        this.templateRender() :
                        '')
                ]);
            },

            methods: {
                onSubmit: function() {
                    var this_this = this;

                    axios.post('{{ route('shop.checkout.check.coupons') }}', {code: this_this.coupon_code})
                        .then(function(response) {
                            this_this.$emit('onApplyCoupon');

                            this_this.couponChanged = true;

                            this_this.getOrderSummary();
                        })
                        .catch(function(error) {
                            this_this.couponChanged = true;

                            this_this.error_message = error.response.data.message;
                        });
                },

                changeCoupon: function() {
                    var this_this = this;

                    this_this.coupon_code = this.coupon_code.toUpperCase();

                    if (this_this.couponChanged == true && this_this.changeCount == 0) {
                        this_this.changeCount++;

                        this_this.error_message = null;

                        this_this.couponChanged = false;
                    } else {
                        this_this.changeCount = 0;
                    }
                },

                removeCoupon: function () {
                    var this_this = this;

                    axios.post('{{ route('shop.checkout.remove.coupon') }}')
                        .then(function(response) {
                            this_this.$emit('onRemoveCoupon');

                            this_this.couponApplied = false;

                            this_this.getOrderSummary();
                        })
                        .catch(function(error) {
                            window.flashMessages = [{'type' : 'alert-error', 'message' : error.response.data.message}];

                            this_this.$root.addFlashMessages();
                        });
                },

                getOrderSummary () {
                    this.$http.get("<?php echo e(route('shop.checkout.summary')); ?>")
                        .then(function(response) {
                            summaryHtml = Vue.compile(response.data.html)
                        })
                        .catch(function (error) {})
                },
            }
        })
    </script>
@endpush
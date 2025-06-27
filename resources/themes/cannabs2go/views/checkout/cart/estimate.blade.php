@push('scripts')
    <script type="text/html" id="estimate-template" v-if="!estimates">
        <li>
            {{ __('shop::app.checkout.total.delivery-charges') }}
            <div class="widget mb-40">
                <div class="widget-title-box mb-30">
                    <h3 class="widget-title">Simule frete e prazo de entrega</h3>
                </div>
                <form @submit.prevent="onSubmit" class="form" v-if="!estimates">
                    <div class="col-xl-12 col-md-12">

                        {!! view_render_event('onnow.osc.checkout.cart.shipping.after', ['cart' => $cart]) !!}

                        <input type="text" v-validate="'required'" v-model="zipcode" class="control" placeholder="Digite aqui seu CEP"/>

                        {!! view_render_event('onnow.osc.checkout.cart.shipping.before', ['cart' => $cart]) !!}

                        <button class="btn" type="submit">
                            Calcular
                        </button>
                    </div>
                </form>
                <form @submit.prevent="onSubmit" class="form" v-if="estimates">
                    <div class="col-xl-12 col-md-12">
                        <ul class="shipping">
                            <li v-for="estimate in estimates">
                                <div class="form-check">
                                    <label for="metodo1" class="form-check-label">
                                        @{{ estimate.method_title }}
                                    </label>
                                    <span class="f-right">@{{ estimate.price }}</span>
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
                    var _this = this;

                    this.$http.post('{{ route('osc.checkout.estimate') }}', {
                            zipcode: _this.zipcode,
                            '_token': "{{ csrf_token() }}"
                        })
                        .then(response => (
                            this.estimates = response.data
                        ))
                },
                test(){
                    alert(1);
                }
            }
        })
    </script>
@endpush
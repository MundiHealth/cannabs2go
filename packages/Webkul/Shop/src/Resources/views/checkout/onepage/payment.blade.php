<form data-vv-scope="payment-form" class="form" id="payment-form">
    <input v-validate="'required'" type="hidden" id="ebanx" name="payment[method]" value="primeiropay" v-model="payment.method" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.payment-method') }}&quot;">
    <div class="widget-products">
        <ul class="nav product-tab" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="cartao-tab" data-toggle="tab" href="#cartao" @click="selectPaymentBrand('creditcard')">
                    <h5> <i class="fas fa-credit-card"></i> Cartão de Crédito</h5>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="boleto-tab" data-toggle="tab" href="#boleto"  @click="selectPaymentBrand('bankslip')">
                    <h5> <i class="fas fa-barcode"></i> Boleto</h5>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="pix-tab" data-toggle="tab" href="#pix"  @click="selectPaymentBrand('pix')">
                    <h5> <i class="fas fa-qrcode"></i> PIX</h5>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="link-tab" data-toggle="tab" href="#link"  @click="selectPaymentBrand('link')">
                    <h5> <i class="fas fa-link"></i> EBANX</h5>
                </a>
            </li>
        </ul>

        <div class="tab-content clearfix" id="myTabContent">
            <div class="tab-pane fade show active" id="cartao" role="tabpanel" aria-labelledby="cartao-tab">
                <div class="widget-products-body">
                    <h6 class="widget-products-title">Pagamento com Cartão de Crédito</h6>

                        <div class="row">
                            <div class="col-lg-12" :class="[errors.has('payment-form.payment[method]') ? 'has-error' : '']">
                                <div class="row">
                                    <div class="col-xl-7 col-md-7">
                                        <label for="credit_card">Número do cartão</label>
                                        <input name="payment[number]" type="text" maxlength="19" v-model="creditCard.info.number" @change="validCreditCard($event)" v-validate="'required'" v-mask="['#### #### #### ####']">

                                        <div class="box-cards" style="display: inline-block;">
                                            <div class="creditcard_type">
                                                <span class="label">
                                                    <input name="payment[cc_type]" class="radio cards" id="mastercard" value="master" type="radio">
                                                    <label for="mastercard" class="grayscale">
                                                         <img title="MasterCard" alt="MasterCard" src="{{ asset('themes/osc/assets/img/cards/logo-master.png') }}">
                                                    </label>
                                                </span>
                                            </div>

                                            <div class="creditcard_type">
                                                <span class="label">
                                                    <input name="payment[cc_type]" class="radio cards" id="visa" value="visa" type="radio">
                                                    <label for="visa" class="grayscale">
                                                         <img title="Visa" alt="Visa" src="{{ asset('themes/osc/assets/img/cards/logo-visa.png') }}">
                                                    </label>
                                                </span>
                                            </div>
                                            <div class="creditcard_type">
                                                <span class="label">
                                                    <input name="payment[cc_type]" class="radio cards" id="amex" value="amex" type="radio">
                                                    <label for="amex" class="grayscale">
                                                        <img title="Amex" alt="Amex" src="{{ asset('themes/osc/assets/img/cards/logo-amex.png') }}">
                                                    </label>
                                                </span>
                                            </div>
                                            <div class="creditcard_type">
                                                <span class="label">
                                                    <input name="payment[cc_type]" class="radio cards" id="diners" value="diners" type="radio">
                                                    <label for="diners" class="grayscale">
                                                         <img title="Diners" alt="Diners" src="{{ asset('themes/osc/assets/img/cards/logo-diners.png') }}">
                                                    </label>
                                                </span>
                                            </div>
                                            <div class="creditcard_type">
                                                <span class="label">
                                                    <input name="payment[cc_type]" class="radio cards" id="elo" value="elo" type="radio">
                                                    <label for="elo" class="grayscale">
                                                        <img title="Elo" alt="Elo" src="{{ asset('themes/osc/assets/img/cards/logo-elo.png') }}">
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-xl-7 col-md-7">
                                        <label for="name">Nome do titular (como está gravado no cartão)</label>
                                        <input name="payment[holder]" type="text" v-validate="'required'">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12">
                                <label>Data de Validade</label>

                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="payment[month]" id="month" v-validate="'required'">
                                            <option value="">Mês</option>
                                            <option value="1">01</option>
                                            <option value="2">02</option>
                                            <option value="3">03</option>
                                            <option value="4">04</option>
                                            <option value="5">05</option>
                                            <option value="6">06</option>
                                            <option value="7">07</option>
                                            <option value="8">08</option>
                                            <option value="9">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="payment[year]" id="year" v-validate="'required'">
                                            <option value="">Ano</option>
                                            @for($y = \Carbon\Carbon::now()->format('Y'); $y <= \Carbon\Carbon::now()->addYears(10)->format('Y'); $y++)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="name">Código de Segurança</label>
                                        <input name="payment[cvv]" id="cvv" type="text" v-mask="'####'" maxlength="4" v-validate="'required'">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name">CPF do Titular</label>
                                        <input name="payment[taxvat]" type="text" class="cpf" v-validate="'required'" v-mask="['###.###.###-##']">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6">
                                        <label for="name">Parcelas</label>
                                        <select id="installment" @change="defineInstallment" v-model="installment" name="payment[installment]" v-validate="'required'">
                                            <option v-for="installment in installmentsList" :value="installment.qty">@{{ installment.qty }}x de @{{ installment.value }} - Total: @{{ installment.total }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <p class="ajax-response"></p>
                </div>
            </div>
            <div class="tab-pane fade" id="boleto" role="tabpanel" aria-labelledby="boleto-tab">
                <div class="widget-products-body">
                    <h6 class="widget-products-title">Pagamento com Boleto</h6>
                    <p>Você poderá visualizar ou imprimir após a finalização do pedido. A data de vencimento é de 2 dias corridos após a conclusão do pedido. Após esta data, ele perderá a validade.</p>
                </div>
            </div>
            <div class="tab-pane fade" id="pix" role="tabpanel" aria-labelledby="pix-tab">
                <div class="widget-products-body">
                    <h6 class="widget-products-title">Pagamento com PIX</h6>
                    <p>Você poderá visualizar a chave PIX ou acessar o QR CODE após a finalização do pedido. A chave PIX e QR CODE expira 1 hora após a conclusão do pedido.</p>
                </div>
            </div>
            <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link-tab">
                <div class="widget-products-body">
                    <h6 class="widget-products-title">Pagamento com EBANX</h6>
                    <p>Você será redirecionado para a a tela de pagamento do EBANX e poderá escolher entre as formas de pagamento disponíveis.</p>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="payment_brand" name="payment[brand]">
</form>

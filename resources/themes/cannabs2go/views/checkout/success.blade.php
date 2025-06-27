@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.checkout.success.title') }}
@stop

@section('content-wrapper')

    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>{{ __('shop::app.checkout.success.thanks') }}</h1>
                        <ul class="breadcrumb-menu">
                            <li><b>{{ __('shop::app.checkout.success.order-id-info', ['order_id' => $order->increment_id]) }}</b></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="order-success-content pt-60 pb-60 gray-bg" style="min-height: 300px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="widget mb-40">
                        <div class="widget-title-box mb-20">
                            <h3 class="widget-title">{{ __('shop::app.checkout.success.details') }}</h3>
                        </div>
                        <div class="widget-body">
                            <p><b>{{ __('shop::app.checkout.success.order-id-info', ['order_id' => $order->increment_id]) }}.</b></p>

                            <p>{{ __('shop::app.checkout.success.info') }}</p>
                        </div>

                        @if(isset($payment->payment_type_code) && $payment->payment_type_code == 'boleto')
                        <div class="widget-title-box mt-40 mb-20">
                            <h3 class="widget-title">{{ __('shop::app.checkout.success.payment') }}</h3>
                        </div>
                        <div class="widget-body">
                            <p>{{ __('shop::app.checkout.success.payment-info') }}</p>

                            <p><b>{{ __('shop::app.checkout.success.code-bar') }}:</b> {{ $payment->boleto_barcode }}</p>

                            <a href="{{ $payment->boleto_url }}" class="btn" target="_blank">{{ __('shop::app.checkout.success.printing') }}</a>
                        </div>
                        @elseif(isset($payment->payment_type_code) && $payment->payment_type_code == 'pix')
                            <div class="widget-title-box mt-40 mb-20">
                                <h3 class="widget-title">{{ __('shop::app.checkout.success.payment') }}</h3>
                            </div>
                            <div class="widget-body">
                                <p>Você selecionou PIX como forma de pagamento, portanto, lembre-se que seu pedido só será despachado após a confirmação do pagamento. Para efetuar o pagamento, copie a chave abaixo ou clique no botão para acessar o QR CODE.</p>

                                <p><b>Chave PIX:</b> {{ $payment->pix->qr_code_value }}</p>

                                <a href="{{ $payment->redirect_url }}" class="btn" target="_blank">Clique AQUI para acessar o QR CODE</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="widget mb-40">
                        <div class="widget-title-box mb-20">
                            <h3 class="widget-title">{{ __('shop::app.checkout.success.prescription') }}</h3>
                        </div>

                        <div class="widget-body">
                            <div class="alert alert-warning">
                                <b>Importante!</b> Seu pedido só será despachado após o envio da prescrição, de acordo com a RDC 28/2011 da ANVISA.
                                <a href="https://api.whatsapp.com/send?phone=5511998680834" target="_blank">Não possui prescrição? Clique aqui e fale com nosso Customer Care via WhatsApp.</a>
                            </div>

                            {!!  view_render_event('bagisto.shop.checkout.continue-shopping.before', ['order' => $order])  !!}
                        </div>
                    </div>


                </div>
            </div>
        </div>


    {{--    {!!  view_render_event('bagisto.shop.checkout.continue-shopping.before', ['order' => $order])  !!}--}}

    {{--    <div class="misc-controls">--}}
    {{--        <a style="display: inline-block" href="{{ route('shop.home.index') }}" class="btn btn-lg btn-primary">--}}
    {{--            {{ __('shop::app.checkout.cart.continue-shopping') }}--}}
    {{--        </a>--}}
    {{--    </div>--}}

    {{--    {!! view_render_event('bagisto.shop.checkout.continue-shopping.after', ['order' => $order]) !!}--}}

    </div>
@endsection

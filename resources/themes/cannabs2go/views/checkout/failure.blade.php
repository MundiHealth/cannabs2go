@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.checkout.failure.title') }}
@stop

@section('content-wrapper')

    <div class="order-failure-content pt-60 pb-60" style="min-height: 300px;">
        <div class="container">
            <div class="col-xl-12">
                <div class="text-center">
                    <h1><span>Ops!</span> {{ __('shop::app.checkout.failure.title') }}</h1>

                    <p>{{ __('shop::app.checkout.failure.message') }}</p>

                    {{--                <p>{{ __('shop::app.checkout.failure.error-code-info', ['order_id' => $order->increment_id]) }}</p>--}}
                    <p>{{ __('shop::app.checkout.failure.error-code-info', ['error' => $error]) }}</p>

                    <p>
                        <b>
                            {!!
                                __('shop::app.checkout.failure.info', [
                                    'support_email' => ' <a style="color:#0041FF" href="mailto:' . config('mail.from.address') . '">' . config('mail.from.address'). '</a>'
                                    ])
                            !!}
                        </b>
                    </p>

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
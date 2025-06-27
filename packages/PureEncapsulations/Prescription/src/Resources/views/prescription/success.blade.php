@extends('pureencapsulations::layouts.master')

@section('page_title')
    {{ 'Prescrição recebida' }}
@endsection

@section('body_class')
    page-prescription
@stop

@section('content-wrapper')

    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>{{ __('shop::app.checkout.prescription.success.title-breadcrumb') }}</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="/">Home</a></li>
                            <li><span>{{ __('shop::app.checkout.prescription.success.title-breadcrumb') }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="error-area pos-relative pt-100 pb-60 fix">--}}
{{--        <div class="col-xl-12 text-center">--}}
{{--            <div class="container">--}}
{{--                <div class="alert alert-success">--}}
{{--                    {{ __('shop::app.checkout.prescription.success.title') }}--}}
{{--                </div>--}}

{{--                <p>{{ __('shop::app.checkout.prescription.success.message') }}</p>--}}

{{--                <p>--}}
{{--                    {!!--}}
{{--                        __('shop::app.checkout.prescription.success.info', [--}}
{{--                            'support_email' => ' <a href="mailto:' . config('mail.from.address') . '">' . config('mail.from.address'). '</a>'--}}
{{--                            ])--}}
{{--                    !!}--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}



    <div class="order-success-content pt-60 pb-60 gray-bg" style="min-height: 300px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="widget mb-40">
                        <div class="widget-body">
                            <div class="alert alert-success">
                                {{ __('shop::app.checkout.prescription.success.title') }}
                            </div>

                            <p>{{ __('shop::app.checkout.prescription.success.message') }}</p>

                            <p>
                                {!!
                                    __('shop::app.checkout.prescription.success.info', [
                                        'support_email' => ' <a href="mailto:' . config('mail.from.address') . '">' . config('mail.from.address'). '</a>'
                                        ])
                                !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
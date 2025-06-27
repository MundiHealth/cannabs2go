@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.login-form.page-title') }}
@endsection
@section('body_class')
    page-account
@endsection
@section('content-wrapper')

    <section class="account-area gray-bg pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-6" style="margin: 0 auto;">
                    <div class="sign-up-text">
                        @if(request()->has('checkout'))
                            {{ __('shop::app.customer.login-text.no_account') }} <a href="{{ route('customer.register.index', ['checkout']) }}">{{ __('shop::app.customer.login-text.title') }}</a>
                        @else
                            {{ __('shop::app.customer.login-text.no_account') }} <a href="{{ route('customer.register.index') }}">{{ __('shop::app.customer.login-text.title') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6" style="margin: 0 auto;">
                    <div class="widget mb-40">
                        <div class="widget-title-box mb-30">
                            <h3 class="widget-title">Acesse sua conta</h3>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.login.before') !!}

                        @if(request()->has('checkout'))
                            <form class="form" method="POST" action="{{ route('customer.session.create', ['checkout']) }}" @submit.prevent="onSubmit">
                                @else
                                    <form class="form" method="POST" action="{{ route('customer.session.create') }}" @submit.prevent="onSubmit">
                                        @endif
                                        {{ csrf_field() }}
                                        <div class="row">
                                            {!! view_render_event('bagisto.shop.customers.login_form_controls.before') !!}
                                            <div class="col-xl-12 col-lg-12" :class="[errors.has('email') ? 'has-error' : '']">
                                                <input type="text" class="control" name="email" placeholder="{{ __('shop::app.customer.login-form.email') }}" v-validate="'required|email'" value="{{ old('email') }}" data-vv-as="&quot;{{ __('shop::app.customer.login-form.email') }}&quot;">
                                                <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                                            </div>
                                            <div class="col-xl-12 col-lg-12" :class="[errors.has('password') ? 'has-error' : '']">
                                                <input type="password" id="password" class="control" name="password" placeholder="{{ __('shop::app.customer.login-form.password') }}" v-validate="'required'" value="{{ old('password') }}" data-vv-as="&quot;{{ __('shop::app.customer.login-form.password') }}&quot;">
                                                <span id="show_password" class="fa fa-eye-slash" aria-hidden="true"></span>
                                                <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
                                            </div>
                                            {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="contact-button text-center">
                                                    <p><a href="{{ route('customer.forgot-password.create') }}">{{ __('shop::app.customer.login-form.forgot_pass') }}</a></p>

                                                    <div class="mt-10">
                                                        @if (Cookie::has('enable-resend'))
                                                            @if (Cookie::get('enable-resend') == true)
                                                                <a href="{{ route('customer.resend.verification-email', Cookie::get('email-for-resend')) }}">{{ __('shop::app.customer.login-form.resend-verification') }}</a>
                                                            @endif
                                                        @endif
                                                    </div>

                                                    <button class="btn" type="submit">{{ __('shop::app.customer.login-form.button_title') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="ajax-response"></p>
                                    </form>

                            {!! view_render_event('bagisto.shop.customers.login.after') !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
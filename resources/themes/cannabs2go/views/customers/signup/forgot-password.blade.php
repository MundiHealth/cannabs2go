@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.forgot-password.page_title') }}
@stop

@push('css')
    <style>
        .button-group {
            margin-bottom: 25px;
        }
        .primary-back-icon {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content-wrapper')

    <section class="account-area gray-bg pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-6" style="margin: 0 auto;">
                    <div class="sign-up-text">
                        <a href="{{ route('customer.session.index') }}">
                            <i class="fas fa-arrow-left"></i>
                            {{ __('shop::app.customer.reset-password.back-link-title') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6" style="margin: 0 auto;">
                    <div class="widget mb-40">
                        <div class="widget-title-box mb-30">
                            <h3 class="widget-title">{{ __('shop::app.customer.forgot-password.title') }}</h3>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.forget_password.before') !!}

                        <form method="post" class="form" action="{{ route('customer.forgot-password.store') }}" @submit.prevent="onSubmit">

                            {{ csrf_field() }}

                            {!! view_render_event('bagisto.shop.customers.forget_password_form_controls.before') !!}

                            <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                                <label for="email">{{ __('shop::app.customer.forgot-password.email') }}</label>
                                <input type="email" class="control" name="email" v-validate="'required|email'">
                                <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                            </div>

                            {!! view_render_event('bagisto.shop.customers.forget_password_form_controls.before') !!}

                            <div class="button-group">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    {{ __('shop::app.customer.forgot-password.submit') }}
                                </button>
                            </div>

                        </form>

                        {!! view_render_event('bagisto.shop.customers.forget_password.before') !!}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.account.profile.edit.page-title') }}
@endsection
@section('body_class')
    page-account
@endsection
@section('content-wrapper')

    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>Perfil</h1>
                        <ul class="breadcrumb-menu">
                            {{--                            <li><a href="/">Home</a></li>--}}
                            <li><span>Perfil</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="account-area white-bg border-top pt-60 pb-60">
        <div class="container">
    {{--        <div class="row">--}}
        <div class="account-content">

            @include('shop::customers.account.partials.sidemenu')

            <div class="account-layout">

                <div class="account-head mb-10">
                    <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>

                    <span class="account-heading">{{ __('shop::app.customer.account.profile.edit-profile.title') }}</span>

                    <span></span>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.profile.edit.before', ['customer' => $customer]) !!}

                <form method="post" action="{{ route('customer.profile.edit') }}" @submit.prevent="onSubmit" class="form">

                    <div class="edit-form">
                        @csrf

                        {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.before', ['customer' => $customer]) !!}

                        <div class="control-group" :class="[errors.has('first_name') ? 'has-error' : '']">
                            <label for="first_name" class="required">{{ __('shop::app.customer.account.profile.fname') }}</label>

                            <input type="text" class="control" name="first_name" value="{{ old('first_name') ?? $customer->first_name }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.fname') }}&quot;">
                            <span class="control-error" v-if="errors.has('first_name')">@{{ errors.first('first_name') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('last_name') ? 'has-error' : '']">
                            <label for="last_name" class="required">{{ __('shop::app.customer.account.profile.lname') }}</label>

                            <input type="text" class="control" name="last_name" value="{{ old('last_name') ?? $customer->last_name }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.lname') }}&quot;">
                            <span class="control-error" v-if="errors.has('last_name')">@{{ errors.first('last_name') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('gender') ? 'has-error' : '']">
                            <label for="email" class="required">{{ __('shop::app.customer.account.profile.gender') }}</label>

                            <select name="gender" class="control" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.gender') }}&quot;">
                                <option value=""  @if ($customer->gender == "") selected @endif></option>
                                <option value="Other"  @if ($customer->gender == "Other") selected @endif>Outro</option>
                                <option value="Male"  @if ($customer->gender == "Male") selected @endif>Masculino</option>
                                <option value="Female" @if ($customer->gender == "Female") selected @endif>Feminino</option>
                            </select>
                            <span class="control-error" v-if="errors.has('gender')">@{{ errors.first('gender') }}</span>
                        </div>

                        <div class="control-group"  :class="[errors.has('date_of_birth') ? 'has-error' : '']">
                            <label for="date_of_birth">{{ __('shop::app.customer.account.profile.dob') }}</label>
                            <input type="date" class="control" name="date_of_birth" value="{{ old('date_of_birth') ?? $customer->date_of_birth }}" v-validate="" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.dob') }}&quot;">
                            <span class="control-error" v-if="errors.has('date_of_birth')">@{{ errors.first('date_of_birth') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                            <label for="email" class="required">{{ __('shop::app.customer.account.profile.email') }}</label>
                            <input type="email" class="control" name="email" value="{{ old('email') ?? $customer->email }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.email') }}&quot;">
                            <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('oldpassword') ? 'has-error' : '']">
                            <label for="password">{{ __('shop::app.customer.account.profile.opassword') }}</label>
                            <input type="password" class="control" name="oldpassword" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.opassword') }}&quot;" v-validate="'min:6'">
                            <span class="control-error" v-if="errors.has('oldpassword')">@{{ errors.first('oldpassword') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                            <label for="password">{{ __('shop::app.customer.account.profile.password') }}</label>

                            <input type="password" id="password" class="control" name="password" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.password') }}&quot;" v-validate="'min:6'">
                            <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('password_confirmation') ? 'has-error' : '']">
                            <label for="password">{{ __('shop::app.customer.account.profile.cpassword') }}</label>

                            <input type="password" id="password_confirmation" class="control" name="password_confirmation" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.cpassword') }}&quot;" v-validate="'min:6|confirmed:password'">
                            <span class="control-error" v-if="errors.has('password_confirmation')">@{{ errors.first('password_confirmation') }}</span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.after', ['customer' => $customer]) !!}

                        <div class="button-group">
                            <input class="btn btn-primary btn-lg" type="submit" value="{{ __('shop::app.customer.account.profile.submit') }}">
                        </div>
                    </div>

                </form>

                {!! view_render_event('bagisto.shop.customers.account.profile.edit.after', ['customer' => $customer]) !!}

            </div>

        </div>
    {{--        </div>--}}
        </div>
    </section>

@endsection


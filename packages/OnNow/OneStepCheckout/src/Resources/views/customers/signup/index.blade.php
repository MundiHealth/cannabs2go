<section class="account-area gray-bg pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-6" style="margin: 0 auto;">
                <div class="sign-up-text">
                    @if(request()->has('checkout'))
                    {{ __('shop::app.customer.signup-text.account_exists') }} - <a href="{{ route('customer.session.index', ['checkout']) }}">{{ __('shop::app.customer.signup-text.title') }}</a>
                    @else
                    {{ __('shop::app.customer.signup-text.account_exists') }} - <a href="{{ route('customer.session.index') }}">{{ __('shop::app.customer.signup-text.title') }}</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6" style="margin: 0 auto;">
                <div class="widget mb-40">
                    <div class="widget-title-box mb-30">
                        <h3 class="widget-title">Crie sua conta</h3>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.signup.before') !!}

                    @if(request()->has('checkout'))
                    <form method="post" action="{{ route('customer.register.create', ['checkout']) }}" @submit.prevent="onSubmit" class="form">
                    @else
                    <form method="post" action="{{ route('customer.register.create') }}" @submit.prevent="onSubmit" class="form">
                    @endif
                        @csrf
                        <div class="row">

                            {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}

                            <div class="col-xl-12 col-lg-12" :class="[errors.has('first_name') ? 'has-error' : '']">
                                <input type="text" class="control" name="first_name" v-validate="'required'" value="{{ old('first_name') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.firstname') }}&quot;" placeholder="{{ __('shop::app.customer.signup-form.firstname') }}">
                                <span class="control-error" v-if="errors.has('first_name')">@{{ errors.first('first_name') }}</span>
                            </div>
                            <div class="col-xl-12 col-lg-12" :class="[errors.has('last_name') ? 'has-error' : '']">
                                <input type="text" class="control" name="last_name" v-validate="'required'" value="{{ old('last_name') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.lastname') }}&quot;" placeholder="{{ __('shop::app.customer.signup-form.lastname') }}">
                                <span class="control-error" v-if="errors.has('last_name')">@{{ errors.first('last_name') }}</span>
                            </div>
                            <div class="col-xl-12 col-lg-12" :class="[errors.has('email') ? 'has-error' : '']">
                                <input type="email" class="control" name="email" v-validate="'required|email'" value="{{ old('email') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.email') }}&quot;" placeholder="{{ __('shop::app.customer.signup-form.email') }}">
                                <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                            </div>
                            <div class="col-xl-12 col-lg-12" :class="[errors.has('password') ? 'has-error' : '']">
                                <input type="password" class="control" name="password" v-validate="'required|min:6'" ref="password" value="{{ old('password') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.password') }}&quot;" placeholder="{{ __('shop::app.customer.signup-form.password') }}">
                                <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
                            </div>
                            <div class="col-xl-12 col-lg-12" :class="[errors.has('password_confirmation') ? 'has-error' : '']">
                                <input type="password" class="control" name="password_confirmation"  v-validate="'required|min:6|confirmed:password'" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.confirm_pass') }}&quot;" placeholder="{{ __('shop::app.customer.signup-form.confirm_pass') }}">
                                <span class="control-error" v-if="errors.has('password_confirmation')">@{{ errors.first('password_confirmation') }}</span>
                            </div>

                            <div class="col-xl-12 col-lg-12 signup-confirm mb-20" :class="[errors.has('agreement') ? 'has-error' : '']">
                                <span class="checkbox">
                                    <input type="checkbox" id="checkbox2" name="agreement">
                                    <label class="checkbox-view" for="checkbox2"></label>

                                </span>
                                <p>{{ __('shop::app.customer.signup-form.agree') }}
                                    <a href="{{ route('shop.cms.page', ['politica-de-privacidade']) }}">{{ __('shop::app.customer.signup-form.terms') }}</a>.
                                </p>
                                <span class="control-error" v-if="errors.has('agreement')">@{{ errors.first('agreement') }}</span>
                            </div>

                            {!! view_render_event('bagisto.shop.customers.signup_form_controls.after') !!}

                            <div class="col-xl-12 col-lg-12">
                                <div class="contact-button text-center">
                                    <button class="btn" type="submit">{{ __('shop::app.customer.signup-form.button_title') }}</button>
                                </div>
                            </div>
                        </div>
                        <p class="ajax-response"></p>
                    </form>

                    {!! view_render_event('bagisto.shop.customers.signup.after') !!}
                </div>
            </div>
        </div>
    </div>
</section>
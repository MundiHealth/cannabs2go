@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.account.order.index.page-title') }}
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
                        <h1>{{ __('shop::app.customer.account.order.index.title') }}</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="{{url()->to('/customer/account/profile')}}">Minha Conta</a></li>
                            <li><span>{{ __('shop::app.customer.account.order.index.title') }}</span></li>
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
                    <span class="account-heading">
                        {{ __('shop::app.customer.account.order.index.title') }}
                    </span>

                    <div class="horizontal-rule"></div>
                </div>
                {!! view_render_event('bagisto.shop.customers.account.orders.list.before') !!}

                <div class="account-items-list">
                    <div class="account-table-content">

                        {!! app('Webkul\Shop\DataGrids\OrderDataGrid')->render() !!}

                    </div>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.orders.list.after') !!}

            </div>

        </div>

    {{--        </div>--}}
        </div>
    </section>

@endsection
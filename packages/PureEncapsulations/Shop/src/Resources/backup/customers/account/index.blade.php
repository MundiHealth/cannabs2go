@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.login-form.page-title') }}
@endsection
@section('body_class')
    page-account
@endsection
@section('content-wrapper')

    @include('onestepcheckout::customers.account.index')

@endsection


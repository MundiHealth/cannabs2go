@extends('shop::layouts.bariatric')
@section('page_title')
    {{ __('shop::app.customer.signup-form.page-title') }}
@endsection
@section('body_class')
    page-account
@endsection
@section('content-wrapper')

    @include('onestepcheckout::customers.signup.index')

@endsection

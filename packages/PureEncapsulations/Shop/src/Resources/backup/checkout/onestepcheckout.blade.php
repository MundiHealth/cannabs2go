@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.checkout.onepage.title') }}
@stop

@section('body_class')
    page-checkout
@stop

@section('content-wrapper')
    @include('onestepcheckout::checkout.onestepcheckout')
@endsection
@extends('shop::layouts.bariatric')

@section('page_title')
    {{ __('shop::app.checkout.success.title') }}
@stop

@section('content-wrapper')

    @include('onestepcheckout::checkout.success')

@endsection

@extends('shop::layouts.bariatric')

@section('page_title')
    {{ __('shop::app.checkout.failure.title') }}
@stop

@section('content-wrapper')

    @include('onestepcheckout::checkout.failure')

@endsection
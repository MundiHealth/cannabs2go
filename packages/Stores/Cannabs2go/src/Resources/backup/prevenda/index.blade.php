@extends('shop::layouts.bariatric')

@section('page_title')
    {{ 'Pré-Venda' }}
@endsection

@section('body_class')
    page-prevenda
@stop

@section('content-wrapper')

    @include('prevenda::prevenda.index')

@endsection
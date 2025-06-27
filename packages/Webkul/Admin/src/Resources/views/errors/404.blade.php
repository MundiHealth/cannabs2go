@extends('shop::layouts.master')

@section('page_title')
    {{ __('admin::app.error.404.page-title') }}
@stop

@section('content-wrapper')


    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center" style=" font-size: 20px;">
                        <div class="error-title" style="font-size: 30px;color: #5E5E5E">
                            {{ __('admin::app.error.404.name') }}
                        </div>

                        <ul class="breadcrumb-menu">
                            <li><a href="/">Home</a></li>
                            <li><span>404</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="error-area pos-relative pt-100 pb-60 fix">
        <div class="col-xl-12 text-center">
            <div class="container">
                <div class="error-description" style="margin-top: 20px;margin-bottom: 20px;color: #242424">
                    {{ __('admin::app.error.404.message') }}
                </div>


                <p><a href="http://127.0.0.1:8000" class="btn">Voltar para a página inicial</a></p>
            </div>
        </div>
    </div>

@endsection
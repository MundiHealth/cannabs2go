@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.login-form.page-title') }}
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
                        <h1>Avaliações</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="{{url()->to('/customer/account/profile')}}">Minha Conta</a></li>
                            <li><span>Avaliações</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('onestepcheckout::customers.account.reviews.reviews')

@endsection
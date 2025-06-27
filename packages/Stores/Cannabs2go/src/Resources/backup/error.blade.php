@extends('shop::layouts.bariatric')
@section('content-wrapper')
    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>Página não encontrada!</h1>
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
                <p>A página que você está procurando não existe ou foi removida.</p>

                <p><a href="{{ url()->to('/') }}" class="btn">Voltar para a página inicial</a></p>
            </div>
        </div>
    </div>
@endsection
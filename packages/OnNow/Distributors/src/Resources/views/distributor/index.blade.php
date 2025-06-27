@extends('admin::layouts.content')

@section('page_title')
    Distribuidores
@endsection

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>Distribuidores</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('distributor.create') }}" class="btn btn-lg btn-primary">
                    Adicionar Distribuidor
                </a>
            </div>
        </div>

        <div class="page-content">
            {!! app('OnNow\Distributors\DataGrids\DistributorDataGrid')->render('distributor') !!}
        </div>
    </div>
@endsection
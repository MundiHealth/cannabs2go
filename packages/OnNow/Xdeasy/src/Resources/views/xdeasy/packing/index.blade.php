@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.sales.orders.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>Packing</h1>
            </div>

            <div class="page-action">
                <!--<div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>
                    <span>
                        {{ __('admin::app.export.export') }}
                </span>
            </div>-->

                <div class="export-import" @click="showModal('fedexData')">
                    <i class="export-icon"></i>
                    <span>
                        Atualizar Trackings FedEx
                    </span>
                </div>

                <div class="export-import" @click="showModal('warehouseData')">
                    <i class="export-icon"></i>
                    <span>
                        Pesos e Embalagens
                    </span>
                </div>

                <a class="export-import" href="{{ route('admin.xdeasy.zip') }}">
                    <i class="export-icon"></i>
                    Baixar Documentação
                </a>

                <!--<a class="export-import" href="{{ route('admin.xdeasy.mawbGenerate') }}"><i class="export-icon"></i>
                    Imprimir MAWB</a>-->

                <a class="export-import" href="{{ route('admin.xdeasy.mawbBringerGenerate') }}">
                    <i class="export-icon"></i>
                    Imprimir MAWB Bringer
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('orderGrid', 'OnNow\Xdeasy\DataGrids\PackingDataGrid')
            {!! $orderGrid->render() !!}
        </div>
    </div>
    <modal id="downloadDataGrid" :is-open="modalIds.downloadDataGrid">
        <h3 slot="header">{{ __('admin::app.export.download') }}</h3>
        <div slot="body">
            <export-form></export-form>
        </div>
    </modal>
    <modal id="warehouseData" :is-open="modalIds.warehouseData">
        <h3 slot="header">Atualizar pesos e medidas</h3>
        <div slot="body">
            <form method="post" action="{{ route('admin.xdeasy.package.warehouseImport') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-container">
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="file-update" aria-describedby="fileHelp">
                        <small id="fileHelp" class="form-text text-muted">Por favor, selecione um arquivo (.xlsx) com tamanho máximo de 2MB.</small>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Enviar</button>
                </div>
            </form>
        </div>
    </modal>
    <modal id="fedexData" :is-open="modalIds.fedexData">
        <h3 slot="header">Atualizar Trackings FedEx</h3>
        <div slot="body">
            <form method="post" action="{{ route('admin.xdeasy.package.fedexTrackingImport') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-container">
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="file-update" aria-describedby="fileHelp">
                        <small id="fileHelp" class="form-text text-muted">Por favor, selecione um arquivo (.xlsx) com tamanho máximo de 2MB.</small>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Enviar</button>
                </div>
            </form>
        </div>
    </modal>

@stop

@push('scripts')
    @include('admin::export.export', ['gridName' => $orderGrid])
@endpush

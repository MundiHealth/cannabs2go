@extends('admin::layouts.content')

@section('page_title')
    {{ 'Doctors' }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ 'Doctors' }}</h1>
            </div>
            <div class="page-action">
                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>
                    <span >
                        {{ __('admin::app.export.export') }}
                    </span>
                </div>

                <a href="{{ route('doctor.create') }}" class="btn btn-lg btn-primary">
                    {{ 'Add Doctor' }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('doctorGrid', 'PureEncapsulations\Doctor\DataGrids\DoctorDataGrid')

            {!! $doctorGrid->render() !!}
        </div>
    </div>

    <modal id="downloadDataGrid" :is-open="modalIds.downloadDataGrid">
        <h3 slot="header">{{ __('admin::app.export.download') }}</h3>
        <div slot="body">
            <export-form></export-form>
        </div>
    </modal>

@stop

@push('scripts')
    @include('admin::export.export', ['gridName' => $doctorGrid])
@endpush


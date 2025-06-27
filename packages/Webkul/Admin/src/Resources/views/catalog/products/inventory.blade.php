@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.catalog.products.edit-title') }}
@stop

@section('content')
    <div class="content">
        <?php $locale = request()->get('locale') ?: app()->getLocale(); ?>
        <?php $channel = request()->get('channel') ?: core()->getDefaultChannelCode(); ?>

        <form method="POST" action="" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-header">

                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        Atualizar Estoque do produto
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        Atualizar
                    </button>
                </div>
            </div>

            <div class="page-content">
                @csrf()

                <h2>Estoque atual: {{ $inventories->sum('qty') }}</h2>

                <div class="control-group" :class="[errors.has('action') ? 'has-error' : '']">
                    <label for="action" class="required">Ação</label>

                    <select type="text" class="control" id="action" name="action" v-validate="'required'" value="{{ old('channel[]') }}" data-vv-as="&quot;Ação&quot;">
                        <option value="sum">Somar</option>
                        <option value="sub">Subtrair</option>
                    </select>

                    <span class="control-error" v-if="errors.has('action')">@{{ errors.first('action') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('qty') ? 'has-error' : '']">
                    <label for="qty" class="required">Quantidade</label>

                    <input type="text" class="control" id="qty" name="qty" v-validate="'required'" value="{{ old('qty') }}" data-vv-as="&quot;Valor&quot;">

                    <span class="control-error" v-if="errors.has('qty')">@{{ errors.first('qty') }}</span>
                </div>

            </div>

        </form>

    </div>
@stop
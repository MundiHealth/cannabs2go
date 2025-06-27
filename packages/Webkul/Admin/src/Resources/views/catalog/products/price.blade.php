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

                        Atualizar Preços em Massa
                    </h1>

                    <div class="control-group">
                        <select class="control" id="channel-switcher" name="channel">
                            <option value="">
                                Todos Canais
                            </option>
                            @foreach (core()->getAllChannels() as $channelModel)

                                <option value="{{ $channelModel->code }}" {{ ($channelModel->code) == $channel ? 'selected' : '' }}>
                                    {{ $channelModel->name }}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    <div class="control-group">
                        <select class="control" id="locale-switcher" name="locale">
                            @foreach (core()->getAllLocales() as $localeModel)

                                <option value="{{ $localeModel->code }}" {{ ($localeModel->code) == $locale ? 'selected' : '' }}>
                                    {{ $localeModel->name }}
                                </option>

                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        Atualizar
                    </button>
                </div>
            </div>

            <div class="page-content">
                @csrf()

                <div class="control-group" :class="[errors.has('type') ? 'has-error' : '']">
                    <label for="url-key" class="required">Tipo</label>

                    <select type="text" class="control" name="type" v-validate="'required'" value="{{ old('type') }}" data-vv-as="&quot;Tipo&quot;">
                            <option value="fix">Fixo</option>
                            <option value="percentage">Porcentagem</option>
                    </select>

                    <span class="control-error" v-if="errors.has('type')">@{{ errors.first('type') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('action') ? 'has-error' : '']">
                    <label for="url-key" class="required">Ação</label>

                    <select type="text" class="control" name="action" v-validate="'required'" value="{{ old('channel[]') }}" data-vv-as="&quot;Ação&quot;">
                        <option value="sum">Somar</option>
                        <option value="sub">Subtrair</option>
                    </select>

                    <span class="control-error" v-if="errors.has('action')">@{{ errors.first('action') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('value') ? 'has-error' : '']">
                    <label for="page_title" class="required">Valor</label>

                    <input type="text" class="control" name="value" v-validate="'required'" value="{{ old('value') }}" data-vv-as="&quot;Valor&quot;">

                    <span class="control-error" v-if="errors.has('value')">@{{ errors.first('value') }}</span>
                </div>

            </div>

        </form>

    </div>
@stop

@push('scripts')

    <script>
        $(document).ready(function () {
            $('#channel-switcher, #locale-switcher').on('change', function (e) {
                $('#channel-switcher').val()
                var query = '?channel=' + $('#channel-switcher').val() + '&locale=' + $('#locale-switcher').val();

                window.location.href = "{{ route('admin.catalog.products.price')  }}" + query;
            })
        });
    </script>
@endpush
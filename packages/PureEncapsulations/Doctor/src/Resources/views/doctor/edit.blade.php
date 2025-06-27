@extends('admin::layouts.content')

@section('page_title')
    {{ 'Update Doctor' }}
@stop

@section('content')
    <div class="content">

        <form method="post" action="{{ route('doctor.update', $doctor->id) }}">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        {{ 'Doctors' }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ 'Update Doctor' }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()

                            <div class="control-group" :class="[errors.has('doctor_reg') ? 'has-error' : '']">
                                <label for="doctor_reg" class="required">ID do Médico</label>
                                <input type="text" class="control" name="doctor_reg" v-validate="'required'" value="{{ $doctor->doctor_reg }}">
                                <span class="control-error" v-if="errors.has('doctor_reg')">@{{ errors.first('doctor_reg') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">Nome do Médico</label>
                                <input type="text" class="control" name="name" v-validate="'required'" value="{{ $doctor->name }}">
                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('patient') ? 'has-error' : '']">
                                <label for="patient" class="required">Nome do Paciente</label>
                                <input type="text" class="control" name="patient" v-validate="'required'" value="{{ $doctor->patient }}">
                                <span class="control-error" v-if="errors.has('patient')">@{{ errors.first('patient') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('prescription_date') ? 'has-error' : '']">
                                <label for="dob" class="required">{{ 'Data de Prescrição' }}</label>
                                <input type="date" class="control" name="prescription_date" v-validate="" value="{{ $doctor->prescription_date }}">
                                <span class="control-error" v-if="errors.has('prescription_date')">@{{ errors.first('prescription_date') }}</span>
                            </div>


                            <div class="control-group" :class="[errors.has('purchase') ? 'has-error' : '']">
                                <label for="purchase" class="required">{{ 'Comprou' }}</label>
                                <select name="purchase" id="purchase" class="control" v-validate="'required'" onchange="hasOrder()">
                                    <option value=""></option>
                                    <option value="1" {{ $doctor->purchase == 1 ? 'selected' : null }}>{{ 'Sim' }}</option>
                                    <option value="0" {{ $doctor->purchase == 0 ? 'selected' : null }}>{{ 'Não' }}</option>
                                </select>
                                <span class="control-error" v-if="errors.has('purchase')">@{{ errors.first('purchase') }}</span>
                            </div>

                            <div id="disable" style="display: none;">

                                <div class="control-group" :class="[errors.has('purchase_date') ? 'has-error' : '']">
                                    <label for="dob">{{ 'Data da Compra' }}</label>
                                    <input type="date" class="control" name="purchase_date" v-validate="" value="{{ $doctor->purchase_date }}">
                                    <span class="control-error" v-if="errors.has('purchase_date')">@{{ errors.first('purchase_date') }}</span>
                                </div>

                                <div class="control-group" :class="[errors.has('order_number') ? 'has-error' : '']">
                                    <label for="order_number">No. do Pedido</label>
                                    <input type="text" class="control" name="order_number" v-validate="" value="{{ $doctor->order_number }}">
                                    <span class="control-error" v-if="errors.has('order_number')">@{{ errors.first('order_number') }}</span>
                                </div>

                            </div>

                </div>
            </div>
        </form>

    </div>
@stop

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#purchase option:selected").each(function() {
                var purchase = $(this).val();

                // console.log(purchase);
                if (purchase == 1){
                    $("#disable").show()
                } else {
                    $("#disable").hide()
                }
            });

            // console.log(purchase);
        });

        function hasOrder(){
            $("#purchase option:selected").each(function() {
                var purchase = $(this).val();

                // console.log(purchase);
                if (purchase == 1){
                    $("#disable").show()
                } else {
                    $("#disable").hide()
                }
            });
        }
    </script>
@endpush
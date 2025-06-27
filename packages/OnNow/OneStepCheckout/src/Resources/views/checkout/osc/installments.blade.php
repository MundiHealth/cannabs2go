<div class="col-lg-12">
    <div class="row">
        <div class="col-xl-7 col-md-7">
            <label for="name">Parcelas</label>
            <select name="month" id="month" v-validate="'required'">
                @foreach($installments as $installment)
                    <option value="{{ $installment['qty'] }}">{{ core()->currency($installment['value']) }} - Total: {{ core()->currency($installment['total']) }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
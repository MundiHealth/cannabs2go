@section('content-wrapper')
    {!! view_render_event('bagisto.shop.checkout.payment-method.before') !!}

    <h1>Teste</h1>

    {{ view_render_event('bagisto.shop.checkout.payment-method.after') }}

@endsection
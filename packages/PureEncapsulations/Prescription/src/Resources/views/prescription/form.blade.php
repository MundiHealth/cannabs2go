<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-header">Envie sua Prescrição:</div>

            <div class="card-body">
                @if ($message = Session::get('success'))

                    <div class="alert alert-success alert-block">

                        <button type="button" class="close" data-dismiss="alert">×</button>

                        <strong>{{ $message }}</strong>
                    </div>

                @endif

                @if(isset($errors))
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Oops!</strong> Houve problemas com o envio do seu arquivo.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif


                @if (request()->is('checkout/success'))
                <form action="{{ route('prescription.store', ['checkout']) }}" method="post" enctype="multipart/form-data">
                @else
                <form action="{{ route('prescription.store') }}" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="form-group">
                        <input type="hidden" value="{{ $order->id }}" name="order_id" >
                        <input type="file" multiple class="form-control-file" name="prescriptions[]" id="exampleInputFile" aria-describedby="fileHelp">
                        <small id="fileHelp" class="form-text text-muted">Por favor, selecione um arquivo (.jpg ou .pdf) com tamanho máximo de 2MB.</small>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{--<div class="info">--}}
{{--    <div class="alert alert-info">--}}
{{--        Você pode enviar sua prescrição para <b><a href="mailto:receita@mypharma2go.com">receita@mypharma2go.com</a></b> ou para o WhatsApp--}}
{{--        <b><a href="https://api.whatsapp.com/send?phone=5511998680834" target="_blank">(11) 9 9868-0834</a></b>.--}}
{{--    </div>--}}
{{--</div>--}}
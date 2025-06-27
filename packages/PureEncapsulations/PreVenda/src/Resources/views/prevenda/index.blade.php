
    <section class="account-area gray-bg pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-6" style="margin: 0 auto;">
                    <div class="widget mb-40">
                        <div class="widget-title-box mb-30">
                            <h3 class="widget-title">Pré-Venda</h3>
                        </div>

                        @if (Session::has('error'))
                            <div class="alert alert-info">{{ Session::get('error') }}</div>
                        @endif

                        <form method="post" action="{{ route('prevenda.checkout.onepage.index')  }}" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <label for="pedido">Número do Pedido</label>
                                    <input type="text" name="order" placeholder="digite o nº do pedido" >
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="contact-button text-center">
                                        <button class="btn" type="submit">Próximo</button>
                                    </div>
                                </div>
                            </div>
                            <p class="ajax-response"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
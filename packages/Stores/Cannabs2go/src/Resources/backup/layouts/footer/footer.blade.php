<div class="container">
    <div class="container-back-top">
        <a class="back-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>
</div>

<div class="fixed-whats">
    <a href="https://api.whatsapp.com/send?phone=5511998680834" target="_blank">
        <i class="fab fa-whatsapp"></i> <span>Entre em contato!</span>
    </a>
</div>

<div class="overlay"></div>

<footer>
    <div class="footer-area pt-50">
        <div class="container">
            <div class="footer-bg pb-40">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-wrapper mb-30">
                            <div class="footer-logo">
                                <a href="/"><img src="{{ bagisto_asset('img/logo/mypharma.png') }}" alt="MyPharma2GO" /></a>
                            </div>
                            <ul class="footer-link">
                                <li><b>WhatsApp:</b> (11) 99868-0834</li>
                                <li><b>E-mail:</b> {!! '<a  href="mailto:' . config('mail.from.address') . '">' . config('mail.from.address'). '</a>' !!}</li>
                                <li><b>Envio de Prescrições:</b> <br> <a href="mailto:receita@mypharma2go.com">receita@mypharma2go.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-wrapper pl-25">
                            <div class="footer-title">
                                <h4>Institucional</h4>
                            </div>
                            <ul class="footer-menu">
                                <li><a href="{{ route('shop.cms.page', ['quem-somos']) }}">Quem Somos</a></li>
                                <li><a href="{{ route('shop.cms.page', ['termos-de-compra']) }}">Termos de Compra</a></li>
                                <li><a href="{{ route('shop.cms.page', ['politica-de-pagamento']) }}">Política de Pagamento</a></li>
                                <li><a href="{{ route('shop.cms.page', ['troca-e-devolucoes']) }}">Troca e Devoluções</a></li>
                                <li><a href="{{ route('shop.cms.page', ['politica-de-entrega']) }}">Política de Entrega</a></li>
                                <li><a href="{{ route('shop.cms.page', ['politica-de-privacidade']) }}">Política de Privacidade</a></li>
                                <li><a href="{{ route('shop.cms.page', ['prescricao-medica']) }}">Prescrição Médica</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="footer-wrapper pl-25 mb-30">
                            <div class="footer-title">
                                <h4>Minha Conta</h4>
                            </div>
                            <ul class="footer-menu">
                                <li><a href="#">Entrar</a></li>
                                <li><a href="#">Visualizar Carrinho</a></li>
                                <li><a href="#">Rastrear Pedidos</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-wrapper pl-25 mb-30">
                            <div class="footer-logo bariatric">
                                <img src="{{ bagisto_asset('img/logo/bariatric-f.svg') }}" alt="Bariatric Advantage" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom-area">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="copyright text-center">
                            <p>Copyright <i class="far fa-copyright"></i> {{ \Carbon\Carbon::now()->format('Y') }} <a href="https://www.mypharma2go.com">My Pharma 2GO</a>. Todos os direitos reservados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
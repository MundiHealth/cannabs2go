<!-- loading -->
<div class="se-pre-con"></div>

<header>
    <div class="top-header">
        <div class="container">
            <div>
                <a href="javascript:;" data-fancybox data-src="#tracking"><i class="fa-solid fa-plane-departure"></i> Rastrear meu pedido</a>
                <a href="https://api.whatsapp.com/send?phone=5511998680834" target="_blank"><i class="fa-brands fa-whatsapp"></i> Entre em contato</a>
            </div>
        </div>
    </div>
    <div id="sticky-header" class="main-menu-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-9 col-md-8 col-6">
                    <div class="logo">
                        <a href="/">
                            <img class="standard-logo" src="{{ bagisto_asset('img/logo/cannabis2go.svg') }}" alt="Cannabis2GO" />
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-3 col-md-4 col-6">
                    <div class="header-right f-right">
                        <ul>
                            <li class="search-icon"><a><i class="fas fa-search"></i></a></li>
                            @auth('customer')
                                <li class="unser-icon"><a href="{{ route('customer.profile.index') }}"><i class="fas fa-user"></i></a></li>
                            @else
                                <li class="unser-icon"><a href="{{ route('customer.session.index') }}"><i class="fas fa-user"></i></a></li>
                            @endif
                            @include('shop::checkout.cart.mini-cart')
                            <li class="toggle-nav">
                                <i class="fas fa-bars"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="main-menu">
                    @include('shop::layouts.header.nav-menu.navmenu')
                </div>
            </div>
        </div>
    </div>
    <div class="search-open">
        <form role="search" action="{{ route('shop.search.index') }}" method="GET" style="display: inherit;">
            <input type="text" placeholder="Buscar por..." name="term" autofocus>
            <button>
                <i class="fa fa-search"></i>
            </button>
        </form>
        <i class="fas fa-times"></i>
    </div>
</header>

<div style="display: none;" id="tracking">
    <h3>Rastrear meu pedido</h3>

    <div class="form">
        <label for="order">Digite o número do seu pedido:</label>
        <input type="text" name="order" placeholder="Exemplo: MP202000009999">

        <a href="javascript:;" class="btn" target="_blank">Buscar</a>
    </div>
</div>
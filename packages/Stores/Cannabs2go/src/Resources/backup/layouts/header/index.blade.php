<!-- loading -->
<div class="se-pre-con"></div>

<header>
    <div id="sticky-header" class="main-menu-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-3 col-md-4 col-5">
                    <div class="logo">
                        <a href="/">
                            <img class="standard-logo" src="{{ bagisto_asset('img/logo/bariatric.svg') }}" alt="Bariatric Advantage" />
                        </a>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-8 col-7">
                    <div class="header-right-desk">
                        <ul>
                            @auth('customer')
                                <li class="unser-icon"><a href="{{ route('customer.profile.index') }}">Minha Conta</a> |
                                    <a href="{{ route('customer.session.destroy') }}">Sair</a></li>
                            @else
                                <li class="unser-icon"><a href="{{ route('customer.register.index') }}">Criar Conta</a> |
                                    <a href="{{ route('customer.session.index') }}">Login</a></li>
                            @endif
                            @include('shop::checkout.cart.mini-cart')
                        </ul>
                    </div>
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
                    <div class="main-menu text-right f-right">
                        @include('shop::layouts.header.nav-menu.navmenu')
                    </div>
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

<!-- loading -->
<div class="se-pre-con"></div>

<header>
    <div class="header-area d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-9">
                    <div class="header-wrapper">
                        <div class="header-text">
                            <span><b>Scientific Practitioner Advisory:</b> (11) 9 7528-5558</span>
                            <span><i class="far fa-envelope"></i> {!! '<a  href="mailto:' . config('mail.from.address') . '">' . config('mail.from.address'). '</a>' !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-3">
                    <div class="header-icon text-md-right">
                        <a href="{{url()->to('/institucional/prescricao-medica')}}">Como Comprar <i class="fas fa-arrow-right"></i></a>
{{--                        <a href="https://www.facebook.com/PureEncapsulations" target="_blank"><i class="fab fa-facebook-f"></i></a>--}}
{{--                        <a href="https://twitter.com/PureEncaps" target="_blank"><i class="fab fa-twitter"></i></a>--}}
{{--                        <a href="https://www.linkedin.com/company/pure-encapsulations/?trk=company_logo" target="_blank"><i class="fab fa-linkedin"></i></a>--}}
{{--                        <a href="https://www.instagram.com/pureencapsulations/" target="_blank"><i class="fab fa-instagram"></i></a>--}}
{{--                        <a href="https://www.youtube.com/user/pureencapsulations" target="_blank"><i class="fab fa-youtube"></i></a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="sticky-header" class="main-menu-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                    <div class="logo">
                        <a href="/">
                            <img class="standard-logo" src="{{ bagisto_asset('img/logo/pure-encapsulations.svg') }}" alt="Pure Encapsulations" />
                        </a>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-9 col-md-8 col-6">
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

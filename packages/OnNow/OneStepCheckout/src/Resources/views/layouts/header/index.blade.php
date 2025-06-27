<header>
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
                        @if (request()->is('checkout/cart'))
                        <ul>
                            <li class="search-icon"><a><i class="fas fa-search"></i></a></li>
                            @auth('customer')
                            <li class="unser-icon"><a href="{{ route('customer.profile.index') }}"><i class="fas fa-user"></i></a></li>
                            @else
                            <li class="unser-icon"><a href="{{ route('customer.session.index') }}"><i class="fas fa-user"></i></a></li>
                            @endif
                        </ul>
                        @endif
                    </div>
                </div>
            </div>

{{--            @if (Session::has('success'))--}}
{{--                <div class="row">--}}
{{--                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-4">--}}
{{--                        <div class="alert alert-info">{{ Session::get('success') }}</div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
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

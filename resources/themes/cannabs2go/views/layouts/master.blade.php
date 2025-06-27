<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">

    <title>@yield('page_title') | Cannabis2GO</title>
    @section('seo')
        @if (! request()->is('/'))
            <meta name="description" content="{{ core()->getCurrentChannel()->description }}"/>
        @endif
    @show

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">

    @if ($favicon = core()->getCurrentChannel()->favicon_url)
        <link rel="icon" sizes="16x16" href="{{ $favicon }}" />
    @else
        <link rel="icon" sizes="32x32" href="{{ bagisto_asset('img/favicon.png') }}" />
    @endif

    <meta name="theme-color" content="#d82779">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="author" content="On Now">

    <!-- OpenGraph Facebook -->
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Cannabis2GO" />
    <meta property="og:title" content="@yield('page_title')" />
    <meta property="og:description" content="A Cannabis2go é o mais novo marketplace de CBDs na América Latina, reunindo marcas renomadas com produtos que possuem ingredientes retirados da natureza através da ciência, com soluções que realmente funcionam." />
    <meta property="og:image" content="{{ bagisto_asset('img/cannabis2go.jpg') }}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="250" />
    <meta property="og:image:height" content="250" />
    <meta property="og:image:alt" content="Cannabis2GO" />
    <meta property="og:image:url" content="{{ bagisto_asset('img/cannabis2go.jpg') }}" />
    <meta property="og:image:secure_url" content="{{ bagisto_asset('img/cannabis2go.jpg') }}" />
    <meta property="og:locale" content="{{ app()->getLocale() }}" />
    <meta property="fb:app_id" content="1133289567156736" />

{{--    <link rel="stylesheet" href="{{ asset('vendor/webkul/ui/assets/css/ui.css') }}">--}}
    <link rel="stylesheet" href="{{ bagisto_asset('css/shop.css') }}">
    <link rel="stylesheet" href="{{ bagisto_asset('css/main.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-199313295-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-199313295-1');
    </script>
    <script src="https://kit.fontawesome.com/31d9b27105.js" crossorigin="anonymous"></script>
</head>
<body class="@yield('body_class')">

<div class="body" id="app">

    <flash-wrapper ref='flashes'></flash-wrapper>

    {!! view_render_event('bagisto.shop.layout.header.before') !!}

    @include('shop::layouts.header.index')

    {!! view_render_event('bagisto.shop.layout.header.after') !!}

    {!! view_render_event('bagisto.shop.layout.content.before') !!}

    @yield('content-wrapper')

    {!! view_render_event('bagisto.shop.layout.content.after') !!}

    {!! view_render_event('bagisto.shop.layout.footer.before') !!}

    @include('shop::layouts.footer.footer')

    {!! view_render_event('bagisto.shop.layout.footer.after') !!}

</div>

<script type="text/javascript">
    window.flashMessages = [];

    @if ($success = session('success'))
        window.flashMessages = [{'type': 'alert-success', 'message': "{{ $success }}" }];
    @elseif ($warning = session('warning'))
        window.flashMessages = [{'type': 'alert-warning', 'message': "{{ $warning }}" }];
    @elseif ($error = session('error'))
        window.flashMessages = [{'type': 'alert-error', 'message': "{{ $error }}" }
    ];
    @elseif ($info = session('info'))
        window.flashMessages = [{'type': 'alert-info', 'message': "{{ $info }}" }
    ];
    @endif

        window.serverErrors = [];
    @if(isset($errors))
        @if (count($errors))
        window.serverErrors = @json($errors->getMessages());
    @endif
    @endif
</script>

<script type="text/javascript" src="{{ bagisto_asset('js/shop.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/webkul/ui/assets/js/ui.js') }}"></script>

<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

@stack('scripts')

</body>
</html>
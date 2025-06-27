<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">

    <title>@yield('page_title') | Bariatric Advantage</title>
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
        <link rel="icon" sizes="16x16" href="{{ bagisto_asset('img/favicon.jfif') }}" />
    @endif

    <meta name="theme-color" content="#14328c">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="author" content="On Now">

{{--    <link rel="stylesheet" href="{{ asset('vendor/webkul/ui/assets/css/ui.css') }}">--}}
    <link rel="stylesheet" href="{{ bagisto_asset('css/shop.css') }}">
    <link rel="stylesheet" href="{{ bagisto_asset('css/main.css') }}">

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

@stack('scripts')

</body>
</html>
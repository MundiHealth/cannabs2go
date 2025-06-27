{{--@if (core()->getConfigData('general.design.admin_logo.logo_image'))--}}
{{--    <img src="{{ \Illuminate\Support\Facades\Storage::url(core()->getConfigData('general.design.admin_logo.logo_image')) }}" alt="{{ config('app.name') }}" style="height: 65px;"/>--}}
{{--@else--}}
{{--    <img src="{{ bagisto_asset('images/logo.svg') }}">--}}
{{--@endif--}}

<img src="{{ bagisto_asset('img/logo/mypharma.png') }}" alt="MyPharma 2GO" width="300" style="display: block;"/>
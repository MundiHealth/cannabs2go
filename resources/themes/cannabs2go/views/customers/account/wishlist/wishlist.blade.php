@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.account.wishlist.page-title') }}
@endsection
@section('body_class')
    page-account
@endsection
@section('content-wrapper')

    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>{{ __('shop::app.layouts.wishlist') }}</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="{{url()->to('/customer/account/profile')}}">Minha Conta</a></li>
                            <li><span>{{ __('shop::app.layouts.wishlist') }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="account-area white-bg border-top pt-60 pb-60">
        <div class="container">
    {{--        <div class="row">--}}
        <div class="account-content">
            @inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')

            @include('shop::customers.account.partials.sidemenu')

            @inject ('reviewHelper', 'Webkul\Product\Helpers\Review')

            <div class="account-layout">

                <div class="account-head mb-15">
                    <span class="account-heading">{{ __('shop::app.customer.account.wishlist.title') }}</span>

                    @if (count($items))
                        <div class="account-action">
                            <a href="{{ route('customer.wishlist.removeall') }}">{{ __('shop::app.customer.account.wishlist.deleteall') }}</a>
                        </div>
                    @endif

                    <div class="horizontal-rule"></div>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.wishlist.list.before', ['wishlist' => $items]) !!}

                <div class="account-items-list">

                    @if ($items->count())
                        @foreach ($items as $item)
                            <div class="account-item-card mt-15 mb-15">
                                <div class="media-info">
                                    @php
                                        $image = $item->product->getTypeInstance()->getBaseImage($item);
                                    @endphp

                                    <img class="media" src="{{ $image['small_image_url'] }}" />

                                    <div class="info">
                                        <div class="product-name">
                                            {{ $item->product->name }}

                                            @if (isset($item->additional['attributes']))
                                                <div class="item-options">

                                                    @foreach ($item->additional['attributes'] as $attribute)
                                                        <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                                                    @endforeach

                                                </div>
                                            @endif
                                        </div>

                                        <span class="stars" style="display: inline">
                                            @for ($i = 1; $i <= $reviewHelper->getAverageRating($item->product); $i++)
                                                <span class="icon star-icon"></span>
                                            @endfor
                                        </span>
                                    </div>
                                </div>

                                <div class="operations">
                                    <a class="mb-50" href="{{ route('customer.wishlist.remove', $item->id) }}">
                                        <span class="icon trash-icon"></span>
                                    </a>

                                    <a href="{{ route('customer.wishlist.move', $item->id) }}" class="btn btn-primary btn-md">
                                        {{ __('shop::app.customer.account.wishlist.move-to-cart') }}
                                    </a>
                                </div>
                            </div>

                            <div class="horizontal-rule mb-10 mt-10"></div>
                        @endforeach
                    @else
                        <div class="empty">
                            {{ __('customer::app.wishlist.empty') }}
                        </div>
                    @endif
                </div>

                {!! view_render_event('bagisto.shop.customers.account.wishlist.list.after', ['wishlist' => $items]) !!}

            </div>
        </div>
    {{--        </div>--}}
        </div>
    </section>

@endsection
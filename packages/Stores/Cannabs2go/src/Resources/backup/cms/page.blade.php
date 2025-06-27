@extends('shop::layouts.bariatric')

@section('page_title')
    {{ $page->page_title }}
@endsection

@section('head')
    @isset($page->meta_title)
        <meta name="title" content="{{ $page->meta_title }}" />
    @endisset

    @isset($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}" />
    @endisset

    @isset($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}" />
    @endisset

    <link href="{{ asset('themes/default/assets/css/shop.css') }}" rel="stylesheet" />
@endsection

@section('content-wrapper')
    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>{{ $page->page_title }}</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="/">Home</a></li>
                            <li><span>{{ $page->page_title }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="page-area pt-80 pb-60">
        <div class="container">
            <div class="row">
                {!! DbView::make($page)->field('html_content')->render() !!}
            </div>

        </div>
    </section>


@endsection

@push('scripts')
    <script src="{{ asset('themes/default/assets/js/shop.js') }}" type="text/javascript"></script>
@endpush
@extends('shop::layouts.bariatric')

@section('page_title')
    {{ __('shop::app.search.page-title') }}
@endsection

@section('content-wrapper')

    <div class="breadcrumb-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>Pesquisa</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="/">Home</a></li>
                            <li><span>Pesquisa</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-area pos-relative pt-40 pb-60 fix">
        <div class="container">

            @if (!$results)

                <div class="four-zero-wrapper text-center">
                    <div class="four-zero-text">
                        <h1>{{  __('shop::app.search.no-results') }}</h1>
                        <a class="btn" href="/">Voltar para Home</a>
                    </div>
                </div>
            @else
            <div class="row">
                <div class="col-xl-6 col-lg-5 col-md-6 col-sm-7">
                    <div class="product-showing">
                        @if ($results->total() == 1)
                            <p>{{ $results->total() }} resultado encontrado</p>
                        @else
                            <p>{{ $results->total() }} resultados encontrados</p>
                        @endif
                    </div>
                </div>
{{--                <div class="col-xl-6 col-lg-7 col-md-6 col-sm-5">--}}
{{--                    <div class="pro-filter mb-40 f-right">--}}
{{--                        <form action="#">--}}
{{--                            <select name="pro-filter" id="pro-filter">--}}
{{--                                <option value="1">Shop By</option>--}}
{{--                                <option value="2">Top Sales </option>--}}
{{--                                <option value="3">New Product </option>--}}
{{--                                <option value="4">A to Z Product </option>--}}
{{--                            </select>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <div class="row">
                @foreach ($results as $productFlat)

                    @if(isset($productFlat->product))
                        @include('shop::products.list.card', ['product' => $productFlat->product])
                    @endif

                @endforeach
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="basic-pagination basic-pagination-2 text-center mt-20">

                        {{ $results->links('shop::products.list.pagination') }}

                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>
@endsection
@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.sales.invoices.view-title', ['invoice_id' => $invoice->id]) }}
@stop

@section('content-wrapper')

    <?php $order = $invoice->order; ?>

    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                    {{ __('admin::app.sales.invoices.view-title', ['invoice_id' => $invoice->id]) }}
                </h1>
            </div>

            <div class="page-action">
                @if($invoice->order->awb_id)
                <a href="{{ route('admin.xdeasy.phx.hawb', $invoice->id) }}" target="_blank" class="btn btn-lg btn-secondary">
                    {{ __('admin::app.sales.invoices.print') }} HAWB
                </a>
                @else
                <a href="{{ route('admin.xdeasy.phx.createHawb', $invoice->id) }}" class="btn btn-lg btn-secondary">
                    Gerar HAWB
                </a>
                @endif
                <a href="{{ route('admin.sales.invoices.print', $invoice->id) }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.sales.invoices.print') }} Invoice
                </a>

                <a href="{{ route('admin.sales.invoices.zip', $invoice->id) }}" class="btn btn-lg btn-primary">
                    {{ 'Zip AWB + Invoice + Prescrição' }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <div class="sale-container">

                <accordian :title="'{{ __('admin::app.sales.orders.order-and-account') }}'" :active="true">
                    <div slot="body">

                        <div class="sale-section">
                            <div class="secton-title">
                                <span>{{ __('admin::app.sales.orders.order-info') }}</span>
                            </div>

                            <div class="section-content">
                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.invoices.order-id') }}
                                    </span>

                                    <span class="value">
                                        <a href="{{ route('admin.sales.orders.view', $order->id) }}">#{{ $order->increment_id }}</a>
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.order-date') }}
                                    </span>

                                    <span class="value">
                                        {{ $order->created_at->format('d/m/Y H:i:s') }}
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.order-status') }}
                                    </span>

                                    <span class="value">
                                        {{ $order->status_label }}
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.channel') }}
                                    </span>

                                    <span class="value">
                                        {{ $order->channel_name }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="sale-section">
                            <div class="secton-title">
                                <span>{{ __('admin::app.sales.orders.account-info') }}</span>
                            </div>

                            <div class="section-content">
                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.customer-name') }}
                                    </span>

                                    <span class="value">
                                        {{ $invoice->address->name }}
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.email') }}
                                    </span>

                                    <span class="value">
                                        {{ $invoice->address->email }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </accordian>

                <accordian :title="'{{ __('admin::app.sales.orders.address') }}'" :active="true">
                    <div slot="body">

                        <div class="sale-section">
                            <div class="secton-title">
                                <span>{{ __('admin::app.sales.orders.billing-address') }}</span>
                            </div>

                            <div class="section-content">

                                @include ('admin::sales.address', ['address' => $order->billing_address])

                            </div>
                        </div>

                        @if ($order->shipping_address)
                            <div class="sale-section">
                                <div class="secton-title">
                                    <span>{{ __('admin::app.sales.orders.shipping-address') }}</span>
                                </div>

                                <div class="section-content">

                                    @include ('admin::sales.address', ['address' => $order->shipping_address])

                                </div>
                            </div>
                        @endif

                    </div>
                </accordian>

                <accordian :title="'{{ __('admin::app.sales.orders.payment-and-shipping') }}'" :active="true">
                    <div slot="body">

                        <div class="sale-section">
                            <div class="secton-title">
                                <span>{{ __('admin::app.sales.orders.payment-info') }}</span>
                            </div>

                            <div class="section-content">
                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.payment-method') }}
                                    </span>

                                    <span class="value">
                                        {{ core()->getConfigData('sales.paymentmethods.' . $order->payment->method . '.title') }}
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.currency') }}
                                    </span>

                                    <span class="value">
                                        {{ $order->order_currency_code }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if ($order->shipping_address)
                            <div class="sale-section">
                                <div class="secton-title">
                                    <span>{{ __('admin::app.sales.orders.shipping-info') }}</span>
                                </div>

                                <div class="section-content">
                                    <div class="row">
                                        <span class="title">
                                            {{ __('admin::app.sales.orders.shipping-method') }}
                                        </span>

                                        <span class="value">
                                            {{ $order->shipping_title }}
                                        </span>
                                    </div>

                                    <div class="row">
                                        <span class="title">
                                            {{ __('admin::app.sales.orders.shipping-price') }}
                                        </span>

                                        <span class="value">
                                            {{ core()->formatPrice($order->base_shipping_amount, 'USD') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </accordian>

                <accordian :title="'{{ __('admin::app.sales.orders.products-ordered') }}'" :active="true">
                    <div slot="body">

                        <div class="table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>{{ __('admin::app.sales.orders.SKU') }}</th>
                                        <th>{{ __('admin::app.sales.orders.product-name') }}</th>
                                        <th>{{ __('admin::app.sales.orders.price') }}</th>
                                        <th>{{ __('admin::app.sales.orders.qty') }}</th>
                                        <th>{{ __('admin::app.sales.orders.subtotal') }}</th>
                                        <th>{{ __('admin::app.sales.orders.tax-amount') }}</th>
                                        @if ($invoice->base_discount_amount > 0)
                                            <th>{{ __('admin::app.sales.orders.discount-amount') }}</th>
                                        @endif
                                        <th>{{ __('admin::app.sales.orders.grand-total') }}</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($invoice->items as $item)
                                        <tr>
                                            <td>{{ $item->getTypeInstance()->getOrderedItem($item)->sku }}</td>

                                            <td>
                                                {{ $item->name }}

                                                @if (isset($item->additional['attributes']))
                                                    <div class="item-options">

                                                        @foreach ($item->additional['attributes'] as $attribute)
                                                            <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                                                        @endforeach

                                                    </div>
                                                @endif
                                            </td>

                                            <td>{{ core()->formatPrice($item->base_price, 'USD') }}</td>

                                            <td>{{ $item->qty }}</td>

                                            <td>{{ core()->formatPrice($item->base_total, 'USD') }}</td>

                                            <td>{{ core()->formatPrice($item->base_tax_amount, 'USD') }}</td>

                                            @if ($invoice->base_discount_amount > 0)
                                                <td>{{ core()->formatPrice($item->base_discount_amount, 'USD') }}</td>
                                            @endif

                                            <td>{{ core()->formatPrice($item->base_total + $item->base_tax_amount - $item->base_discount_amount, 'USD') }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <table class="sale-summary">
                            <tr>
                                <td>{{ __('admin::app.sales.orders.subtotal') }}</td>
                                <td>-</td>
                                <td>{{ core()->formatPrice($invoice->base_sub_total, 'USD') }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('admin::app.sales.orders.shipping-handling') }}</td>
                                <td>-</td>
                                <td>{{ core()->formatPrice($invoice->base_shipping_amount, 'USD') }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('admin::app.sales.orders.tax') }}</td>
                                <td>-</td>
                                <td>{{ core()->formatPrice($invoice->base_tax_amount, 'USD') }}</td>
                            </tr>

                            @if ($invoice->base_discount_amount > 0)
                                <tr>
                                    <td>{{ __('admin::app.sales.orders.discount') }}</td>
                                    <td>-</td>
                                    <td>{{ core()->formatPrice($invoice->base_discount_amount, 'USD') }}</td>
                                </tr>
                            @endif

                            <tr class="bold">
                                <td>{{ __('admin::app.sales.orders.grand-total') }}</td>
                                <td>-</td>
                                <td>{{ core()->formatPrice($invoice->base_grand_total, 'USD') }}</td>
                            </tr>
                        </table>

                    </div>
                </accordian>

            </div>
        </div>

    </div>
@stop
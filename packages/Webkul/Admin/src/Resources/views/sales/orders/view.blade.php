@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.sales.orders.view-title', ['order_id' => $order->increment_id]) }}
@stop

@section('content-wrapper')

    <div class="content full-page">

        <div class="page-header">

            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                    {{ __('admin::app.sales.orders.view-title', ['order_id' => $order->increment_id]) }}
                </h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.sales.orders.link-ebanx', $order->id) }}" class="btn btn-lg btn-primary" v-alert:message="'Tem certeza que deseja criar um novo link de pagamento para o pedido?'">
                    Gerar Link Ebank
                </a>

                <a href="{{ route('admin.sales.orders.zero', $order->id) }}" class="btn btn-lg btn-primary" v-alert:message="'Tem certeza que deseja zerar os valores do pedido?'">
                        Zerar
                    </a>

                @if ($order->canCancel())
                    <a href="{{ route('admin.sales.orders.cancel', $order->id) }}" class="btn btn-lg btn-primary" v-alert:message="'{{ __('admin::app.sales.orders.cancel-confirm-msg') }}'">
                        {{ __('admin::app.sales.orders.cancel-btn-title') }}
                    </a>
                @endif

                @if ($order->canInvoice())
                    @if(! $order->prescriptions()->get()->isEmpty())
                    <a href="{{ route('admin.sales.invoices.create', $order->id) }}" class="btn btn-lg btn-primary">
                        {{ __('admin::app.sales.orders.invoice-btn-title') }}
                    </a>
                    @endif
                @endif

                @if ($order->canRefund())
                    <a href="{{ route('admin.sales.refunds.create', $order->id) }}" class="btn btn-lg btn-primary">
                        {{ __('admin::app.sales.orders.refund-btn-title') }}
                    </a>
                @endif

                @if ($order->canShip())
                    @if(! $order->prescriptions()->get()->isEmpty())
                    <a href="{{ route('admin.sales.shipments.create', $order->id) }}" class="btn btn-lg btn-primary">
                        {{ __('admin::app.sales.orders.shipment-btn-title') }}
                    </a>
                    @endif
                @endif
            </div>
        </div>

        <div class="page-content">

            <tabs>
                <tab name="{{ __('admin::app.sales.orders.info') }}" :selected="true">
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
                                                {{ $order->customer_full_name }}
                                            </span>
                                        </div>

                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.orders.email') }}
                                            </span>

                                            <span class="value">
                                                {{ $order->customer_email }}
                                            </span>
                                        </div>

                                        @if (! is_null($order->customer))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('admin::app.customers.customers.customer_group') }}
                                                </span>

                                                <span class="value">
                                                    {{ $order->customer->group['name'] }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="sale-section">
                                    <div class="secton-title">
                                        <span>Prescriptions</span>
                                    </div>

                                    <div class="section-content">
                                        @foreach($order->prescriptions as $prescription)
                                            <div class="row">
                                                <a href="{{ asset( $prescription->path) }}" download class="btn btn-lg btn-primary"><i class="fas fas-file"></i> {{ $prescription->prescription }}</a>
                                            </div>
                                        @endforeach

                                        {{--@if($order->prescriptions()->get()->isEmpty())--}}
                                            <form action="{{ route('prescription.store') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="control-group file">
                                                    <input type="hidden" value="{{ $order->id }}" name="order_id" >
                                                    <input type="file" multiple class="control" name="prescriptions[]" id="exampleInputFile">
                                                </div>
                                                <button type="submit" class="btn  btn-lg btn-primary" name="submit">Enviar</button>
                                            </form>
                                     {{--   @endif--}}
                                    </div>
                                </div>

                                <div class="sale-section">
                                    <div class="secton-title">
                                        <span>Rastreio FedEx</span>
                                    </div>

                                    <div class="section-content">
                                        <div class="row">
                                            <span class="title">
                                                Código de rastreio (FedEx)
                                            </span>

                                            <span class="value">
                                                {{ $order->awb_code != null ? $order->awb_code : '-' }}
                                            </span>
                                        </div>

                                        @if(!$order->awb_code)
                                        <form action="{{ route('tracking-number.fedex.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="control-group file">
                                                <input type="hidden" value="{{ $order->id }}" name="order_id" >
                                                <input type="text" class="control" name="trackingNumber" id="exampleInputFile">
                                            </div>
                                            <button type="submit" class="btn  btn-lg btn-primary" name="submit">Enviar</button>
                                        </form>
                                        @endif
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
                                                {{ core()->getConfigData('sales.paymentmethods.' . $order->payment->method . '.title') }}:

                                                @if($order->payment->method_title == 'bankslip')
                                                    {{ 'Boleto' }}
                                                @else
                                                    {{ 'Cartão de Crédito ('. $order->payment->method_title .')' }}
                                                @endif
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
                                                    {{ core()->formatBasePrice($order->shipping_amount) }}
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
                                                <th>{{ __('admin::app.sales.orders.item-status') }}</th>
                                                <th>{{ __('admin::app.sales.orders.subtotal') }}</th>
                                                <th>{{ __('admin::app.sales.orders.tax-percent') }}</th>
                                                <th>{{ __('admin::app.sales.orders.tax-amount') }}</th>
                                                @if ($order->discount_amount > 0)
                                                    <th>{{ __('admin::app.sales.orders.discount-amount') }}</th>
                                                @endif
                                                <th>{{ __('admin::app.sales.orders.grand-total') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td>
                                                        {{ $item->getTypeInstance()->getOrderedItem($item)->sku }}
                                                    </td>

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

                                                    <td>{{ core()->formatBasePrice($item->price) }}</td>

                                                    <td>
                                                        <span class="qty-row">
                                                            {{ $item->qty_ordered ? __('admin::app.sales.orders.item-ordered', ['qty_ordered' => $item->qty_ordered]) : '' }}
                                                        </span>

                                                        <span class="qty-row">
                                                            {{ $item->qty_invoiced ? __('admin::app.sales.orders.item-invoice', ['qty_invoiced' => $item->qty_invoiced]) : '' }}
                                                        </span>

                                                        <span class="qty-row">
                                                            {{ $item->qty_shipped ? __('admin::app.sales.orders.item-shipped', ['qty_shipped' => $item->qty_shipped]) : '' }}
                                                        </span>

                                                        <span class="qty-row">
                                                            {{ $item->qty_refunded ? __('admin::app.sales.orders.item-refunded', ['qty_refunded' => $item->qty_refunded]) : '' }}
                                                        </span>

                                                        <span class="qty-row">
                                                            {{ $item->qty_canceled ? __('admin::app.sales.orders.item-canceled', ['qty_canceled' => $item->qty_canceled]) : '' }}
                                                        </span>
                                                    </td>

                                                    <td>{{ core()->formatBasePrice($item->total) }}</td>

                                                    <td>{{ $item->tax_percent }}%</td>

                                                    <td>{{ core()->formatBasePrice($item->tax_amount) }}</td>

                                                    @if ($order->discount_amount > 0)
                                                        <td>{{ core()->formatBasePrice($item->discount_amount) }}</td>
                                                    @endif

                                                    <td>{{ core()->formatBasePrice($item->total + $item->tax_amount - $item->discount_amount) }}</td>
                                                </tr>
                                            @endforeach
                                    </table>
                                </div>

                                <table class="sale-summary">
                                    <tr>
                                        <td>{{ __('admin::app.sales.orders.subtotal') }}</td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($order->sub_total) }}</td>
                                    </tr>

                                    @if ($order->haveStockableItems())
                                        <tr>
                                            <td>{{ __('admin::app.sales.orders.shipping-handling') }}</td>
                                            <td>-</td>
                                            <td>{{ core()->formatBasePrice($order->shipping_amount) }}</td>
                                        </tr>
                                    @endif

                                    @if ($order->discount_amount > 0)
                                        <tr>
                                            <td>{{ __('admin::app.sales.orders.discount') }}</td>
                                            <td>-</td>
                                            <td>{{ core()->formatBasePrice($order->discount_amount) }}</td>
                                        </tr>
                                    @endif

                                    <tr class="border">
                                        <td>{{ __('admin::app.sales.orders.tax') }}</td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($order->tax_amount) }}</td>
                                    </tr>

                                    <tr class="bold">
                                        <td>{{ __('admin::app.sales.orders.grand-total') }}</td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($order->grand_total) }}</td>
                                    </tr>

                                    <tr class="bold">
                                        <td>{{ __('admin::app.sales.orders.total-paid') }}</td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($order->grand_total_invoiced) }}</td>
                                    </tr>

                                    <tr class="bold">
                                        <td>{{ __('admin::app.sales.orders.total-refunded') }}</td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($order->grand_total_refunded) }}</td>
                                    </tr>

                                    <tr class="bold">
                                        <td>{{ __('admin::app.sales.orders.total-due') }}</td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($order->total_due) }}</td>
                                    </tr>
                                </table>

                            </div>
                        </accordian>

                    </div>
                </tab>

                <tab name="{{ __('admin::app.sales.orders.invoices') }}">

                    <div class="table" style="padding: 20px 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>{{ __('admin::app.sales.invoices.id') }}</th>
                                    <th>{{ __('admin::app.sales.invoices.date') }}</th>
                                    <th>{{ __('admin::app.sales.invoices.order-id') }}</th>
                                    <th>{{ __('admin::app.sales.invoices.customer-name') }}</th>
                                    <th>{{ __('admin::app.sales.invoices.status') }}</th>
                                    <th>{{ __('admin::app.sales.invoices.amount') }}</th>
                                    <th>{{ __('admin::app.sales.invoices.action') }}</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($order->invoices as $invoice)
                                    <tr>
                                        <td>#{{ $invoice->id }}</td>
                                        <td>{{ $invoice->created_at }}</td>
                                        <td>#{{ $invoice->order->increment_id }}</td>
                                        <td>{{ $invoice->address->name }}</td>
                                        <td>{{ $invoice->status_label }}</td>
                                        <td>{{ core()->formatBasePrice($invoice->grand_total) }}</td>
                                        <td class="action">
                                            <a href="{{ route('admin.sales.invoices.view', $invoice->id) }}">
                                                <i class="icon eye-icon"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                @if (! $order->invoices->count())
                                    <tr>
                                        <td class="empty" colspan="7">{{ __('admin::app.common.no-result-found') }}</td>
                                    <tr>
                                @endif
                        </table>
                    </div>

                </tab>

                @if ($order->shipping_address)
                    <tab name="{{ __('admin::app.sales.orders.shipments') }}">

                        <div class="table" style="padding: 20px 0">
                            <table>
                                <thead>
                                    <tr>
                                        <th>{{ __('admin::app.sales.shipments.id') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.date') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.order-id') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.order-date') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.customer-name') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.total-qty') }}</th>
                                        <th>{{ __('admin::app.sales.shipments.action') }}</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($order->shipments as $shipment)
                                        <tr>
                                            <td>#{{ $shipment->id }}</td>
                                            <td>{{ $shipment->created_at }}</td>
                                            <td>#{{ $shipment->order->id }}</td>
                                            <td>{{ $shipment->order->created_at }}</td>
                                            <td>{{ $shipment->address->name }}</td>
                                            <td>{{ $shipment->total_qty }}</td>
                                            <td class="action">
                                                <a href="{{ route('admin.sales.shipments.view', $shipment->id) }}">
                                                    <i class="icon eye-icon"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if (! $order->shipments->count())
                                        <tr>
                                            <td class="empty" colspan="7">{{ __('admin::app.common.no-result-found') }}</td>
                                        <tr>
                                    @endif
                            </table>
                        </div>

                    </tab>
                @endif

                <tab name="{{ __('admin::app.sales.orders.refunds') }}">

                    <div class="table" style="padding: 20px 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>{{ __('admin::app.sales.refunds.id') }}</th>
                                    <th>{{ __('admin::app.sales.refunds.date') }}</th>
                                    <th>{{ __('admin::app.sales.refunds.order-id') }}</th>
                                    <th>{{ __('admin::app.sales.refunds.customer-name') }}</th>
                                    <th>{{ __('admin::app.sales.refunds.status') }}</th>
                                    <th>{{ __('admin::app.sales.refunds.refunded') }}</th>
                                    <th>{{ __('admin::app.sales.refunds.action') }}</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($order->refunds as $refund)
                                    <tr>
                                        <td>#{{ $refund->id }}</td>
                                        <td>{{ $refund->created_at }}</td>
                                        <td>#{{ $refund->order->increment_id }}</td>
                                        <td>{{ $refund->order->customer_full_name }}</td>
                                        <td>{{ __('admin::app.sales.refunds.refunded') }}</td>
                                        <td>{{ core()->formatBasePrice($refund->grand_total) }}</td>
                                        <td class="action">
                                            <a href="{{ route('admin.sales.refunds.view', $refund->id) }}">
                                                <i class="icon eye-icon"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                @if (! $order->refunds->count())
                                    <tr>
                                        <td class="empty" colspan="7">{{ __('admin::app.common.no-result-found') }}</td>
                                    <tr>
                                @endif
                        </table>
                    </div>

                </tab>
            </tabs>
        </div>

    </div>
@stop
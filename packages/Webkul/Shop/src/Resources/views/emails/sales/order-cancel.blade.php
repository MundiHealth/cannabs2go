@component('shop::emails.layouts.master')

    <tr>
        <td bgcolor="#eef4fa" align="center" style="padding: 30px 0 30px 0;">
            <a href="{{ config('app.url') }}">
                @include ('shop::emails.layouts.logo')
            </a>
        </td>
    </tr>

    <tr>
        <td bgcolor="#ffffff" style="padding: 30px 30px 30px 30px;">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                        <b>{{ __('shop::app.mail.cancel.heading', ['order_id' => '#' . $order->increment_id]) }}</b>
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif; padding: 10px 0 10px 0;">
                        {{ __('shop::app.mail.order.dear', ['customer_name' => $order->customer_full_name]) }},
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif; padding: 10px 0 10px 0;">
                        {!! __('shop::app.mail.cancel.greeting', [
                            'order_id' => '<a href="' . route('customer.orders.view', $order->id) . '" style="color: #0041FF; font-weight: bold;">#' . $order->increment_id . '</a>',
                            'created_at' => $order->created_at->format('d/m/Y H:i')
                            ])
                        !!}
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif; padding: 10px 0 10px 0;">
                        {{ __('shop::app.mail.order.summary') }}
                    </td>
                </tr>

                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                @if ($order->shipping_address)
                                    <td width="50%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 15px 10px 0;">
                                        <b>{{ __('shop::app.mail.order.shipping-address') }}</b>
                                    </td>
                                @endif

                                <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                                    <b>{{ __('shop::app.mail.order.billing-address') }}</b>
                                </td>
                            </tr>

                            <tr>
                                @if ($order->shipping_address)
                                    <td width="50%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 15px 10px 0;">
                                        {{ $order->shipping_address->name }} <br>
                                        {{ $order->shipping_address->address1 }} <br>
                                        {{ $order->shipping_address->city }} / {{ $order->shipping_address->state }} - CEP {{ $order->shipping_address->postcode }}
                                        <br>
                                        {{ core()->country_name($order->shipping_address->country) }} <br>
                                        --- <br>
                                        {{ __('shop::app.mail.order.contact') }}: {{ $order->shipping_address->phone }}
                                    </td>
                                @endif

                                <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                                    {{ $order->billing_address->name }} <br>
                                    {{ $order->billing_address->address1 }}, <br>
                                    {{ $order->billing_address->city }} / {{ $order->billing_address->state }} - CEP {{ $order->billing_address->postcode }}
                                    <br>
                                    {{ core()->country_name($order->billing_address->country) }} <br>
                                    --- <br>
                                    {{ __('shop::app.mail.order.contact') }}: {{ $order->billing_address->phone }}
                                </td>
                            </tr>

                            <tr>
                                @if ($order->shipping_address)
                                    <td width="50%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 15px 10px 0;">
                                        <b>{{ __('shop::app.mail.order.shipping') }}</b>
                                    </td>
                                @endif

                                <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                                    <b>{{ __('shop::app.mail.order.payment') }}</b>
                                </td>
                            </tr>

                            <tr>
                                @if ($order->shipping_address)
                                    <td width="50%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 15px 10px 0;">
                                        {{ $order->shipping_title }}
                                    </td>
                                @endif

                                <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                                    {{ core()->getConfigData('sales.paymentmethods.' . $order->payment->method . '.title') }}:

                                    @if($order->payment->method_title == 'bankslip')
                                        {{ 'Boleto' }}
                                    @else
                                        {{ 'Cartão de Crédito ('. $order->payment->method_title .')' }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                            <tr style="background-color: #f2f2f2">
                                <th style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ __('shop::app.customer.account.order.view.SKU') }}</th>
                                <th style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ __('shop::app.customer.account.order.view.product-name') }}</th>
                                <th style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ __('shop::app.customer.account.order.view.price') }}</th>
                                <th style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ __('shop::app.customer.account.order.view.qty') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td data-value="{{ __('shop::app.customer.account.order.view.SKU') }}" style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ $item->child ? $item->child->sku : $item->sku }}</td>

                                    <td data-value="{{ __('shop::app.customer.account.order.view.product-name') }}" style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">
                                        {{ $item->name }}

                                        @if (isset($item->additional['attributes']))
                                            <div class="item-options">

                                                @foreach ($item->additional['attributes'] as $attribute)
                                                    <i style="font-size: 12px;"><b>{{ $attribute['attribute_name'] }}: </b>{{ $attribute['option_label'] }}</i></br>
                                                @endforeach

                                            </div>
                                        @endif
                                    </td>

                                    <td data-value="{{ __('shop::app.customer.account.order.view.price') }}" style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ core()->formatPrice($item->price, $order->order_currency_code) }}
                                    </td>

                                    <td data-value="{{ __('shop::app.customer.account.order.view.qty') }}" style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ $item->qty_canceled }}</td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.order.subtotal') }}</b></td>
                                <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($order->sub_total, $order->order_currency_code) }}</td>
                            </tr>

                            @if ($order->shipping_address)
                                <tr>
                                    <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.order.shipping-handling') }}</b></td>
                                    <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($order->shipping_amount, $order->order_currency_code) }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.order.tax') }}</b></td>
                                <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($order->tax_amount, $order->order_currency_code) }}</td>
                            </tr>

                            @if ($order->discount_amount > 0)
                                <tr>
                                    <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.order.discount') }}</b></td>
                                    <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($order->discount_amount, $order->order_currency_code) }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.order.grand-total') }}</b></td>
                                <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                        {!!
                            __('shop::app.mail.cancel.help', [
                                'support_email' => ' <a style="color:#0041FF" href="mailto:' . config('mail.from.address') . '">' . config('mail.from.address'). '</a>'
                                ])
                        !!}
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                        {{ __('shop::app.mail.cancel.thanks') }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endcomponent
@component('shop::emails.layouts.master')

    <tr>
        <td bgcolor="#eef4fa" align="center" style="padding: 30px 0 30px 0;">
            <a href="{{ config('app.url') }}">
                @include ('shop::emails.layouts.logo')
            </a>
        </td>
    </tr>

    <?php $order = $refund->order; ?>

    <tr>
        <td bgcolor="#ffffff" style="padding: 30px 30px 30px 30px;">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                        <b> {{ __('shop::app.mail.refund.heading', ['order_id' => $order->increment_id, 'refund_id' => $refund->id]) }}</b>
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif; padding: 10px 0 10px 0;">
                        {{ __('shop::app.mail.order.dear', ['customer_name' => $order->customer_full_name]) }},
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif; padding: 10px 0 10px 0;">
                        {!! __('shop::app.mail.refund.greeting', [
                           'order_id' => '<a href="' . route('customer.orders.view', $order->id) . '" style="color: #0041FF; font-weight: bold;">#' . $order->increment_id . '</a>',
                           'created_at' => $order->created_at->format('d/m/Y H:i')
                           ])
                       !!}
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                        <b>{{ __('shop::app.mail.refund.summary') }}</b>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                                    <b>{{ __('shop::app.mail.order.billing-address') }}</b>
                                </td>
                            </tr>

                            <tr>
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
                                <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                                    <b>{{ __('shop::app.mail.order.payment') }}</b>
                                </td>
                            </tr>

                            <tr>
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
                                <th style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ __('shop::app.customer.account.order.view.product-name') }}</th>
                                <th style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ __('shop::app.customer.account.order.view.price') }}</th>
                                <th style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ __('shop::app.customer.account.order.view.qty') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($refund->items as $item)
                                <tr>
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

                                    <td data-value="{{ __('shop::app.customer.account.order.view.qty') }}" style="text-align: left;padding: 8px 8px 8px 8px; font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;">{{ $item->qty }}</td>
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
                                <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($refund->sub_total, $refund->order_currency_code) }}</td>
                            </tr>

                            @if ($refund->shipping_amount > 0)
                                <tr>
                                    <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.order.shipping-handling') }}</b></td>
                                    <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($refund->shipping_amount, $refund->order_currency_code) }}</td>
                                </tr>
                            @endif

                            @if ($refund->tax_amount > 0)
                            <tr>
                                <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.order.tax') }}</b></td>
                                <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($refund->tax_amount, $refund->order_currency_code) }}</td>
                            </tr>
                            @endif

                            @if ($refund->discount_amount > 0)
                                <tr>
                                    <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.order.discount') }}</b></td>
                                    <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($refund->discount_amount, $refund->order_currency_code) }}</td>
                                </tr>
                            @endif

                            @if ($refund->adjustment_refund > 0)
                                <tr>
                                    <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.refund.adjustment-refund') }}</b></td>
                                    <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;"> {{ core()->formatPrice($refund->adjustment_refund, $refund->order_currency_code) }}</td>
                                </tr>
                            @endif

                            @if ($refund->adjustment_fee > 0)
                                <tr>
                                    <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.refund.adjustment-fee') }}</b></td>
                                    <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($refund->adjustment_fee, $refund->order_currency_code) }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td align="right" width="80%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 10px 5px 0;"><b>{{ __('shop::app.mail.order.grand-total') }}</b></td>
                                <td align="right" width="20%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 5px 0 5px 0;">{{ core()->formatPrice($refund->grand_total, $refund->order_currency_code) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                        {!!
                            __('shop::app.mail.order.help', [
                                'support_email' => ' <a style="color:#0041FF" href="mailto:' . config('mail.from.address') . '">' . config('mail.from.address'). '</a>'
                                ])
                        !!}
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                        {{ __('shop::app.mail.order.thanks') }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endcomponent

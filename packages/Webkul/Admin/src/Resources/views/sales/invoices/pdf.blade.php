    <!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">

    <title>Invoice | Pure Encapsulations</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

</head>

<body style="font-family: montserrat, sans-serif; margin: 0; padding: 0;">
<table cellpadding="0" cellspacing="0" width="100%">
    <table align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 30px 0 30px 0;">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="75%" style="font-size: 18px;color: #000000;line-height: 32px;font-family: montserrat, sans-serif;padding: 0 20px 0 20px;">
                            <b>Commercial Invoice Nº {{ $invoice->order->increment_id }}</b>
                        </td>
                        <td width="25%" align="right" style="font-size: 18px;color: #5E5E5E;line-height: 32px;font-family: montserrat, sans-serif;padding: 0 20px 0 20px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 30px 30px 30px 30px;">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0; text-transform: uppercase;">
                            PERSONAL USE - MEDICAL PRESCRIPTION INCLUDED
                        </td>
                    </tr>
                    <tr>
                        <td width="75%" style="font-size: 14px;color: #000000;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 0 0;">
                            <b>Ship To:</b>
                        </td>
                        <td width="25%" style="font-size: 14px;color: #000000;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 0 0;">
                            @if($invoice->order->channel_id == 7)
                            <b>Nasus Pharma Ltd:</b>
                            @else
                            <b>MundiHealth.com:</b>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td width="75%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                            {{ $invoice->order->shipping_address->first_name }} {{ $invoice->order->shipping_address->last_name }}<br>
                            {{ $invoice->order->shipping_address->address1 }} <br>
                            {{ $invoice->order->shipping_address->city }} / {{ $invoice->order->shipping_address->state }} - {{ $invoice->order->shipping_address->postcode }}<br>
                            BR +55 {{ $invoice->order->shipping_address->phone }} <br>
                            ID/EIN: {{ $invoice->order->shipping_address->taxvat }}
                        </td>
                        <td width="25%" style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                            8601 Commodity Cir., Suite 102 <br>
                            Orlando - FL 32819-9003 <br>
                            Phone: (407) 985-1237 (direct)
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 30px 30px 30px 30px; border-bottom:2px solid #bdbdbd;">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="padding: 0 0 15px 0;"><b>Description</b></td>
                        <td style="padding: 0 0 15px 0;"><b>HS Code</b></td>
                        <td style="padding: 0 0 15px 0;"><b>Qty.</b></td>
                        <td style="padding: 0 0 15px 0;"><b>Unit Price</b></td>
                        <td style="padding: 0 0 15px 0;"><b>Line Price</b></td>
                    </tr>

                    @foreach ($invoice->items as $item)
                        <tr>
                            <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;border-bottom:1px solid #bdbdbd;padding: 0 0 10px 0; margin: 0 0 10px 0;">
                                @if($invoice->order->base_grand_total == 0 && !is_null($invoice->order->coupon_code))
                                {{ $item->name }} (AMOSTRA AVALIAÇÃO PRESCRITOR)
                                @else
                                {{ $item->name }}
                                @endif
                                @if (isset($item->additional['attributes']))
                                    <br>
                                    @foreach ($item->additional['attributes'] as $attribute)
                                        <i>{{ $attribute['attribute_name'] }}: </i>{{ $attribute['option_label'] }}</br>
                                    @endforeach
                                @endif
                            </td>
                            <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;border-bottom:1px solid #bdbdbd; margin: 0 0 10px 0;">
                                3004.50.5030
                            </td>
                            <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;border-bottom:1px solid #bdbdbd; margin: 0 0 10px 0;">
                                {{ $item->qty }}
                            </td>2
                            <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;border-bottom:1px solid #bdbdbd; margin: 0 0 10px 0;">
                                {{ core()->formatPrice($item->base_price, 'USD') }}
                            </td>
                            <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;border-bottom:1px solid #bdbdbd; margin: 0 0 10px 0;">
                                {{ core()->formatPrice($item->base_total, 'USD') }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 30px 30px 30px 30px;">
                <table cellpadding="0" cellspacing="0" width="100%">

                    <tr>
                        <td align="right" width="80%" style="padding: 5px 0 5px 0;"><b>Item(s) Subtotal:</b></td>
                        <td align="right" width="20%" style="padding: 5px 0 5px 0;">{{ core()->formatPrice($invoice->base_sub_total, 'USD') }}</td>
                    </tr>

                    <tr>
                        <td align="right" width="80%" style="padding: 5px 0 5px 0;"><b>Discount:</b></td>
                        <td align="right" width="20%" style="padding: 5px 0 5px 0;">{{ core()->formatPrice($invoice->base_discount_amount, 'USD') }}</td>
                    </tr>

                    <tr>
                        <td align="right" width="80%" style="padding: 5px 0 5px 0;"><b>Incoterm:</b></td>
                        <td align="right" width="20%" style="padding: 5px 0 5px 0;">DDP</td>
                    </tr>

                    <tr>
                        <td align="right" width="80%" style="padding: 5px 0 5px 0;"><b>Freight:</b></td>
                        <td align="right" width="20%" style="padding: 5px 0 5px 0;">{{ core()->formatPrice($invoice->base_shipping_amount, 'USD') }}</td>
                    </tr>

                    <tr>
                        <td align="right" width="80%" style="padding: 5px 0 5px 0;"><b>Total Before Tax:</b></td>
                            <td align="right" width="20%" style="padding: 5px 0 5px 0;">{{ core()->formatPrice($invoice->total_before_tax, 'USD') }}</td>
                    </tr>

                    <tr>
                        <td align="right" width="80%" style="padding: 5px 0 5px 0;"><b>Local Duties Fee Deposit:</b></td>
                        <td align="right" width="20%" style="padding: 5px 0 5px 0;">{{ core()->formatPrice($invoice->local_duties_fee_deposit, 'USD') }}</td>
                    </tr>

                    <tr>
                        <td align="right" width="80%" style="padding: 5px 0 5px 0;"><b>Grand Total:</b></td>
                        <td align="right" width="20%" style="padding: 5px 0 5px 0;">{{ core()->formatPrice($invoice->base_grand_total, 'USD') }}</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</table>
</body>
</html>
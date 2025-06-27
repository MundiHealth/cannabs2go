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
                    <td style="font-size: 16px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                    {{ __('shop::app.mail.confirmation-prescription.dear') }},
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif; padding: 10px 0 10px 0;">
                        {!! __('shop::app.mail.confirmation-prescription.info', [
                            'order_id' => '<a href="' . route('customer.orders.view', $dados->order_id) . '" style="color: #0041FF; font-weight: bold;">#' . 'MP20200000'.$dados->order_id . '</a>'
                            ])
                        !!}
                    </td>
                </tr>
                <tr>
                    <td style="padding:30px 0 0 0;"></td>
                </tr>

                <tr>
                    <td style="padding:0 0 30px 0;"></td>
                </tr>

                <tr>
                    <td style="font-size: 16px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                        {{ __('shop::app.mail.confirmation-prescription.thanks') }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endcomponent
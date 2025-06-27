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
                        {!! __('shop::app.mail.customer.subscription.greeting') !!}
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 16px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif; padding: 10px 0 10px 0;">
                        {!! __('shop::app.mail.customer.subscription.summary') !!}
                    </td>
                </tr>

                <tr>
                    <td style="padding:30px 0 0 0;"></td>
                </tr>

                <tr>
                    <td style="padding:10px 20px 10px 20px;background: #0041FF;text-transform: uppercase; font-size: 16px;text-align: center;">
                        <a href="{{ route('shop.unsubscribe', $data['token']) }}" style="text-decoration: none;color: #ffffff;font-family: montserrat, sans-serif;line-height: 24px;">
                            {!! __('shop::app.mail.customer.subscription.unsubscribe') !!}
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

@endcomponent
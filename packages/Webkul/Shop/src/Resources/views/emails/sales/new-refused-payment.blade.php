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
                        Prezado(a),
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif; padding: 10px 0 10px 0;">
                        Infelizmente seu pagamento foi recusado e seu pedido foi cancelado. Para refazer o pedido, acesse seu perfil ou entre em contato conosco.
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
                        Muito obrigado(a)!
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endcomponent
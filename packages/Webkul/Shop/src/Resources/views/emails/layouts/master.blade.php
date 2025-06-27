<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500" rel="stylesheet" type="text/css">
    </head>

    <body style="font-family: montserrat, sans-serif; margin: 0; padding: 0;">
{{--        <table cellpadding="0" cellspacing="0" width="100%">--}}
            <table align="center" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border:1px solid #eef4fa;">
                <tr>
                    <td bgcolor="#ffffff" align="center">
                        {{ $header ?? '' }}
                    </td>
                </tr>

                {{ $slot }}

                {{ $subcopy ?? '' }}
            </table>
{{--        </table>--}}
    </body>
</html>

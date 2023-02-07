<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>GoldenKey</title>
    <!--[if (gte mso 9)|(IE)]>
    <style type="text/css">
        table {border-collapse: collapse;}
    </style>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; min-width: 100%; ">
<center bgcolor="#FFFFFF"  class="wrapper" style="width: 100%; table-layout: fixed; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; ">
    <div class="webkit" style="max-width: 600px;">
        <!--[if (gte mso 9)|(IE)]>
        <table width="600" align="center">
            <tr>
                <td>
        <![endif]-->
        <table bgcolor="#FFFFFF" width="100%" class="outer" align="center" style="border-spacing: 0; font-family: Arial,Tahoma,sans-serif; color: #8F8E8E; margin: 0 auto; width: 100%; max-width: 600px; font-size: 12px; line-height: normal;" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="padding: 0;">
                    <table width="100%" class="outer" align="center" style="border-spacing: 0; font-family: Arial,Tahoma,sans-serif; color: #8F8E8E; Margin: 0 auto; width: 100%; max-width: 600px;" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">

                        @include('mail.regular.header')

                        <tr class="section-content">
                            <td>
                                <table width="100%" style="border-spacing: 0; font-family: Arial,Tahoma,sans-serif; color: #8F8E8E; margin: 0 auto; width: 100%; max-width: 600px; padding-top: 50px; padding-bottom: 50px; border-bottom: 1px solid #C8C8C8;" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td  align="center" class="order-number" style="color: #8F8E8E; font-size: 14px; font-family: Arial,Tahoma,sans-serif; line-height: 20px; display: block; -webkit-text-size-adjust: none; -ms-text-size-adjust: none;">
                                            Ваш новый пароль для входа <span class="order-number" style="font-weight: 700;">{{$password}}</span>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        @include('mail.regular.footer')
                    </table>
                </td>
            </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
    </div>
</center>
</body>
</html>

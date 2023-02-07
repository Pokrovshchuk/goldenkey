@extends('layouts.mail')

@section('content')

    @if($certificate->user)
        <tr class="title" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
            <td class="title__container _container"
                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:30px;padding-right:30px;padding-top:30px;text-align:left;vertical-align:top;word-wrap:break-word">
                <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <td class="title__body"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:18px;font-style:normal;font-weight:600;hyphens:auto;letter-spacing:0;line-height:22px;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                            {{$certificate->user->name}}, благодарим за покупку!
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif

    <tr class="text" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
        <td class="text__container _container"
            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:30px;padding-right:30px;padding-top:20px;text-align:left;vertical-align:top;word-wrap:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                    <td class="text__body"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                        Ваш сертификат готов. Теперь вы можете получить доступ в бизнес-зал РЖД нового формата: <span
                            style="font-size:14px;font-style:normal;font-weight:600;letter-spacing:0;line-height:20px;text-align:left">{{$certificate->halls->name}}</span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="qr-code" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
        <td class="qr-code__container _container"
            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:30px;padding-right:30px;padding-top:31px;text-align:left;vertical-align:top;word-wrap:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                    <td height="312" width="310" class="qr-code__body"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background-image:url({{asset('img/qr-bg.png')}});border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;height:312px;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:center;vertical-align:middle;word-wrap:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td width="5"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word"></td>
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                    <img width="300" height="300" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{$code}}&choe=UTF-8" title="Your qr code"
                                         style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:300px;outline:0;text-decoration:none;width:auto"></td>
                                <td width="5"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word"></td>
                            </tr>
                        </table>
                    </td>
                    <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="text-help" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
        <td class="text-help__container _container"
            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:30px;padding-right:30px;padding-top:30px;text-align:left;vertical-align:top;word-wrap:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                    <td class="text-help__body"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #c7c7c74d;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:30px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                        Для доступа в бизнес-зал просто покажите этот QR-код администратору.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="register" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
        <td class="register__container _container"
            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:30px;padding-right:30px;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                    <td class="register__body"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;width:290px;word-wrap:break-word">
                                    Номер сертификата:
                                </td>
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:22px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;word-wrap:break-word">
                                    {{$certificate->id}}
                                </td>
                            </tr>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;width:290px;word-wrap:break-word">
                                    Код сертификата:
                                </td>
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:22px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;word-wrap:break-word">
                                    {{$code}}
                                </td>
                            </tr>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;width:290px;word-wrap:break-word">
                                    Длительность посещения:
                                </td>
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:22px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;word-wrap:break-word">
                                    3 часа
                                </td>
                            </tr>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;width:290px;word-wrap:break-word">
                                    Дата покупки
                                </td>
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:22px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;word-wrap:break-word">
                                    {{\Carbon\Carbon::parse($certificate->created_at)->format('d.m.Y')}}
                                </td>
                            </tr>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;width:290px;word-wrap:break-word">
                                    Действителен до:
                                </td>
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:22px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;word-wrap:break-word">
                                    {{\Carbon\Carbon::parse($certificate->created_at)->addMonths(\App\Models\Certificate::EXPIRATION_IN_MONTHS)->format('d.m.Y')}}
                                </td>
                            </tr>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;width:290px;word-wrap:break-word">
                                    Количество гостей:
                                </td>
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:22px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;word-wrap:break-word">
                                    {{$certificate->pass_limit}}
                                </td>
                            </tr>
                            @if($certificate->pass_limit === 1 and $certificate->user_name)
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;width:290px;word-wrap:break-word">
                                        Имя гостя:
                                    </td>
                                    <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:22px;margin:0;padding-bottom:21px;padding-left:0;padding-right:0;padding-top:21px;text-align:left;vertical-align:top;word-wrap:break-word">
                                        {{$certificate->user_name}}
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    @if($certificate->pass_limit >= 2 and $certificate->user_name)
        @php($certificate->user_name = json_decode($certificate->user_name))
        <tr class="subtitle" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
            <td class="subtitle__container _container"
                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:21px;padding-left:30px;padding-right:30px;padding-top:30px;text-align:left;vertical-align:top;word-wrap:break-word">
                <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <td class="subtitle__body"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:600;hyphens:auto;letter-spacing:0;line-height:17px;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                            Имя гостя(-ей)
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="guests" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
            <td class="guests__container _container"
                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:30px;padding-right:30px;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <td class="guests__body"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:30px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                @php($total = 0)
                                @while($total < count($certificate->user_name))
                                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                        <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:21px;margin:0;padding-bottom:20px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:290px;word-wrap:break-word">
                                            <span style="padding-right:5px">{{$total + 1}}.</span>{{$certificate->user_name[$total]}}
                                        </td>
                                        @if(isset($certificate->user_name[$total+1]))
                                            @php($total++)
                                            <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:21px;margin:0;padding-bottom:20px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:290px;word-wrap:break-word">
                                                <span style="padding-right:5px">{{$total + 1}}.</span>{{$certificate->user_name[$total]}}
                                            </td>
                                        @endif
                                    </tr>
                                    @php($total++)
                                @endwhile
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif

    {{--
    <tr class="wallet" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
        <td class="wallet__container _container"
            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:30px;padding-right:30px;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                    <td class="wallet__body"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background-color:#f5f5f5;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:30px;padding-left:30px;padding-right:30px;padding-top:30px;text-align:left;vertical-align:top;word-wrap:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td width="224"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                    Также вы можете добавить сертификат в Apple Wallet, чтобы он всегда был под рукой.
                                </td>
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word"></td>
                                <td width="204"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                    <img width="204" height="63" src="{{asset('img/wallet.png')}}" alt="Wallet"
                                         style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    --}}

    <tr class="text-help" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
        <td class="text-help__container _container"
            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:30px;padding-right:30px;padding-top:30px;text-align:left;vertical-align:top;word-wrap:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                    <td class="text-help__body"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #c7c7c74d;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:20px;margin:0;padding-bottom:30px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                        Во вложении даннного письма находится PDF-версия сертификата. Печатать его необязательно, только если вам так удобнее.
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr class="text-alert" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
        <td class="text-alert__container _container"
            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:20px;padding-left:30px;padding-right:30px;padding-top:30px;text-align:left;vertical-align:top;word-wrap:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                    <td class="text-alert__body"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#eb5757;font-family:Inter,Helvetica,Arial,sans-serif;font-size:13px;font-style:normal;font-weight:500;hyphens:auto;letter-spacing:0;line-height:18px;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                        Внимание!
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr class="alert-block" style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
        <td class="alert-block__container _container"
            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:0;padding-left:30px;padding-right:30px;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                    <td class="alert-block__body"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:1px solid #7c7c7c4d;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:140%;margin:0;padding-bottom:30px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td class="dot" width="4"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:12px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:17px;margin:0;padding-bottom:10px;padding-left:8px;padding-right:8px;padding-top:6px;text-align:left;vertical-align:top;word-wrap:break-word">
                                    <img width="4" height="4" src="{{asset('img/dot.png')}}" alt
                                         style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"></td>
                                <td class="text"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:12px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:17px;margin:0;padding-bottom:10px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                    Сертификат может быть использован только один раз.
                                </td>
                            </tr>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td class="dot" width="4"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:12px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:17px;margin:0;padding-bottom:10px;padding-left:8px;padding-right:8px;padding-top:6px;text-align:left;vertical-align:top;word-wrap:break-word">
                                    <img width="4" height="4" src="{{asset('img/dot.png')}}" alt
                                         style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"></td>
                                <td class="text"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:12px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:17px;margin:0;padding-bottom:10px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                    Сертификат необходимо предъявить только Администратору Бизнес-зала на стойке регистрации в Бизнес-зале.
                                </td>
                            </tr>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td class="dot" width="4"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:12px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:17px;margin:0;padding-bottom:10px;padding-left:8px;padding-right:8px;padding-top:6px;text-align:left;vertical-align:top;word-wrap:break-word">
                                    <img width="4" height="4" src="{{asset('img/dot.png')}}" alt
                                         style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"></td>
                                <td class="text"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:12px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:17px;margin:0;padding-bottom:10px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                    Не передавать, не предъявлять и не показывать сертификат третьим лицам во избежание несанкционированного использования или кражи сертификата.
                                </td>
                            </tr>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <td class="dot" width="4"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#242424;font-family:Inter,Helvetica,Arial,sans-serif;font-size:12px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:17px;margin:0;padding-bottom:10px;padding-left:8px;padding-right:8px;padding-top:6px;text-align:left;vertical-align:top;word-wrap:break-word">
                                    <img width="4" height="4" src="{{asset('img/dot.png')}}" alt
                                         style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"></td>
                                <td class="text"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#7c7c7c;font-family:Inter,Helvetica,Arial,sans-serif;font-size:12px;font-style:normal;font-weight:400;hyphens:auto;letter-spacing:0;line-height:17px;margin:0;padding-bottom:10px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                    За сохранность сертификата от использования третьими лицами с момента получения несет ответственность получатель.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>FMI SA - Aviso</title>
    <!--<link href="styles.css" media="all" rel="stylesheet" type="text/css" />-->
    <style type="text/css">
        /* -------------------------------------
            GLOBAL
            A very basic CSS reset
        ------------------------------------- */
        * {
            margin: 0;
            padding: 0;
            /*font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;*/

            font-family: "Helvetica Neue", Arial, sans-serif;
            box-sizing: border-box;
            font-size: 14px;
        }

        img {
            max-width: 100%;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            line-height: 1.6;
        }

        /* Let's make sure all tables have defaults */
        table td {
            vertical-align: top;
        }

        /* -------------------------------------
            BODY & CONTAINER
        ------------------------------------- */
        body {
            background-color: #f6f6f6;
        }

        .body-wrap {
            /*background-color: #f6f6f6;*/
            background-color: rgb(249, 249, 249);
            width: 100%;
        }

        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            /* makes it centered */
            clear: both !important;
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
            padding: 20px 0px;
        }

        /* -------------------------------------
            HEADER, FOOTER, MAIN
        ------------------------------------- */
        .main {
            background: #fff;
            /*border: 1px solid #e9e9e9;*/
            /*border: 1px solid grey;*/
            /*border-radius: 3px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;*/

            color: rgb(82, 82, 82);;
            font-family: "Helvetica Neue", Arial, sans-serif;

            table-layout: fixed;
            border-collapse: collapse;
            border-color: #f6f6f6;
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
            border-style: solid solid none;
            border-width: 0px 1px 1px;
            border-bottom: 0px solid #fff;
            width: 600px;
            /*box-shadow: 0px 0px 10px #a7a7a7;*/
            -webkit-border-radius:;
            -moz-border-radius:;
            border-radius:0px;
        }

        .content-wrap {
            /*padding: 20px;*/
            padding: 40px 40px 30px;
        }

        .content-block {
            padding: 0 0 20px;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .footer {
            width: 100%;
            clear: both;
            color: #999;
            padding: 20px;
        }

        .footer a {
            color: #999;
        }

        .footer p, .footer a, .footer unsubscribe, .footer td {
            font-size: 12px;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1, h2, h3 {
            /*font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;*/

            font-family: "Helvetica Neue", Arial, sans-serif;
            color: rgb(82, 82, 82);;
            margin: 40px 0 0;
            line-height: 1.2;
            font-weight: 400;
        }

        h1 {
            font-size: 32px;
            font-weight: 500;
        }

        h2 {
            font-size: 24px;
        }

        h3 {
            font-size: 18px;
        }

        h4 {
            font-size: 14px;
            font-weight: 600;
        }

        p, ul, ol {
            margin-bottom: 10px;
            font-weight: normal;
        }

        p li, ul li, ol li {
            margin-left: 5px;
            list-style-position: inside;
        }

        /* -------------------------------------
            LINKS & BUTTONS
        ------------------------------------- */
        a {
            color: rgb(18, 81, 186);
            text-decoration: underline;
        }

        .btn-primary {
            text-decoration: none;
            color: #FFF;
            background-color: #1ab394;
            border: solid #1ab394;
            border-width: 5px 10px;
            line-height: 2;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            border-radius: 5px;
            text-transform: capitalize;
        }

        /* -------------------------------------
            OTHER STYLES THAT MIGHT BE USEFUL
        ------------------------------------- */
        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .aligncenter {
            text-align: center;
        }

        .alignright {
            text-align: right;
        }

        .alignleft {
            text-align: left;
        }

        .clear {
            clear: both;
        }

        /* -------------------------------------
            ALERTS
            Change the class depending on warning email, good email or bad email
        ------------------------------------- */
        .alert {
            font-size: 16px;
            color: #fff;
            font-weight: 500;
            padding: 20px;
            text-align: center;
            border-radius: 3px 3px 0 0;
        }

        .alert a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
        }

        .alert.alert-warning {
            background: #f8ac59;
        }

        .alert.alert-bad {
            background: #ed5565;
        }

        .alert.alert-good {
            background: #1ab394;
        }

        /* -------------------------------------
            INVOICE
            Styles for the billing table
        ------------------------------------- */
        .invoice {
            margin: 40px auto;
            text-align: left;
            width: 80%;
        }

        .invoice td {
            padding: 5px 0;
        }

        .invoice .invoice-items {
            width: 100%;
        }

        .invoice .invoice-items td {
            border-top: #eee 1px solid;
        }

        .invoice .invoice-items .total td {
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            font-weight: 700;
        }

        /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        @media only screen and (max-width: 640px) {
            h1, h2, h3, h4 {
                font-weight: 600 !important;
                margin: 20px 0 5px !important;
            }

            h1 {
                font-size: 22px !important;
            }

            h2 {
                font-size: 18px !important;
            }

            h3 {
                font-size: 16px !important;
            }

            .container {
                width: 100% !important;
            }

            .content, .content-wrap {
                padding: 10px !important;
            }

            .invoice {
                width: 100% !important;
            }
        }

        .border-orange {
            vertical-align: top;
            border-collapse: collapse;
            width: 600px;
            background-color: transparent;
            border: none;
            font-family: "Helvetica Neue", Arial, sans-serif;
            line-height: 3px;
            height: 3px;
        }

        .helvetica {
            font-family: "Helvetica Neue", Arial, sans-serif;
        }

        table.avatar {
            display: table;
        }

        table.avatar tr td {
            display: table-cell;
        }

        table > tbody > tr.impar > td{
            padding: 10px;
            vertical-align: middle;
            text-align: left;
            background-color: #F5F7F8;
            color: #707070;
        }

        table > tbody > tr.impar > td p{
            margin-bottom: 0px;
        }

        table > tbody > tr.par > td{
            padding: 10px;
            vertical-align: middle;
            text-align: left;
            background-color: #fff;
            color: #707070;
        }

        table > tbody > tr.par > td p{
            margin-bottom: 0px;
        }

    </style>
</head>

<body>

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600" style="padding-top: 20px;">
            <div class="content">
                <!-- <table class="border-orange" style="background-color: #fff;">
                     <tbody>
                     <tr>
                         <td>

                         </td>
                     </tr>
                     </tbody>
                 </table>-->
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <img style="margin-left: -1px; width:600px;max-width: 600px;" class="cabecalho" src="<?php echo CLOUDFRONT.'email/cabecalho.png?v=3' ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="content-wrap">
                            <table cellpadding="0" cellspacing="0" width="100%" style="width:100%;">
                                <?php if(!empty($nome)){

                                    ?><tr>
                                    <td>
                                        <p style="padding-top:15px;font-size:26px;font-weight:900;color: #004365;text-align: left!important; margin: 0px 0px 0px; line-height: 1.5;">
                                            <?php echo $nome;?>,</p>

                                        <p style="color: #008FC1;text-align: left!important; margin: 0px 0px 35px; line-height: 1.5;">

                                        </p>
                                    </td>
                                    </tr><?php }?>

                                <tr>

                                    <td>
                                        Identificamos vosso aporte. Para concluir a subscrição, por favor, siga os passos abaixo: <br/><br/>
                                        1. Clique em Investimento digital<br/><br/>
                                        <img src="<?php echo CLOUDFRONT.'imagem/mail/digital_step1.png' ?>" title="Passo 1"/><br/><br/>
                                        2. Em seguida, clique em “Aceitar Subscrição”<br/><br/>
                                        <img src="<?php echo CLOUDFRONT.'imagem/mail/digital_step2.png' ?>" title="Passo 2"/><br/><br/>
                                        3. Em tipo de rendimento, opte pela forma como irá performar o seu rendimento. Resgatar mensalmente (cupom mensal) ou reinvestir (juros compostos).<br/><br/>
                                        4. Por fim, basta apenas preencher a sua assinatura digital e confirmar a subscrição.<br/><br/>
                                        Em caso de dúvidas, estamos à disposição.<br/><br/>
                                        Atenciosamente,
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table class="avatar" cellpadding="0" cellspacing="0"
                       style="table-layout: fixed;border-collapse: collapse;width: 600px;background-color: #F9F9F9;margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td style="vertical-align: middle;background-color: #004365;padding: 20px 0px 20px 20px;">
                            <p style="color: #008FC1;text-align: left!important; margin: 0px 0px 10px; line-height: 1.5;font-size: 14px;">
                                +55 (11) 2500-4699 | +55 (11) 97137-1825
                            </p>
                            <p style="color: #fff;text-align: left!important; margin: 0px 0px 0px; line-height: 1.5;">
                                LWM Corporate Center | Torre A | 9˚ Andar<br/>
                                Rua George Ohm, 206<br/>
                                CEP 04576-020 - São Paulo - SP
                            </p>
                        </td>
                        <td style="vertical-align: middle;background-color: #004365; text-align: right;padding:20px 25px 15px 0px">
                            <img valign="middle" style="max-width: 605px;"
                                 src="<?php echo CLOUDFRONT.'email/logo-rodape.png' ?>" alt="">
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="avatar" cellpadding="0" cellspacing="0"
                       style="table-layout: fixed;border-collapse: collapse;width: 600px;background-color: #F9F9F9;margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td style="text-align: center;">
                            <p style="padding-top:20px;">
                                <a class="helvetica"
                                   style="font-weight:900;text-decoration:none;font-size:24px;padding-left: 0px;color: #004365;text-align: center!important; margin: 0px 0px 17px; line-height: 1.5;"
                                   href="http://gcbinvestimentos.com">gcbinvestimentos.com</a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <ul style="list-style: none;text-align: center;">
                                <li style="display: inline-block;">
                                    <a target="_blank" href="https://www.facebook.com/gcbinvestimentos/?fref=ts">
                                        <img src="<?php echo CLOUDFRONT.'email/instagram.png' ?>" alt="">
                                    </a>
                                </li>
                                <li style="display: inline-block;">
                                    <a target="_blank" href="https://www.facebook.com/gcbinvestimentos/?fref=ts">
                                        <img src="<?php echo CLOUDFRONT.'email/facebook.png' ?>" alt="">
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
</table>

</body>
</html>


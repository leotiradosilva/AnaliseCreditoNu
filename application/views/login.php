<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head id="Head1" runat="server">
    <title>Faça o login para acessar o FMI</title>

    <link rel="Shortcut Icon" href="imagens/favicon.png"/>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0"/>-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	
	<meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">

    <meta name="robots" content="index, follow">
    <meta name="description" content="Através da emissão e da colocação de CRM’s - Certificado de Recebível Mercantil - a FMI gera créditos e os securitiza, transformando os ativos financeiros em títulos negociáveis no mercado de capitais. 
Fundado em 2013, a FMI foi criada com o objetivo de executar investimentos para clientes private e prestar serviços de consultoria. Foi em 2016 que a empresa atingiu seu grande crescimento, devido a importantes parcerias, resultando em aberturas de filiais por todo o país. Conheça todos os nossos serviços. 
">
    <meta name="keywords" content="">
    <meta name="author" content="L8 DIGITAL">
    <meta property="og:type" content="website">
    <meta property="og:title" content="FMI SA - Securitizadora">
    <meta property="og:site_name" content="FMI Securitizadora">
    <meta property="og:url" content="https://fmisa.com.br/site/">
    <meta property="og:description" content="Através da emissão e da colocação de CRM’s - Certificado de Recebível Mercantil - a FMI gera créditos e os securitiza, transformando os ativos financeiros em títulos negociáveis no mercado de capitais. 
Fundado em 2013, a FMI foi criada com o objetivo de executar investimentos para clientes private e prestar serviços de consultoria. Foi em 2016 que a empresa atingiu seu grande crescimento, devido a importantes parcerias, resultando em aberturas de filiais por todo o país. Conheça todos os nossos serviços. 
">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="450">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="FMI SA - Securitizadora">
    <meta name="twitter:url" content="https://fmisa.com.br/site/">
    <meta name="twitter:creator" content="L8 DIGITAL">

    <meta itemprop="name" content="FMI Securitizadora">
    <meta itemprop="description" content="Através da emissão e da colocação de CRM’s - Certificado de Recebível Mercantil - a FMI gera créditos e os securitiza, transformando os ativos financeiros em títulos negociáveis no mercado de capitais. 
Fundado em 2013, a FMI foi criada com o objetivo de executar investimentos para clientes private e prestar serviços de consultoria. Foi em 2016 que a empresa atingiu seu grande crescimento, devido a importantes parcerias, resultando em aberturas de filiais por todo o país. Conheça todos os nossos serviços. 
">

    <link href='http://fonts.googleapis.com/css?family=Maven+Pro' rel='stylesheet' type='text/css'/>
    <!--    <link href='-->
    <?php //echo CLOUDFRONT; ?><!--fancybox/source/jquery.fancybox.css' rel='stylesheet' type='text/css' />-->
    <!--    <link href="-->
    <?php //echo CLOUDFRONT; ?><!--css/bootstrap.css" rel="stylesheet" type="text/css" />-->

    <!--    <link href="-->
    <?php //echo CLOUDFRONT; ?><!--css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />-->
    <script type="text/javascript" src="<?php echo CLOUDFRONT; ?>js/jquery-1.6.1.min.js"></script>

    <!--    <script type="text/javascript" src="-->
    <?php //echo CLOUDFRONT; ?><!--fancybox/source/jquery.fancybox.js"></script>-->
    <!--    <script type="text/javascript" src="-->
    <?php //echo CLOUDFRONT; ?><!--fancybox/source/jquery.fancybox.pack.js"></script>-->

    <!--    <link rel="stylesheet" href="--><?php //echo CLOUDFRONT; ?><!--css/login.css" />-->


    <!-- CSS -->
    <link href="<?php echo CLOUDFRONT ?>superadmin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT ?>superadmin/css/form.css?v=<?= time(); ?>" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT ?>superadmin/css/style.css?v=<?= time(); ?>" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT ?>superadmin/css/animate.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT ?>superadmin/css/generics.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/fonte/avenir/avenir.css" rel="stylesheet">

    <script type="text/javascript">

        $(document).ready(function (e) {
            $('#abrir').click(function (e) {
                $('#erro').fadeIn('slow');

                setTimeout("$('#erro').fadeOut('slow')", 5000);
            });
            /*$('#fechar').click(function(e) {
             $('#erro').fadeOut('slow');

             });*/

            $(".fancybox").fancybox();
        });

        function MostrarMensagem(msg) {
            $('#mensagem').html(msg);
        }


        $(document).ready(function (e) {
            $('.container').animate({marginTop: 50}, 300, function () {
            });
            $('.container').animate({marginTop: 0}, 50, function () {
            });
        });
    </script>
</head>

<body id="skin-blur-ocean" class="body-login">

<section id="login" class="clearfix">

    <div class="aux-login">
        <header>
            <h1><img id="img-logo" src="<?php echo CLOUDFRONT.'imagem/logo/fmi.svg' ?>"></h1>

        </header>

        <!-- Login -->
        <?php
        $atributos = array('class' => 'form-signin box clearfix animated active', 'id' => 'box-login');
        echo form_open('login/entrar/'. TOKEN_ACCESS_PAINEL_FMI .'', $atributos);
        ?>

        <h2 class="m-t-0 m-b-15 h2-login">Login</h2>

        <div class="item-input">
            <label for="senha">E-MAIL</label>
            <input type="text" name="tbxEmail" id="tbxEmail" class="login-control m-b-10"
                   placeholder="Nome de Usuário">
        </div>

        <div class="item-input">
            <label for="senha">SENHA</label>
            <input type="password" name="tbxSenha" id="tbxSenha" placeholder="***********" class="login-control m-b-10"
                   TextMode="Password">

        </div>

        <div class="esqueci-manter">
            <div class="checkbox m-b-20">
                <label>
                    <div class="aux-check">
                        <input type="checkbox">
                    </div>

                    Mantenha-me contectado.
                </label>
            </div>

            <a class="box-switcher esqueci-a-senha" data-switch="box-reset" href="">Esqueci minha senha</a>
        </div>

        <input type="submit" ID="btnEntrar" class="btn btn-sm m-r-5 btn-login" value="Entrar"/>

        <?php echo form_close(); ?>

        <!-- Forgot Password -->
        <form class="box animated clearfix" id="box-reset">
            <h2 class="m-t-0 m-b-15 h2-login">Reset sua senha</h2>
            <p class="p-login">Digite o e-mail cadastrado, será enviado uma senha provisória para ele.</p>
            <input type="email" class="login-control m-b-20" placeholder="Endereço de e-mail">

            <button class="btn btn-sm m-r-5 btn-login">Resetar Senha</button>

            <small><a class="box-switcher voltar-login" data-switch="box-login" href="">Voltar para o login.</a></small>
        </form>

    </div>
</section>


<section class="div-login" style="display: none;">
    <img src="<?php echo CLOUDFRONT; ?>imagem/logo/login.png" class="logo-login" alt="L8 Agência"/>

    <div class="inputs-login">
        <h1 class="titulo1">Área de Login</h1>

        <div class="cada-input">
            <div class="input-prepend">
                <span class="add-on add-on-login"><i class="usuario-login"></i></span>
                <input type="text" name="tbxEmail" id="tbxEmail" class="input-login"
                       placeholder="Nome de Usuário"></input>
            </div>
        </div>

        <div class="cada-input">
            <div class="input-prepend">
                <span class="add-on add-on-login"><i class="senha-login"></i></span><input type="password"
                                                                                           name="tbxSenha" id="tbxSenha"
                                                                                           placeholder="***********"
                                                                                           class="input-login"
                                                                                           TextMode="Password"></input>
            </div>
        </div>

        <div class="cada-input checkbox">
            <label class="">
                <input type="checkbox" ID="cbxManter"/>
                Mantenha-me contectado.
            </label>
        </div>

        <div class="cada-input ">
            <input type="submit" ID="btnEntrar" class="entrar-login" value="Entrar"/>
        </div>

        <label ID="lblMensagem" Text=""
               class="mensagem-erro"><?php if (isset($error_message)) echo $error_message; ?></label>
    </div>
</section>

<footer class="rodape-login" style="display: none;">
    Tela de login | L8 Agência - © 2014<br>
    Todos os direitos reservados
</footer>


<!-- Javascript Libraries -->
<!-- jQuery -->
<script src="<?php echo CLOUDFRONT ?>superadmin/js/jquery.min.js"></script> <!-- jQuery Library -->

<!-- Bootstrap -->
<script src="<?php echo CLOUDFRONT ?>superadmin/js/bootstrap.min.js"></script>

<!--  Form Related -->
<script src="<?php echo CLOUDFRONT ?>superadmin/js/icheck.js"></script> <!-- Custom Checkbox + Radio -->

<!-- All JS functions -->
<script src="<?php echo CLOUDFRONT ?>superadmin/js/functions.js"></script>
</body>
</html>
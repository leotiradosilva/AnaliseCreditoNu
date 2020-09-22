<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//PT"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
       <?php
    if (!empty($css)) {
        foreach ($css as $cada) {
            echo '<link href="' . $cada . '" rel="stylesheet" />';
        }
    }
    ?>
    <title>Fmisa</title>

    <meta name="description" content="Sistemas"/>
    <meta name="keywords" content="Sistemas, online"/>
    <meta name="robots" content="index, follow"/>
    <meta name="copyright" content="L8 Agência"/>
    <meta name="language" content="PT-br"/>
    <meta name="author" content="L8 Agência"/>

    <meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no"/>

    <link href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- CSS -->
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/form.css?v=<?= time(); ?>" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/calendar.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/style.css?v=<?= time(); ?>" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/icons.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/generics.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/fonte/avenir/avenir.css" rel="stylesheet">

 

</head>
<body id="skin-blur-ocean" class="body-sistema">

<? include('svg.php') ?>

<header id="header" class="media m-t-0">
    <a id="menu-toggle"></a>
    <a class="logo pull-left"
       href="<?php echo($this->session->usuario['grupo'] == 1 ? site_url("principal") : site_url("principal/comissao")) ?>">
        <img src="<?php echo CLOUDFRONT ?>imagem/logo/fmi.svg"/>
    </a>

    <div class="media-body">
        <div class="media" id="top-menu">
            <!-- <div class="pull-left tm-icon">
                 <a data-drawer="messages" class="drawer-toggle" href="">
                     <i class="sa-top-message"></i>
                     <i class="n-count animated">5</i>
                     <span>Messages</span>
                 </a>
             </div>
             <div class="pull-left tm-icon">
                 <a data-drawer="notifications" class="drawer-toggle" href="">
                     <i class="sa-top-updates"></i>
                     <i class="n-count animated">9</i>
                     <span>Updates</span>
                 </a>
             </div>-->

            <div id="time" class="pull-right">

                <div class="btn-group pull-right">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                        <?php echo Nome($this->session->usuario['nome']); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <?php if ($this->session->usuario['grupo'] == 1)
                            echo '<li>' .
                                anchor('usuario', '<i class="fa fa-cogs"></i> Configuração', array('class' => 'trasicao')) .
                                '</li>';
                        ?>
                        <li>
                            <?php echo anchor('usuario/meu_perfil', '<i class="fa fa-user"></i> Meu Perfil') ?>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <?php echo anchor('login/sair', '<i class="fa fa-sign-out"></i> Sair') ?>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
</header>

<section id="main" class="p-relative" role="main">

    <!-- Sidebar -->
    <aside id="sidebar">

        <!-- Side Menu -->
        <ul class="list-unstyled side-menu">

           <!-- <li>
                <a href="">
                    <svg>
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#home"></use>
                    </svg>
                </a>
            </li>-->
            <li class="">
                <?php echo($this->session->usuario['grupo'] == 1 ? anchor('principal', '<span class="menu-item">Página Inicial</span>',
                    array('class' => 'trasicao sa-side-home')) : anchor('principal/comissao', '<span class="menu-item">Página Inicial</span>',
                    array('class' => 'trasicao sa-side-home'))) ?>
            </li>
            <li class="dropdown">
                <a class="sa-side-cog" href="">
                    <span class="menu-item">Geral</span>
                </a>
                <ul class="list-unstyled menu-item">
                    <li id="liConsultaUsuario" visible="false">
                        <?php
                        echo anchor('usuario', 'Usuários', array('class' => 'trasicao'));
                        ?>
                    </li>
                    <?php if ($this->session->userdata('usuario')['grupo'] == 1) { ?>
                        <li id="liConsultaUsuario" visible="false">
                            <?php
                            echo anchor('principal/historico_usuario', 'Acesso Usuário', array('class' => 'trasicao'));
                            ?>
                        </li>
                        <li id="liConsultaUsuario" visible="false">
                            <?php
                            echo anchor('principal/comissao', 'Comissão Usuário', array('class' => 'trasicao'));
                            ?>
                        </li>
                    <?php } ?>
                </ul>
            </li>

            <?php

            //print_r($this->session->userdata('usuario')['grupo']);
            if($this->session->userdata('usuario')['grupo'] == 1)
                $resgates = $this->db->where('dataresgatado_resg is null')->join('subscricao', 'subscricao.codigo_subs = resgate.codigo_subs')->join('pessoa', 'pessoa.codigo_pes = subscricao.codigo_pes')->where('ativo_resg', 1)->where('ativo_subs', 1)->where('ativo_pes', 1)->from('resgate')->get()->result();
            else
                $resgates = $this->db->where('dataresgatado_resg is null')->join('subscricao', 'subscricao.codigo_subs = resgate.codigo_subs')->join('pessoa', 'pessoa.codigo_pes = subscricao.codigo_pes')->join('usuario_ve_pessoa', 'usuario_ve_pessoa.codigo_pes = pessoa.codigo_pes')->where('usuario_ve_pessoa.codigo_usu', $this->session->userdata('usuario')['codigo'])->where('ativo_resg', 1)->where('ativo_subs', 1)->where('ativo_pes', 1)->from('resgate')->get()->result();


            ?>

            <li class="dropdown">
                <a class="sa-side-savings" href="">
                    <?= (!empty($resgates) ? '<span class=\'badge\' style="border-radius: 100px !important; float:right;">' . count($resgates) . '</span>' : '') ?>
                    <span class="menu-item">Investimentos</span>
                </a>
                <ul class="list-unstyled menu-item">
                    <li id="liConsultaApartamento" visible="false">
                        <?php echo anchor('subscricao', 'Investimentos', array('class' => 'trasicao')); ?>
                    </li>
                    <li id="liConsultaCampanha" visible="false">
                        <?php echo anchor('resgate', 'Resgates' . (!empty($resgates) ? '<span class=\'badge\' style="border-radius: 100px !important; float:right;">' . count($resgates) . '</span>' : ''), array('class' => 'trasicao')); ?>
                    </li>
                    <li id="liConsultaCampanha" visible="false">
                        <?php echo anchor('irenda', 'IR Recolhido', array('class' => 'trasicao')); ?>
                    </li>
                    <li id="liConsultaApartamento" visible="false">
                        <?php echo anchor('pessoa', 'Clientes', array('class' => 'trasicao')); ?>
                    </li>
                </ul>
            </li>

            <li class="">
                <?php echo anchor('indicador', '<span class="menu-item">Indicadores</span>',
                    array('class' => 'trasicao sa-side-information')); ?>
            </li>
            <li class="">
                <?php echo anchor('mensagem', '<span class="menu-item">Mensagem</span>',
                    array('class' => 'trasicao sa-side-message')); ?>
            </li>

            <?php

            $tarefas = $this->db->where('data_tar <= ', date('Y-m-d'))->where('codigo_usu', $this->session->userdata('usuario')['codigo'])->where('ativo_tar', 1)->where('concluido_tar is null')->from('tarefa')->get()->result();

            ?>


            <li class="">
                <?php echo anchor('tarefa', (!empty($tarefas) ? '<span class=\'badge\' style="border-radius: 100px !important; float:right;">' . count($tarefas) . '</span>' : '') . '<span class="menu-item">Tarefa</span>',
                    array('class' => 'trasicao sa-side-calendar2')); ?>
            </li>
        </ul>

    </aside>
    <input type="hidden" id="base_url" value="<?=base_url()?>">
    <!-- Content -->
    <section id="content" class="container">



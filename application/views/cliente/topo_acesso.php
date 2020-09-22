<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//PT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
    <title>Fmisa</title>

    <meta name="description" content="Sistemas" />
    <meta name="keywords" content="Sistemas, online" />
    <meta name="robots" content="index, follow" />
    <meta name="copyright" content="L8 Agência" />
    <meta name="language" content="PT-br" />
    <meta name="author" content="L8 Agência" />

    <meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no" />

    <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/fonte/fontawesome/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/fonte/avenir/avenir.css?v=1" rel="stylesheet">

    <!-- CSS -->
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/form.css?v=<?= time(); ?>" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/calendar.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/style.css?v=<?= time(); ?>" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/icons.css" rel="stylesheet">
    <link href="<?php echo CLOUDFRONT; ?>superadmin/css/generics.css?v=<?= time(); ?>" rel="stylesheet">

    <?php
        if(!empty($css))
        {
            foreach($css as $cada){
                echo '<link href="'.$cada.'" rel="stylesheet" />';
            }
        }   
    ?>

    <style type="text/css">
        .link:hover {
            text-decoration: underline;
        }
    </style>

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
                    <?php echo anchor('acesso/sair', '<i class="fa fa-sign-out"></i> Sair', array('class'=>"btn dropdown-toggle"))?>
                </div>

                <?php
                    if(!empty($page))
                    {
                        echo '<div class="btn-group pull-right hidden-xs">
								 <a class="btn onclick="mudarHome(\''.$page.'\')">Definir como Home Page</a>
							  </div>';
                    }
                ?>
            </div>

        </div>
    </div>
</header>

<?php

$subscricoes = $this->mod->buscarSubscricaoCalculada($this->session->aluno['codigo']);
//var_dump($subscricoes);exit;
//$subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);

$saldoTotalCliente = 0;
$ind = 0;
$arrayRendimento = array();
$arraySaldo = array();
$htmlsub = "";
$totalAll = 0;

if(!empty($subscricoes))
	$totalAll = $subscricoes->totalLiquido;

$mensagens = $this->db->where('codigo_pes',$this->session->userdata('aluno')['codigo'])->where('ativo_mes',1)->where('view_mes',1)->where('datalido_mes',null)->get('mensagem')->result();
$agendas = $this->db->where('codigo_pes',$this->session->userdata('aluno')['codigo'])->where('ativo_age',1)->where('data_age',date('Y-m-d'))->where('concluido_age',null)->get('agenda')->result();
?>

<section id="main" class="p-relative" role="main">

    <!-- Sidebar -->
    <aside id="sidebar">

        <!-- Side Menu -->
        <ul class="list-unstyled side-menu">
            <li class="">
                <?php echo anchor('acesso/home', '<span class="menu-item">Resumo Financeiro</span>',
                    array('class'=> 'trasicao sa-side-home')); ?>
            </li>
            <li class="dropdown">
                <a class="sa-side-cog" href="">
                    <span class="menu-item">Configurações</span>
                </a>
                <ul class="list-unstyled menu-item">
                    <li class="menu-acesso" data-menu=".meu-perfil" visible="false">
                        <a href="<?php echo site_url("acesso/meus_dados") ?>" class="">Meus Dados</a>
                    </li>
                    <!--<li class="menu-acesso" visible="false">
                        <a href="meu_perfil" class="">Editar Meu Perfil</a>
                    </li>-->
                </ul>
            </li>

            <li class="dropdown">
                <a class="sa-side-savings" href="">
                    <span class="menu-item">Financeiro</span>
                </a>
                <ul class="list-unstyled menu-item">
                    <li class="menu-acesso" >
                        <a href="<?php echo site_url("acesso/subscricao") ?>">Investimentos</a>
                    </li>
                    <li class="menu-acesso" >
                        <a href="<?php echo site_url("acesso/resgate") ?>">Resgates</a>
                    </li>
                    <li class="menu-acesso" >
                        <a href="<?php echo site_url("acesso/saldo") ?>">Detalhado</a>
                    </li>
                </ul>
            </li>

            <?php $subscricoes = $this->mod->buscaSubscricaoPendente($this->session->aluno['codigo']); ?>

            <li class="">
                <?php echo anchor('acesso/indicadores', '<span class="menu-item">Indicadores</span>',
                    array('class'=> 'trasicao sa-side-information')); ?>
            </li>
            <li class="">
                <?php echo anchor('acesso/digital', (!empty($subscricoes) ? '<span class=\'badge\' style="border-radius: 100px !important; float:right;">'.count($subscricoes).'</span>' : '').'<span class="menu-item">Investimento Digital</span>',
                    array('class'=> 'trasicao sa-side-coin'));  ?>
            </li>
			<?php
			if(!$this->mobile_detect->isiOS()){
			?>
			<li class="">
                <?php echo anchor('#', '<span class="menu-item">Aviso de Investimento</span>',
                    array('class'=> 'trasicao sa-side-plus', 'id'=>'menu-subscricao', 'onclick'=>'modalAgendarSubscricao()'));  ?>
            </li>
			<?php
			}
            ?>
            <li class="">
                <?php echo anchor('#', '<span class="menu-item">Solicitar Resgate</span>',
                    array('class'=> 'trasicao sa-side-minus', 'id'=>'menu-resgata', 'onclick'=>'modalResgate(\'\',\'' . formata_moeda($totalAll) . '\')')); ?>
            </li>
            <li class="">
                <?php echo anchor('acesso/mensagens', (!empty($mensagens) ? '<span class=\'badge\' style="border-radius: 100px !important; float:right;">'.count($mensagens).'</span>' : '').'<span class=\'menu-item\'>Mensagens</span>',
                    array('class'=> 'trasicao sa-side-message')); ?>
            </li>
            <li class="">
                <?php echo anchor('acesso/agenda', (!empty($agendas) ? '<span class=\'badge\' style="border-radius: 100px !important; float:right;">'.count($agendas).'</span>' : '').'<span class=\'menu-item\'>Agendas</span>',
                    array('class'=> 'trasicao sa-side-calendar2')); ?>
            </li>
        </ul>

    </aside>
    <input type="hidden" id="base_url" value="<?= base_url(); ?>">

    <!-- Content -->
    <section id="content" class="container">


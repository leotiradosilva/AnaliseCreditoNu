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
    <link href="<?php echo CLOUDFRONT; ?>css/tablesorter/css/filter.formatter.min.css" rel="stylesheet">
    

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
        @media (max-width: 770px) {
            .link-tipo-subs span::before {
                content: "\A";
                white-space: pre;
            }
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
                    <?php echo anchor('login_cliente/sair', '<i class="fa fa-sign-out"></i> Sair', array('class'=>"btn dropdown-toggle"))?>
                </div>

                <?php
                    if(!empty($page))
                    {
                        echo '<div class="btn-group pull-right hidden-xs">
								 <a class="btn" onclick="mudarHome(\''.$page.'\')">Definir como Home Page!</a>
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

/*
if(!empty($subscricoes))
{
    $totalAll = 0;
    $totalAllBruto = 0;
    $totalSubscricao = 0;
    $totalRendimento= 0;
    $totalResgates= 0;
    $totalAllRendimentoBruto = 0;
    foreach ($subscricoes as $key => $cada) {
        $rendimentoscalculabruto = $this->mod->buscarRendimentoMes($cada->codigo_subs, date("Y-m-01"), date("Y-m-31"));
        $rendimentobrutonovo = 0;
        $totalLiq = 0;
        $totalBruto = 0;

        if ($cada->datainiciocalculo == $cada->data_subs)
        {
            $rendimentoscalculabruto = $this->mod->buscarRendimentoNaoReinveste($cada->codigo_subs, $cada->datainiciocalculo);
            $resgatesSolicitados = $this->mod->buscarResgatesSolicitadosBruto($cada->codigo_subs, date("Y-m-01"), date("Y-m-31"));

            $totalInicio = $cada->valor_subs;
            $totalInicioBruto = $totalInicio;
            $cont = 0;

            foreach ($rendimentoscalculabruto as $keybr => $cadabr)
            {
                if(!empty($resgatesSolicitados) && $resgatesSolicitados[0]->dataresgatado_resg == $cadabr->data_rend)
                {
                    $cadaresg = array_shift($resgatesSolicitados);
                    $anttotalinicio = $totalInicio;
                    $anttotaliniciobruto = $totalInicioBruto;
                    $totalInicio -= $cadaresg->valor_resg;
                    $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;
                }

                $totalInicio += $cadabr->valor_rend;
                if($cadabr->ultimodia <= 180)
                {
                    $totalInicioBruto += $cadabr->valor_rend / 0.775;
                }
                elseif($cadabr->ultimodia >= 181 && $cadabr->ultimodia <= 360)
                {
                    $totalInicioBruto += $cadabr->valor_rend / 0.8;
                }
                elseif($cadabr->ultimodia >= 361 && $cadabr->ultimodia <= 720)
                {
                    $totalInicioBruto += $cadabr->valor_rend / 0.825;
                }
                elseif($cadabr->ultimodia >= 721)
                {
                    $totalInicioBruto += $cadabr->valor_rend / 0.85;
                }
            }

            if(!empty($resgatesSolicitados) && strtotime($resgatesSolicitados[0]->dataresgatado_resg) <= strtotime(date('Y-m-d')))
            {
                $cadaresg = array_shift($resgatesSolicitados);
                $anttotalinicio = $totalInicio;
                $anttotaliniciobruto = $totalInicioBruto;

                $totalInicio -= $cadaresg->valor_resg;

                $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;
            }

            if($totalInicio >= -0.01 && $totalInicio <= 0.01)
            {
                $totalInicioBruto = 0;
            }

            $totalrendimento = $totalInicio;
            $totalrendimentoBruto = $totalInicioBruto;
        }
        else
        {
            if($cada->ultimodia <= 180)
            {
                $rendimentobrutonovo = $cada->rendimentomesatual / 0.775;
            }
            elseif($cada->ultimodia >= 181 && $cada->ultimodia <= 360)
            {
                $rendimentobrutonovo = $cada->rendimentomesatual / 0.8;
            }
            elseif($cada->ultimodia >= 361 && $cada->ultimodia <= 720)
            {
                $rendimentobrutonovo = $cada->rendimentomesatual / 0.825;
            }
            elseif($cada->ultimodia >= 721)
            {
                $rendimentobrutonovo = $cada->rendimentomesatual / 0.85;
            }

            $diferencamesfixbruto = $rendimentobrutonovo - $cada->rendimentomesatual;
            $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;

            if($totalrendimento >= -0.01 && $totalrendimento <= 0.01)
            {
                $totalrendimentoBruto = 0;
            }
            else
                $totalrendimentoBruto = $totalrendimento + $diferencamesfixbruto;
        }

        $dtultimo = splitData($cada->ultimo);

        if($dtultimo['month'] == date('m') && $dtultimo['year'] == date("Y"))
        {
            $totalAll += $totalrendimento;
            $totalAllBruto += $totalrendimentoBruto;
        }
        else
        {
            $totalrendimento = 0; $totalrendimentoBruto = 0;
        }

        $totalSubscricao += $cada->valor_subs;
        $totalRendimento += $cada->rendimento;
        $totalResgates += $cada->resgate;
        $saldoTotalCliente += $totalrendimento;
        $totalAllRendimentoBruto += $cada->rendimentobruto;
    }
} */

$mensagens = $this->db->where('codigo_pes',$this->session->userdata('aluno')['codigo'])->where('ativo_mes',1)->where('view_mes',1)->where('datalido_mes',null)->get('mensagem')->result();
$agendas = $this->db->where('codigo_pes',$this->session->userdata('aluno')['codigo'])->where('ativo_age',1)->where('data_age',date('Y-m-d'))->where('concluido_age',null)->get('agenda')->result();
?>

<section id="main" class="p-relative" role="main">

    <!-- Sidebar -->
    <aside id="sidebar">

        <!-- Side Menu -->
        <ul class="list-unstyled side-menu">
            <li class="">
                <?php echo anchor('cliente/home', '<span class="menu-item">Resumo Financeiro</span>',
                    array('class'=> 'trasicao sa-side-home')); ?>
            </li>
            <li class="dropdown">
                <a class="sa-side-cog" href="<?php echo site_url("cliente/meus_dados") ?>">
                    <span class="menu-item">Configurações</span>
                </a>
                <ul class="list-unstyled menu-item">
                    <li class="menu-acesso" data-menu=".meu-perfil" visible="false">
                        <a href="<?php echo site_url("cliente/meus_dados") ?>" class="">Meus Dados</a>
                    </li>
                    <!--<li class="menu-acesso" visible="false">
                        <a href="meu_perfil" class="">Editar Meu Perfil</a>
                    </li>-->
                </ul>
            </li>

            <li class="dropdown">
                <a class="sa-side-savings" href="<?php echo site_url("cliente/investimentos") ?>">
                    <span class="menu-item">Financeiro</span>
                </a>
                <ul class="list-unstyled menu-item">
                    <li class="menu-acesso" >
                        <a href="<?php echo site_url("cliente/investimentos") ?>">Investimentos</a>
                    </li>
                    <li class="menu-acesso" >
                        <a href="<?php echo site_url("cliente/investimentos/resgate") ?>">Resgates</a>
                    </li>
                    <li class="menu-acesso" >
                        <a href="<?php echo site_url("cliente/investimentos/saldo") ?>">Detalhado</a>
                    </li>
                </ul>
            </li>

            <?php $subscricoes_tipo_1 = $this->mod->buscaSubscricaoPendente($this->session->aluno['codigo'], 1); ?>
            <?php $subscricoes_tipo_2 = $this->mod->buscaSubscricaoPendente($this->session->aluno['codigo'], 2); ?>

            <li class="">
                <?php echo anchor('cliente/indicadores', '<span class="menu-item">Indicadores</span>',
                    array('class'=> 'trasicao sa-side-information')); ?>
            </li>

            <li class="dropdown">
                
                <a class="trasicao sa-side-coin" href="<?php echo site_url("cliente/investimentos") ?>">
                    <?= (!empty($subscricoes_tipo_1) || !empty($subscricoes_tipo_2) ? '<span class=\'badge\' style="float: right; background: green !important; border-radius: 100px !important;">!</span>' : '') ?>
                    <span class="menu-item">INVESTIMENTOS</span>
                </a>
                <ul class="list-unstyled menu-item">

                    <li class="menu-acesso" >                        
                        <a class="link-tipo-subs" href="<?php echo site_url("cliente/investimentos/digital/1") ?>">
                            Nova Subscrição <span>(Deb 90 dias)</span> 
                            <?= (!empty($subscricoes_tipo_1) ? '<span class=\'badge\' style="float: right; background: white !important; color: #22a1d6 !important; border-radius: 100px !important; margin: -2px 0 0 5px;">'.count($subscricoes_tipo_1).'</span>' : '') ?>
                        </a>
                    </li>
                    <li class="menu-acesso" >
                        <a class="link-tipo-subs" href="<?php echo site_url("cliente/investimentos/digital/2") ?>">
                            Nova Subscrição <span>(Deb 360 dias)</span>
                            <?= (!empty($subscricoes_tipo_2) ? '<span class=\'badge\' style="float: right; background: white !important; color: #22a1d6 !important; border-radius: 100px !important; margin: -2px 0 0 5px;">'.count($subscricoes_tipo_2).'</span>' : '') ?>                            
                        </a>
                    </li>
                </ul>
            </li>

			<?php
			if(!$this->mobile_detect->isiOS()){
			?>
            <li class="">
                <a href="javascript:;" class="trasicao sa-side-plus" id="menu-subscricao" onclick="modalAgendarSubscricao()">

                    <span class="menu-item">Aviso de Investimento</span>

                </a>
            </li>
			<?php
			}
			?>
            <li class="">

                <a href="javascript:;" class="trasicao sa-side-minus" id="menu-resgata" onclick="modalResgate('', <?= formata_moeda($totalAll) ?>)">

                    <span class="menu-item">Solicitar Resgate</span>

                </a>

            </li>
            <li class="">
                <?php echo anchor('cliente/mensagens', (!empty($mensagens) ? '<span class=\'badge\' style="border-radius: 100px !important; float:right;">'.count($mensagens).'</span>' : '').'<span class=\'menu-item\'>Mensagens</span>',
                    array('class'=> 'trasicao sa-side-message')); ?>
            </li>
            <li class="">
                <?php echo anchor('cliente/minha_agenda', (!empty($agendas) ? '<span class=\'badge\' style="border-radius: 100px !important; float:right;">'.count($agendas).'</span>' : '').'<span class=\'menu-item\'>Agendas</span>',
                    array('class'=> 'trasicao sa-side-calendar2')); ?>
            </li>
        </ul>

    </aside>
    <input type="hidden" id="base_url" value="<?= base_url(); ?>">

    <!-- Content -->
    <section id="content" class="container">


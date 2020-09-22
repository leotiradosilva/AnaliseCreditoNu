<?php
/**
 * Created by PhpStorm.
 * User: richa
 * Date: 20/01/2017
 * Time: 15:06
 */
if($operacao == "c")

    //----------------------------------------- Consulta --------------------------------------------------
{ ?>
    <h4 class="page-title clearfix ">
        <span class="pull-left m-t-10">Investimentos</span>

        <div class="pull-right">
            <!--<a href="add" role="button" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>-->
            <?php echo ($permissao->inserir ? anchor('subscricao/add', '<i class="fa fa-plus"></i> Adicionar', array('class'=> 'btn btn-primary novo-registro')) : "")." ".
                ($permissao->inserir ? anchor('subscricao/addRetroativo', '<i class="fa fa-plus"></i> Retroativo', array('class'=> 'btn btn-primary novo-registro')) : "")." ".
                ($permissao->alterar ? form_button('', '<i class="fa fa-print"></i> Imprimir', array('class'=> 'printS btn btn-primary ')) : "")." ".
                ($permissao->alterar ? form_button('', '<i class="fa fa-file-excel-o"></i> Exportar', array('class'=> 'downloadcsv btn btn-primary ')) : "")?>
        </div>
    </h4>
    <style>
        .loader {
            position: absolute;
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50% !important;
            width: 120px;
            height: 120px;
            top: 45%;
            left: 45%;
            animation: spin 2s linear infinite;
            z-index: 5;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <div class="block-area">
        <div class="loader" style="display: none;"></div>
        <div id="divDados" class="div-dados clearfix">
            <?php
            //Cabecalho da tabela
            $total = 0;
            $linhas = '<table class="tile table table-bordered table-striped2 tablesorter" id="table">
					<thead>
					    <tr>
					        <th colspan="9"></th>
					        <th colspan="4">Filtro: <input type="text" id="filterTable" class="form-control input1" onblur="filterTable(this)"></th>
                        </tr>
						<tr>
							<th data-name="Código" data-placeholder="Filtrar Código" >Código</th>
							<th data-name="Data" data-date-format="ddmmyyyy" data-placeholder="Filtrar Data" >Data</th>
							<th data-name="Vencimento" data-date-format="ddmmyyyy" data-placeholder="Filtrar Vencimento" >Vencimento</th>
							<th data-name="Cliente" data-placeholder="Filtrar Cliente" >Cliente</th>
							<th data-name="CPF/CNPJ" data-placeholder="Filtrar CPF/CNPJ" >CPF/CNPJ</th>
							<th data-name="Taxa" data-placeholder="Filtrar Taxa" >Taxa</th>
							<th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial" >Valor Inicial</th>
							<th data-name="Valor Atual" data-placeholder="Filtrar Valor Atual" >Valor Atual</th>
							<th data-name="Valor Atual" data-placeholder="Filtrar Valor Atual" >Valor Bruto</th>
							<th data-name="Rendimento" data-placeholder="Filtrar Rendimento" >Rendimento</th>
							<th data-name="Tipo" data-placeholder="Filtrar Tipo" >Tipo</th>
							<th data-name="Status" data-placeholder="Filtrar Status" >Status</th>
							<th data-name="Ação" data-sorter="false" class="m-w-155 columnSelector-false filter-false sorter-false sorter-false sumir-impressao inviPrint">A&ccedil;&atilde;o</th>
						</tr>
					</thead><tbody>';

            $totalAll = 0;
            $totalAllBruto = 0;
            $totalSubscricao = 0;
            $totalRendimento= 0;
            $totalResgates= 0;
            $totalCupom= 0;
            $totalSolicitado= 0;
            $totalAllRendimentoBruto = 0;

            foreach ($dados as $cada){

//            	$subsCalc = $this->mod->buscarSubscricaoCalculada($cada['codigo_subs']);


               /* $subs = $this->mod->buscarRendimento($cada['codigo_subs']);

                if(!empty($subs))
                {
                    $totalrendimento = $subs->valor_subs + $subs->rendimento - $subs->resgate;
                }
                else
                {
                    $totalrendimento = $cada['valor_subs'];
                }

                //------------------------------------------------------
                //$dadosGraph = $controller->dadosGraficos($cada->codigo_subs);
                $rendimentoscalculabruto = $this->mod->buscarRendimentoMes($cada['codigo_subs'], date("Y-m-01"), date("Y-m-31"));


                $rendimentobrutonovo = 0;
                $totalLiq = 0;
                $totalBruto = 0;

                if ($cada['datainiciocalculo'] == $cada['data_subs'])
                {

                    $rendimentoscalculabruto = $this->mod->buscarRendimentoNaoReinveste($cada['codigo_subs'], $cada['datainiciocalculo']);
                    $resgatesSolicitados = $this->mod->buscarResgatesSolicitadosBruto($cada['codigo_subs'], date("Y-m-01"), date("Y-m-31"));

                    $totalInicio = $cada['valor_subs'];
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

                            //$totalAllRendimentoBruto += $totalInicioBruto;



                        }


                        $totalInicio += $cadabr->valor_rend;
                        if($cadabr->ultimodia <= 180)
                        {
                            $totalInicioBruto += $cadabr->valor_rend / 0.775;
                            $totalAllRendimentoBruto += $cadabr->valor_rend / 0.775;
                        }
                        elseif($cadabr->ultimodia >= 181 && $cadabr->ultimodia <= 360)
                        {
                            $totalInicioBruto += $cadabr->valor_rend / 0.8;
                            $totalAllRendimentoBruto += $cadabr->valor_rend / 0.8;
                        }
                        elseif($cadabr->ultimodia >= 361 && $cadabr->ultimodia <= 720)
                        {
                            $totalInicioBruto += $cadabr->valor_rend / 0.825;
                            $totalAllRendimentoBruto += $cadabr->valor_rend / 0.825;
                        }
                        elseif($cadabr->ultimodia >= 721)
                        {
                            $totalInicioBruto += $cadabr->valor_rend / 0.85;
                            $totalAllRendimentoBruto += $cadabr->valor_rend / 0.85;
                        }

                    }
                    if(!empty($resgatesSolicitados) && strtotime($resgatesSolicitados[0]->dataresgatado_resg) <= strtotime(date('Y-m-d')))// && $resgatesSolicitados[0]->dataresgatado_resg == date('Y-m-d')
                    {
                        $cadaresg = array_shift($resgatesSolicitados);
                        $anttotalinicio = $totalInicio;
                        $anttotaliniciobruto = $totalInicioBruto;

                        $totalInicio -= $cadaresg->valor_resg;

                        $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;

                        //$totalAllRendimentoBruto += $totalInicioBruto;

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
                    if($cada['ultimodia'] <= 180)
                    {
                        $rendimentobrutonovo = $cada['rendimentomesatual'] / 0.775;
                        //$totalAllRendimentoBruto += $cada['rendimentomesatual'] / 0.775;

                    }
                    elseif($cada['ultimodia'] >= 181 && $cada['ultimodia'] <= 360)
                    {
                        $rendimentobrutonovo = $cada['rendimentomesatual'] / 0.8;
                        // $totalAllRendimentoBruto += $cada['rendimentomesatual'] / 0.8;

                    }
                    elseif($cada['ultimodia'] >= 361 && $cada['ultimodia'] <= 720)
                    {
                        $rendimentobrutonovo = $cada['rendimentomesatual'] / 0.825;
                        //$totalAllRendimentoBruto += $cada['rendimentomesatual'] / 0.825;

                    }
                    elseif($cada['ultimodia'] >= 721)
                    {
                        $rendimentobrutonovo = $cada['rendimentomesatual'] / 0.85;
                        //$totalAllRendimentoBruto += $cada['rendimentomesatual'] / 0.85;

                    }

                    $diferencamesfixbruto = $rendimentobrutonovo - $cada['rendimentomesatual'];


                    $totalrendimento = $cada['valor_subs'] + $cada['rendimento'] - $cada['resgate'];
                    $totalAllRendimentoBruto += $rendimentobrutonovo;

                    if($totalrendimento >= -0.01 && $totalrendimento <= 0.01)
                    {
                        $totalrendimentoBruto = 0;
                    }
                    else
                    {
                        $totalrendimentoBruto = $totalrendimento + $diferencamesfixbruto    ;
                    }
                }

                $dtultimo = splitData($cada['ultimo']);



                if($dtultimo['month'] == date('m') && $dtultimo['year'] == date("Y"))
                {
                    $totalAll += $totalrendimento;
                    $totalAllBruto += $totalrendimentoBruto;
                }
                else
                {
                    $totalrendimento = 0; $totalrendimentoBruto = 0;
                }
				*/




                //-----------------------------------------------------------------------------


                //$editar = '<a href="edit/'.$apto['codigo_apto'].'" class="btn sumir-responsivo btn-default btn-acao-tabela invi" title="Editar"><i class="fa fa-edit"></i></a> ';
                //$excluir = '<a href="Javascript: Inativar(\''.$codigo.'\', \''.$nome.'\')" class="btn sumir-responsivo btn-default btn-acao-tabela inativar invi" title="Excluir"><i class="fa fa-trash-o"></i></a> ';

                $linhas .= '<tr class="" >
											<td class=" hover-data" >'.($cada['codigo_subs']).'</td>
											<td class=" hover-data" >'.Mysql_to_Data($cada['data_subs']).'</td>
											<td class=" hover-data" >'.Mysql_to_Data($cada['vencimento_subs']).'</td>
											<td class=" hover-data" >'.$cada['nome_pes'].'</td>
											<td class=" hover-data" >'.($cada['tipo_pes'] ? $cada['cnpj_pes'] : $cada['cpf_pes']).'</td>
											<td class=" hover-data" >'.formata_cupom($cada['taxa_subs']).'</td>
											<td class=" " >'.formata_moeda($cada['valor_subs']).'</td>
											<td class=" " >'.formata_moeda($cada['total_liquito']).'</td>
											<td class=" " >'.formata_moeda($cada['total_bruto']).'</td>
											<td class=" " >'.($cada['rendimento_subs'] == 0 ? "Resgatar Mensalmente" : "Reinvestir" ).'</td>
											<td class=" " >'.($cada['codigo_subs'] ? $cada['descricao_tipo'] : $cada['codigo_subs']).'</td>
											<td class=" " >'.(!empty($cada['contabiliza_subs']) ? "Inativo desde ".Mysql_to_Data($cada['contabiliza_subs']) : "Ativo" ).'</td>
											
											<td class=" sumir-impressao inviPrint">'.($permissao->alterar ? anchor("subscricao/edit/".base64_encode($cada['codigo_subs']), '<i class="fa fa-edit"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Editar')) : "")." ".
                                                            ($permissao->alterar && empty($cada['contabiliza_subs']) ? anchor("subscricao/recalcular/".base64_encode($cada['codigo_subs']), '<i class="fa fa-refresh"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Recalcular')) : "")." ".
                                                            ($permissao->detalhar ? anchor("subscricao/detail/".base64_encode($cada['codigo_subs']), '<i class="fa fa-plus-circle"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Detalhar')) : "")." ".
                                                            ($permissao->excluir && empty($cada['contabiliza_subs']) ? form_button(array('name'=>'btnInativar', 'content'=>'<i class="fa fa-times"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Inativar', 'onClick'=>'inativarSubscricao('.$cada['codigo_subs'].','.($cada['total_liquito']).')')) : "").
                                                            ($permissao->excluir ? form_button(array('name'=>'btnExcluir', 'content'=>'<i class="fa fa-trash-o"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Excluir', 'onClick'=>'inativar('.$cada['codigo_subs'].')')) : "").'</td>

										</tr>';

                $total += 1;

            }


            $linhas .= '</tbody></table>';
            $linhas .= '<div class="pager"> <span class="left">
                                Mostrar:
                                <a onclick="altQtd(25)" class="current">25</a>
                                <a onclick="altQtd(50)">50</a>
                                <a onclick="altQtd(100)">100</a>
                            </span>
                            <span class="center">
                                Total de Registros: '.$countTotal['total'].'
                            </span>
                             <span class="right">
                                    <span class="prev" onclick="antPage()">
                                        <img src="'.CLOUDFRONT.'tablesorter/css/images/prev.png'.'" /> Ant&nbsp;
                                    </span>
                             <span class="pagecount"></span>
                             &nbsp;<span class="next" onclick="proxPage()">Prox 
                                        <img src="'.CLOUDFRONT.'tablesorter/css/images/next.png'.'" /> 
                                    </span>
                            </span>
                        </div>';
            /*<tr>
                <td colspan="7"><center>Total de Dados: ' . $total . '</center></td>
            </tr>
                            </tfoot></table>';*/

            echo $linhas;
            ?>
        </div>

        <div id="dialog-confirm"></div>

        <div id="divMensagem"></div>

    </div>

    <!-- Div do fancybox de detalhes do conteudo -->
    <div id="divDetalhes" class="div-detalhes-agenda"></div>



    <div class="modal fade" id="modal-inativar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Inativar</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                  <!--  <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse p-l-0">Dados</h2>
                    </div>-->
                    <div class="tile tile-reverse">

                        <div class="form-group clearfix m-t-20">
                            <label class="col-md-3 control-label p-l-0 m-t-10">Data da Inativação: </label>
                            <div class="col-md-9">
                                <?php
                                $predata = ((date('Y-m-d')));

                                echo form_input(array('type' => 'text',
                                    'name' => 'contabiliza_subs',
                                    'id' => 'contabiliza_subs',
                                    'readonly' => '',
                                    'class' => 'form-control  input1',
                                    'value' => inverterdata(set_value("contabiliza_subs", $predata)))); ?>
                            </div>
                        </div>
                        <input type="hidden" id="codigo_subs" value="">
                        <input type="hidden" id="total_subs" value="">
                        <?php
                        echo '</div>';
                        ?>
                    </div>

                </div>

                <div class="modal-footer m-t-0">
                    <button type="button" class="btn btn-success btn-reverse" id="btnConfirmarInativar"> <i class="fa fa-check"></i> Confirmar</button>
                    <button type="button" class="btn btn-danger btn-reverse" data-dismiss="modal">  <i class="fa fa-times"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>

<?php }elseif($operacao == "ajaxSubscricao")
    //----------------------------------------- Consulta --------------------------------------------------
{

            $totalAll = 0;
            $totalAllBruto = 0;
            $totalSubscricao = 0;
            $totalRendimento= 0;
            $totalResgates= 0;
            $totalCupom= 0;
            $totalSolicitado= 0;
            $totalAllRendimentoBruto = 0;
            foreach ($dados as $cada){

				$subsCalc = $this->mod->buscarSubscricaoCalculada($cada['codigo_subs']);

               /* $subs = $this->mod->buscarRendimento($cada['codigo_subs']);

                if(!empty($subs))
                {
                    $totalrendimento = $subs->valor_subs + $subs->rendimento - $subs->resgate;
                }
                else
                {
                    $totalrendimento = $cada['valor_subs'];
                }

                //------------------------------------------------------
                //$dadosGraph = $controller->dadosGraficos($cada->codigo_subs);
                $rendimentoscalculabruto = $this->mod->buscarRendimentoMes($cada['codigo_subs'], date("Y-m-01"), date("Y-m-31"));


                $rendimentobrutonovo = 0;
                $totalLiq = 0;
                $totalBruto = 0;

                if ($cada['datainiciocalculo'] == $cada['data_subs'])
                {

                    $rendimentoscalculabruto = $this->mod->buscarRendimentoNaoReinveste($cada['codigo_subs'], $cada['datainiciocalculo']);
                    $resgatesSolicitados = $this->mod->buscarResgatesSolicitadosBruto($cada['codigo_subs'], date("Y-m-01"), date("Y-m-31"));

                    $totalInicio = $cada['valor_subs'];
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

                            //$totalAllRendimentoBruto += $totalInicioBruto;



                        }


                        $totalInicio += $cadabr->valor_rend;
                        if($cadabr->ultimodia <= 180)
                        {
                            $totalInicioBruto += $cadabr->valor_rend / 0.775;
                            $totalAllRendimentoBruto += $cadabr->valor_rend / 0.775;
                        }
                        elseif($cadabr->ultimodia >= 181 && $cadabr->ultimodia <= 360)
                        {
                            $totalInicioBruto += $cadabr->valor_rend / 0.8;
                            $totalAllRendimentoBruto += $cadabr->valor_rend / 0.8;
                        }
                        elseif($cadabr->ultimodia >= 361 && $cadabr->ultimodia <= 720)
                        {
                            $totalInicioBruto += $cadabr->valor_rend / 0.825;
                            $totalAllRendimentoBruto += $cadabr->valor_rend / 0.825;
                        }
                        elseif($cadabr->ultimodia >= 721)
                        {
                            $totalInicioBruto += $cadabr->valor_rend / 0.85;
                            $totalAllRendimentoBruto += $cadabr->valor_rend / 0.85;
                        }

                    }
                    if(!empty($resgatesSolicitados) && strtotime($resgatesSolicitados[0]->dataresgatado_resg) <= strtotime(date('Y-m-d')))// && $resgatesSolicitados[0]->dataresgatado_resg == date('Y-m-d')
                    {
                        $cadaresg = array_shift($resgatesSolicitados);
                        $anttotalinicio = $totalInicio;
                        $anttotaliniciobruto = $totalInicioBruto;

                        $totalInicio -= $cadaresg->valor_resg;

                        $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;

                        //$totalAllRendimentoBruto += $totalInicioBruto;

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
                    if($cada['ultimodia'] <= 180)
                    {
                        $rendimentobrutonovo = $cada['rendimentomesatual'] / 0.775;
                        //$totalAllRendimentoBruto += $cada['rendimentomesatual'] / 0.775;

                    }
                    elseif($cada['ultimodia'] >= 181 && $cada['ultimodia'] <= 360)
                    {
                        $rendimentobrutonovo = $cada['rendimentomesatual'] / 0.8;
                        // $totalAllRendimentoBruto += $cada['rendimentomesatual'] / 0.8;

                    }
                    elseif($cada['ultimodia'] >= 361 && $cada['ultimodia'] <= 720)
                    {
                        $rendimentobrutonovo = $cada['rendimentomesatual'] / 0.825;
                        //$totalAllRendimentoBruto += $cada['rendimentomesatual'] / 0.825;

                    }
                    elseif($cada['ultimodia'] >= 721)
                    {
                        $rendimentobrutonovo = $cada['rendimentomesatual'] / 0.85;
                        //$totalAllRendimentoBruto += $cada['rendimentomesatual'] / 0.85;

                    }

                    $diferencamesfixbruto = $rendimentobrutonovo - $cada['rendimentomesatual'];


                    $totalrendimento = $cada['valor_subs'] + $cada['rendimento'] - $cada['resgate'];
                    $totalAllRendimentoBruto += $rendimentobrutonovo;

                    if($totalrendimento >= -0.01 && $totalrendimento <= 0.01)
                    {
                        $totalrendimentoBruto = 0;
                    }
                    else
                    {
                        $totalrendimentoBruto = $totalrendimento + $diferencamesfixbruto    ;
                    }
                }

                $dtultimo = splitData($cada['ultimo']);



                if($dtultimo['month'] == date('m') && $dtultimo['year'] == date("Y"))
                {
                    $totalAll += $totalrendimento;
                    $totalAllBruto += $totalrendimentoBruto;
                }
                else
                {
                    $totalrendimento = 0; $totalrendimentoBruto = 0;
                } */


                echo '<tr class="" >
						<td class=" hover-data" >'.($cada['codigo_subs']).'</td>
						<td class=" hover-data" >'.Mysql_to_Data($cada['data_subs']).'</td>
						<td class=" hover-data" >'.Mysql_to_Data($cada['vencimento_subs']).'</td>
						<td class=" hover-data" >'.$cada['nome_pes'].'</td>
						<td class=" hover-data" >'.($cada['tipo_pes'] ? $cada['cnpj_pes'] : $cada['cpf_pes']).'</td>
						<td class=" hover-data" >'.formata_cupom($cada['taxa_subs']).'</td>
						<td class=" " >'.formata_moeda($cada['valor_subs']).'</td>
						<td class=" " >'.formata_moeda($subsCalc[0]['total_liquito']).'</td>
						<td class=" " >'.formata_moeda($subsCalc[0]['total_bruto']).'</td>
                        <td class=" " >'.($cada['rendimento_subs'] == 0 ? "Resgatar Mensalmente" : "Reinvestir" ).'</td>
                        <td class=" " >'.($cada['codigo_subs'] ? $cada['descricao_tipo'] : $cada['codigo_subs']).'</td>
						<td class=" " >'.(!empty($cada['contabiliza_subs']) ? "Inativo desde ".Mysql_to_Data($cada['contabiliza_subs']) : "Ativo" ).'</td>
						
						<td class=" sumir-impressao inviPrint">'.($permissao->alterar ? anchor("subscricao/edit/".base64_encode($cada['codigo_subs']), '<i class="fa fa-edit"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Editar')) : "")." ".
										($permissao->alterar && empty($cada['contabiliza_subs']) ? anchor("subscricao/recalcular/".base64_encode($cada['codigo_subs']), '<i class="fa fa-refresh"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Recalcular')) : "")." ".
										($permissao->detalhar ? anchor("subscricao/detail/".base64_encode($cada['codigo_subs']), '<i class="fa fa-plus-circle"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Detalhar')) : "")." ".
										($permissao->excluir && empty($cada['contabiliza_subs']) ? form_button(array('name'=>'btnInativar', 'content'=>'<i class="fa fa-times"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Inativar', 'onClick'=>'inativarSubscricao('.$cada['codigo_subs'].','.($subsCalc[0]['total_liquito']).')')) : "").
										($permissao->excluir ? form_button(array('name'=>'btnExcluir', 'content'=>'<i class="fa fa-trash-o"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Excluir', 'onClick'=>'inativar('.$cada['codigo_subs'].')')) : "").'</td>
	
					</tr>';

                $total += 1;

            }


}
//-------------------------------------------------- Cadastro -------------------------------------------------
elseif ($operacao == 'a') {
    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("subscricao/index")?>">Investimento</a></li>
        <li class="active">Cadastrar Investimento</li>
    </ol>
    <h4 class="page-title">
        Investimento

        <p class="sub-title">Adicionar</p>
    </h4>

    <div class="block-area clearfix">
    <div class="tile m-b-0">
        <h2 class="tile-title"></h2>
    </div>
    <div class="tile p-15 form-horizontal clearfix p-t-20">
    <?php
    $atributos = array('class' => 'form-signin', 'id' => 'form1');
    echo form_open('subscricao/add', $atributos, array('ativo_subs'=>1));

    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('cadastro'))
    {
        echo '<div class="clearfix alert-success">'.$this->session->flashdata('cadastro').'</div>';
    }

    echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Cliente:</label>
		            <div class="col-md-9">
		                '.form_dropdown(array('name'=>"codigo_pes", 'id'=>'ddlCliente', 'class'=>'form-control input1','style'=>'color:black;'), $clientes, set_value('ddlCliente')).'
		            </div>
		        </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Data: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'data_subs',
            'id'    => 'data_subs',
            'readonly'    => '',
            'value' => set_value('data_subs'),
            'class' => 'form-control input1')).'
		            </div>
                </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Taxa: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'taxa_subs',
            'id'    => 'taxa_subs',
            'value' => set_value('taxa_subs'),
            'class' => 'form-control input1 cupom')).'
		            </div>
		        </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Valor: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'valor_subs',
            'id'    => 'valor_subs',
            'value' => set_value('valor_subs'),
            'class' => 'form-control preco input1')).'
		            </div>
		        </div>';


    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Rendimento: </label>
		            <div class="col-md-9">
		                '.form_dropdown(array('name'=>"rendimento_subs", 'id'=>'ddlRendimento', 'class'=>'form-control input1'), array("0" => "Resgatar Mensalmente","1" => "Reinvestir"), set_value('tipo_pes')).'
		            </div>
                </div>';

    echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">Tipo: </label>
                <div class="col-md-9">
                    '.form_dropdown(array('name'=>"tipo_subs", 'id'=>'ddlTipo', 'class'=>'form-control input1'), $tipos, set_value('tipo_subs')).'
                </div>
            </div>';


    echo '<div class="form-group clearfix">
            <div class="col-md-offset-2 col-md-10 m-t-10">
			'.form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar e Voltar', 'class'=>'btn btn-primary')).
        form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
        anchor('subscricao/index', "Voltar", array('class'=> 'btn btn-danger')).
        '
            
            </div>
        </div>
        '.form_close().'

        </div>
    </div>';

}elseif ($operacao == 'addRetroativo') {
    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("subscricao/index")?>">Investimento</a></li>
        <li class="active">Cadastrar Retroativo</li>
    </ol>
    <h4 class="page-title">
        Retroativo

        <p class="sub-title">Adicionar</p>
    </h4>

    <div class="block-area clearfix">

    <?php
    $atributos = array('class' => 'form-signin', 'id' => 'form1');
    echo form_open('subscricao/addRetroativo', $atributos, array('ativo_subs'=>1));

    echo '
        <div class="tile p-15 form-horizontal clearfix p-t-20">';

    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('cadastro'))
    {
        echo '<div class="clearfix alert-success">'.$this->session->flashdata('cadastro').'</div>';
    }

    echo '<div class="form-group m-t-10 clearfix">
           <label class="col-md-2 control-label">Cliente:</label>
            <div class="col-md-9">
                '.form_dropdown(array('name'=>"codigo_pes", 'id'=>'ddlCliente', 'class'=>'form-control input1'), $clientes, set_value('ddlCliente')).'
            </div>
        </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Data: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'data_subs',
            'id'    => 'data_subs',
            'readonly'    => '',
            'value' => set_value('data_subs'),
            'class' => 'form-control input1')).'
		            </div>
                </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Taxa: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'taxa_subs',
            'id'    => 'taxa_subs',
            'value' => set_value('taxa_subs'),
            'class' => 'form-control input1 cupom')).'
		            </div>
		        </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Valor: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'valor_subs',
            'id'    => 'valor_subs',
            'value' => set_value('valor_subs'),
            'class' => 'form-control preco input1')).'
		            </div>
		        </div>';


    echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">Rendimento:</label>
                <div class="col-md-9">
                    '.form_dropdown(array('name'=>"rendimento_subs", 'id'=>'ddlRendimento', 'class'=>'form-control input1'), array("0" => "Resgatar Mensalmente","1" => "Reinvestir"), set_value('tipo_pes')).'
                </div>
            </div>';

    echo '<div class="form-group m-t-20 clearfix">
            <label class="col-md-2 control-label">Tipo: </label>
            <div class="col-md-9">
                '.form_dropdown(array('name'=>"tipo_subs", 'id'=>'ddlTipo', 'class'=>'form-control input1'), $tipos, set_value('tipo_subs')).'
            </div>
        </div>
            
     </div><!--Fecha primeiro form-horizontal-->';

     

    echo '
        
         <h4 class="page-title clearfix p-l-0 p-r-0">
            <div class="pull-left">
                Resgastes
                <p class="sub-title">Adicionar</p>
            </div>
            
            <div class="pull-right">
                '.form_button('btnAddResgate','<i class="fa fa-plus"></i> Adicionar Resgate',array('class'=>"tile-add btn", 'data-placement'=>'left', 'data-original-title'=>'Adicionar Resgates', 'id'=>'btnAddResgate', 'onClick'=>"adicionarResgate(this)")).'
            </div>
        </h4>
        
        ';
    echo '<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20"><div id="divResgates"></div></div>';


    /*<div class="cada-input clearfix">
		            <div class="cada-nome">'.form_label("Data: ").'</div>
		            <div class="cada-elemento cada-elemento-2">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'data_resg',
            'id'    => 'data_resg',
            'value' => set_value('data_resg'),
            'class' => 'form-control input1')).'
		            </div>
		            <div class="cada-nome" style="padding-left: 20px;">'.form_label("Valor: ").'</div>
		            <div class="cada-elemento cada-elemento-2">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'valor_resg',
            'id'    => 'valor_resg',
            'value' => set_value('valor_resg'),
            'class' => 'form-control preco input1')).'
		            </div>
		        </div>*/


    echo '<div class="tile p-15 form-horizontal clearfix">
            <div class="form-group clearfix">
                <div class="col-md-offset-2 col-md-10 m-t-10">
                '.form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar e Voltar', 'class'=>'btn btn-primary')).
            form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
            anchor('subscricao/index', "Voltar", array('class'=> 'btn btn-danger')).
            '
                
                </div>
            </div>
        </div>
        '.form_close().'

        
    </div>';

}elseif ($operacao == 'editaRetroativo') {

    $id = pegaParam1($this->uri);
    // print_r($id);exit;

    if($id == NULL) redirect('subscricao/index');
    $result = $this->mod->get_byid($id);
    // print_r($result);exit;
    $res = $result[0];
    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("subscricao/index")?>">Investimento</a></li>
        <li class="active">Recalcular</li>
    </ol>
    <h4 class="page-title">
        Recalcular
        <p class="sub-title">Adicionar</p>
    </h4>

    <div class="block-area clearfix">

    <?php
    $atributos = array('class' => 'form-signin', 'id' => 'form1');
    echo form_open('subscricao/recalcular/'.$res->codigo_subs, $atributos, array('ativo_subs'=>1));

    echo '
        <div class="tile p-15 form-horizontal clearfix p-t-20">';

    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('cadastro'))
    {
        echo '<div class="clearfix alert-success">'.$this->session->flashdata('cadastro').'</div>';
    }

    echo '<div class="form-group m-t-10 clearfix">
           <label class="col-md-2 control-label">Cliente:</label>
            <div class="col-md-9">
                '.form_dropdown(array('name'=>"codigo_pes", 'id'=>'ddlCliente', 'class'=>'form-control input1'), $clientes, set_value('ddlCliente',$res->codigo_pes)).'
            </div>
        </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Data: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'data_subs',
            'id'    => 'data_subs',
            'readonly'    => '',
            'value' => set_value('data_subs', inverterdata($res->data_subs)),
            'class' => 'form-control input1')).'
		            </div>
                </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Valor: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'valor_subs',
            'id'    => 'valor_subs',
            'value' => set_value('valor_subs', formata_moeda($res->valor_subs)),
            'class' => 'form-control preco input1')).'
		            </div>
                </div>';
                
    echo '<div class="form-group m-t-10 clearfix">
                <label class="col-md-2 control-label">Tipo:</label>
                 <div class="col-md-9">
                     '.form_dropdown(array('name'=>"tipo_subs", 'id'=>'ddlTipo', 'class'=>'form-control input1'), $tipos, set_value('ddlTipo',$res->tipo_subs)).'
                 </div>
             </div>';

     echo '</div><!--Fecha primeiro form-horizontal-->';

    echo '
        
         <h4 class="page-title clearfix p-l-0 p-r-0">
            <div class="pull-left">
                Taxas
                <p class="sub-title">Adicionar</p>
            </div>
            
            <div class="pull-right">
                '.form_button('btnAddTaxa','<i class="fa fa-plus"></i> Adicionar',array('class'=>"btn", 'data-placement'=>'left', 'data-original-title'=>'Adicionar Resgates', 'id'=>'btnAddTaxa', 'onClick'=>"adicionarTaxa(this)")).'
            </div>
        </h4>
        ';

        $allrendimentosmudanca = $this->mod->buscarMudancasbySubs($id);
        // print_r($allrendimentosmudanca);exit;

        $anttaxa = 0 ;
        $antrend = 0;

        $taxasSubs = array();
        $tiposrendimentos = array();

        if (!empty($allrendimentosmudanca)) {

            foreach($allrendimentosmudanca as $keycadarendimento => $cadarendimentomuda)
            {
                if($keycadarendimento == 0)
                {
                    $anttaxa = $cadarendimentomuda->taxa_rend;
                    $antrend = $cadarendimentomuda->tipo_rendimento;
    
                    $taxasSubs[] = (object)array("data"=>$res->data_subs, 'taxa_rend'=>$cadarendimentomuda->taxa_rend);
                    $tiposrendimentos[] = (object)array("data"=>$res->data_subs, 'tipo_rendimento'=>$cadarendimentomuda->tipo_rendimento);
                }
    
                if($cadarendimentomuda->taxa_rend != $anttaxa)
                {
                    $taxasSubs[] = (object)array("data"=>$cadarendimentomuda->data_rend, 'taxa_rend'=>$cadarendimentomuda->taxa_rend);
                    $anttaxa = $cadarendimentomuda->taxa_rend;
                }
                if($cadarendimentomuda->tipo_rendimento != $antrend)
                {
                    $tiposrendimentos[] = (object)array("data"=>$cadarendimentomuda->data_rend, 'tipo_rendimento'=>$cadarendimentomuda->tipo_rendimento);
                    $antrend = $cadarendimentomuda->tipo_rendimento;
                }
    
            }
        } else {
            $taxasSubs[] = (object)array("data"=>$res->data_subs, 'taxa_rend'=>$res->taxa_subs);
            $tiposrendimentos[] = (object)array("data"=>$res->data_subs, 'tipo_rendimento'=>$res->rendimento_subs);
        }


        //   print_r($taxasSubs); exit;


        $divTaxas = "";

        foreach ($taxasSubs as $keytaxa => $cadataxa)
        {

            $divTaxas .= '<div class="block-resgate"><div class="form-group m-t-20 clearfix">
		            <label class="col-md-1 control-label">Data: </label>
		            <div class="col-md-5">
		                '.form_input(array(
                    'type'  => 'text',
                    'name'  => 'data_taxa[]',
                    'id'    => 'data_taxa',
                    'readonly' => '',
                    'value' => ($keytaxa == 0 ? inverterdata($res->data_subs) : Mysql_to_Data($cadataxa->data)),
                    'class' => 'form-control input1')).'
		            </div>
		            
		            <label class="col-md-1 control-label">Taxa: </label>
		            <div class="col-md-3">
		                '.form_input(array(
                    'type'  => 'text',
                    'name'  => 'taxa_subs[]',
                    'id'    => 'taxa_subs',
                    'value' => formata_cupom($cadataxa->taxa_rend),
                    'class' => 'form-control input1 cupom')).'
		            </div>
		            '.($keytaxa != 0 ? ' <div class="col-md-2 ">
                    <button name="btnRemoveResgate" type="button" onClick="removeResgate(this)" class="btn btn-danger" id="btnRemoveResgate"><i class="fa fa-minus"></i> Remover</button>
		        </div>' : "").'
		           </div></div>';
        }

        $divRendimentos = "";

        foreach ($tiposrendimentos as $keyrendimento => $cadarendimento)
        {

            $divRendimentos .= '<div class="block-resgate"><div class="form-group m-t-20 clearfix">
		            <label class="col-md-1 control-label">Data: </label>
		            <div class="col-md-5">
		                '.form_input(array(
                    'type'  => 'text',
                    'name'  => 'data_rendimento[]',
                    'id'    => 'data_rendimento',
                    'readonly' => '',
                    'value' => ($keyrendimento == 0 ? inverterdata($res->data_subs) : Mysql_to_Data($cadarendimento->data)),
                    'class' => 'form-control input1')).'
		            </div>
		            
		            <label class="col-md-1 control-label">Rendimento: </label>
		            <div class="col-md-3">
                            '.form_dropdown(array('name'=>"rendimento_subs[]", 'id'=>'ddlRendimento', 'class'=>'form-control input1'), array("0" => "Resgatar Mensalmente","1" => "Reinvestir"), $cadarendimento->tipo_rendimento).'

		            </div>
		            '.($keyrendimento != 0 ? ' <div class="col-md-2 ">
                    <button name="btnRemoveResgate" type="button" onClick="removeResgate(this)" class="btn btn-danger" id="btnRemoveResgate"><i class="fa fa-minus"></i> Remover</button></div>
		        ' : "").'
		        </div></div>';
        }

    echo '<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20"><div id="divTaxas">'.
            $divTaxas
        .'</div></div>';

    echo '
        <h4 class="page-title clearfix p-l-0 p-r-0">
            <div class="pull-left">
                Rendimentos
                <p class="sub-title">Adicionar</p>
            </div>
            
            <div class="pull-right">
                '.form_button('btnAddRendimento','<i class="fa fa-plus"></i> Adicionar',array('class'=>"btn", 'data-placement'=>'left', 'data-original-title'=>'Adicionar Resgates', 'id'=>'btnAddRendimento', 'onClick'=>"adicionarRendimento(this)")).'
            </div>
        </h4>
        ';
    echo '<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20"><div id="divRendimentos">'.
        $divRendimentos
        .'</div></div>';

    echo '

         <h4 class="page-title clearfix p-l-0 p-r-0">
            <div class="pull-left">
                Resgastes
                <p class="sub-title">Adicionar</p>
            </div>
            
            <div class="pull-right">
                '.form_button('btnAddResgate','<i class="fa fa-plus"></i> Adicionar',array('class'=>"btn", 'data-placement'=>'left', 'data-original-title'=>'Adicionar Resgates', 'id'=>'btnAddResgate', 'onClick'=>"adicionarResgate(this)")).'
            </div>
        </h4>
        ';
        $resgatesSolicitados = $this->mod->buscarResgatesLançadosbySubs($id);
        $divresg = "";

        if(!empty($resgatesSolicitados))
        {
            foreach ($resgatesSolicitados as $keyresg => $cadaresg)
            {
                $divresg .= '<div class="block-resgate ">
                                <div class="form-group clearfix m-t-10">
                                    <label class="col-md-1 control-label">Data:</label>
                                    <div class="col-md-4">
                                        <input type="text" name="data_resg[]" value="'.Mysql_to_Data($cadaresg->dataresgatado_resg).'" id="data_resg" class="form-control input1 dataresg"></div>
                                    <label class="col-md-1 control-label">Valor: </label>
                                    <div class="col-md-3">
                                        <input type="text" name="valor_resg[]" value="'.formata_moeda($cadaresg->valor_resg).'" id="valor_resg" class="form-control precoresg input1"></div>
                                    
                                    <div class="col-md-1">
                                        <button name="btnRemoveResgate" type="button" onclick="removeResgate(this)" class="btn btn-danger" id="btnRemoveResgate"><i class="fa fa-minus"></i> Remover</button></div>
                                    
                                </div>
                             </div>';
            }
        }

    echo '<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20"><div id="divResgates">'.
        (!empty($divresg) ? $divresg : "").'

            </div></div>';


    /*<div class="cada-input clearfix">
		            <div class="cada-nome">'.form_label("Data: ").'</div>
		            <div class="cada-elemento cada-elemento-2">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'data_resg',
            'id'    => 'data_resg',
            'value' => set_value('data_resg'),
            'class' => 'form-control input1')).'
		            </div>
		            <div class="cada-nome" style="padding-left: 20px;">'.form_label("Valor: ").'</div>
		            <div class="cada-elemento cada-elemento-2">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'valor_resg',
            'id'    => 'valor_resg',
            'value' => set_value('valor_resg'),
            'class' => 'form-control preco input1')).'
		            </div>
		        </div>*/


    echo '<div class="tile p-15 form-horizontal clearfix">
            <div class="form-group clearfix">
                <div class="col-md-offset-2 col-md-10 m-t-10">
                '.form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar e Voltar', 'class'=>'btn btn-primary')).
            form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
            anchor('subscricao/index', "Voltar", array('class'=> 'btn btn-danger')).
            '
                
                </div>
            </div>
        </div>
        '.form_close().'

        
    </div>';

}
elseif ($operacao == 'u') {
    //--------------------------------- Update ---------------------------------------------
    $id = pegaParam1($this->uri);

    if($id == NULL) redirect('subscricao/index');

    $result = $this->mod->get_byid($id);
    $res = $result[0];


    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("subscricao/index")?>">Investimento</a></li>
        <li class="active">Alterar investimento</li>
    </ol>
    <h4 class="page-title">
        Investimento

        <p class="sub-title">Alterar</p>
    </h4>

    <div class="block-area clearfix">
    <div class="tile p-15 form-horizontal clearfix p-t-20">
    <?php

    $atributos = array('class' => 'form-signin', 'id' => 'form1');
    echo form_open('subscricao/edit/'.base64_encode($res->codigo_subs), $atributos, array('ativo_subs'=>$res->ativo_subs, 'cd'=>$res->codigo_subs));

    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('alterar'))
    {
        echo '<div class="clearfix alert-success">'.$this->session->flashdata('alterar').'</div>';
    }


    echo '<div class="form-group clearfix m-t-10">
		            <label class="col-md-2 control-label">Cliente:</label>
		            <div class="col-md-9">
		                '.form_dropdown(array('name'=>"codigo_pes", 'id'=>'ddlCliente', 'class'=>'form-control input1'), $clientes, set_value('codigo_pes',$res->codigo_pes)).'
		            </div>
		        </div>';

    echo '<div class="form-group clearfix m-t-20">
		            <label class="col-md-2 control-label">Data:</label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'data_subs',
            'id'    => 'data_subs',
            'value' => set_value('data_subs',Mysql_to_Data($res->data_subs)),
            'class' => 'form-control input1')).'
		            </div>
                </div>';
                
    echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">Vencimento: </label>
                <div class="col-md-9">
                    '.form_input(array(
                        'type'  => 'text',
                        'name'  => 'vencimento_subs',
                        'id'    => 'vencimento_subs',
                        'readonly'    => '',
                        'value' => set_value('vencimento_subs', Mysql_to_Data($res->vencimento_subs)),
                        'class' => 'form-control input1')).'
                </div>
            </div>';

    echo '<div class="form-group clearfix m-t-20">
		            <label class="col-md-2 control-label">Taxa:</label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'taxa_subs',
            'id'    => 'taxa_subs',
            'value' => set_value('taxa_subs',formata_cupom($res->taxa_subs)),
            'class' => 'form-control input1 cupom')).'
		            </div>
		        </div>';

    echo '<div class="form-group clearfix m-t-20">
		            <label class="col-md-2 control-label">Valor:</label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'valor_subs',
            'id'    => 'valor_subs',
            'value' => set_value('valor_subs',formata_moeda($res->valor_subs)),
            'class' => 'form-control preco input1')).'
		            </div>
		        </div>';


    echo '<div class="form-group clearfix m-t-20">
		            <label class="col-md-2 control-label">Rendimento: </label>
		            <div class="col-md-9">
		                '.form_dropdown(array('name'=>"rendimento_subs", 'id'=>'ddlRendimento', 'class'=>'form-control input1'), array("0" => "Resgatar Mensalmente","1" => "Reinvestir"), set_value('rendimento_subs',$res->rendimento_subs)).'
		            </div>
                </div>';
                
    echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">Tipo: </label>
                <div class="col-md-9">
                    '.form_dropdown(array('name'=>"tipo_subs", 'id'=>'ddlTipo', 'class'=>'form-control input1'), $tipos, set_value('tipo_subs', $res->tipo_subs)).'
                </div>
            </div>';

    echo '<div class="form-group clearfix">
            <div class="col-md-offset-2 col-md-10 m-t-10">'.
        form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
        anchor('subscricao/index', "Voltar", array('class'=> 'btn btn-danger')).'
            
            </div>
        </div>
        '.form_close().'

        </div>
    </div>';
}

elseif ($operacao == 'd') {
    //--------------------------------- Detalhar ---------------------------------------------
    $id = base64_decode($this->uri->segment(3));

    if($id == NULL) redirect('subscricao/index');

    $result = $this->mod->get_byid($id);
    $res = $result[0];

    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("subscricao/index")?>">Investimento</a></li>
        <li class="active">Detalhar investimento</li>
    </ol>

    <h4 class="page-title clearfix p-t-35">
        <div class="pull-left">
            Investimento
            <p class="sub-title">Detalhes de Dados Investimento</p>
        </div>

        <div class="pull-right">
            <a href="<?php echo site_url("subscricao/index")?>" class="btn"> <i class="fa fa-undo"></i> Voltar</a>
        </div>
    </h4>

    <div class="block-area clearfix">

    <div class="tile">
    <div class="listview icon-list">

    <?php

    echo '<div class="media clearfix">
		            <label class="col-md-1">Cliente:</label>
		            <div class="col-md-9">
		                '.form_label(($res->nome_pes)).'
		            </div>
		        </div>';

        echo '<div class="media clearfix">
		            <label class="col-md-1">Data:</label>
		            <div class="col-md-9">
		                '.form_label(Mysql_to_Data($res->data_subs)).'
		            </div>
                </div>';
                
        echo '<div class="media clearfix">
		            <label class="col-md-1">Vencimento:</label>
		            <div class="col-md-9">
		                '.form_label(Mysql_to_Data($res->vencimento_subs)).'
		            </div>
		        </div>';

        echo '<div class="media clearfix">
		            <label class="col-md-1">Taxa: </label>
		            <div class="col-md-9">
		                '.form_label(formata_cupom($res->taxa_subs)).'
		            </div>
		        </div>';

        echo '<div class="media clearfix">
		            <label class="col-md-1">Valor: </label>
		            <div class="col-md-9">
		                '.form_label(formata_moeda($res->valor_subs)).'
		            </div>
		        </div>';

        echo '<div class="media clearfix">
		            <label class="col-md-1">Rendimento: </label>
		            <div class="col-md-9">
		                '.form_label(($res->rendimento_subs == 1 ? "Reinvestir" : "Resgatar Mensalmente")).'
		            </div>
                </div>';
                
        echo '<div class="media clearfix">
		            <label class="col-md-1">Tipo: </label>
		            <div class="col-md-9">
		                '.form_label(($res->descricao_tipo)).'
		            </div>
		        </div>';



    echo '</div></div></div>';
}

elseif ($operacao == 'import') {
    //--------------------------------- Update ---------------------------------------------
    ?><div class="clearfix titulo-principal">
        <h1>Importar Números</h1>
    </div>

    <section class="cada-conteudo clearfix">
    <div class="titulo-secundario clearfix">
        <h1>
            <i class="fa fa-plus-square"></i> Arquivo
        </h1>
    </div>
    <?php

    echo form_open_multipart('subscricao/import');
    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('erro'))
    {
        echo '<div class="alert-danger clearfix">'.$this->session->flashdata('cadastro').'</div>';
    }

    echo '<div class="cada-input clearfix">
		            <div class="cada-nome">'.form_label("Arquivo de Importação: ").'</div>
		            <div class="cada-elemento cada-elemento-2">
		                '.form_input(array('type'=>'file', 'name'=>'importacao')).'
		            </div>
		        </div>';

    echo '<div class="area-botao-salvar clearfix">
					'.form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Importar', 'class'=>'btn btn-primary')).
        anchor('subscricao/index', "Voltar", array('class'=> 'btn btn-danger')).
        '
		            
		        </div>';

    echo form_close();






    echo '</section>';
}elseif ($operacao == 'importado') {
    //--------------------------------- Update ---------------------------------------------
    ?><div class="clearfix titulo-principal">
        <h1>Importar Números</h1>
    </div>

    <section class="cada-conteudo clearfix">
    <div class="titulo-secundario clearfix">
        <h1>
            <i class="fa fa-plus-square"></i> Arquivo
            <?php echo anchor('subscricao/index', "Voltar", array('class'=> 'btn btn-danger'));?>
        </h1>
    </div>
    <?php



    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('erro'))
    {
        echo '<div class="alert-danger clearfix">'.$this->session->flashdata('cadastro').'</div>';
    }

    echo '<div class="cada-input clearfix">
		            <div class="cada-nome">'.form_label("Arquivo de Importação: ").'</div>
		            <div class="cada-elemento cada-elemento-2">
		                '.form_label($nome_arq).'
		            </div>
		        </div>';

    echo '<div class="cada-input clearfix">
		            <div class="">
		                '.$tabelaNum.'
		            </div>
		        </div>';



    echo '</section>';
}?>

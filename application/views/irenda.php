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
    <h4 class="page-title">
        Imposto de Renda
    </h4>

    <div class="block-area">
        <div class="clearfix m-b-20">
            <!--<a href="add" role="button" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>-->
            <?php echo printaAnoMes($this->session, 'usuario/')." 

                <div class='pull-right m-t-20'>".
                    ($permissao->alterar ? form_button('', '<i class="fa fa-print"></i> Imprimir', array('class'=> 'print btn btn-primary novo-registro')) : "")." ".
                    ($permissao->alterar ? form_button('', '<i class="fa fa-file-excel-o"></i> Exportar', array('class'=> 'download btn btn-primary ', 'data-hidecolum'=>'', 'data-namearq'=>"irenda".date('dmY'))) : ""); ?>
                </div>
        </div>

        <div id="divDados" class="div-dados clearfix">
            <?php
            //Cabecalho da tabela
            $total = 0;
            $total2 = 0;
            $linhas = '<table class="tile table table-bordered table-striped2 tablesorter" id="tablesorter">
					<thead>
						<tr>
							<th data-name="" data-placeholder="Filtrar Data" >Código Investimento</th>
							<th data-name="Data" data-placeholder="Filtrar Data" >Cliente</th>
							<th data-name="Data" data-placeholder="Filtrar Data" >CPF/CNPJ</th>
							<th data-name="Data" data-placeholder="Filtrar Data" >Data</th>
							<th data-name="Data" data-placeholder="Filtrar Data" >Valor Resgatado</th>
							<th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial" >IR Recolhido</th>
						</tr>
					</thead><tbody>';

            $subscricoes = $this->mod->buscaSubscricao(null, $this->session->userdata('ano').'-'.$this->session->userdata('mes')."-01",$this->session->userdata('ano').'-'.$this->session->userdata('mes')."-31");

            if(!empty($subscricoes))
            {
                $totalAll = 0;
                $totalAllBruto = 0;
                $totalSubscricao = 0;
                $totalRendimento= 0;
                $totalResgates= 0;
                $totalCupom= 0;
                $totalSolicitado= 0;
                foreach ($subscricoes as $key => $cada) {
                    //echo $key;
                    //print_r($cada); exit;
                    //$rendimentoscalculabruto = $this->mod->buscarRendimentoMes2($cada->codigo_subs, $this->session->userdata('ano').'-'.$this->session->userdata('mes')."-01",$this->session->userdata('ano').'-'.$this->session->userdata('mes')."-31");


                    $rendimentobrutonovo = 0;
                    $totalLiq = 0;
                    $totalBruto = 0;


                    $rendimentoscalculabruto = $this->mod->buscarRendimentoNaoReinveste($cada->codigo_subs, $cada->datainiciocalculo);
                    $resgatesSolicitados = $this->mod->buscarResgatesSolicitadosBruto($cada->codigo_subs, $this->session->userdata('ano').'-'.$this->session->userdata('mes')."-01",$this->session->userdata('ano').'-'.$this->session->userdata('mes')."-31");

                    //print_r($rendimentoscalculabruto); echo "<br/><br/>";

                    $totalInicio = $cada->valor_subs;
                    $totalInicioBruto = $totalInicio;
                    $cont = 0;


                    //if($cada->codigo_subs == 294)
                    //echo $cada->codigo_subs." - ".$cada->datainiciocalculo." - ". $rendimentoscalculabruto[0]->data_rend . " - " .$resgatesSolicitados[0]->dataresgatado_resg . "<br/>";
                    /*if($cada->codigo_subs == 498)
                    {
                        print_r($resgatesSolicitados); exit;
                    }*/

                    while(!empty($resgatesSolicitados) && strtotime($rendimentoscalculabruto[0]->data_rend) > strtotime($resgatesSolicitados[0]->dataresgatado_resg))
                    {
                        array_shift($resgatesSolicitados);
                    }

                    foreach ($rendimentoscalculabruto as $keybr => $cadabr)
                    {
                        if(strtotime($cadabr->data_rend) <= strtotime($cada->ultimo))
                        {
                            while(!empty($resgatesSolicitados) && $resgatesSolicitados[0]->dataresgatado_resg == $cadabr->data_rend)
                            {

                                $cadaresg = array_shift($resgatesSolicitados);
                                $anttotalinicio = $totalInicio;
                                $anttotaliniciobruto = $totalInicioBruto;

                                $totalInicio -= $cadaresg->valor_resg;

                                $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;

                                if(strtotime($cadaresg->dataresgatado_resg) >= strtotime($this->session->userdata('ano').'-'.$this->session->userdata('mes')."-01") && strtotime($cadaresg->dataresgatado_resg) <= strtotime($this->session->userdata('ano').'-'.$this->session->userdata('mes')."-31"))
                                {

                                    $linhas .= '<tr class="" >

                                        <td class=" hover-data" >'.($cada->codigo_subs).'</td>
                                        <td class=" hover-data" >'.$cada->nome_pes.'</td>
                                        <td class=" hover-data" >'.$cada->documento.'</td>
                                        <td class=" hover-data" >'.inverterdata($cadaresg->dataresgatado_resg).'</td>
                                        <td class=" hover-data" >'.formata_moeda($cadaresg->valor_resg).'</td>
                                        <td class=" hover-data" >'.formata_moeda(($anttotaliniciobruto-$totalInicioBruto-$cadaresg->valor_resg)).'</td>
                                        
                                    </tr>';
                                    $total++;
                                    $total2 += $anttotaliniciobruto-$totalInicioBruto-$cadaresg->valor_resg;
                                }
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


                    }
                    if(strtotime($cadabr->data_rend) <= strtotime($cada->ultimo))
                    {
                        if(!empty($resgatesSolicitados) && strtotime($resgatesSolicitados[0]->dataresgatado_resg) <= strtotime(date('Y-m-d')))// && $resgatesSolicitados[0]->dataresgatado_resg == date('Y-m-d')
                        {

                            $cadaresg = array_shift($resgatesSolicitados);


                            $anttotalinicio = $totalInicio;
                            $anttotaliniciobruto = $totalInicioBruto;

                            $totalInicio -= $cadaresg->valor_resg;

                            $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;

                            if(strtotime($cadaresg->dataresgatado_resg) >= strtotime($this->session->userdata('ano').'-'.$this->session->userdata('mes')."-01") && strtotime($cadaresg->dataresgatado_resg) <= strtotime($this->session->userdata('ano').'-'.$this->session->userdata('mes')."-31"))
                            {
                                $linhas .= '<tr class="" >
                                        <td class=" hover-data" >'.($cada->codigo_subs).'</td>
                                        <td class=" hover-data" >'.$cada->nome_pes.'</td>
                                        <td class=" hover-data" >'.$cada->documento.'</td>
                                        <td class=" hover-data" >'.inverterdata($cadaresg->dataresgatado_resg).'</td>
                                        <td class=" hover-data" >'.formata_moeda($cadaresg->valor_resg).'</td>
                                        <td class=" hover-data" >'.formata_moeda(($anttotaliniciobruto-$totalInicioBruto-$cadaresg->valor_resg)).'</td>
                                        
                                    </tr>';
                                $total++;
                                $total2 += $anttotaliniciobruto-$totalInicioBruto-$cadaresg->valor_resg;
                            }


                        }
                    }



                    if($totalInicio >= -0.01 && $totalInicio <= 0.01)
                    {
                        $totalInicioBruto = 0;
                    }


                    $totalrendimento = $totalInicio;
                    $totalrendimentoBruto = $totalInicioBruto;





                }
            }



            $linhas .= '</tbody></table>';
            $linhas .= '<div class="pager"> <span class="left">
                                Mostrar:
                                <a href="#" class="current">30</a>
                                <a href="#">50</a>
                                <a href="#">100</a>
                            </span>
                            <span class="center">
                                Total de Registros: '.$total.' | Total IR: '.formata_moeda($total2).'
                            </span>
                             <span class="right">
                                    <span class="prev">
                                        <img src="'.CLOUDFRONT.'tablesorter/css/images/prev.png'.'" /> Ant&nbsp;
                                    </span>
                             <span class="pagecount"></span>
                             &nbsp;<span class="next">Prox 
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
                    <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse">Dados</h2>
                    </div>
                    <div class="tile tile-reverse">

                        <div class="form-group clearfix m-t-20">
                            <label class="col-md-2 control-label">Data da Inativação: </label>
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
                        <?php
                        echo '</div>';
                        ?>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-reverse" id="btnConfirmarInativar">Confirmar</button>
                    <button type="button" class="btn btn-danger btn-reverse" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

<?php }


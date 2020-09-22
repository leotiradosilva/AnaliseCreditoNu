<?php
$id = $this->session->aluno['codigo'];
        //print_r($this->session->aluno); exit;
        if ($id == NULL){ 
            redirect('acesso/home');
        }
 ?>

        <div class="resgates ">
            <h4 class="page-title clearfix">
              <div class="pull-left m-t-10"> Resgates </div>

                <div class="pull-right">
                    <?php  echo form_button(array("content" => "<i class='fa fa-money'></i> Solicitar Resgate", 'name' => "btnResgate", 'class' => "btn", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'\',\'' . formata_moeda($totalAll) . '\')'))?>
                </div>
            </h4>
            <div class="block-area">

                <table class="tile table table-bordered table-striped tablesorter table-responsive"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Data" data-placeholder="Filtrar Data">Data da Solicitação</th>
                        <th data-name="Valor" data-placeholder="Filtrar Valor">Valor (R$)</th>
                        <th data-name="Data" data-placeholder="Filtrar Data">Data do Resgate</th>
                        <th data-name="Data" data-placeholder="Filtrar Data">Origem</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($resgates)) {
                        foreach ($resgates as $key => $cada) {
                            echo "<tr>
								<td>" . inverterdata($cada->data_resg) . "</td>
								<td>" . formata_moeda($cada->valor_resg) . "</td>
								<td>" . (!empty($cada->dataresgatado_resg) ? inverterdata($cada->dataresgatado_resg) : "-") . "</td>
								<td>" . ($cada->tipo_resg == 0 ? "Cupom" : "Resgate") . "</td>
							 </tr>";
                            if(!empty($cada->dataresgatado_resg))
                            {
                                $saldoTotalCliente += $cada->valor_resg;
                                if($cada->tipo_resg == 0)
                                {
                                    $saldoCupom += $cada->valor_resg;
                                }
                                else
                                {
                                    $saldoSolicitado += $cada->valor_resg;
                                }
                            }

                        }
                    } else {
                        echo "<tr>
								<td colspan='4'>" . "Não há valores resgatados" . "</td>
							 </tr>";
                    }


                    ?>
                    </tbody>
                    <tfoot>
                   <tr>
                        <td colspan="3">Total Cupom</td>
                        <td> R$ <?php echo formata_moeda($saldoCupom); ?></td>
                    </tr><tr>
                        <td colspan="3">Total Solicitado</td>
                        <td> R$ <?php echo formata_moeda($saldoSolicitado); ?></td>
                    </tr> <tr>
                        <td colspan="3">Total Resgatado</td>
                        <td> R$ <?php echo formata_moeda($saldoTotalCliente); ?></td>
                    </tr>
                    </tfoot>
                </table>


            </div>

        </div>

        <div class="modal fade" id="modal-extrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Extrato</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group clearfix m-b-20">
                            <label class="col-md-1 m-t-5 control-label text-black">Período</label>
                            <div class="col-md-5">
                                <?php echo form_dropdown(array('name' => "ddlExtrato", 'id' => 'ddlExtrato', 'class' => 'form-control reverse'), array('30' => '30 Dias', '60' => '60 Dias', '90' => '90 Dias', '120' => '120 Dias', '150' => "Todos"), 30); ?>
                            </div>
                        </div>
                        <div id="divExtrato"></div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-grafico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 1300px !important;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Gráficos</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <div class="titulo-secundario clearfix">
                                <h1><i class="fa fa-users"></i> Rendimentos
                                </h1>
                            </div>
                            <div id="divGraficoLucro" style="width: 1250px;height: 400px;">


                            </div>

                        </div>
                        <div class="form-group">
                            <div class="titulo-secundario clearfix">
                                <h1><i class="fa fa-users"></i> Saldo
                                </h1>
                            </div>
                            <div id="divGraficoSaldo" style="width: 1250px;height: 400px;">


                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
<div class="saldo">
    <h4 class="page-title">Saldos</h4>
    <div class="block-area">
        <div class="accordion tile">
            <div class="panel-group block" id="accordion">
               
    <div class="panel panel-default">
         <div class="panel-heading panel-personalizado">
            <h3 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                   href="#collapseTotal">
                    <?php echo "Total"; ?>
                </a>
            </h3>
         </div>
        <div id="collapseTotal" class="panel-collapse collapse">
            <div class="panel-body">
                <div>
                    <table
                        class="tile table table-bordered table-striped tablesorter table-responsive tabela-especial"
                        id="tablesorter">
                        <thead>
                        <tr>
                            <th data-name="Total" data-placeholder="Filtrar Total">Investimento (R$)</th>
                            <th data-name="Total" data-placeholder="Filtrar Total">Resgates (R$)</th>
                            <th data-name="Total" data-placeholder="Filtrar Total">Cupom Recebido (R$)</th>
                           <!-- <th data-name="Total" data-placeholder="Filtrar Total">Lucro Bruto (R$)</th> -->
                           <!-- <th data-name="Total" data-placeholder="Filtrar Total">Saldo Bruto (R$)</th> -->
                            <th data-name="Total" data-placeholder="Filtrar Total">Lucro Líquido (R$)</th>
                            <th data-name="Total" data-placeholder="Filtrar Total">Saldo Líquido (R$)</th>
                            <th data-name="Total" data-placeholder="Filtrar Total">Ação</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        echo "<tr>
                                    <td>" . formata_moeda($totalSubscricao) . "</td>
                                    <td>" . formata_moeda($totalSolicitado) . "</td>
                                    <td>" . formata_moeda($totalCupom) . "</td>
                                    <!--  <td>" . formata_moeda($subsAllCalc->totalRendBruto) . "</td> -->
                                    <!--  <td>" . formata_moeda($subsAllCalc->totalBruto) . "</td> -->
                                    <td>" . formata_moeda($subsAllCalc->totalRendLiquido) . "</td>
                                    <td id='saldoLiquido'>" . formata_moeda($subsAllCalc->totalLiquido) . "</td>
                                    <td>" . form_button(array("content" => "<i class='fa fa-file-text'></i>", 'data-toggle'=> 'tooltip', 'data-placement'=> 'top', 'title'=> 'Extrato', 'name' => "btnExtrato", 'class' => "btn tooltips btn-action-table btn-acao-tabela", 'onClick' => 'visualizarExtratoTotal(\'' . base64_encode($this->session->userdata('aluno')['codigo']) . '\')')).
                            form_button(array("content" => "<i class='fa fa-undo'></i> ", 'data-toggle'=> 'tooltip', 'data-placement'=> 'top', 'name' => "btnResgate", 'class' => "btn tooltips btn-action-table btn-acao-tabela", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'\',\'' .  formata_moeda($subsAllCalc->totalLiquido) . '\')')) .
                            form_button(array("content" => "<i class='fa fa-dollar'></i> ", 'data-toggle'=> 'tooltip', 'data-placement'=> 'top', 'name' => "btnSimulaSaldo", 'class' => "btn tooltips btn-action-table btn-acao-tabela", 'title' => 'Simulação de Saldo', 'onClick' => 'simularSaldo(\'' . base64_encode($cada->codigo_subs) . '\', \'' . formata_cupom($cada->taxa_subs) . '\', \'' . formata_moeda($subsAllCalc->totalLiquido) . '\')')).

                            "</td>
                              </tr>";
                        ?>
                        </tbody>
                    </table>
                </div>

                <div class="tile">
                    <h2 class="tile-title p-l-0">Rendimentos <span class="badge badge-blue m-l-5 tooltips" data-toggle="tooltip" data-placement="right" title="Rendimentos acumulados ao mês de todas as subscrições ativas">?</span></h2>

                    <div class="p-10">
                        <div id="line-chart-rendimento-total"
                             class="main-chart line-chart" style="height: 250px;"
                             data-dados="<?php echo base64_encode(json_encode($graphTotalRendimento)); ?>"></div>
                    </div>
                </div>

                <div class="tile">
                    <h2 class="tile-title p-l-0">Saldo Líquido<span class="badge badge-blue m-l-5 tooltips" data-toggle="tooltip" data-placement="right" title="Somatória dos saldos líquidos ao mês de todas as subscrições ativas">?</span></h2>

                    <div class="p-10" >
                        <div id="line-chart-saldo-total"
                             class="main-chart line-chart" style="height: 250px"
                             data-dados="<?php echo base64_encode(json_encode($graphTotalSaldo)); ?>"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php
                    echo $htmlsub;
                ?>
            </div>
        </div>

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
                        <label class="col-md-2 m-t-10 control-label text-black">Data Inicial</label>
                        <div class="col-md-9">
                            <?php
                            $predata = (removeXMonthIntoDate(date('Y-m-d'),1));

                            echo form_input(array('type' => 'text',
                                'name' => 'dtinicio',
                                'id' => 'dtinicio',
                                'readonly' => '',
                                'style'=>"",
                                'class' => 'form-control  input1',
                                'value' => inverterdata(set_value("dtinicio", $predata)))); ?>
                        </div>
                    </div>
                    <div class="form-group clearfix m-b-20">
                        <label class="col-md-2 m-t-10 control-label text-black">Data Final</label>
                        <div class="col-md-9">
                            <?php
                            $posdata = ((date('Y-m-d')));

                            echo form_input(array('type' => 'text',
                                'name' => 'dtfinal',
                                'id' => 'dtfinal',
                                'readonly' => '',
                                'style'=>"",
                                'class' => 'form-control  input1',
                                'value' => inverterdata(set_value("dtfinal", $posdata)))); ?>
                        </div>
                    </div>
                    <div class="form-group clearfix m-b-20">
                        <label class="col-md-2 m-t-10 control-label text-black">Rendimento</label>
                        <div class="col-md-5" style="width:44.8%">
                            <?php
                            echo form_dropdown(array('name'=>"tipoRendimento", 'id'=>'tipoRendimento', 'class'=>'form-control input1', 'style'=>'color: black;'), array('0'=>'Diário', '1'=>'Mensal'), 0) ?>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-danger" id="btnAtualizarExtrato" name="btnAtualizarExtrato" onclick="AtualizaExtratoModal()">Gerar Extrato</button>
                            <button type="button" class="btn btn-danger" id="btnExportarPDF" name="btnExportarPDF" onclick="gerarPDF()">Exportar PDF</button>

                        </div>
                       <!-- <div class="col-md-2">
                            </div>-->
                    </div>


                    <div id="divExtrato"></div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>



<div class="modal fade" id="modal-simulacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 900px;">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Simulação de Saldo</h4>
                </div>

                <div class="modal-body">
                    <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse">Simular</h2>
                    </div>

                    <div class="tile tile-reverse">
                        <div class="listview icon-list">
                            <div class="media clearfix">
                                <label class="col-md-1 control-label p-l-0 m-b-0">Data: </label>
                                <div class="col-md-9"><?php echo date('d/m/Y'); ?></div>
                            </div>

                            <div class="media clearfix">
                                <label class="col-md-1 control-label p-l-0 m-b-0">Saldo Atual Teste: </label>
                                <div class="col-md-9">
                                    R$ <span id="saldoAtual"></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse">Remuneração Mensal Líquida e Data</h2>
                    </div>

                    <div class="tile tile-reverse p-15 form-horizontal clearfix p-t-20 p-b-0">

                        <div class="form-group clearfix">
                            <label class="col-md-2 control-label">Remuneração Mensal Líquida %: </label>
                            <div class="col-md-7">
                                <?php echo form_input(array('type' => 'text',
                                    'name' => 'cupom',
                                    'id' => 'cupom',
                                    'class' => 'form-control cupom',
                                    'readonly' => true,
                                    'value' => set_value("cupom"))); ?>
                            </div>
                        </div>

                        <div class="form-group clearfix m-t-20">
                            <label class="col-md-2 control-label">Simular Para: </label>
                            <div class="col-md-7">
                                <?php
                                $predata = (addDayIntoDate(date('Y-m-d')));

                                echo form_input(array('type' => 'text',
                                    'name' => 'data_simulacao',
                                    'id' => 'data_simulacao',
                                    'readonly' => '',
                                    'class' => 'form-control  input1',
                                    'value' => inverterdata(set_value("data_simulacao", $predata)))); ?>
                            </div>
                        </div>
                        <input type="hidden" id="codigoSimulacao" value=""/>
                        <input type="hidden" id="preencheData" value="<?php echo inverterdata($predata); ?>"/>
                    </div>

                    <div id="divMostraSimulacao" class=""></div>
                </div>

                <div class="modal-footer m-t-0">
                    <button type="button" class="btn btn-success" id="btnSimularSaldo">Simular</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

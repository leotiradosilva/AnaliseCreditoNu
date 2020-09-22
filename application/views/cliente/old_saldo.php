<div class="saldo">
	<h4 class="page-title">Saldos</h4>
	<div class="block-area">
		<div class="accordion tile">
			<div class="panel-group block" id="accordion">
				<?php
				$subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);
				$subsAllCalc = $this->mod->buscarSubscricaoCalculada($this->session->aluno['codigo']);

				$ind = 0;
				$arrayRendimento = array();
				$arraySaldo = array();
				$htmlsub = "";

				if(!empty($subscricoes))
				{
					$totalAll = 0;
					$totalAllBruto = 0;
					$totalSubscricao = 0;
					$totalRendimento= 0;
					$totalResgates= 0;
					$totalCupom= 0;
					$totalSolicitado= 0;
					$totalAllRendimentoBruto = 0;
					$totalAllRendimentoLiquido = 0;

					foreach ($subscricoes as $key => $cada) {

						$dadosGraph = $controller->dadosGraficos($cada->codigo_subs);
						$rendimentoscalculabruto = $this->mod->buscarRendimentoMes($cada->codigo_subs, date("Y-m-01"), date("Y-m-31"));
						$subsCalc = $this->mod->buscarSubscricaoCalculada($this->session->aluno['codigo'], $cada->codigo_subs);

						$totalSubscricao += $cada->valor_subs;
						$totalRendimento += $cada->rendimento;
						$totalResgates += $cada->resgate;
						$totalSolicitado += $cada->resgateSolicitado;
						$totalCupom += $cada->resgateCupom;

						$htmlsub .= '<div class="panel panel-default">
										<div class="panel-heading panel-personalizado">
											<h3 class="panel-title">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
												   href="#collapse'.$key.'">
													'.($key+1)."ª Subscrição".' - '.inverterdata($cada->data_subs).'
												</a>
											</h3>
										</div>
										<div id="collapse'.$key.'" class="panel-collapse collapse in">
											<div class="panel-body">
												<div>
													<table
														class="tile table table-bordered table-striped tablesorter table-responsive tabela-especial"
														id="tablesorter">
														<thead>
														<tr>
															<th data-name="Status" data-placeholder="Filtrar Status">Status</th>
															<th data-name="Código" data-placeholder="Filtrar Código">Investimento (R$)</th>
															<th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
															<th data-name="Saldo Atual" data-placeholder="Filtrar Saldo Atual">Saldo Bruto (R$)</th>
															<th data-name="Saldo Atual" data-placeholder="Filtrar Saldo Atual">Saldo Líquido (R$)</th>
															<th data-name="Ação" data-sorter="false"
																class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">
																A&ccedil;&atilde;o
															</th>
														</tr>
														</thead>
														<tbody>';

														$htmlsub .= "<tr>
															<td>" . (!empty($cada->contabiliza_subs) ? "Inativo" : "Ativo") . "</td>    
															<td>" . formata_moeda($cada->valor_subs) . "</td>
															<td>" . formata_cupom($cada->taxa_subs) . " </td>
															<td>" . formata_moeda($subsCalc->totalBruto) . "</td>
															<td>" . formata_moeda($subsCalc->totalLiquido) . "</td>
															<td>" . form_button(['content' => "<i class='fa fa-file-text'></i>",
																				 'name'    => "btnExtrato",
																				 'class'   => "btn btn-default btn-action-table btn-acao-tabela",
																				 'title'   => 'Extrato',
																				 'onClick' => 'visualizarExtrato(\'' . base64_encode($cada->codigo_subs) .'\')'])
															. "</td>
														</tbody>
													</table>
												</div>";

														$dadosGraph['rendimentoarray'] = array_reverse($dadosGraph['rendimentoarray']);
														foreach($dadosGraph['rendimentoarray'] as $keyrend => $cadarend) {
															$flag = 0;
															foreach ($arrayRendimento as $keyarray => $cadaarray) {
																if($cadaarray[0] == $cadarend[0]) {
																	$arrayRendimento[$keyarray][1] += $cadarend[1];
																	$flag = 1;
																}
															}
															if(!$flag) {
																array_unshift($arrayRendimento, $cadarend);
															}
														}


														$dadosGraph['saldoarray'] = array_reverse($dadosGraph['saldoarray']);
														foreach($dadosGraph['saldoarray'] as $keyrend => $cadarend) {
															$flag = 0;
															foreach ($arraySaldo as $keyarray => $cadaarray) {
																if($cadaarray[0] == $cadarend[0]) {
																	$arraySaldo[$keyarray][1] += $cadarend[1];
																	$flag = 1;
																}
															}
															if(!$flag) {
																array_unshift($arraySaldo, $cadarend);
															}
														}
									$htmlsub .= '</div>
										</div>
									</div>';

								$ind++;
					}

					$ordenarendimento = array();
					$ordenasaldo = array();
					$graphTotalRendimento = array();
					$graphTotalSaldo = array();
					$graphDatas = array();
					$graphDatasSaldo = array();

					foreach ($arrayRendimento as $keyarray => $cadaarray) {
						$graphDatas[] = $cadaarray[0];
						$graphDatasSaldo[] = $cadaarray[0];
						$ordenarendimento[] = $cadaarray[1];
						$ordenasaldo[] = $arraySaldo[$keyarray][1];
					}
					 //   print_r($graphDatas); echo "<br/>"; print_r($ordenarendimento); echo "<br/>"; print_r($ordenasaldo);  echo "<br/>";
					array_multisort($graphDatas, $ordenarendimento);
					array_multisort($graphDatasSaldo, $ordenasaldo);

					foreach ($graphDatas as $keydata => $cadadata) {
						$graphTotalRendimento[] = array($cadadata, $ordenarendimento[$keydata]);
						$graphTotalSaldo[] = array($cadadata, $ordenasaldo[$keydata]);
					}
?>
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
							<th data-name="Total" data-placeholder="Filtrar Total">Lucro Bruto (R$)</th>
							<th data-name="Total" data-placeholder="Filtrar Total">Saldo Bruto (R$)</th>
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
									<td>" . formata_moeda($subsAllCalc->totalRendBruto) . "</td>
									<td>" . formata_moeda($subsAllCalc->totalBruto) . "</td>
									<td>" . formata_moeda($subsAllCalc->totalRendLiquido) . "</td>
									<td>"."Este Saldo" . formata_moeda($subsAllCalc->totalLiquido) . "</td>
									<td>" . form_button(array("content" => "<i class='fa fa-file-text'></i>", 'data-toggle'=> 'tooltip', 'data-placement'=> 'top', 'title'=> 'Extrato', 'name' => "btnExtrato", 'class' => "btn tooltips btn-action-table btn-acao-tabela", 'onClick' => 'visualizarExtratoTotal(\'' . base64_encode($this->session->userdata('aluno')['codigo']) . '\')')).
							form_button(array("content" => "<i class='fa fa-undo'></i> ", 'data-toggle'=> 'tooltip', 'data-placement'=> 'top', 'name' => "btnResgate", 'class' => "btn tooltips btn-action-table btn-acao-tabela", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'\',\'' . formata_moeda($totalAll) . '\')')) .
							form_button(array("content" => "<i class='fa fa-dollar'></i> ", 'data-toggle'=> 'tooltip', 'data-placement'=> 'top', 'name' => "btnSimulaSaldo", 'class' => "btn tooltips btn-action-table btn-acao-tabela", 'title' => 'Simulação de Saldo', 'onClick' => 'simularSaldo(\'' . base64_encode($cada->codigo_subs) . '\', \'' . formata_cupom($cada->taxa_subs) . '\', \'' . formata_moeda($totalAll) . '\')')).

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
			   } ?>
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
                        <div class="col-md-6">
                            <?php
                            echo form_dropdown(array('name'=>"tipoRendimento", 'id'=>'tipoRendimento', 'class'=>'form-control input1', 'style'=>'color: black;'), array('0'=>'Diário', '1'=>'Mensal'), 0) ?>
                        </div>
                        <div class="col-md-2">
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
                                <label class="col-md-1 control-label p-l-0 m-b-0">Saldo Atual: </label>
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
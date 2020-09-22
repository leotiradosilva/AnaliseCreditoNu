 <div class="subscricoes">
	<h4 class="page-title">Investimentos</h4>
	<div class="block-area">
		<table class="tile table table-bordered table-striped table-responsive" id="tablesorter">
			<thead>
                <tr>
                    <th data-name="Data" data-placeholder="Filtrar Data">Data</th>
                    <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                    <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Investimento (R$)</th>
                    <th data-name="Rendimento" data-placeholder="Filtrar Rendimento">Rendimento</th>
                    <th data-name="Tipo Subscricao" data-placeholder="Filtrar Tipo Subscricao">Tipo Subscricao</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            
			<tbody>
			<?php

            if(!empty($subscricoes))
            {
                foreach ($subscricoes as $key => $cada) {
                    $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;
                    $saldoTotalCliente += $totalrendimento;
                    $totalSubscrito += $cada->valor_subs;
                    ?>      
                    <tr>
                        <td><?= inverterdata($cada->data_subs) ?></td>
                        <td><?= formata_cupom($cada->taxa_subs) ?></td>
                        <td><?= formata_moeda($cada->valor_subs) ?></td>
                        <td><?= ($cada->rendimento_subs == 0 ? "Resgatar Mensalmente" : "Reinvestir") ?></td>
                        <td><?= $cada->tipo_subs > 1 ? 'Nova Subscrição (Deb 360 dias)' : 'Nova Subscrição (Deb 90 dias)' ?></td>
                        <td class="text-center">

                            <form action="<?= base_url('cliente/investimentos/gerarcontrato') ?>" method="POST" target="_blank">
                                <input type="hidden" id="codigo_subs" name="codigo_subs" value="<?= $cada->codigo_subs ?>">
                                <input type="hidden" id="data_subs" name="data_subs" value="<?= $cada->data_subs ?>">
                                <input type="hidden" id="valor_total" name="valor_total" value="<?= $cada->valor_subs ?>">
                                <input type="hidden" id="is_cupom" name="is_cupom" value="<?= $cada->rendimento_subs ?>">
                                <p><input id='pdf' class="btn btn-success btn-raised" type='submit' name='submit' value='Contrato'></p> 
                            </form>

                        </td>
                    </tr>

                <?php		
                }
            }
			else
			{
				echo "<tr>
						<td colspan='6'>Nenhuma Subcrição Encontrada!</td>
					 </tr>";
			}


			?>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="2">Total Subscrito</td>
				<td colspan="3"> R$ <?php echo formata_moeda($totalSubscrito); ?></td>
				<td></td>
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

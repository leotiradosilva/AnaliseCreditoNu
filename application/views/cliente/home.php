<?php
    $id = $this->session->aluno['codigo'];

    if ($id == NULL)
        redirect('cliente/home');


?>
<div class="block-area clearfix body-sistema p-t-35">
	<div class="listview listview-valores icon-list">
		<div class="item-valores">
            <span class="icone">
                <img src="<?php echo CLOUDFRONT.('imagem/icone/valor-investido.svg')?>" alt="">
            </span>
			<div class="aux clearfix">
				<p class="valor"><span>R$</span> <?php echo  formata_moeda($totalSubscricao)?></p>
				<label class="desc">Valor Investido </label>
			</div>
		</div>

		<div class="item-valores">
	        <span class="icone">
	            <img class="resgate" src="<?php echo CLOUDFRONT.('imagem/icone/resgate.svg')?>" alt="">
	        </span>
			<div class="aux clearfix">
				<p class="valor"><span>R$</span><?php echo formata_moeda($totalSolicitado)?></p>
				<label class="desc">Resgates</label>
			</div>
		</div>

		<div class="item-valores">
            <span class="icone">
                <img src="<?php echo CLOUDFRONT.('imagem/icone/cupom-recebido.svg')?>" alt="">
            </span>
			<div class="aux clearfix">
				<p class="valor"><span>R$</span><?php echo formata_moeda($totalCupom)?></p>
				<label class="desc">Cupom Recebido</label>
			</div>
		</div>

<!--		<div class="item-valores">
            <span class="icone">
                <img src="<?php echo CLOUDFRONT.('imagem/icone/lucro-bruto.svg')?>" alt="">
            </span>
			<div class="aux clearfix">
				<p class="valor"><span>R$</span><?php echo formata_moeda($totalAllRendimentoBruto)?></p>
				<label class="desc">Lucro Bruto</label>
			</div>
		</div>

		<div class="item-valores">
                                <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/saldo-bruto.svg')?>" alt="">
                                </span>
			<div class="aux clearfix">
				<p class="valor"><span>R$</span><?php echo formata_moeda($totalAllBruto)?></p>
				<label class="desc">Saldo Bruto</label>
			</div>
		</div> -->

		<div class="item-valores">
                                 <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/lucro-liquido.svg')?>" alt="">
                                 </span>
			<div class="aux clearfix">
				<p class="valor"><span>R$</span><?php echo formata_moeda($totalAllRendimentoLiquido)?></p>
				<label class="desc">Lucro Líquido (R$): </label>
			</div>
		</div>

		<div class="item-valores">
                                 <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/saldo-liquido.svg')?>" alt="">
                                 </span>
			<div class="aux clearfix">
				<p class="valor"><span>R$</span><?php echo formata_moeda($totalAll)?></p>
				<label class="desc">Saldo Líquido (R$): </label>
			</div>
		</div>

		<div class="item-valores">
			<div class="aux acoes clearfix">
				<?php echo form_button(array("content" => "<i class='fa fa-file-text'></i> Extrato",
						'name' => "btnExtrato",
						'class' => "btn btn-extrato",
						'title' => 'Extrato',
						'onClick' => 'visualizarExtratoTotal(\'' . base64_encode($this->session->userdata('aluno')['codigo']) . '\')')).
					form_button(array("content" => "<i class='fa fa-money'></i> Resgate", 'name' => "btnResgate", 'class' => "btn btn-resgate", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'\',\'' . formata_moeda($totalAll) . '\')'))?>
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
							'style'=>"color: black;",
							'class' => 'form-control  input1',
							'value' => inverterdata(set_value("dtinicio", $predata)))); ?>
					</div>
				</div>
				<div class="form-group clearfix m-b-20">
					<label class="col-md-2 m-t-10 control-label text-black">Data Final</label>
					<div class="col-md-5 m-b-10">
						<?php
						$posdata = ((date('Y-m-d')));

						echo form_input(array('type' => 'text',
							'name' => 'dtfinal',
							'id' => 'dtfinal',
							'readonly' => '',
							'style'=>"color: black;",
							'class' => 'form-control  input1',
							'value' => inverterdata(set_value("dtfinal", $posdata)))); ?>
					</div>
					<div class="col-md-4 m-t-3">
						<button type="button" class="btn btn-danger" id="btnAtualizarExtrato" name="btnAtualizarExtrato" onclick="AtualizaExtratoModal()">Gerar Extrato</button>
						<button type="button" class="btn btn-danger" id="btnExportarPDF" name="btnExportarPDF" onclick="gerarPDF()">Exportar PDF</button>
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



<div class="modal fade" id="modal-simulacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
 aria-hidden="true">
<div class="modal-dialog modal-lg" style="width: 1200px;">
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
						<label class="col-md-1 control-label">Data: </label>
						<div class="col-md-9"><?php echo date('d/m/Y'); ?></div>
					</div>

					<div class="media clearfix">
						<label class="col-md-1 control-label">Saldo Atual: </label>
						<div class="col-md-9">
							R$ <span id="saldoAtual"></span></div>
					</div>
				</div>
			</div>

			<div class="tile m-b-0">
				<h2 class="tile-title tile-reverse">Remuneração Mensal Líquida e Data</h2>
			</div>

			<div class="tile tile-reverse p-15 form-horizontal clearfix p-t-20">

				<div class="form-group clearfix">
					<label class="col-md-2 control-label">Remuneração Mensal Líquida %: </label>
					<div class="col-md-9">
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
					<div class="col-md-9">
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

		<div class="modal-footer">
			<button type="button" class="btn btn-success" id="btnSimularSaldo">Simular</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
		</div>
	</div>
</div>

<?php if($acao == 'principal') { ?>

<h4 class="page-title">Página Inicial</h4>

<div class="block-area">

    <div id="divDados" class="div-dados clearfix">
        <?php
        echo '<div class="tile p-15">
				<div class="form-group p-t-20 clearfix">
				<label class="col-md-2 control-label m-t-10">Investimento Nº:</label>
				<div class="col-md-8 sub-input">
						'.form_input(array(
					'type'  => 'text',
					'name'  => 'subscricao_emp',
					'id'    => 'subscricao_emp',
					'value' => set_value('subscricao_emp',$numerotaxavigente->subscricao_emp),
					'class' => 'form-control input1')).'
				</div>
				<div class="col-md-2 sub-btn">
					'.form_button(array('name'=>'btnSalvar', 'id'=>'btnSalvarSubscricao','content'=>'Salvar Número', 'class'=>'btn btn-primary')).'
				</div>
			  </div>';
        //Cabecalho da tabela
        echo '<div class="form-group m-t-20 p-b-20 clearfix">
                <label class="col-md-2 control-label m-t-10">Taxa Vigente:</label>
                <div class="col-md-8 sub-input">
                    '.form_input(array(
                'type'  => 'text',
                'name'  => 'taxa_emp',
                'id'    => 'taxa_emp',
                'value' => set_value('taxa_emp',formata_cupom($numerotaxavigente->taxa_emp)),
                'class' => 'form-control input1 cupom')).'
                </div>
                <div class="col-md-2 sub-btn">
                    '.form_button(array('name'=>'btnSalvar', 'id'=>'btnSalvarTaxa','content'=>'Salvar Taxa', 'class'=>'btn btn-primary')).'
                </div>
            </div>
            </div>';

        //Cabecalho da tabela
        $total = 0;
        $linhas = '<div class="tile m-b-0">
                    <h2 class="tile-title">Tabela Total/Mês</h2>
                </div>
                <table class="tile table table-bordered table-striped2 tablesorter" id="tablesorter">
					<thead>
						<tr>
							<th data-name="Mês/Ano" data-placeholder="Filtrar Mês/Ano" >Mês/Ano</th>
							<th data-name="Subscrições" data-placeholder="Filtrar Subscrições" >Subscrições</th>
							<th data-name="Resgates" data-placeholder="Filtrar Resgates" >Resgates</th>
							<th data-name="Cupom" data-placeholder="Filtrar Cupom" >Cupom</th>
							<th data-name="Rendimento Líquido" data-placeholder="Filtrar Rendimento Líquido" >Rendimento Líquido</th>
							<th data-name="Fluxo de Caixa" data-placeholder="Filtrar Saldo" >Fluxo de Caixa</th>
						</tr>
					</thead><tbody>';
        $totalAllme = 0;
        $totalAllComissaome = 0;
        $totalRendimentome = 0;
        $totalRendimentoliquidome = 0;
        $totalSubscricaome = 0;
        $totalRendimentoSolicitadome = 0;
        $totalTotalSaldoLiquidome = 0;

		$totalbrutoMes = 0;
		$totalRendimentoBrutoMes = 0;
		$totalIRMes = 0;
		$totalbrutoMesAll = 0;
		$totalRendimentoBrutoMesAll = 0;
		$totalIRMesAll = 0;

        $tableImpressao = "<table border='1' style='width:100%'>
                            <thead>
                                <tr>
                                    <th colspan='5' style='text-align:center;'>Tabela Total M&ecirc;s</th>
                                </tr>
                                <tr>
                                    <th>M&ecirc;s/Ano</th>
                                    <th>Investimentos</th>
                                    <th>Resgates</th>
                                    <th>Cupom</th>
                                    <th>Rendimento Líquido</th>
                                    <th>Rendimento Bruto</th>
                                    <th>Fluxo de Caixa</th>
                                    <th>Saldo Líquido</th>
                                    <th>Saldo Bruto</th>
                                    <th>IR Recolhido</th>
                                </tr>
                            </thead><tbody>";

        $linhasDados = "";
        $totalSaldoLiquidoMesaMes = 0;
        foreach ($SubscricaoResgate as $key => $cada) {
            $totalSaldoLiquidoMesaMes += $cada->inscricao - $cada->resgate_solicitado - $cada->resgate_rendimento + $cada->rendimento;
        }

        foreach ($SubscricaoResgate as $key => $cadame)
        {
            $totalComissao = 0;
            $saldoTotalCliente = 0;
            $ind = 0;
            $arrayRendimento = array();
            $arraySaldo = array();
            $htmlsub = "";

			$balanco_calc = $this->mod->buscarBalancoCalculado($cadame->data, 'total_rendimento_bruto, total_saldo_bruto, total_ir');
			if( $balanco_calc ) {
				$totalbrutoMes = $balanco_calc->total_saldo_bruto;
				$totalRendimentoBrutoMes = $balanco_calc->total_rendimento_bruto;
				$totalIRMes = $balanco_calc->total_ir;

				$totalbrutoMesAll += $totalbrutoMes;
				$totalRendimentoBrutoMesAll += $totalRendimentoBrutoMes;
				$totalIRMesAll += $totalIRMes;
			}

            if($key > 0) {
                $totalSaldoLiquidoMesaMes = $totalSaldoLiquidoMesaMes -  $ant->inscricao + $ant->resgate_solicitado + $ant->resgate_rendimento - $ant->rendimento;
                $ant = $cadame;
            } else {
                $ant = $cadame;
            }

            $linhasDados.= "<tr>
                            <td>".$cadame->data_formatada."</td>
                            <td>".formata_moeda($cadame->inscricao)."</td>
                            <td>".formata_moeda($cadame->resgate_solicitado)."</td>
                            <td>".formata_moeda($cadame->resgate_rendimento)."</td>
                            <td>".formata_moeda($cadame->rendimento)."</td>
                            <td class='totalbrutomes' data-mes='$cadame->data'>".formata_moeda($totalRendimentoBrutoMes)."</td>
                            <td>".formata_moeda(($cadame->inscricao - $cadame->resgate_solicitado))."</td>
                            <td>".formata_moeda($totalSaldoLiquidoMesaMes)."</td>
                            <td class='saldototalbrutomes' data-mes='$cadame->data'>".formata_moeda($totalbrutoMes)."</td>
                            <td class='IRmes'>".formata_moeda($totalIRMes)."</td>
                            </tr>";

            $tableImpressao .= "<tr>
                            <td>".utf8_decode($cadame->data_formatada)."</td>
                            <td>".formata_moeda($cadame->inscricao)."</td>
                            <td>".formata_moeda($cadame->resgate_solicitado)."</td>
                            <td>".formata_moeda($cadame->resgate_rendimento)."</td>
                            <td>".formata_moeda($cadame->rendimento)."</td>
                            <td>".formata_moeda($totalRendimentoBrutoMes)."</td>
                            <td>".formata_moeda(($cadame->inscricao - $cadame->resgate_solicitado))."</td>
                            <td>".formata_moeda($totalSaldoLiquidoMesaMes)."</td>
                            <td>".formata_moeda($totalbrutoMes)."</td>
                            <td>".formata_moeda($totalIRMes)."</td>
                            </tr>";
            $totalAllme += ($cadame->inscricao - $cadame->resgate_solicitado);
            $totalRendimentome += $cadame->resgate_rendimento;
            $totalRendimentoliquidome += $cadame->rendimento;
            $totalSubscricaome += $cadame->inscricao;
            $totalRendimentoSolicitadome += $cadame->resgate_solicitado;
            $totalTotalSaldoLiquidome += ($cadame->inscricao - $cadame->resgate_solicitado - $cadame->resgate_rendimento + $cadame->rendimento);
        }

        $linhasDados .= '</tbody>
							<tfoot>
								<tr>
									<td colspan="1">Total:</td><td>'.formata_moeda($totalSubscricaome).'</td>
									<td>'.formata_moeda($totalRendimentoSolicitadome).'</td>
									<td>'.formata_moeda($totalRendimentome).'</td>
									<td>'.formata_moeda($totalRendimentoliquidome).'</td>
									<td id="totalBrutoAll">'.formata_moeda($totalbrutoMesAll).'</td>
									<td>'.formata_moeda($totalAllme).'</td>
									<td>'.formata_moeda($totalTotalSaldoLiquidome).'</td>
									<td id="totalBrutoMonth">'.formata_moeda($totalRendimentoBrutoMesAll).'</td>
									<td id="totalIR">'.formata_moeda($totalIRMesAll).'</td>
								</tr>
							</tfoot>
						</table>';


        $tableImpressao .= '</tbody>
								<tfoot>
									<tr>
										<td colspan="1">Total:</td><td>'.formata_moeda($totalSubscricaome).'</td>
										<td>'.formata_moeda($totalRendimentoSolicitadome).'</td>
										<td>'.formata_moeda($totalRendimentome).'</td>
										<td>'.formata_moeda($totalRendimentoliquidome).'</td>
										<td>'.formata_moeda($totalbrutoMesAll).'</td>
										<td>'.formata_moeda($totalAllme).'</td>
										<td>'.formata_moeda($totalTotalSaldoLiquidome).'</td>
										<td>'.formata_moeda($totalRendimentoBrutoMesAll).'</td>
										<td>'.formata_moeda($totalIRMesAll).'</td>
									</tr>
								</tfoot>
							</table>';

        $linhas = '<h2 class="tile-title">
                        <span class="texto pull-left m-t-10">
                            Tabela Total/Mês 
                        </span>
                        
                        <div class="pull-right">
                            <a class="btn btn-primary print m-l-5 m-r-5" ><i class="fa fa-print"></i></a>
                            <a class="btn btn-primary btnDownload"><i class="fa fa-file-excel-o"></i></a>
                        </div>
                    </h2>
                <table class="tile table table-bordered table-striped2 tablesorter" id="relatorio">
					<thead>
						<tr>
							<th class="filter-false sorter-false" data-name="Mês/Ano" data-placeholder="Filtrar Mês/Ano" >Mês/Ano</th>
							<th class="filter-false sorter-false" data-name="Subscrições" data-placeholder="Filtrar Subscrições" >Investimentos</th>
							<th class="filter-false sorter-false" data-name="Resgates" data-placeholder="Filtrar Resgates" >Resgates</th>
							<th class="filter-false sorter-false" data-name="Cupom" data-placeholder="Filtrar Cupom" >Cupom</th>
							<th class="filter-false sorter-false" data-name="Rendimento Líquido" data-placeholder="Filtrar Rendimento Líquido" >Rendimento Líquido</th>
							<th class="filter-false sorter-false" data-name="Rendimento Bruto" data-placeholder="Filtrar Rendimento Bruto" >Rendimento Bruto</th>
							<th class="filter-false sorter-false" data-name="Fluxo de Caixa" data-placeholder="Filtrar Fluxo de Caixa" >Fluxo de Caixa</th>
							<th class="filter-false sorter-false" data-name="Saldo Líquido" data-placeholder="Filtrar Saldo Líquido" >Saldo Líquido</th>
							<th class="filter-false sorter-false" data-name="Saldo Bruto" data-placeholder="Filtrar Saldo Bruto" >Saldo Bruto</th>
							<th class="filter-false sorter-false" data-name="IR Recolhido" data-placeholder="Filtrar IR Recolhido" >IR Recolhido</th>
						</tr>
					</thead><tbody>'.$linhasDados;

        echo $linhas;
        ?>
    </div>

    <div id="dialog-confirm"></div>

    <div id="divMensagem"></div>

</div>
<?php  }elseif($acao == 'semperm'){
    redirect(site_url('principal/sem_permissao'));
    ?>

    <!--<h4 class="page-title">Página Inicial</h4>

    <div class="block-area">

        <div id="divDados" class="div-dados clearfix">

        </div>

        <div id="dialog-confirm"></div>

        <div id="divMensagem"></div>

    </div>-->
<?php }

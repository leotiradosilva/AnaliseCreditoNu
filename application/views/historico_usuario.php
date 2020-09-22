<?php if($acao == 'principal')
{?><h4 class="page-title">Histórico
    <p class="sub-title">Acessos de Usuários</p>
</h4>

    <div class="block-area">

        <div id="divDados" class="div-dados clearfix">
            <?php
            //Cabecalho da tabela
            $total = 0;
            $linhas = '<table class="tile table table-bordered table-striped2 tablesorter" id="tablesorter">
					<thead>
						<tr>
							<th data-parser="customDate" data-name="Data" data-placeholder="Filtrar Data" >Data</th>
							<th data-name="Usuário" data-placeholder="Filtrar Usuário" >Usuário</th>
							<th data-name="IP" data-placeholder="Filtrar IP" >IP</th>
						</tr>
					</thead><tbody>';

            $linhasDados = "";
            foreach ($dados as $key => $cada)
            {
                $linhasDados.= "<tr>
                            <td>".inverterdatetime($cada->datahora_log)."</td>
                            <td>".($cada->nome_pes)."</td>
                            <td>".($cada->ip_log)."</td>
                            </tr>";

            }

            $linhasDados .= '</tbody></table>';
            $linhasDados .= '<div class="pager"> <span class="left">
                                Mostrar:
                                <a href="#" class="current">30</a>
                                <a href="#">50</a>
                                <a href="#">100</a>
                            </span>
                            <span class="center">
                                Total de Registros: '.$total.'
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

            $linhas .= $linhasDados;

            echo $linhas;
            ?>
        </div>

        <div id="dialog-confirm"></div>

        <div id="divMensagem"></div>

    </div>
<?php }elseif($acao == 'semperm'){
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
<?php if($acao == 'principal')
{?><h4 class="page-title">Comissão</h4>

    <div class="block-area">
        <div class="m-b-10 clearfix">
            <?php echo printaAnoMes($this->session, 'usuario/');
                echo $usuarios;
            ?>
        </div>

        <div id="divDados" class="div-dados clearfix">
            <?php
            //Cabecalho da tabela
            $total = 0;
            $linhas = '
                    <h2 class="tile-title clearfix">
                        <span class="texto pull-left m-t-10">Tabela Comissão</span> 
                        
                        <div class="acoes pull-right">
                            <a class="btn btn-primary print  m-l-5 m-r-5" ><i class="fa fa-print"></i></a>'.form_button('', '<i class="fa fa-file-excel-o"></i>', array('class'=> 'download btn btn-primary ', 'data-hidecolum'=>'', 'data-namearq'=>"comissao".date('dmY'))).'
                        </div>
                    </h2>
                    <table class="tile table table-bordered table-striped2 tablesorter" id="tablesorter">
					<thead>
						<tr>
							'.($this->session->userdata('usuario')['grupo'] == 1 ? '<th data-name="Usuário" data-placeholder="Filtrar Usuário" >Usuário</th>' : "").'
							<th data-name="Subscrição" data-placeholder="Filtrar Subscrição" >Subscrição</th>
							<th data-name="Cliente" data-placeholder="Filtrar Cliente" >Cliente</th>
							<th data-name="Taxa Comissão" data-placeholder="Filtrar Taxa Comissão" >Taxa Comissão</th>
							<th data-name="Comissão" data-placeholder="Filtrar Comissão" >Comissão</th>
							<th data-name="Total" data-placeholder="Filtrar Total" >Total</th>
						</tr>
					</thead><tbody>';

            $linhasDados = "";
            $totalComissao = 0;
            foreach ($dados as $key => $cada)
            {
                $subscricoes = $this->mod->buscaSubscricaoComissao($cada->codigo_pes,$cada->codigo_usu,$this->session->userdata('ano')."-".$this->session->userdata('mes')."-31");
                if(!empty($subscricoes))
                {
                    foreach ($subscricoes as $keysub => $cadasub)
                    {
                        $rendimento = $this->mod->buscaRendimentosMesSubscricao($cadasub->codigo_subs);
                        $comissao = 0;
                        $taxa = $cadasub->taxa_usupes;


                        //print_r($rendimento); exit;
                        foreach ($rendimento as $cadar)
                        {
                            $comissao += ($cadar->valor_rend * $taxa) / $cadar->taxa_rend;
                        }


                        $liquido = ($cadasub->valor_subs + $cadasub->rendimento - $cadasub->resgate);
                        $comissao = ($liquido * $taxa )/ 100;
                        $totalComissao += $comissao;
                        $linhasDados.= "<tr>
                            ".($this->session->userdata('usuario')['grupo'] == 1 ? '<td>'.$cada->nome_usu.'</td>' : "")."
                            <td>".($cadasub->codigo_subs)."</td>
                            <td>".($cadasub->nome_pes)."</td>
                            <td>".formata_moeda($taxa)."</td>
                            <td>".formata_moeda($comissao)."</td>
                            <td>".formata_moeda($liquido)."</td>
                            </tr>";
                    }
                }


            }

            $linhasDados .= '</tbody></table>';
            $linhasDados .= '<div class="pager"> <span class="left">
                                Mostrar:
                                <a href="#" class="current">30</a>
                                <a href="#">50</a>
                                <a href="#">100</a>
                            </span>
                            <span class="center">
                                Total de Comissão: '.formata_moeda($totalComissao).'
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
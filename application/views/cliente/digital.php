<!-- View Digital do CLiente -->
<?php
$id = $this->session->aluno['codigo'];
//print_r($this->session->aluno); exit;
if ($id == NULL)
    redirect('acesso/home');
?>

<div class="meu-perfil cada-perfil" style="display: block;">

    <?php

    if ($tipo == 1) {

        echo '<h4 class="page-title">Nova Subscrição (Deb 90 dias)</h4>';
    } else if ($tipo == 2) {

        echo '<h4 class="page-title">Nova Subscrição (Deb 360 dias)</h4>';
    }

    ?>

    <div class="block-area clearfix">
        <div class="tile">
            <div class="listview icon-list">

                <div class="media clearfix">
                    <label class="col-md-1 control-label">Dados bancários para investimento:</label>
                    <div class="col-md-9">
                        <?php
                        echo "<p>Banco Itaú: 341 <br/>
Agência: 8719 <br/>
Conta corrente: 27505-2<br/>
Titular da conta: <span style='font-weight: bold;'>FMI SECURITIZADORA S/A</span><br/>
<span style='font-weight: bold; margin-left:90px;'>CNPJ/MF 20.541.441/0001-08</span>
</p>";
                        ?>
                    </div>
                </div>

                <div class="media clearfix">
                    <label class="col-md-1 control-label">Disclaimer: </label>
                    <span class="col-md-9"><?php echo "Ao realizar uma transferência para conta da emissora, identificamos o recebimento e em até 24 horas alertamos via sistema as características da subscrição realizada, a qual deverá ser confirmada pelo subscritor com sua assinatura digital.<br/>
- O subscritor deve assinalar como quer performar seus rendimentos (resgatar mensalmente ou reinvestir);<br/>
- A transferência deve ocorrer de uma conta bancária de mesmo CPF do subscritor;<br/>
- Todas as características da subscrição estão detalhadas na escritura da debênture;<br/>
- O subscritor confirma possuir ciência dos termos de subscrição de acordo com a escritura da debênture;<br/>
- Para fins de segurança, o subscritor receberá também um alerta via e-mail como forma de registro pessoal.<br/>
" ?></span>
                </div>

                <div class="media clearfix">
                    <label class="col-md-1 control-label">Escritura Debênture: </label>
                    <div class="col-md-9"><a class='btn btn-acao-tabela' href="<?= base_url('cliente/investimentos/downloadEscritura/' . $tipo) ?>" title="Download Escritura"><i class='fa fa-cloud-download'></i> Download</a></div>
                </div>
            </div>
        </div>

        <h4 class="page-title p-l-0">Investimentos Pendentes</h4>
        <div class="tile">
            <div class="listview icon-list">
                <table class="tile table table-bordered table-striped tablesorter table-responsive" id="tablesorter">
                    <thead>
                        <tr>
                            <!-- <th data-name="Código" data-placeholder="Filtrar Código">Código</th> -->
                            <th data-name="Data" data-placeholder="Filtrar Data">Data Investimento</th>
                            <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                            <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Valor Investido</th>
                            <th data-name="" data-placeholder=""></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        if (!empty($subscricoesPendentes)) {
                            foreach ($subscricoesPendentes as $key => $cada) {
                                $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;
                                echo "<tr>  
<!-- <td>" . $cada->codigo_subs . "</td> --> 
<td>" . inverterdata($cada->data_subs) . "</td>
<td>" . formata_cupom($cada->taxa_subs) . "</td>
<td>" . formata_moeda($cada->valor_subs) . "</td>
<td>" . "<a class='btn btn-action-table tooltips' data-toggle='tooltip' data-placement='top' title='Aceitar Subscrição' 
onclick='aceitarSubscricao(
" . $cada->codigo_subs . ", \""
                                    . inverterdata($cada->data_subs) . "\", \""
                                    . $cada->taxa_subs . "\", \""
                                    . formata_moeda($cada->valor_subs) . "\")'>
<i class='fa fa-check'></i></a>" .
                                    "</td>
</tr>";

                                $saldoTotalCliente += $totalrendimento;
                            }
                        } else {
                            echo "<tr >
<td colspan='5'>Nenhuma Subscrição Pendente Encontrada!</td>
</tr>";
                        }


                        ?>
                    </tbody>
                </table>
            </div>
        </div>



    </div>
</div>

<div class="subscricoes cada-perfil">

    <h4 class="page-title">Investimento</h4>
    <div class="block-area">

        <table class="tile table table-bordered table-striped tablesorter table-responsive" id="tablesorter">
            <thead>
                <tr>
                    <th data-name="Código" data-placeholder="Filtrar Código">Código</th>
                    <th data-name="Data" data-placeholder="Filtrar Data">Data Investimento</th>
                    <th data-name="Cliente" data-placeholder="Filtrar Cliente">Cliente</th>
                    <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                    <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Valor Investido</th>
                    <th data-name="Rendimento" data-placeholder="Filtrar Rendimento">Rendimento</th>
                </tr>
            </thead>
            <tbody>
                <?php



                foreach ($subscricoes as $key => $cada) {
                    $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;
                    echo "<tr>
<td>" . $cada->codigo_subs . "</td>
<td>" . inverterdata($cada->data_subs) . "</td>
<td>" . $cada->nome_pes . "</td>
<td>" . formata_cupom($cada->taxa_subs) . "</td>
<td>" . formata_moeda($cada->valor_subs) . "</td>
<td>" . ($cada->rendimento_subs == 0 ? "Resgatar Mensalmente" : "Reinvestir") . "</td>
</tr>";

                    $saldoTotalCliente += $totalrendimento;
                }

                ?>
            </tbody>
        </table>
    </div>

</div>

<div class="saldo cada-perfil">

    <h4 class="page-title">Investimento</h4>
    <div class="block-area">
        <table class="tile table table-bordered table-striped tablesorter table-responsive tabela-especial" id="tablesorter">
            <thead>
                <tr>
                    <th data-name="Código" data-placeholder="Filtrar Código">Código Investimento</th>
                    <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                    <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Saldo Atual</th>
                    <th data-name="Ação" data-sorter="false" class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($subscricoes as $key => $cada) {
                    $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;
                    echo "<tr>
<td>" . $cada->codigo_subs . "</td>
<td>" . formata_cupom($cada->taxa_subs) . " %</td>
<td>" . formata_moeda($totalrendimento) . "</td>
<td>" . form_button(array("content" => "<i class='fa fa-file-text'></i>", 'name' => "btnExtrato", 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Extrato', 'onClick' => 'visualizarExtrato(\'' . base64_encode($cada->codigo_subs) . '\')'))
                        . " " . anchor("acesso/fazerSimulacao/" . base64_encode($cada->codigo_subs), "<i class='fa fa-dollar'></i>", array('name' => "btnResgate", 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Simular Saldo'))
                        . " " . anchor("acesso/fazerResgate/" . base64_encode($cada->codigo_subs), "<i class='fa fa-money'></i>", array('name' => "btnResgate", 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Resgate'))
                        . " " . form_button(array("content" => "<i class='fa fa-area-chart'></i>", 'name' => "btnGrafico", 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Gráficos', 'onClick' => 'graficosRendimento(\'' . base64_encode($cada->codigo_subs) . '\')'))
                        . "</td>
</tr>";

                    $saldoTotalCliente += $totalrendimento;
                }

                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Saldo Total</td>
                    <td><?php echo formata_moeda($saldoTotalCliente); ?></td>
                </tr>
            </tfoot>
        </table>



    </div>
</div>

<div class="resgates cada-perfil">
    <h4 class="page-title">Resgates</h4>
    <div class="block-area">
        <table class="tile table table-bordered table-striped tablesorter table-responsive" id="tablesorter">
            <thead>
                <tr>
                    <th data-name="Data" data-placeholder="Filtrar Data">Código Subscrição</th>
                    <th data-name="Data" data-placeholder="Filtrar Data">Cliente</th>
                    <th data-name="Data" data-placeholder="Filtrar Data">Data</th>
                    <th data-name="Valor" data-placeholder="Filtrar Valor">Valor</th>
                    <th data-name="Ação" data-sorter="false" class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (!empty($resgates)) {
                    foreach ($resgates as $key => $cada) {
                        echo "<tr>
<td>" . $cada->codigo_subs . "</td>
<td>" . $cada->nome_pes . "</td>
<td>" . inverterdata($cada->data_resg) . "</td>
<td>" . formata_moeda($cada->valor_resg) . "</td>
<td>" . "</td>
</tr>";

                        $saldoTotalCliente += $cada->valor_resg;
                    }
                } else {
                    echo "<tr>
<td colspan='5'>" . "Não há valores resgatados" . "</td>
</tr>";
                }


                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total Resgatado</td>
                    <td><?php echo formata_moeda($saldoTotalCliente); ?></td>
                </tr>
            </tfoot>
        </table>


    </div>

</div>

</div>

<div class="modal fade" id="modal-extrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Extrato </h4>
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

<div class="modal fade" id="modal-grafico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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



<div class="modal fade" id="modal-aceitar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar Investimento</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse">Dados Investimento</h2>
                    </div>
                    <div class="tile tile-reverse">
                        <div class="listview icon-list">
                            <div class="media clearfix">
                                <label class="col-md-2 control-label">Data: </label>
                                <span class="col-md-9"><span id="dataSubscricao"></span></span>
                            </div>

                            <div class="media clearfix">
                                <label class="col-md-2 control-label">Remuneração Mensal Líquida (%): </label>
                                <span class="col-md-9" id="spanTaxa"></span>
                            </div>

                            <div class="media clearfix">
                                <label class="col-md-2 control-label">Valor (R$): </label>
                                <span class="col-md-9" id="spanValorSubscricao"></span>
                            </div>
                        </div>
                    </div>

                    <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse">Dados da Confirmação</h2>
                    </div>

                    <div class="tile tile-reverse p-15 form-horizontal clearfix p-t-20 m-b-0 p-b-0">

                        <div class="form-group clearfix">

                            <label class="col-md-2 control-label">Tipo Rendimento: </label>

                            <div class="col-md-9">
                                <?php echo form_dropdown(array('name' => "rendimento_subs", 'id' => 'ddlRendimento', 'class' => 'form-control'), array('' => "---------------", "0" => "Resgatar Mensalmente", "1" => "Reinvestir"), set_value("rendimento_subs")) ?>
                            </div>

                        </div>

                        <div class="form-group clearfix m-t-20">

                            <label class="col-md-2 control-label">Assinatura Digital: </label>

                            <div class="col-md-9">
                                <?php
                                echo form_input(array(
                                    'type' => 'password',
                                    'name' => 'inscricao',
                                    'id' => 'inscricao',
                                    'class' => 'form-control  input1',
                                    'value' => (set_value("inscricao"))
                                )); ?>
                            </div>
                        </div>

                        <div class="form-group clearfix m-t-20">

                            <div class="checkbox" style="margin-left: 20px">
                                <label style="display: flex; justify-content: space-between; align-items: flex-start">
                                    <div class="aux-check">
                                        <input type="checkbox" id="ckbTotal2">
                                    </div>
                                    <p style="color: black">
                                    <?php if ($tipo == 1) {
                                        echo 'Estou ciente e de acordo com os termos da Debenture, a qual subscrevo neste momento, dispostos em sua escritura e disponível 
                                        em <a href="https://www.fmisa.com.br/escrituradeprimeiraemissao.pdf" target="_blank">www.fmisa.com.br/escrituradeprimeiraemissao.pdf</a> Para formalizar o Ato de Subscrição assino digitalmente o presente boletim de subscrição, 
                                        cujo modelo tive acesso em <a href="https://www.fmisa.com.br/boletimdeprimeiraemissao.pdf" target="_blank">www.fmisa.com.br/boletimdeprimeiraemissao.pdf</a>';
                                    } else {
                                        echo 'Estou ciente e de acordo com os termos da Debenture, a qual subscrevo neste momento, dispostos em sua escritura e disponível 
                                        em <a href="https://www.fmisa.com.br/escrituradesegundaemissao.pdf" target="_blank">www.fmisa.com.br/escrituradesegundaemissao.pdf</a>. Para formalizar o Ato de Subscrição assino digitalmente o presente boletim de subscrição, 
                                        cujo modelo tive acesso em <a href="https://www.fmisa.com.br/boletinsdesegundaemissao.pdf" target="_blank">www.fmisa.com.br/boletinsdesegundaemissao.pdf</a>';
                                    } ?>
                                    </p>
                                </label>
                            </div>

                        </div>

                        <input type="hidden" id="codigoSubscricaoAceita" value="">

                    </div>
                </div>

            </div>

            <div class="modal-footer m-t-0">
                <button type="button" class="btn btn-success btn-reverse" id="btnConfirmarSubscricao" disabled> <i class="fa fa-check"></i> Confirmar</button>
                <button type="button" class="btn btn-danger btn-reverse" data-dismiss="modal"> <i class="fa fa-times"></i> Fechar</button>
            </div>
        </div>
    </div>
</div>
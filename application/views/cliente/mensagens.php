<div class="subscricoes">

    <h4 class="page-title">Mensagens</h4>
    <div class="block-area">
        <table class="tile table table-bordered table-striped tablesorter table-responsive"
               id="tablesorter">
            <thead>
            <tr>
                <th data-name="Data" data-placeholder="Filtrar Data">Data</th>
                <th data-name="Assunto" data-placeholder="Filtr ar Assunto">Assunto</th>
                <th data-name="Mensagem" data-placeholder="Filtrar Mensagem">Mensagem</th>
                <th data-name="Ação" data-placeholder="Filtrar Ação">Ação</th>
            </tr>
            </thead>
            <tbody>
            <?php
            
            if(!empty($mensagens))
            {
                foreach ($mensagens as $key => $cada) {
                    echo "<tr>
                        <td>" . Mysql_to_Data($cada->datacriado_mes) . "</td>
                        <td>" . ($cada->assunto_mes) . "</td>
                        <td>" . ($cada->conteudo_mes) . "</td>
                        <td>" .
                                (empty($cada->datalido_mes) ? form_button("", '<i class="fa fa-eye"></i>', array('class'=>"btn btn-action-table", "title"=>'Ler', 'onclick'=>'marcarLido('.$cada->codigo_mes.', \''.base64_encode(utf8_decode($cada->assunto_mes)).'\', \''.base64_encode(utf8_decode($cada->conteudo_mes)).'\')')) : "").
                                form_button(array('name'=>'btnExcluir', 'content'=>'<i class="fa fa-trash-o"></i>', 'class'=>"btn btn-action-table", 'title'=>'Excluir', 'onClick'=>'inativar('.$cada->codigo_mes.')')).
                        "</td>
                     </tr>";

                    $total++;
                }
            }
            else
            {
                echo "<tr>
                        <td colspan='4'>Nenhuma Mensagem encontrada!</td>
                     </tr>";
            }


            ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
        <div class="pager"> <span class="left">
                        Mostrar:
                        <a href="#" class="current">30</a>
                        <a href="#">50</a>
                        <a href="#">100</a>
                    </span>
            <span class="center">
                Total de Registros: <?php echo $total; ?>
                    </span>
            <span class="right">
                            <span class="prev">
                                <img src="<?php echo CLOUDFRONT.'tablesorter/css/images/prev.png' ?>" /> Ant&nbsp;
                            </span>
                     <span class="pagecount"></span>
                     &nbsp;<span class="next">Prox
                                <img src="<?php echo CLOUDFRONT.'tablesorter/css/images/next.png' ?>" />
                            </span>
                    </span>
        </div>
    </div>

</div>

<div class="modal fade" id="modal-lido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Mensagem</h4>
            </div>

            <div class="modal-body">
                <div class="form-group clearfix m-b-20">
                    <label class="col-md-1 m-t-5 control-label text-black">Assunto: </label>
                    <div class="col-md-10">
                        <p id="assunto_message" class="text-black m-t-7 p-l-10"></p>
                    </div>
                </div>
                <div class="form-group clearfix m-b-20">
                    <label class="col-md-1 m-t-5 control-label text-black">Mensagem: </label>
                    <div class="col-md-10">
                        <p id="conteudo_message" class="text-black m-t-7 p-l-10"></p>
                    </div>
                </div>
                <div class="form-group clearfix m-b-20">
                    <h4 class="col-md-12 m-t-5 page-title p-0">Marcar como Lido</h4>
                </div>
                <div class="form-group clearfix m-b-20">
                    <label class="col-md-2 m-t-10 control-label text-black">Assinatura Digital</label>
                    <div class="col-md-6">
                        <?php
                        echo form_input(array(
                            'type'  => 'password',
                            'name'  => 'digital_sign',
                            'id'    => 'digital_sign',
                            'value' => '',
                            'class' => 'form-control input1 text-black'))

                        ?>
                    </div>
                </div>




                <input type="hidden" name="codigo_mes" id="codigo_mes" value="">
            </div>



            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="confirmarLido()">Confirmar</button>
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

<?php

$id = $this->session->aluno['codigo'];
    if ($id == NULL){
        redirect('acesso/home');
    }
?>

<div class="subscricoes">

    <h4 class="page-title">Indicadores</h4>
    <div class="block-area">
        <table class="tile table table-indicadores table-bordered table-striped tablesorter table-responsive"
               id="tablesorter">
            <thead>
            <tr>
                <th data-name="Mês" data-placeholder="Filtrar Mês">Mês</th>
                <th data-name="Arquivo" data-placeholder="Filtrar Arquivo">Arquivo</th>
            </tr>
            </thead>
            <tbody>
            <?php
            
            if(!empty($subscricoes)){
                foreach ($subscricoes as $key => $cada){

                      echo "<tr>
                                <td>" . Mes(splitData($cada->mes_ind)['month'])." / ". splitData($cada->mes_ind)['year'] . "</td>
                                <td>" . "<a class='btn  btn-action-table tooltips' data-toggle='tootilp' data-placement='top' title='Visualizar' href='javascript:visualizarIndicador(".'"'.$cada->upload_ind.'"'.", \"Indicador_". Mes(splitData($cada->mes_ind)['month'])."-". splitData($cada->mes_ind)['year'].".pdf\")'><i class='fa fa-search'></i></a>" . "</td>
                            </tr>";

                }
            } else {
                echo "<tr>
                        <td colspan='5'>Nenhum Indicador Encontrado!</td>
                     </tr>";
            }


            ?>
            </tbody>

        </table>
    </div>

</div>



        <div class="modal fade" id="modal-grafico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" style="">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Indicador</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">

                            <div id="divArquivo">


                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-danger" id="btnDownload">Download PDF</button> -->
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
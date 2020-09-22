<?php
/**
 * Created by PhpStorm.
 * User: richa
 * Date: 25/01/2017
 * Time: 10:46
 */

if ($operacao == "c") //----------------------------------------- Consulta --------------------------------------------------
{ ?>

    <h4 class="page-title clearfix">
        <div class="pull-left m-t-10">
            Tarefas
        </div>

        <div class="pull-right">
            <?php echo ($permissao->inserir ? anchor('tarefa/add', '<i class="fa fa-plus icone-botoes"></i> Adicionar', array('class' => 'btn btn-primary novo-registro')) : "") . " "
            //($permissao->alterar ? form_button('', '<i class="fa fa-print"></i> Imprimir', array('class'=> 'print btn btn-primary novo-registro')) : "")." ".
            //($permissao->alterar ? form_button('', '<i class="fa fa-file-excel-o"></i> Exportar', array('class'=> 'download btn btn-primary ', 'data-hidecolum'=>6, 'data-namearq'=>"Mensagens".date('dmY'))) : "")

            ?>
        </div>
    </h4>

    <div class="block-area">


        <div id="divDados" class="div-dados clearfix">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                       aria-controls="home" aria-selected="true">Recebidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                       aria-controls="profile" aria-selected="false">Enviados</a>
                </li>

            </ul>
            <div class="tab-content p-l-0 p-r-0" id="myTabContent">
                <div class="tab-pane fade active in" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?php
                    //Cabecalho da tabela
                    $total = 0;
                    $linhas = '<table class="tile table table-bordered table-striped2 tablesorter" id="tablesorter">
					<thead>
						<tr>
							<th data-name="Data" data-placeholder="Filtrar Data" >Data</th>
							<th data-name="Usuário" data-placeholder="Filtrar Usuário" >Usuário</th>
							<th data-name="Tarefa" data-placeholder="Filtrar Tarefa" >Tarefa</th>
							<th data-name="Confirmado" data-placeholder="Filtrar Confirmado" >Confirmado</th>
							<th data-name="Ação" data-sorter="false" class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao inviPrint">A&ccedil;&atilde;o</th>
						</tr>
					</thead><tbody>';


                    foreach ($dadosRecebidos as $cada) {

                        //$editar = '<a href="edit/'.$apto['codigo_apto'].'" class="btn sumir-responsivo btn-default btn-acao-tabela invi" title="Editar"><i class="fa fa-edit"></i></a> ';
                        //$excluir = '<a href="Javascript: Inativar(\''.$codigo.'\', \''.$nome.'\')" class="btn sumir-responsivo btn-default btn-acao-tabela inativar invi" title="Excluir"><i class="fa fa-trash-o"></i></a> ';

                        $linhas .= '<tr class="" >
											<td class=" hover-data" >' . Mysql_to_Data($cada['data_tar']) . '</td>
											<td class=" hover-data" >' . $cada['nome_usu'] . '</td>
											<td class=" hover-data" >' . $cada['desc_tar'] . '</td>
											<td class=" hover-data" >' . (!empty($cada['concluido_tar']) ? Mysql_to_Data($cada['concluido_tar']) : " - ") . '</td>
											<td class=" sumir-impressao inviPrint">' . ($permissao->alterar && empty($cada['concluido_tar']) ? form_button('', '<i class="fa fa-check"></i>', array('class' => "btn btn-default btn-action-table btn-acao-tabela", "title" => 'Editar', 'onclick' => 'confirmaConcluido(' . $cada['codigo_tar'] . ')')) : "") . " " .
                            ($permissao->detalhar ? anchor("tarefa/detail/" . base64_encode($cada['codigo_tar']), '<i class="fa fa-plus-circle"></i>', array('class' => "btn btn-default btn-action-table btn-acao-tabela", "title" => 'Detalhar')) : "") . " " .
                            //($permissao->alterar && empty($cada['dataresgatado_tar']) ? form_button(array('name'=>'btnConfirmar', 'content'=>'<i class="fa fa-check"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Confirmar tarefa', 'onClick'=>'confirmartarefa('.$cada['codigo_tar'].', \''.Mysql_to_Data($cada['data_tar']).'\', \''.formata_moeda($cada['valor_tar']).'\')')) : "").
                            //($permissao->excluir && empty($cada['datalido_tar']) ? form_button(array('name'=>'btnExcluir', 'content'=>'<i class="fa fa-trash-o"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Excluir', 'onClick'=>'inativar('.$cada['codigo_tar'].')')) : "").'</td>

                            '</tr>';

                        $total += 1;

                    }


                    $linhas .= '</tbody></table>';
                    $linhas .= '<div class="pager"> <span class="left">
                                Mostrar:
                                <a href="#" class="current">30</a>
                                <a href="#">50</a>
                                <a href="#">100</a>
                            </span>
                            <span class="center">
                                Total de Registros: ' . $total . '
                            </span>
                             <span class="right">
                                    <span class="prev">
                                        <img src="' . CLOUDFRONT.'tablesorter/css/images/prev.png' . '" /> Ant&nbsp;
                                    </span>
                             <span class="pagecount"></span>
                             &nbsp;<span class="next">Prox 
                                        <img src="' . CLOUDFRONT.'tablesorter/css/images/next.png' . '" /> 
                                    </span>
                            </span>
                        </div>';
                    /*<tr>
                        <td colspan="7"><center>Total de Dados: ' . $total . '</center></td>
                    </tr>
                                    </tfoot></table>';*/

                    echo $linhas;
                    ?>

                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?php
                    //Cabecalho da tabela
                    $total = 0;
                    $linhas = '<table class="tile table table-bordered table-striped2 tablesorter" id="tablesorter2">
					<thead>
						<tr>
							<th data-name="Data" data-placeholder="Filtrar Data" >Data</th>
							<th data-name="Usuário" data-placeholder="Filtrar Usuário" >Usuário</th>
							<th data-name="Tarefa" data-placeholder="Filtrar Tarefa" >Tarefa</th>
							<th data-name="Confirmado" data-placeholder="Filtrar Confirmado" >Confirmado</th>
							<th data-name="Ação" data-sorter="false" class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao inviPrint">A&ccedil;&atilde;o</th>
						</tr>
					</thead><tbody>';


                    foreach ($dados as $cada) {

                        //$editar = '<a href="edit/'.$apto['codigo_apto'].'" class="btn sumir-responsivo btn-default btn-acao-tabela invi" title="Editar"><i class="fa fa-edit"></i></a> ';
                        //$excluir = '<a href="Javascript: Inativar(\''.$codigo.'\', \''.$nome.'\')" class="btn sumir-responsivo btn-default btn-acao-tabela inativar invi" title="Excluir"><i class="fa fa-trash-o"></i></a> ';

                        $linhas .= '<tr class="" >

											<td class=" hover-data" >' . Mysql_to_Data($cada['data_tar']) . '</td>
											<td class=" hover-data" >' . $cada['nome_usu'] . '</td>
											<td class=" hover-data" >' . $cada['desc_tar'] . '</td>
											<td class=" hover-data" >' . (!empty($cada['concluido_tar']) ? Mysql_to_Data($cada['concluido_tar']) : " - ") . '</td>
											<td class=" sumir-impressao inviPrint">' . ($permissao->alterar && empty($cada['concluido_tar']) ? anchor("tarefa/edit/" . base64_encode($cada['codigo_tar']), '<i class="fa fa-edit"></i>', array('class' => "btn btn-default btn-action-table btn-acao-tabela", "title" => 'Editar')) : "") . " " .
                            ($permissao->detalhar ? anchor("tarefa/detail/" . base64_encode($cada['codigo_tar']), '<i class="fa fa-plus-circle"></i>', array('class' => "btn btn-default btn-action-table btn-acao-tabela", "title" => 'Detalhar')) : "") . " " .
                            //($permissao->alterar && empty($cada['dataresgatado_tar']) ? form_button(array('name'=>'btnConfirmar', 'content'=>'<i class="fa fa-check"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Confirmar tarefa', 'onClick'=>'confirmartarefa('.$cada['codigo_tar'].', \''.Mysql_to_Data($cada['data_tar']).'\', \''.formata_moeda($cada['valor_tar']).'\')')) : "").
                            ($permissao->excluir && empty($cada['concluido_tar']) ? form_button(array('name' => 'btnExcluir', 'content' => '<i class="fa fa-trash-o"></i>', 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Excluir', 'onClick' => 'inativar(' . $cada['codigo_tar'] . ')')) : "") . '</td>

										</tr>';

                        $total += 1;

                    }


                    $linhas .= '</tbody></table>';
                    $linhas .= '<div class="pager"> <span class="left">
                                Mostrar:
                                <a href="#" class="current">30</a>
                                <a href="#">50</a>
                                <a href="#">100</a>
                            </span>
                            <span class="center">
                                Total de Registros: ' . $total . '
                            </span>
                             <span class="right">
                                    <span class="prev">
                                        <img src="' . CLOUDFRONT.'tablesorter/css/images/prev.png' . '" /> Ant&nbsp;
                                    </span>
                             <span class="pagecount"></span>
                             &nbsp;<span class="next">Prox 
                                        <img src="' . CLOUDFRONT.'tablesorter/css/images/next.png' . '" /> 
                                    </span>
                            </span>
                        </div>';
                    /*<tr>
                        <td colspan="7"><center>Total de Dados: ' . $total . '</center></td>
                    </tr>
                                    </tfoot></table>';*/

                    echo $linhas;
                    ?>

                </div>
            </div>


        </div>

        <div id="dialog-confirm"></div>

        <div id="divtarefa"></div>

    </div>

    <!-- Div do fancybox de detalhes do conteudo -->
    <div id="divDetalhes" class="div-detalhes-agenda"></div>


    <div class="modal fade" id="modal-confirmar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar Tarefa</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse">Dados Confirmação</h2>
                    </div>
                    <div class="tile tile-reverse">
                        <div class="listview icon-list">
                            <div class="media clearfix">
                                <label class="col-md-2 control-label">Data da Solicitação: </label>
                                <span class="col-md-9" id="dataSolicitacao"></span>
                            </div>
                            <div class="media clearfix">
                                <label class="col-md-2 control-label">Valor Solicitado: </label>
                                <span class="col-md-9" id="valorSolicitacao"></span>
                            </div>

                        </div>

                        <div class="form-group clearfix m-t-20">
                            <label class="col-md-2 control-label">Data do tarefa: </label>
                            <div class="col-md-9">
                                <?php
                                $predata = ((date('Y-m-d')));

                                echo form_input(array('type' => 'text',
                                    'name' => 'data_tar',
                                    'id' => 'data_tar',
                                    'readonly' => '',
                                    'class' => 'form-control  input1',
                                    'value' => inverterdata(set_value("data_tar", $predata)))); ?>
                            </div>
                        </div>
                        <input type="hidden" id="codigotarefa" value="">
                        <input type="hidden" id="preencheDatatarefa" value="<?php echo inverterdata($predata); ?>">

                        <?php
                        echo '</div>';
                        ?>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-reverse" id="btnConfirmartarefa">Confirmar</button>
                    <button type="button" class="btn btn-danger btn-reverse" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


<?php } //-------------------------------------------------- Cadastro -------------------------------------------------
elseif ($operacao == 'a') {
    ?>

    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("tarefa/index") ?>">tarefa</a></li>
        <li class="active">Cadastrar tarefa</li>
    </ol>
    <h4 class="page-title">
        Tarefa

        <p class="sub-title">Adicionar</p>
    </h4>

    <div class="block-area clearfix">
    <div class="tile p-15 form-horizontal clearfix p-t-20">
    <?php
    $atributos = array('class' => 'form-signin', 'id' => 'form1');
    echo form_open('tarefa/add', $atributos, array('ativo_subs' => 1));

    if (validation_errors() != '') {
        echo '<div class="alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
    }

    if ($this->session->flashdata('cadastro')) {
        echo '<div class="clearfix alert-success">' . $this->session->flashdata('cadastro') . '</div>';
    }

    echo '<div class="form-group m-t-10 clearfix">
            <label class="col-md-2 control-label">Tarefa para: </label>
            <div class="col-md-9">
                ' . form_dropdown(array('name' => "codigo_usu", 'id' => 'ddlUsuario', 'class' => 'form-control input1'), $usuarios, set_value('codigo_usu')) . '
            </div>
        </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Data: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
            'type' => 'text',
            'name' => 'data_tar',
            'id' => 'data_tar',
            'readonly' => '',
            'value' => set_value('data_tar'),
            'class' => 'form-control input1')) . '
		            </div>
		        </div>';

    echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">' . form_label("Tarefa: ") . '</label>
                <div class="col-md-9">
                    ' . form_textarea(array(
            'type' => 'text',
            'name' => 'desc_tar',
            'id' => 'desc_tar',
            'value' => set_value('desc_tar'),
            'class' => 'form-control input1')) . '
                </div>
            </div>';

    echo '<input type="hidden" name="sender_tar" value="' . $this->session->userdata('usuario')['codigo'] . '"  />';


    echo '<div class="form-group clearfix">
            <div class="col-md-offset-2 col-md-10 m-t-10">
			' . form_submit(array('name' => 'btnSalvar', 'id' => 'btnSalvar', 'value' => 'Salvar e Voltar', 'class' => 'btn btn-primary')) .
        form_submit(array('name' => 'btnSalvar', 'id' => 'btnSalvar', 'value' => 'Salvar', 'class' => 'btn btn-primary')) .
        anchor('tarefa/index', "Voltar", array('class' => 'btn btn-danger')) .
        '
            
            </div>
        </div>
        ' . form_close() . '

    </div></div>';

}
elseif ($operacao == 'u') {
    //--------------------------------- Update ---------------------------------------------
    $id = pegaParam1($this->uri);

    if ($id == NULL) redirect('tarefa/index');

    $result = $this->mod->get_byid($id);
    $res = $result[0];


    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("tarefa/index") ?>">tarefa</a></li>
        <li class="active">Alterar tarefa</li>
    </ol>
    <h4 class="page-title">
        Tarefa
        <p class="sub-title">Alterar</p>
    </h4>

    <div class="block-area clearfix">
    <div class="tile p-15 form-horizontal clearfix p-t-20">
    <?php

    $atributos = array('class' => 'form-signin', 'id' => 'form1');
    echo form_open('tarefa/edit/' . base64_encode($res->codigo_tar), $atributos, array('ativo_tar' => $res->ativo_tar, 'cd' => $res->codigo_tar));

    if (validation_errors() != '') {
        echo '<div class="alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
    }

    if ($this->session->flashdata('alterar')) {
        echo '<div class="clearfix alert alert-success">' . $this->session->flashdata('alterar') . '</div>';
    }



    echo '<div class="form-group m-t-10 clearfix">
            <label class="col-md-2 control-label">Tarefa para: </label>
            <div class="col-md-9">
                ' . form_dropdown(array('name' => "codigo_usu", 'id' => 'ddlUsuario', 'class' => 'form-control input1'), $usuarios, set_value('codigo_usu', $res->codigo_usu)) . '
            </div>
        </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Data: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
            'type' => 'text',
            'name' => 'data_tar',
            'id' => 'data_tar',
            'readonly' => '',
            'value' => set_value('data_tar', Mysql_to_Data($res->data_tar)),
            'class' => 'form-control input1')) . '
		            </div>
		        </div>';

    echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">' . form_label("Tarefa: ") . '</label>
                <div class="col-md-9">
                    ' . form_textarea(array(
            'type' => 'text',
            'name' => 'desc_tar',
            'id' => 'desc_tar',
            'value' => set_value('desc_tar', $res->desc_tar),
            'class' => 'form-control input1')) . '
                </div>
            </div>';

    echo '<div class="form-group clearfix">
            <div class="col-md-offset-2 col-md-10 m-t-10">' .
        form_submit(array('name' => 'btnSalvar', 'id' => 'btnSalvar', 'value' => 'Salvar', 'class' => 'btn btn-primary')) .
        anchor('tarefa/index', "Voltar", array('class' => 'btn btn-danger')) . '
            
            </div>
        </div>
        ' . form_close() . '

    </div></div>';
}
elseif ($operacao == 'd') {
    //--------------------------------- Detalhar ---------------------------------------------
    $id = base64_decode($this->uri->segment(3));

    if ($id == NULL) redirect('tarefa/index');

    $result = $this->mod->get_byid($id);
    $res = $result[0];


    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("tarefa/index") ?>">Tarefas</a></li>
        <li class="active">Detalhar Tarefa</li>
    </ol>
    <h4 class="page-title clearfix p-t-35">
        <div class="pull-left">
            Tarefa
            <p class="sub-title">Detalhes</p>
        </div>

        <div class="pull-right">
            <a href="<?php echo site_url("tarefa/index") ?>" class="btn"> <i class="fa fa-undo"></i> Voltar</a>
        </div>
    </h4>

    <div class="block-area clearfix">

    <div class="tile">
    <div class="listview icon-list">
    <?php

    echo '<div class="media clearfix">
		            <label class="col-md-2 control-label">Tarefa Para: </label>
		            <div class="col-md-9">
		                ' . form_label(($res->nome_usu)) . '
		            </div>
		        </div>';


    echo '<div class="media clearfix">
		            <label class="col-md-2 control-label">Data:</label>
		            <div class="col-md-9">
		                ' . form_label(Mysql_to_Data($res->data_tar)) . '
		            </div>
		        </div>';

    echo '<div class="media clearfix">
		            <label class="col-md-2 control-label">Tarefa:</label>
		            <div class="col-md-9">
		                ' . form_label(($res->desc_tar)) . '
		            </div>
		        </div>';

    echo '<div class="media clearfix">
		            <label class="col-md-2 control-label">Concluido:</label>
		            <div class="col-md-9">
		                ' . form_label((!empty($res->concluido_tar) ? Mysql_to_Data($res->concluido_tar) : " - ")) . '
		            </div>
		        </div>';



    echo '</div></div></div>';
}
elseif ($operacao == 'import') {
    //--------------------------------- Update ---------------------------------------------
    ?>
    <div class="clearfix titulo-principal">
        <h1>Importar Números</h1>
    </div>

    <section class="cada-conteudo clearfix">
    <div class="titulo-secundario clearfix">
        <h1>
            <i class="fa fa-plus-square"></i> Arquivo
        </h1>
    </div>
    <?php


    echo form_open_multipart('tarefa/import');
    if (validation_errors() != '') {
        echo '<div class="alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
    }

    if ($this->session->flashdata('erro')) {
        echo '<div class="alert-danger clearfix">' . $this->session->flashdata('cadastro') . '</div>';
    }

    echo '<div class="cada-input clearfix">
		            <div class="cada-nome">' . form_label("Arquivo de Importação: ") . '</div>
		            <div class="cada-elemento cada-elemento-2">
		                ' . form_input(array('type' => 'file', 'name' => 'importacao')) . '
		            </div>
		        </div>';

    echo '<div class="area-botao-salvar clearfix">
					' . form_submit(array('name' => 'btnSalvar', 'id' => 'btnSalvar', 'value' => 'Importar', 'class' => 'btn btn-primary')) .
        anchor('tarefa/index', "Voltar", array('class' => 'btn btn-danger')) .
        '
		            
		        </div>';

    echo form_close();






    echo '</section>';
} elseif ($operacao == 'importado') {
    //--------------------------------- Update ---------------------------------------------
    ?>
    <div class="clearfix titulo-principal">
        <h1>Importar Números</h1>
    </div>

    <section class="cada-conteudo clearfix">
    <div class="titulo-secundario clearfix">
        <h1>
            <i class="fa fa-plus-square"></i> Arquivo
            <?php echo anchor('tarefa/index', "Voltar", array('class' => 'btn btn-danger')); ?>
        </h1>
    </div>
    <?php


    if (validation_errors() != '') {
        echo '<div class="alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
    }

    if ($this->session->flashdata('erro')) {
        echo '<div class="alert-danger clearfix">' . $this->session->flashdata('cadastro') . '</div>';
    }

    echo '<div class="cada-input clearfix">
		            <div class="cada-nome">' . form_label("Arquivo de Importação: ") . '</div>
		            <div class="cada-elemento cada-elemento-2">
		                ' . form_label($nome_arq) . '
		            </div>
		        </div>';

    echo '<div class="cada-input clearfix">
		            <div class="">
		                ' . $tabelaNum . '
		            </div>
		        </div>';


    echo '</section>';
} ?>
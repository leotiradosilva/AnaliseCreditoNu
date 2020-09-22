<?php
/**
 * Created by PhpStorm.
 * User: richa
 * Date: 25/01/2017
 * Time: 10:46
 */

if($operacao == "c")
    //----------------------------------------- Consulta --------------------------------------------------
{ ?>

    <h4 class="page-title clearfix">
        <div class="pull-left m-t-10">Resgates</div>

        <div class="pull-right">
            <?php echo ($permissao->inserir ? anchor('resgate/add', '<i class="fa fa-plus icone-botoes"></i> Adicionar', array('class'=> 'btn btn-primary novo-registro')) : "")." ".
                ($permissao->alterar ? form_button('', '<i class="fa fa-print"></i> Imprimir', array('class'=> 'print btn btn-primary novo-registro')) : "")." ".
                ($permissao->alterar ? form_button('', '<i class="fa fa-file-excel-o"></i> Exportar', array('class'=> 'download btn btn-primary ', 'data-hidecolum'=>6, 'data-namearq'=>"resgates".date('dmY'))) : "")?>

        </div>
    </h4>

    <div class="block-area">

        <div id="divDados" class="div-dados clearfix">
            <?php
            //Cabecalho da tabela
            $total = 0;
            $linhas = '<table class="tile table table-bordered table-striped2 tablesorter" id="tablesorter">
					<thead>
						<tr>
							<th data-name="Data" data-placeholder="Filtrar Data" >Código Subs</th>
							<th data-name="Data" data-placeholder="Filtrar Data" >Cliente</th>
							<th data-name="Data" data-placeholder="Filtrar Data" >CPF/CNPJ</th>
							<th data-name="Data" data-placeholder="Filtrar Data" >Data da Solicitação</th>
							<th data-name="Valor" data-placeholder="Filtrar Valor" >Valor</th>
							<th data-name="Data" data-placeholder="Filtrar Data" >Data do Resgate</th>
							<th data-name="Data" data-placeholder="Filtrar Data" >Origem</th>
							<th data-name="Ação" data-sorter="false" class="m-w-120 columnSelector-false filter-false sorter-false sorter-false sumir-impressao inviPrint">A&ccedil;&atilde;o</th>
						</tr>
					</thead><tbody>';


            foreach ($dados as $cada){

                //$editar = '<a href="edit/'.$apto['codigo_apto'].'" class="btn sumir-responsivo btn-default btn-acao-tabela invi" title="Editar"><i class="fa fa-edit"></i></a> ';
                //$excluir = '<a href="Javascript: Inativar(\''.$codigo.'\', \''.$nome.'\')" class="btn sumir-responsivo btn-default btn-acao-tabela inativar invi" title="Excluir"><i class="fa fa-trash-o"></i></a> ';

                $linhas .= '<tr class="" >
								<td class=" hover-data" >'.($cada['codigo_subs']).'</td>
								<td class=" hover-data" >'.$cada['nome_pes'].'</td>
								<td class=" hover-data" >'.($cada['tipo_pes'] ? $cada['cnpj_pes'] : $cada['cpf_pes']).'</td>
								<td class=" hover-data" >'.Mysql_to_Data($cada['data_resg']).'</td>
								<td class=" " >'.formata_moeda($cada['valor_resg']).'</td>
								<td class=" hover-data" >'.(!empty($cada['dataresgatado_resg']) ? Mysql_to_Data($cada['dataresgatado_resg']) : "-").'</td>
								<td class=" hover-data" >'.($cada['tipo_resg'] == 0 ? "Resgate dos Rendimentos" : "Resgate Solicitado").'</td>
								<td class=" sumir-impressao inviPrint">'.
									($permissao->alterar ? anchor("resgate/edit/".base64_encode($cada['codigo_resg']), '<i class="fa fa-edit"></i>',
										array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Editar')) : "")." ".
									($permissao->detalhar ? anchor("resgate/detail/".base64_encode($cada['codigo_resg']), '<i class="fa fa-plus-circle"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Detalhar')) : "")." ".
								    ($permissao->alterar && empty($cada['dataresgatado_resg']) ? form_button(array('name'=>'btnConfirmar', 'content'=>'<i class="fa fa-check"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Confirmar Resgate', 'onClick'=>'confirmarResgate('.$cada['codigo_resg'].', \''.Mysql_to_Data($cada['data_resg']).'\', \''.formata_moeda($cada['valor_resg']).'\')')) : "").
										($permissao->excluir ? form_button(array('name'=>'btnExcluir', 'content'=>'<i class="fa fa-trash-o"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Excluir', 'onClick'=>'inativar('.$cada['codigo_resg'].')')) : "")
								.'</td>
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

            echo $linhas;
            ?>
        </div>

        <div id="dialog-confirm"></div>

        <div id="divMensagem"></div>

    </div>

    <!-- Div do fancybox de detalhes do conteudo -->
    <div id="divDetalhes" class="div-detalhes-agenda"></div>


    <div class="modal fade" id="modal-confirmar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar Resgate</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse p-l-0">Dados Confirmação</h2>
                    </div>
                    <div class="tile tile-reverse">
                        <div class="listview icon-list">
                            <div class="media clearfix p-l-0">
                                <label class="col-md-3 control-label">Data da Solicitação: </label>
                                <span class="col-md-9" id="dataSolicitacao"></span>
                            </div>
                            <div class="media clearfix p-l-0">
                                <label class="col-md-3 control-label">Valor Solicitado: </label>
                                <span class="col-md-9" id="valorSolicitacao"></span>
                            </div>

                        </div>

                        <div class="form-group clearfix m-t-20">
                            <label class="col-md-3 control-label">Data do Resgate: </label>
                            <div class="col-md-9">
                                <?php
                                $predata = ((date('Y-m-d')));

                                echo form_input(array('type' => 'text',
                                    'name' => 'data_resg',
                                    'id' => 'data_resg',
                                    'readonly' => '',
                                    'class' => 'form-control  input1',
                                    'value' => inverterdata(set_value("data_resg", $predata)))); ?>
                            </div>
                        </div>
                        <input type="hidden" id="codigoResgate" value="">
                        <input type="hidden" id="preencheDataResgate" value="<?php echo inverterdata($predata); ?>">

                        <?php
                        echo '</div>';
                        ?>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-reverse" id="btnConfirmarResgate"> <i class="fa fa-check"></i> Confirmar</button>
                    <button type="button" class="btn btn-danger btn-reverse" data-dismiss="modal"> <i class="fa fa-times"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>


<?php }
//-------------------------------------------------- Cadastro -------------------------------------------------
elseif ($operacao == 'a') {
    ?>

    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("resgate/index")?>">Resgate</a></li>
        <li class="active">Cadastrar resgate</li>
    </ol>
    <h4 class="page-title">
        Resgate

        <p class="sub-title">Adicionar</p>
    </h4>

    <div class="block-area clearfix">
        <div class="tile p-15 form-horizontal clearfix p-t-20">
    <?php
    $atributos = array('class' => 'form-signin', 'id' => 'form1');
    echo form_open('resgate/add', $atributos, array('ativo_subs'=>1));

    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('cadastro'))
    {
        echo '<div class="clearfix alert-success">'.$this->session->flashdata('cadastro').'</div>';
    }

    echo '<div class="form-group m-t-10 clearfix">
            <label class="col-md-2 control-label">Subscrição: </label>
            <div class="col-md-9">
                '.form_dropdown(array('name'=>"codigo_subs", 'id'=>'ddlSubscricao', 'class'=>'form-control input1'), $subscricao, set_value('codigo_subs')).'
            </div>
        </div>';

    echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">'.form_label("Data Solicitado: ").'</label>
                <div class="col-md-9">
                    '.form_input(array(
                    'type'  => 'text',
                    'name'  => 'data_resg',
                    'id'    => 'data_resg',
                    'value' => set_value('data_resg'),
                    'class' => 'form-control input1')).'
                </div>
            </div>';

    echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">'.form_label("Data Resgate: ").'</label>
                <div class="col-md-9">
                    '.form_input(array(
                    'type'  => 'text',
                    'name'  => 'dataresgatado_resg',
                    'id'    => 'dataresgatado_resg',
                    'value' => set_value('dataresgatado_resg'),
                    'class' => 'form-control input1')).'
                </div>
            </div>';

    echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">Valor:</label>
                <div class="col-md-9">
                    '.form_input(array(
                    'type'  => 'text',
                    'name'  => 'valor_resg',
                    'id'    => 'valor_resg',
                    'value' => set_value('valor_resg'),
                    'class' => 'form-control preco input1')).'
                </div>
            </div>';


    echo '<div class="form-group clearfix">
            <div class="col-md-offset-2 col-md-10 m-t-10">
			'.form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar e Voltar', 'class'=>'btn btn-primary')).
        form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
        anchor('resgate/index', "Voltar", array('class'=> 'btn btn-danger')).
        '
            
            </div>
        </div>
        '.form_close().'

    </div></div>';

}
elseif ($operacao == 'u') {
    //--------------------------------- Update ---------------------------------------------
    $id = pegaParam1($this->uri);

    if($id == NULL) redirect('resgate/index');

    $result = $this->mod->get_byid($id);
    $res = $result[0];


    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("resgate/index")?>">Resgate</a></li>
        <li class="active">Alterar resgate</li>
    </ol>
    <h4 class="page-title">
        Resgate

        <p class="sub-title">Alterar</p>
    </h4>

    <div class="block-area clearfix">
        <div class="tile p-15 form-horizontal clearfix p-t-20">
    <?php

    $atributos = array('class' => 'form-signin', 'id' => 'form1');
    echo form_open('resgate/edit/'.base64_encode($res->codigo_resg), $atributos, array('ativo_resg'=>$res->ativo_resg, 'cd'=>$res->codigo_resg));

    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('alterar'))
    {
        echo '<div class="clearfix alert alert-success">'.$this->session->flashdata('alterar').'</div>';
    }


    echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Subscrição: </label>
		            <div class="col-md-9">
		                '.form_dropdown(array('name'=>"codigo_subs", 'id'=>'ddlSubscricao', 'class'=>'form-control input1'), $subscricao, set_value('codigo_subs', $res->codigo_subs)).'
		            </div>
		        </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Data: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'data_resg',
            'id'    => 'data_resg',
            'value' => set_value('data_resg',inverterdata($res->data_resg)),
            'class' => 'form-control input1')).'
		            </div>
		        </div>';


    echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">'.form_label("Data Resgate: ").'</label>
                <div class="col-md-9">
                    '.form_input(array(
            'type'  => 'text',
            'name'  => 'dataresgatado_resg',
            'id'    => 'dataresgatado_resg',
            'value' => set_value('dataresgatado_resg',(empty($res->dataresgatado_resg) ? "" : inverterdata($res->dataresgatado_resg))),
            'class' => 'form-control input1')).'
                </div>
            </div>';


    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Valor:</label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'text',
            'name'  => 'valor_resg',
            'id'    => 'valor_resg',
            'value' => set_value('valor_resg',formata_moeda($res->valor_resg)),
            'class' => 'form-control preco input1')).'
		            </div>
		        </div>';

    echo '<div class="form-group clearfix">
            <div class="col-md-offset-2 col-md-10 m-t-10">'.
        form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
        anchor('resgate/index', "Voltar", array('class'=> 'btn btn-danger')).'
            
            </div>
        </div>
        '.form_close().'

    </div></div>';
}
elseif ($operacao == 'd') {
    //--------------------------------- Detalhar ---------------------------------------------
    $id = base64_decode($this->uri->segment(3));

    if($id == NULL) redirect('resgate/index');

    $result = $this->mod->get_byid($id);
    $res = $result[0];


    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("resgate/index")?>">Resgate</a></li>
        <li class="active">Detalhar resgate</li>
    </ol>
    <h4 class="page-title clearfix p-t-35">
        <div class="pull-left">
            Subscrição
            <p class="sub-title">Detalhes de Dados</p>
        </div>

        <div class="pull-right">
            <a href="<?php echo site_url("resgate/index")?>" class="btn"> <i class="fa fa-undo"></i> Voltar</a>
        </div>
    </h4>

    <div class="block-area clearfix">

    <div class="tile">
    <div class="listview icon-list">
    <?php

    echo '<div class="media clearfix">
		            <label class="col-md-2 control-label">Cliente</label>
		            <div class="col-md-9">
		                '.form_label(($res->nome_pes)).'
		            </div>
		        </div>';

    echo '<div class="media clearfix">
		            <label class="col-md-2 control-label">Data:</label>
		            <div class="col-md-9">
		                '.form_label(Mysql_to_Data($res->data_subs)).'
		            </div>
		        </div>';

    echo '<div class="media clearfix">
		            <label class="col-md-2 control-label">Taxa:</label>
		            <div class="col-md-9">
		                '.form_label(($res->taxa_subs)).'
		            </div>
		        </div>';

    echo '<div class="media clearfix">
		            <label class="col-md-2 control-label">Valor:</label>
		            <div class="col-md-9">
		                '.form_label(formata_moeda($res->valor_subs)).'
		            </div>
		        </div>';

    echo '<div class="media clearfix">
		            <label class="col-md-2 control-label">Rendimento: </label>
		            <div class="col-md-9">
		                '.form_label(($res->rendimento_subs == 1 ? "Reinvestir" : "Retirar Mensalmente")).'
		            </div>
		        </div>';



    echo '</div></div></div>';
}
elseif ($operacao == 'import') {
    //--------------------------------- Update ---------------------------------------------
    ?><div class="clearfix titulo-principal">
    <h1>Importar Números</h1>
</div>

    <section class="cada-conteudo clearfix">
    <div class="titulo-secundario clearfix">
        <h1>
            <i class="fa fa-plus-square"></i> Arquivo
        </h1>
    </div>
    <?php



    echo form_open_multipart('resgate/import');
    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('erro'))
    {
        echo '<div class="alert-danger clearfix">'.$this->session->flashdata('cadastro').'</div>';
    }

    echo '<div class="cada-input clearfix">
		            <div class="cada-nome">'.form_label("Arquivo de Importação: ").'</div>
		            <div class="cada-elemento cada-elemento-2">
		                '.form_input(array('type'=>'file', 'name'=>'importacao')).'
		            </div>
		        </div>';

    echo '<div class="area-botao-salvar clearfix">
					'.form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Importar', 'class'=>'btn btn-primary')).
        anchor('resgate/index', "Voltar", array('class'=> 'btn btn-danger')).
        '
		            
		        </div>';

    echo form_close();






    echo '</section>';
}elseif ($operacao == 'importado') {
    //--------------------------------- Update ---------------------------------------------
    ?><div class="clearfix titulo-principal">
        <h1>Importar Números</h1>
    </div>

    <section class="cada-conteudo clearfix">
    <div class="titulo-secundario clearfix">
        <h1>
            <i class="fa fa-plus-square"></i> Arquivo
            <?php echo anchor('resgate/index', "Voltar", array('class'=> 'btn btn-danger'));?>
        </h1>
    </div>
    <?php



    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('erro'))
    {
        echo '<div class="alert-danger clearfix">'.$this->session->flashdata('cadastro').'</div>';
    }

    echo '<div class="cada-input clearfix">
		            <div class="cada-nome">'.form_label("Arquivo de Importação: ").'</div>
		            <div class="cada-elemento cada-elemento-2">
		                '.form_label($nome_arq).'
		            </div>
		        </div>';

    echo '<div class="cada-input clearfix">
		            <div class="">
		                '.$tabelaNum.'
		            </div>
		        </div>';



    echo '</section>';
}?>

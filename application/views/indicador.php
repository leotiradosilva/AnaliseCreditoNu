<?php
/**
 * Created by PhpStorm.
 * User: richa
 * Date: 20/01/2017
 * Time: 15:06
 */

if($operacao == "c")
    //----------------------------------------- Consulta --------------------------------------------------
{ ?>
    <h4 class="page-title clearfix">
        <div class="pull-left m-t-10">Indicadores</div>

        <div class="pull-right">
            <?php echo ($permissao->inserir ? anchor('indicador/add', '<i class="fa fa-plus"></i> Adicionar', array('class'=> 'btn btn-primary novo-registro')) : "")?>
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
							<th data-name="Data" data-placeholder="Filtrar Data" >Data</th>
							<th data-name="Cliente" data-placeholder="Filtrar Arquivo" >Arquivo</th>
							<th data-name="Ação" data-sorter="false" class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o</th>
						</tr>
					</thead><tbody>';


            foreach ($dados as $cada){
                $dt = splitData($cada['mes_ind']);
                if(is_file(('assets/uploads/indicador/'.$cada['upload_ind'])))
                {
                    $icon = "<i class='fa fa-check fa-2x'></i>";
                }
                else
                {
                    $icon = "<i class='fa fa-times fa-2x'></i>";

                }

                $linhas .= '<tr class="" >

											<td class=" hover-data" >'.Mes($dt['month'])."/".$dt['year'].'</td>
											<td class=" hover-data" >'.$icon.'</td>
											<td class=" sumir-impressao">'.($permissao->alterar ? anchor("indicador/edit/".base64_encode($cada['codigo_ind']), '<i class="fa fa-edit"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Editar')) : "")." ".
                    ($permissao->detalhar ? anchor("indicador/detail/".base64_encode($cada['codigo_ind']), '<i class="fa fa-plus-circle"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Detalhar')) : "")." ".
                    ($permissao->excluir ? form_button(array('name'=>'btnExcluir', 'content'=>'<i class="fa fa-trash-o"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Excluir', 'onClick'=>'inativar('.$cada['codigo_ind'].')')) : "").'</td>

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
            /*<tr>
                <td colspan="7"><center>Total de Dados: ' . $total . '</center></td>
            </tr>
                            </tfoot></table>';*/

            echo $linhas;
            ?>
        </div>

        <div id="dialog-confirm"></div>

        <div id="divMensagem"></div>

    </div>

    <!-- Div do fancybox de detalhes do conteudo -->
    <div id="divDetalhes" class="div-detalhes-agenda"></div>
<?php }
//-------------------------------------------------- Cadastro -------------------------------------------------
elseif ($operacao == 'a') {
    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("subscricao/index")?>">Indicador</a></li>
        <li class="active">Cadastrar Indicador</li>
    </ol>
    <h4 class="page-title">
        Indicador

        <p class="sub-title">Adicionar</p>
    </h4>

    <div class="block-area clearfix">
    <div class="tile p-15 form-horizontal clearfix p-t-20">
    <?php
    $atributos = array('class' => 'form-signin', 'id' => 'form1','enctype'=>'multipart/form-data');
    echo form_open('indicador/add', $atributos, array('ativo_ind'=>1));

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
		            <label class="col-md-2 control-label">Mes:</label>
		            <div class="col-md-9">
		                '.form_dropdown(array('name'=>"mes", 'id'=>'mes', 'class'=>'form-control input1'), array(1 =>'Janeiro',
                                                                                                                 2 =>'Fevereiro',
                                                                                                                 3 =>'Março',
                                                                                                                 4 =>'Abril',
                                                                                                                 5 =>'Maio',
                                                                                                                 6 =>'Junho',
                                                                                                                 7 =>'Julho',
                                                                                                                 8 =>'Agosto',
                                                                                                                 9 =>'Setembro',
                                                                                                                 10 =>'Outubro',
                                                                                                                 11 =>'Novembro',
                                                                                                                 12 =>'Dezembro'), set_value('mes',date('m'))).'
		            </div>
		        </div>';
    $anos = array();
    for ($i = 2010; $i<= date("Y")+1 ; $i++)
    {
        $anos[$i] = $i;
    }

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Data: </label>
		            <div class="col-md-9">
		               '.form_dropdown(array('name'=>"ano", 'id'=>'ano', 'class'=>'form-control input1'), $anos, set_value('ano',date("Y"))).'
		            </div>
		        </div>';

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">PDF: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'file',
            'name'  => 'upload_ind',
            'id'    => 'upload_ind',
            'class' => 'form-control input1')).'
		            </div>
		        </div>';


    echo '<div class="form-group clearfix">
            <div class="col-md-offset-2 col-md-10 m-t-10">
			'.form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar e Voltar', 'class'=>'btn btn-primary')).
        form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
        anchor('indicador/index', "Voltar", array('class'=> 'btn btn-danger')).
        '
            
            </div>
        </div>
        '.form_close().'

        </div>
    </div>';

}
elseif ($operacao == 'u') {
    //--------------------------------- Update ---------------------------------------------
    $id = pegaParam1($this->uri);

    if($id == NULL) redirect('subscricao/index');

    $result = $this->mod->get_byid($id);
    $res = $result[0];


    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("subscricao/index")?>">Indicador</a></li>
        <li class="active">Alterar Indicador</li>
    </ol>
    <h4 class="page-title">
        Indicador

        <p class="sub-title">Alterar</p>
    </h4>

    <div class="block-area clearfix">
    <div class="tile p-15 form-horizontal clearfix p-t-20">
    <?php

    $atributos = array('class' => 'form-signin', 'id' => 'form1','enctype'=>'multipart/form-data');
    echo form_open('indicador/edit/'.base64_encode($res->codigo_ind), $atributos, array('ativo_ind'=>$res->ativo_ind, 'cd'=>$res->codigo_ind));

    if(validation_errors()!='')
    {
        echo '<div class="alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
    }

    if($this->session->flashdata('alterar'))
    {
        echo '<div class="clearfix alert-success">'.$this->session->flashdata('alterar').'</div>';
    }

    echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Mes:</label>
		            <div class="col-md-9">
		                '.form_dropdown(array('name'=>"mes", 'id'=>'mes', 'class'=>'form-control input1', 'disabled' => 'disabled'), array(1 =>'Janeiro',
            2 =>'Fevereiro',
            3 =>'Março',
            4 =>'Abril',
            5 =>'Maio',
            6 =>'Junho',
            7 =>'Julho',
            8 =>'Agosto',
            9 =>'Setembro',
            10 =>'Outubro',
            11 =>'Novembro',
            12 =>'Dezembro'), set_value('mes',splitData($res->mes_ind)['month'])).'
		            </div>
		        </div>';
    $anos = array();
    for ($i = 2010; $i<= date("Y")+1 ; $i++)
    {
        $anos[$i] = $i;
    }

    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Data: </label>
		            <div class="col-md-9">
		               '.form_dropdown(array('name'=>"ano", 'id'=>'ano', 'class'=>'form-control input1', 'disabled' => 'disabled'), $anos, set_value('ano',splitData($res->mes_ind)['year'])).'
		            </div>
                </div>';
    echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">PDF: </label>
		            <div class="col-md-9">
		                '.form_input(array(
            'type'  => 'file',
            'name'  => 'upload_ind',
            'id'    => 'upload_ind',
            'class' => 'form-control input1')).'
		            </div>
		        </div>';


    echo '<div class="form-group clearfix">
            <div class="col-md-offset-2 col-md-10 m-t-10">'.
        form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
        anchor('indicador/index', "Voltar", array('class'=> 'btn btn-danger')).'
            
            </div>
        </div>
        '.form_close().'

        </div>
    </div>';
}

elseif ($operacao == 'd') {
    //--------------------------------- Detalhar ---------------------------------------------
    $id = base64_decode($this->uri->segment(3));

    if($id == NULL) redirect('subscricao/index');

    $result = $this->mod->get_byid($id);
    $res = $result[0];

    ?>
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo site_url("indicador/index")?>">Indicador</a></li>
        <li class="active">Detalhar Indicador</li>
    </ol>
    <h4 class="page-title p-t-35 clearfix">
        <div class="pull-left">
            Indicador
            <p class="sub-title">Detalhes dos Dados</p>
        </div>

        <div class="pull-right">
            <a href="<?php echo site_url("indicador/index")?>" class="btn"><i class="fa fa-undo"></i> Voltar</a>
        </div>
    </h4>

    <div class="block-area clearfix">

    <div class="tile">
    <div class="listview icon-list">

    <?php

    echo '<div class="media clearfix">
		            <label class="col-md-1">Mês:</label>
		            <div class="col-md-9">
		                '.form_label(Mes(splitData($res->mes_ind)['month'])."/".splitData($res->mes_ind)['year']).'
		            </div>
		        </div>';

    echo '<div class="media clearfix">
		            <label class="col-md-1">Mês:</label>
		            <div class="col-md-9">
		                <iframe src="'.$res->upload_ind.'" style="width:718px; height:700px;" frameborder="0"></iframe>
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

    echo form_open_multipart('subscricao/import');
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
        anchor('subscricao/index', "Voltar", array('class'=> 'btn btn-danger')).
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
            <?php echo anchor('subscricao/index', "Voltar", array('class'=> 'btn btn-danger'));?>
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

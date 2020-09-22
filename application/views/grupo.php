    <?php if($operacao == "c")
    //----------------------------------------- Consulta --------------------------------------------------
    { ?>

	<h4 class="page-title clearfix">
        <div class="pull-left m-t-10">
             Grupos
        </div>

        <div class="pull-right">
            <?php
            if($permissao->inserir)
                echo   anchor('grupo/add', '<i class="fa fa-plus icone-botoes"></i> Adicionar', array('class'=> 'btn btn-primary novo-registro'));
            echo   " ".anchor('usuario', '<i class="fa fa-arrow-left icone-botoes"></i> Voltar', array('class'=> 'btn btn-danger novo-registro')); ?>

        </div>
	</h4>

    <div class="block-area">
        <div id="divDados" class="div-dados clearfix">
			<?php  
				//Cabecalho da tabela
				$total = 0;
				$linhas = '<table class="tile table table-bordered table-striped tablesorter table-responsive tabela-especial" id="tablesorter">
					<thead>
						<tr>
							<th data-name="Nome" data-placeholder="Filtrar Nome" >Nome</th>
							<th data-name="Descrição" data-placeholder="Filtrar Descrição" >Descrição</th>
							
							<th data-name="Ação" data-sorter="false" class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o</th>
						</tr>
					</thead><tbody>';

				
					foreach ($dados as $cada){	
							//$editar = '<a href="edit/'.$apto['codigo_apto'].'" class="btn sumir-responsivo btn-default btn-acao-tabela invi" title="Editar"><i class="fa fa-edit"></i></a> ';
							//$excluir = '<a href="Javascript: Inativar(\''.$codigo.'\', \''.$nome.'\')" class="btn sumir-responsivo btn-default btn-acao-tabela inativar invi" title="Excluir"><i class="fa fa-trash-o"></i></a> ';
							
							$linhas .= '<tr class="" >

											<td class=" hover-data" >'.$cada['nome_gru'].'</td>
											
											<td class= >'.$cada['descricao_gru'].'</td>
											
											
											<td class=" sumir-impressao">'.
											($permissao->alterar ? anchor("grupo/edit/".base64_encode($cada['codigo_gru']), '<i class="fa fa-edit"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Editar')) : "")." ".
											($permissao->excluir ? form_button(array('name'=>'btnExcluir', 'content'=>'<i class="fa fa-trash-o"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Excluir', 'onClick'=>'inativar('.$cada['codigo_gru'].')')) : "")
											.'</td>

										</tr>';	
										
								$total += 1;
						
					}	
					
					
				

				$linhas .= '</tbody><tfoot>
					<tr>
                        <td colspan="3"><center>Total de Dados: ' . $total . '</center></td>
					</tr>
                                    </tfoot></table>';

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
			<li><a href="<?php echo site_url("grupo/index")?>">Grupo</a></li>
			<li class="active">Cadastrar grupo</li>
		</ol>
		<h4 class="page-title">
			Grupo
            <p class="sub-title">Adicionar</p>
		</h4>

	<div class="block-area clearfix">
		<div class="tile p-15 form-horizontal clearfix p-t-20">
        <?php 
        		
    			$atributos = array('class' => 'form-signin', 'id' => 'form1');
				echo form_open('grupo/add', $atributos, array('ativo_gru'=>1)); 
				
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
		        if($this->session->flashdata('cadastroerro'))
		        {
		        	echo '<div class="clearfix alert-danger">'.$this->session->flashdata('cadastroerro').'</div>';
		        }

		        echo '<div class="form-group m-t-10 clearfix">
						<div class="col-md-2 control-label">Nome:</div>
						<div class="col-md-9">
							'.form_input(array(
									'type'  => 'text',
									'name'  => 'nome_gru',
									'id'    => 'nome_gru',
									'value' => set_value('nome_gru'),
									'class' => 'form-control input1')).'
						</div>
					</div>';

				echo '<div class="form-group clearfix m-t-20 m-b-20">
		            <label class="col-md-2 control-label">Descrição: </label>
		            <div class="col-md-9">
		                '.form_input(array(
						        'type'  => 'text',
						        'name'  => 'descricao_gru',
						        'id'    => 'descricao_gru',
						        'value' => set_value('descricao_gru'),
						        'class' => 'form-control input1')).'
		            </div>
		        </div>';

		        echo '<table class="table tile table-bordered table-striped2 tablesorter" id="relatorio">
                        <thead>
                            <tr>
                                <th class="sorter-false">Pagina</th>
                                <th class="sorter-false">Todos</th>
                                <th class="sorter-false">Permissão de Visualizar</th>
                                <th class="sorter-false">Permissão de Inserir</th>
                                <th class="sorter-false">Permissão de Alterar</th>
                                <th class="sorter-false">Permissão de Detalhar</th>
                                <th class="sorter-false">Permissão de Excluir</th>
                            </tr>
                        </thead><tbody>';
                      // $js="";
                foreach ($paginas as $key => $cada) {
                	echo '<tr>
                                <th class="sorter-false">'.$cada['nome_pag'].'</th>

                                <th class="sorter-false"><div class="aux-check"><input name="todos-'.$cada['nome_pag'].'" type="checkbox" id="'.$cada['nome_pag'].'" /></div></th>
                                
                                <th class="sorter-false"><div class="pull-left m-t-5"> Visualizar: </div> <div class="aux-check pull-left m-l-10"><input name="'.$cada['nome_pag'].'[]" class="'.$cada['nome_pag'].'" type="checkbox" value="1" /> </div></th>
                                
                                <th class="sorter-false"><div class="pull-left m-t-5"> Inserir:</div> <div class="aux-check pull-left m-l-10"><input name="'.$cada['nome_pag'].'[]" class="'.$cada['nome_pag'].'" type="checkbox" value="2" /></div></th>
                                
                                <th class="sorter-false" id="alterar"><div class="pull-left m-t-5"> Alterar:</div> <div class="aux-check pull-left m-l-10"><input name="'.$cada['nome_pag'].'[]" class="'.$cada['nome_pag'].'" type="checkbox" value="3" /></div></th>
                                
                                <th class="sorter-false" id="detalhar"><div class="pull-left m-t-5"> Detalhar:</div> <div class="aux-check pull-left m-l-10"><input name="'.$cada['nome_pag'].'[]" class="'.$cada['nome_pag'].'" type="checkbox" value="4" /></div></th>

                                <th class="sorter-false" id="excluir"><div class="pull-left m-t-5"> Excluir:</div> <div class="aux-check pull-left m-l-10"><input name="'.$cada['nome_pag'].'[]" class="'.$cada['nome_pag'].'" type="checkbox" value="5" /></div></th>    
                            </tr>';

                             
                }

                echo '</tbody></table>';
				
				/*echo '<div class="cada-input clearfix">
		            <div class="cada-nome">'.form_label("Senha: ").'</div>
		            <div class="cada-elemento cada-elemento-2">
		                '.form_input(array(
						        'type'  => 'password',
						        'name'  => 'senha_usu',
						        'id'    => 'senha_usu',
						        'value' => set_value('senha_usu'),
						        'class' => 'form-control input1')).'
		            </div>
		        </div>';*/
			
				
			echo '<div class="form-group p-l-0 m-l-0 clearfix">
			'.form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar e Voltar', 'class'=>'btn btn-primary')).
			form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
			anchor('grupo/index', "Voltar", array('class'=> 'btn btn-danger')).
			'
            
        </div>
        '.form_close().'

    	</div>
    </div>';
    //return $js;

    }
    elseif ($operacao == 'u') {
    	//--------------------------------- Update ---------------------------------------------
    	$id = pegaParam1($this->uri);
   
    	if($id == NULL) redirect('grupo/index');

    	$result = $this->gru->get_byid($id);
    	$res = $result[0];
    	?>

		<ol class="breadcrumb hidden-xs">
			<li><a href="<?php echo site_url("grupo/index")?>">Grupo</a></li>
			<li class="active">Alterar grupo</li>
		</ol>

		<h4 class="page-title">
			Grupo
            <p class="sub-title">Alterar</p>
		</h4>

    <div class="block-area">

		<div class="tile p-15 form-horizontal clearfix p-t-20">
        <?php 

    			$atributos = array('class' => 'form-signin', 'id' => 'form1');
				echo form_open('grupo/edit/'.base64_encode($res->codigo_gru), $atributos, array('ativo_gru'=>$res->ativo_gru, 'cd'=>$res->codigo_gru)); 
				
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
		        if($this->session->flashdata('alterarerro'))
		        {
		        	echo '<div class="clearfix alert-danger">'.$this->session->flashdata('alterarerro').'</div>';
		        }

		        echo '<div class="form-group col-md-6 clearfix">
		            <label class="col-md-2 control-label">'.form_label("Nome: ").'</label>
		            <div class="col-md-9">
		                '.form_input(array(
						        'type'  => 'text',
						        'name'  => 'nome_gru',
						        'id'    => 'nome_gru',
						        'value' => set_value('nome_gru', $res->nome_gru),
						        'class' => 'form-control input1')).'
		            </div>
		        </div>';

				echo '<div class="form-group col-md-6 clearfix">
		            <label class="col-md-2 control-label">'.form_label("Descrição: ").'</label>
		            <div class="col-md-9">
		                '.form_input(array(
						        'type'  => 'text',
						        'name'  => 'descricao_gru',
						        'id'    => 'descricao_gru',
						        'value' => set_value('descricao_gru', $res->descricao_gru),
						        'class' => 'form-control input1')).'
		            </div>
		        </div>';
		?>
		</div>
		<?php

		        echo '<table class="table table-bordered table-striped2 tablesorter" id="relatorio">
                        <thead>
                            <tr>
                                <th class="sorter-false">Pagina</th>
                                <th class="sorter-false">Todos</th>
                                <th class="sorter-false">Permissão de Visualizar</th>
                                <th class="sorter-false">Permissão de Inserir</th>
                                <th class="sorter-false">Permissão de Alterar</th>
                                <th class="sorter-false">Permissão de Detalhar</th>
                                <th class="sorter-false">Permissão de Excluir</th>
                            </tr>
                        </thead><tbody>';
                      // $js="";
                foreach ($paginas as $key => $cada) {
                			$vCheck = "";
							$iCheck = "";
							$aCheck = "";
							$dCheck = "";
							$eCheck = "";
						//echo $res->codigo_gru." - ".$cada['codigo_pag']."<br/>";
						
						$permissao = $this->gru->buscarpermissao($res->codigo_gru, $cada['codigo_pag']);
						//print_r($permissao);
						foreach($permissao as $key => $pers){
						//Cabecalho da tabela
							if($cada['codigo_pag'] == $pers['paginas_codigo_pag'] && $pers['grupo_codigo_gru'] == $res->codigo_gru){
								if($pers['ver'] == 1){
									$vCheck = "checked";
								}else{
									$vCheck = "";
								}
								
								if($pers['inserir'] == 1){
									$iCheck = "checked";
								}else{
									$iCheck = "";
								}
								
								if($pers['alterar'] == 1){
									$aCheck = "checked";
								}else{
									$aCheck = "";
								}
								
								if($pers['detalhar'] == 1){
									$dCheck = "checked";
								}else{
									$dCheck ="";
								}
								
								if($pers['excluir'] == 1){
									$eCheck = "checked";
								}else{
									$eCheck ="";
								}
							}						
						}
						
						echo '<tr>
								<th class="sorter-false">'.$cada['nome_pag'].'</th>

								<th class="sorter-false"> <div class="aux-check"> <input name="todos-'.$cada['nome_pag'].'" type="checkbox" id="'.$cada['nome_pag'].'" /></div></th>
								
								<th class="sorter-false"><div class="pull-left m-t-5 m-r-5">Visualizar:</div> <div class="aux-check pull-left"><input name="'.$cada['nome_pag'].'[]" class="'.$cada['nome_pag'].'" type="checkbox" value="1" '.$vCheck.' /></div></th>
								
								<th class="sorter-false"><div class="pull-left m-t-5 m-r-5">Inserir</div>: <div class="aux-check pull-left"><input name="'.$cada['nome_pag'].'[]" class="'.$cada['nome_pag'].'" type="checkbox" value="2" '.$iCheck.' /></div></th>
								
								<th class="sorter-false" id="alterar"><div class="pull-left m-t-5 m-r-5">Alterar:</div> <div class="aux-check pull-left"><input name="'.$cada['nome_pag'].'[]" class="'.$cada['nome_pag'].'" type="checkbox" value="3" '.$aCheck.' /></div></th>
								
								<th class="sorter-false" id="detalhar"><div class="pull-left m-t-5 m-r-5">Detalhar:</div> <div class="aux-check pull-left"><input name="'.$cada['nome_pag'].'[]" class="'.$cada['nome_pag'].'" type="checkbox" value="4" '.$dCheck.' /></div></th>

								<th class="sorter-false" id="excluir"><div class="pull-left m-t-5 m-r-5">Excluir:</div> <div class="aux-check pull-left"><input name="'.$cada['nome_pag'].'[]" class="'.$cada['nome_pag'].'" type="checkbox" value="5" '.$eCheck.' /></div></th>	
							</tr>';

                             
                }

                echo '</tbody></table>';



			echo '<div class="area-botao-salvar clearfix">'.
			form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
			anchor('grupo/index', "Voltar", array('class'=> 'btn btn-danger')).'
            
        </div>
        '.form_close().'

    </section>';
    }?>
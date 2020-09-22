    <?php if($operacao == "c")
    //----------------------------------------- Consulta --------------------------------------------------
    { ?>
		<h4 class="page-title clearfix">
            <span class="pull-left m-t-10">
			Usuários
            </span>

            <div class="pull-right">
                <?php echo anchor('grupo', '<i class="fa fa-users icone-botoes"></i> Grupos', array('class'=> 'btn btn-primary novo-registro'))." ".
                    anchor('usuario/add', '<i class="fa fa-plus icone-botoes"></i> Adicionar', array('class'=> "btn btn-primary novo-registro"));//echo anchor('grupo', '<i class="fa fa-search icone-botoes"></i> Grupos', array('class'=> 'btn btn-primary novo-registro')).
                //($permissao->inserir ? anchor('usuario/add', '<i class="fa fa-plus icone-botoes"></i> Adicionar', array('class'=> 'btn btn-primary novo-registro')) : "") ?>
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
							<th data-name="Número" data-placeholder="Filtrar Número" >Nome</th>
							<th data-name="Tipo" data-placeholder="Filtrar Tipo" >Email</th>
							<th data-name="Capacidade" data-placeholder="Filtrar Capacidade" >Grupo</th>
							
							<th data-name="Ação" data-sorter="false" class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o</th>
						</tr>
					</thead><tbody>';

				
					foreach ($dados as $cada){	
							//$editar = '<a href="edit/'.$apto['codigo_apto'].'" class="btn sumir-responsivo btn-default btn-acao-tabela invi" title="Editar"><i class="fa fa-edit"></i></a> ';
							//$excluir = '<a href="Javascript: Inativar(\''.$codigo.'\', \''.$nome.'\')" class="btn sumir-responsivo btn-default btn-acao-tabela inativar invi" title="Excluir"><i class="fa fa-trash-o"></i></a> ';
							
							$linhas .= '<tr class="" >

								<td class=" hover-data" >'.$cada['nome_usu'].'</td>
								
								<td class= >'.$cada['email_usu'].'</td>
								
								<td class=" " >'.$cada['nome_gru'].'</td>
								<!---->
								<td class=" sumir-impressao">'.anchor("usuario/edit/".base64_encode($cada['codigo_usu']), '<i class="fa fa-edit"></i>' ,array('class'=>"btn btn-default btn-action-table editar-usuario", "title"=>'Editar'))." ".
                                ($cada['codigo_gru'] != 1 ? anchor("usuario/comissao_pessoa/".base64_encode($cada['codigo_usu']), '<i class="fa fa-user"></i>' ,array('class'=>"btn btn-default btn-action-table editar-usuario", "title"=>'Editar')) : "")." ".
								form_button(array('name'=>'btnExcluir', 'content'=>'<i class="fa fa-trash-o"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Excluir', 'onClick'=>'inativar('.$cada['codigo_usu'].')')).'</td>

							</tr>';	
							
					$total += 1;
						
					}	

				$linhas .= '</tbody><tfoot>
					<tr>
                        <td colspan="4"><center>Total de Dados: ' . $total . '</center></td>
					</tr>
                                    </tfoot></table>';

				echo $linhas;
			?>
		</div>
	
        <div id="dialog-confirm"></div>

		<div id="divMensagem"></div>

<!--		<div class="modal fade" id="modalAlterarUsuario" style="display: none;" role="dialog" aria-hidden="true" tabindex="-1">-->
<!--			<div class="modal-dialog">-->
<!--				<div class="modal-content">-->
<!--					<div class="modal-header">-->
<!--						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">-->
<!--							&times;-->
<!--						</button>-->
<!--						<h4 class="modal-title">Alterar Usuário</h4>-->
<!--					</div>-->
<!--					<div class="modal-body form-horizontal">-->
<!--						--><?php
//						echo '<div class="form-group clearfix">
//								<label class="col-md-2 control-label">'.form_label("Nome: ").'</label>
//								<div class="col-md-9">
//									'.form_input(array(
//											'type'  => 'text',
//											'name'  => 'nome_usu',
//											'id'    => 'nome_usu',
//											'value' => set_value('nome_usu'),
//											'class' => 'form-control input1')).'
//								</div>
//							</div>';
//
//						echo '<div class="form-group clearfix">
//								<label class="col-md-2 control-label">'.form_label("Grupo: ").'</label>
//								<div class="col-md-9">
//									'.form_dropdown(array('name'=>"codigo_gru", 'id'=>'ddlGrupo', 'class'=>'form-control input1'), $ddlGrupo, set_value('codigo_gru')).'
//								</div>
//							</div>';
//
//							echo '<div class="form-group clearfix">
//								<label class="col-md-2 control-label">'.form_label("Email: ").'</label>
//								<div class="col-md-9">
//									'.form_input(array(
//											'type'  => 'text',
//											'name'  => 'email_usu',
//											'id'    => 'email_usu',
//											'value' => set_value('email_usu'),
//											'class' => 'form-control input1')).'
//								</div>
//							</div>';
//						?>
<!---->
<!--						-->
<!--					</div>-->
<!--					<div class="modal-footer">-->
<!--						<button type="button" class="btn btn-sm btn-success">Save changes</button>-->
<!--						<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
		
    </div>
    
    <!-- Div do fancybox de detalhes do conteudo -->
    <div id="divDetalhes" class="div-detalhes-agenda"></div>
    <?php }
    //-------------------------------------------------- Cadastro -------------------------------------------------
    elseif ($operacao == 'a') {
    	?>
		<ol class="breadcrumb hidden-xs">
			<li><a href="<?php echo site_url("usuario/index")?>">Usuário</a></li>
			<li class="active">Cadastrar usuário</li>
		</ol>
		<h4 class="page-title">
			Usuário

            <p class="sub-title">Adicionar</p>
		</h4>

    <div class="block-area clearfix">
		<div class="tile p-15 form-horizontal clearfix p-t-20">
        <?php 
        		
    			$atributos = array('class' => 'form-signin', 'id' => 'form1');
				echo form_open('usuario/add', $atributos, array('ativo_usu'=>1)); 
				
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
		            <label class="col-md-2 control-label">Nome:</label>
		            <div class="col-md-9">
		                '.form_input(array(
						        'type'  => 'text',
						        'name'  => 'nome_usu',
						        'id'    => 'nome_usu',
						        'value' => set_value('nome_usu'),
						        'class' => 'form-control input1')).'
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Grupo:</label>
		            <div class="col-md-9">
		                '.form_dropdown(array('name'=>"codigo_gru", 'id'=>'ddlGrupo', 'class'=>'form-control input1'), $ddlGrupo, set_value('codigo_gru')).'
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">E-mail:</label>
		            <div class="col-md-9">
		                '.form_input(array(
						        'type'  => 'text',
						        'name'  => 'email_usu',
						        'id'    => 'email_usu',
						        'value' => set_value('email_usu'),
						        'class' => 'form-control input1')).'
		            </div>
		        </div>';

                echo '<div class="form-group m-t-20 clearfix">
						<label class="col-md-2 control-label">'.form_label("Senha: ").'</label>
						<div class="col-md-9">
							'.form_input(array(
                                'type'  => 'password',
                                'name'  => 'senha_usu',
                                'id'    => 'senha_usu',
                                'value' => '',
                                'class' => 'form-control input1')).'
						</div>
					</div>';




        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Clientes:</label>
		            <div class="col-md-9">
		                '.form_dropdown(array('name'=>"ddlClientes[]", 'id'=>'ddlClientes', 'multiple'=>true, 'class'=>'form-control input1'), $ddlPessoa, set_value('ddlClientes')).'
		            </div>
		        </div>';



        /*echo '<div class="form-group m-t-20 clearfix">
            <label class="col-md-2 control-label">Senha:</label>
            <div class="col-md-9">
                '.form_input(array(
                        'type'  => 'password',
                        'name'  => 'senha_usu',
                        'id'    => 'senha_usu',
                        'value' => set_value('senha_usu'),
                        'class' => 'form-control input1')).'
            </div>
        </div>';*/
			
				
			echo '<div class="form-group clearfix">
					<div class="col-md-offset-2 col-md-10 m-t-10">
			'.form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar e Voltar', 'class'=>'btn btn-primary')).
			form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
			anchor('usuario/index', "Voltar", array('class'=> 'btn btn-danger')).
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
   
    	if($id == NULL) redirect('usuario/index');

    	$result = $this->usu->get_byid($id);
    	$res = $result[0];
    	?>
		<ol class="breadcrumb hidden-xs">
			<li><a href="<?php echo site_url("usuario/index")?>">Usuário</a></li>
			<li class="active">Alterar usuário</li>
		</ol>
		<h4 class="page-title">
            Usuário

            <p class="sub-title">Alterar</p>
		</h4>

    <div class="block-area clearfix">

		<div class="tile p-15 form-horizontal clearfix p-t-20">
        <?php

    			$atributos = array('class' => 'form-signin', 'id' => 'form1');
				echo form_open('usuario/edit/'.base64_encode($res->codigo_usu), $atributos, array('ativo_usu'=>$res->ativo_usu, 'cd'=>$res->codigo_usu)); 
				
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
							<label class="col-md-2 control-label">'.form_label("Nome: ").'</label>
							<div class="col-md-9">
								'.form_input(array(
										'type'  => 'text',
										'name'  => 'nome_usu',
										'id'    => 'nome_usu',
										'value' => set_value('nome_usu', $res->nome_usu),
										'class' => 'form-control input1')).'
							</div>
						</div>';

				echo '<div class="form-group m-t-20 clearfix">
						<label class="col-md-2 control-label">'.form_label("Grupo: ").'</label>
						<div class="col-md-9">
							'.form_dropdown(array('name'=>"codigo_gru", 'id'=>'ddlGrupo', 'class'=>'form-control input1'), $ddlGrupo, set_value('codigo_gru', $res->codigo_gru)).'
						</div>
					</div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">'.form_label("Email: ").'</label>
		            <div class="col-md-9">
		                '.form_input(array(
						        'type'  => 'text',
						        'name'  => 'email_usu',
						        'id'    => 'email_usu',
						        'value' => set_value('email_usu', $res->email_usu),
						        'class' => 'form-control input1')).'
		            </div>
		        </div>';

		        echo '<div class="form-group m-t-20 clearfix">
						<label class="col-md-2 control-label">'.form_label("Senha: ").'</label>
						<div class="col-md-9">
							'.form_input(array(
									'type'  => 'password',
									'name'  => 'senha_usu',
									'id'    => 'senha_usu',
									'value' => '',
									'class' => 'form-control input1')).'
						</div>
					</div>';


                echo '<div class="form-group m-t-20 clearfix">
                            <label class="col-md-2 control-label">Clientes:</label>
                            <div class="col-md-9">
                                '.form_dropdown(array('name'=>"ddlClientes", 'id'=>'ddlClientes', 'class'=>'form-control input1'), $ddlPessoa).'
                            </div>
                            <a class="btn" onclick="addComissao('.$res->codigo_usu.',this)"><i class="fa fa-plus"></i></a>
                        </div>';

                echo '<div class="form-group m-t-20 clearfix">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-9">
                                <table class="tile table table-bordered table-striped2 tablesorter" id="comissoes">
                                    <thead>
                                        <tr>
                                            <th data-name="Número" data-placeholder="Filtrar Número" >Nome</th>
                                            <th data-name="Ação" data-sorter="false" class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listaComissao">'.$tablePessoa.'</tbody>
                                </table>
                            </div>
                        </div>';





        echo '<div class="form-group clearfix">
					<div class="col-md-offset-2 col-md-10 m-t-10">'.
			form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
			anchor('usuario/index', "Voltar", array('class'=> 'btn btn-danger')).'
            
        		 	</div>
        		 </div>
        '.form_close().'

    	</div>
    </div>';
    }
    elseif ($operacao == 'meu_perfil') {
    	//--------------------------------- Meu Perfil ---------------------------------------------
    	$id = $this->session->usuario['codigo'];

    	if($id == NULL) redirect('usuario/index');

    	$result = $this->usu->get_byid($id);
    	$res = $result[0];
    	?>

		<ol class="breadcrumb hidden-xs">
			<li><a href="<?php echo site_url("usuario/index")?>">Usuário</a></li>
			<li class="active">Meu Perfil</li>
		</ol>

		<h4 class="page-title">
			Meu Perfil
            <p class="sub-title">Dados</p>
		</h4>


		<div class="block-area clearfix">
			<div class="tile p-15 form-horizontal clearfix p-t-20">
        <?php 

    			$atributos = array('class' => 'form-signin', 'id' => 'form1');
				echo form_open('usuario/meu_perfil', $atributos, array('ativo_usu'=>$res->ativo_usu, 'cd'=>$res->codigo_usu)); 
				
				if(validation_errors()!='')
				{
					echo '<div class="alert alert-danger clearfix">
		            '.validation_errors('<p>',' </p>').'
		        </div>';
				}	
		        
		        if($this->session->flashdata('alterar'))
		        {
		        	echo '<div class="clearfix alert alert-success">'.$this->session->flashdata('alterar').'</div>';
		        }

		        echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">'.form_label("Nome: ").'</label>
		            <div class="col-md-9">
		                '.form_input(array(
						        'type'  => 'text',
						        'name'  => 'nome_usu',
						        'id'    => 'nome_usu',
						        'value' => set_value('nome_usu', $res->nome_usu),
						        'class' => 'form-control input1')).'
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">'.form_label("Email: ").'</label>
		            <div class="col-md-9">
		                '.form_input(array(
						        'type'  => 'text',
						        'name'  => 'email_usu',
						        'id'    => 'email_usu',
						        'value' => set_value('email_usu', $res->email_usu),
						        'class' => 'form-control input1',
						        'readonly' => '')).'
		            </div>
		        </div>';

		        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">'.form_label("Senha: ").'</label>
		            <div class="col-md-9">
		                '.form_input(array(
						        'type'  => 'password',
						        'name'  => 'senha_usu',
						        'id'    => 'senha_usu',
						        'value' => set_value('senha_usu'),
						        'class' => 'form-control input1')).'
		            </div>
		        </div>';



			echo '<div class="form-group clearfix">
            		<div class="col-md-offset-2 col-md-10 m-t-10">'.
			form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
			anchor('usuario/index', "Voltar", array('class'=> 'btn btn-danger')).'
            
        			</div>
        		</div>
        	'.form_close().'

    	</div>
    </div>';
    }elseif($operacao == "comissao_usuario")
    //----------------------------------------- Consulta --------------------------------------------------
    {?>
		<h4 class="page-title">
			Comissão
		</h4>


    <div class="block-area">
        <div id="divDados" class="div-dados clearfix">
			<?php
				//Cabecalho da tabela
				$total = 0;
				$linhas = '<table class="tile table table-bordered table-striped2 tablesorter" id="tablesorter">
					<thead>
						<tr>
                                <th data-name="Cliente" data-placeholder="Filtrar Cliente" >Cliente</th>
                                <th data-name="Data" data-placeholder="Filtrar Data" >Data</th>
                                <th data-name="Subscrição" data-placeholder="Filtrar Subscrição" >Subscrição</th>
                                <th data-name="Valor" data-placeholder="Filtrar Valor" >Valor</th>
                                <th data-name="Taxa" data-placeholder="Filtrar Taxa" >Taxa (%)</th>
                                <th style="width: 100px;" data-name="Ação" data-sorter="false" class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o</th>
						</tr>
					</thead><tbody>';


					foreach ($dados as $cada){
							//$editar = '<a href="edit/'.$apto['codigo_apto'].'" class="btn sumir-responsivo btn-default btn-acao-tabela invi" title="Editar"><i class="fa fa-edit"></i></a> ';
							//$excluir = '<a href="Javascript: Inativar(\''.$codigo.'\', \''.$nome.'\')" class="btn sumir-responsivo btn-default btn-acao-tabela inativar invi" title="Excluir"><i class="fa fa-trash-o"></i></a> ';

							$linhas .= '<tr class="" >

											<td class="" >'.$cada->nome_pes.'</td>
											
											<td class= >'.inverterdata($cada->data_subs).'</td>
											<td class= >'.($cada->codigo_subs).'</td>
											<td class= >'.formata_moeda($cada->valor_subs).'</td>
											
											<td class= >'.formata_moeda($cada->taxa_usupes).'</td>
											
											<td class=" sumir-impressao">'.
											form_button(array('name'=>'btnExcluir', 'content'=>'<i class="fa fa-edit"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Alterar Taxa', 'onClick'=>'AlterarTaxa('.$id.','.$cada->codigo_pes.',\''.formata_moeda($cada->taxa_usupes).'\','.$cada->codigo_subs.')')).'</td>

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
                                Total de Dados: ' . $total . '
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


    <div class="modal fade" id="modal-altera" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="color: black;"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Alterar Taxa</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group clearfix m-b-20">
                        <label class="col-md-1 m-t-5 control-label text-black">Taxa (%)</label>
                        <div class="col-md-9">
                            <?php

                            echo form_input(array('type' => 'text',
                                'name' => 'taxa_usupes',
                                'id' => 'taxa_usupes',
                                'style'=>"color: black;",
                                'class' => 'form-control  input1 taxa',
                                'value' => '')); ?>
                        </div>
                    </div>

                    <input type="hidden" id="codigo_usu_taxa" value="">
                    <input type="hidden" id="codigo_pes_taxa" value="">
                    <input type="hidden" id="codigo_subs_taxa" value="">


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnConfirmarTaxa">Confirmar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <?php }?>
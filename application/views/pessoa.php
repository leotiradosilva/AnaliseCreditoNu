    <?php if ($operacao == "c")
	//----------------------------------------- Consulta --------------------------------------------------
	{ ?>

    	<h4 class="page-title clearfix">
    		<div class="pull-left m-t-10">
    			Clientes
    		</div>

    		<div class="pull-right acoes-cliente">
    			<?php echo ($permissao->inserir ? anchor('pessoa/add', '<i class="fa fa-plus icone-botoes"></i> Adicionar', array('class' => 'btn btn-primary novo-registro')) : "") . " " .
					($permissao->alterar ? form_button('', '<i class="fa fa-print"></i> Imprimir', array('class' => 'print btn btn-primary novo-registro')) : "") . " " .
					($permissao->alterar ? form_button('', '<i class="fa fa-file-excel-o"></i> Exportar', array('class' => 'download btn btn-primary ', 'data-hidecolum' => 7, 'data-namearq' => "clientes" . date('dmY'))) : "") ?>
    		</div>

    	</h4>

    	<div class="block-area">
    		<div class="pull-right m-b-10">
    			<!--<a href="add" role="button" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>-->

    		</div>
    		<div id="divDados" class="div-dados clearfix">
    			<?php
				//Cabecalho da tabela
				$total = 0;
				$linhas = '<table class="tile table table-bordered table-striped2 tablesorter" id="tablesorter">
					<thead>
						<tr>
							<th data-name="Tipo" data-placeholder="Filtrar Tipo" >Tipo</th>
							<th data-name="Nome" data-placeholder="Filtrar Nome" >Nome</th>
							<th data-name="CPF" data-placeholder="Filtrar CPF" >CPF</th>
							<th data-name="Cc" data-placeholder="Filtrar Cc" >C/c</th>
							<th data-name="Telefone" data-placeholder="Filtrar Telefone" >Telefone</th>
							<th data-name="Email" data-placeholder="Filtrar Email" >Email</th>
							<th data-name="Cidade" data-placeholder="Filtrar Cidade" >Cidade</th>
							<th data-name="UF" data-placeholder="Filtrar UF" >UF</th>
							<th data-name="Ação" data-sorter="false" class="m-w-120 columnSelector-false filter-false sorter-false sorter-false sumir-impressao inviPrint">A&ccedil;&atilde;o</th>
						</tr>
					</thead><tbody>';


				foreach ($dados as $cada) {

					//$editar = '<a href="edit/'.$apto['codigo_apto'].'" class="btn sumir-responsivo btn-default btn-acao-tabela invi" title="Editar"><i class="fa fa-edit"></i></a> ';
					//$excluir = '<a href="Javascript: Inativar(\''.$codigo.'\', \''.$nome.'\')" class="btn sumir-responsivo btn-default btn-acao-tabela inativar invi" title="Excluir"><i class="fa fa-trash-o"></i></a> ';


					$linhas .= '<tr class="" >

											<td class=" hover-data" >' . ($cada['tipo_pes'] ? "Pessoa Jurídica" : "Pessoa Física") . '</td>
											<td class=" hover-data" >' . $cada['nome_pes'] . '</td>
											<td class=" hover-data" >' . ($cada['tipo_pes'] ? $cada['cnpj_pes'] : $cada['cpf_pes']) . '</td>
											<td class=" hover-data" >' . str_replace('|sep|', '<br/>', $cada['conta_pes']) . '</td>
											<td class=" " >' . $cada['telefone_pes'] . '</td>
											<td class=" hover-data" >' . $cada['email_pes'] . '</td>
											<td class=" " >' . $cada['nome_cid'] . '</td>
											<td class=" " >' . $cada['uf_est'] . '</td>
											
											<td class=" sumir-impressao inviPrint">' . ($permissao->alterar ? anchor("pessoa/edit/" . base64_encode($cada['codigo_pes']), '<i class="fa fa-edit"></i>', array('class' => "btn btn-default btn-action-table btn-acao-tabela", "title" => 'Editar')) : "") . " " .
						($permissao->detalhar ? anchor("pessoa/detail/" . base64_encode($cada['codigo_pes']), '<i class="fa fa-plus-circle"></i>', array('class' => "btn btn-default btn-action-table btn-acao-tabela", "title" => 'Detalhar')) : "") . " " .
						form_button(array('name' => 'btnLogarComo', 'content' => '<i class="fa fa-user"></i>', 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Logar Como ' . $cada['nome_pes'], 'onClick' => 'logarComo(\'' . $cada['email_pes'] . '\',\'' . $cada['codigo_pes'] . '\')')) .
						($permissao->excluir ? form_button(array('name' => 'btnExcluir', 'content' => '<i class="fa fa-trash-o"></i>', 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Excluir', 'onClick' => 'inativar(' . $cada['codigo_pes'] . ')')) : "") . '</td>

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
                                        <img src="' . CLOUDFRONT . 'tablesorter/css/images/prev.png' . '" /> Ant&nbsp;
                                    </span>
                             <span class="pagecount"></span>
                             &nbsp;<span class="next">Prox 
                                        <img src="' . CLOUDFRONT . 'tablesorter/css/images/next.png' . '" /> 
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
    		<li><a href="<?php echo site_url("pessoa/index") ?>">Pessoas</a></li>
    		<li class="active">Cadastrar Pessoa</li>
    	</ol>
    	<h4 class="page-title">
    		Pessoa

    		<p class="sub-title">Adicionar Dados Pessoais</p>
    	</h4>

    	<div class="block-area clearfix">
    		<div class="tile p-15 form-horizontal clearfix p-t-20">
    			<?php
				$atributos = array('class' => 'form-signin', 'id' => 'form1');
				echo form_open('pessoa/add', $atributos, array('ativo_pes' => 1));

				if (validation_errors() != '') {
					echo '<div class="alert alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
				}

				if ($this->session->flashdata('cadastro')) {
					echo '<div class="clearfix alert alert-success">' . $this->session->flashdata('cadastro') . '</div>';
				}

				echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Contabiliza Home:</label>
		            <div class="col-md-9">
		                ' . form_dropdown(array('name' => "contahome_pes", 'id' => 'contahome_pes', 'class' => 'form-control input1'), array('0' => 'Não', '1' => 'Sim'), set_value('contahome_pes')) . '
		            </div>
				</div>';


				echo '<div class="form-group m-t-10 clearfix">
				<label class="col-md-2 control-label">Tipo:</label>
				<div class="col-md-9">
				' . form_dropdown(array('name' => "tipo_pes", 'id' => 'ddlTipo', 'class' => 'form-control input1'), array('0' => 'Pessoa Física', '1' => 'Pessoa Jurídica'), set_value('tipo_pes')) . '
				</div>
				</div>';


				echo '<div class="form-group m-t-10 clearfix">
				<label class="col-md-2 control-label">Estado civil: </label>
				<div class="col-md-9">
				' . form_dropdown(array('name' => "est_civil_pes", 'id' => 'est_civil_pes', 'class' => 'form-control input1'), array('solteiro' => 'Solteiro(a)', 'casado' => 'Casado(a)', 'separado' => 'Separado(a)', 'divorciado' => 'Divorciado(a)', 'viuvo' => "Viúvo(a)", 'uniao_estavel' => 'União estável'), set_value('est_civil_pes')) . '
				</div>
				</div>';

				echo '<div class="conjuge-data" style="display:none">';


				echo '<div class="form-group m-t-20 clearfix">
				<label class="col-md-2 control-label">Nome Cônjuge: </label>
				<div class="col-md-9">
					' . form_input(array_merge(
					[
						'type'  => 'text',
						'name'  => 'nome_conjuge',
						'id'    => 'nome_conjuge',
						'value' => set_value('nome_conjuge'),
						'class' => 'form-control input1'
					]

				)) . '
			</div>
		</div>';

				echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">CPF Cônjuge: </label>
                <div class="col-md-9">
                    ' . form_input(array_merge(
					[
						'type'  => 'text',
						'name'  => 'cpf_conjuge',
						'id'    => 'cpf_conjuge',
						'value' => set_value('cpf_conjuge'),
						'class' => 'form-control cpf input1'
					]
				)) . '
                </div>
            </div>';

				echo '<div class="form-group m-t-20 clearfix">
                    <label class="col-md-2 control-label">Nacionalidade Cônjuge: </label>
                    <div class="col-md-9">
                    ' . form_input(array_merge(
					[
						'type'  => 'text',
						'name'  => 'nacionalidade_conjuge',
						'id'    => 'nacionalidade_conjuge',
						'value' => set_value('nacionalidade_conjuge'),
						'class' => 'form-control input1'
					]
				)) . '
                </div>
            </div>';


				echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">Data de Nascimento Cônjuge: </label>
                <div class="col-md-9">
                    ' . form_input(array_merge(
					[
						'type'  => 'text',
						'name'  => 'dtnascimento_conjuge',
						'id'    => 'dtnascimento_conjuge',
						'value' => set_value('dtnascimento_conjuge'),
						'class' => 'form-control input1'
					]
				)) . '
                </div>
            </div>';





				echo '</div>';



				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Data de Nascimento: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'dtnascimento_pes',
					'id'    => 'dtnascimento_pes',
					'value' => set_value('dtnascimento_pes'),
					'class' => 'form-control input1'
				)) . '
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Nome: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'nome_pes',
					'id'    => 'nomes_pes',
					'value' => set_value('nome_pes'),
					'class' => 'form-control input1'
				)) . '
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">CPF: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'cpf_pes',
					'id'    => 'cpf_pes',
					'value' => set_value('cpf_pes'),
					'class' => 'form-control cpf input1'
				)) . '
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">RG:</label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'rg_pes',
					'id'    => 'rg_pes',
					'value' => set_value('rg_pes'),
					'class' => 'form-control rg input1'
				)) . '
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Razão Social: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'razao_pes',
					'id'    => 'razao_pes',
					'value' => set_value('razao_pes'),
					'class' => 'form-control input1'
				)) . '
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">CNPJ: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'cnpj_pes',
					'id'    => 'cnpj_pes',
					'value' => set_value('cnpj_pes'),
					'class' => 'form-control cnpj input1'
				)) . '
		            </div>
		        </div>';


				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">CEP: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'cep_pes',
					'id'    => 'cep_pes',
					'value' => set_value('cep_pes'),
					'class' => 'form-control cep input1'
				)) . '
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Endereco: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'endereco_pes',
					'id'    => 'endereco_pes',
					'value' => set_value('endereco_pes'),
					'class' => 'form-control input1'
				)) . '
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Bairro: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'bairro_pes',
					'id'    => 'bairro_pes',
					'value' => set_value('bairro_pes'),
					'class' => 'form-control  input1'
				)) . '
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Número: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'numero_pes',
					'id'    => 'numero_pes',
					'value' => set_value('numero_pes'),
					'class' => 'form-control  input1'
				)) . '
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Complemento: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'complemento_pes',
					'id'    => 'complemento_pes',
					'value' => set_value('complemento_pes'),
					'class' => 'form-control  input1'
				)) . '
		            </div>
		        </div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Estado: </label>
		            <div class="col-md-9">
		                ' . form_dropdown(array('name' => "codigo_est", 'id' => 'ddlEstado', 'class' => 'form-control input1'), $estados, set_value('codigo_est')) . '
		            </div>
		        </div>';
				$ddlCidades = array("" => "Selecione o Estado");
				if (!empty(set_value('codigo_cid'))) {
					$cidades = $this->mod->buscarCidadesbyid(set_value('codigo_est'));
					foreach ($cidades as $key => $cada) {
						$ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
					}
				}

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Cidade: </label>
		            <div class="col-md-9">
		                ' . form_dropdown(array('name' => "codigo_cid", 'id' => 'ddlCidade', 'class' => 'form-control input1'), $ddlCidades, set_value('codigo_cid')) . '
		            </div>
		        </div>';


				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Telefone: </label>
		            <div class="col-md-9 ">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'telefone_pes',
					'id'    => 'telefones',
					'value' => set_value('telefone_pes'),
					'class' => 'form-control dditelefone  input1 '
				)) . '</div>
		        	</div>';

				echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Email: </label>
		            <div class="col-md-9 ">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'email_pes',
					'id'    => 'emails',
					'value' => set_value('email_pes'),
					'class' => 'form-control  input1 '
				)) . '</div>
		        	</div>
		        	
		        
		        ';

				echo '


		<h4 class="page-title p-l-0">
			Dados Bancários
			    <a class="btn btn-default" id="addConta"><i class="fa fa-plus"></i></a>
                <a class="btn btn-danger" id="removeConta"><i class="fa fa-minus"></i></a>
		</h4>
                   
				<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20">';

				echo '<div id="divBancos">';

				echo '<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20 eachBanco">
                <div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Banco: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'banco_pes[]',
					'id'    => 'banco_pes',
					'value' => set_value('banco_pes[0]'),
					'class' => 'form-control  input1 '
				)) . '</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Número Banco: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'numerobanco_pes[]',
					'id'    => 'numerobanco_pes',
					'value' => set_value('numerobanco_pes[0]'),
					'class' => 'form-control  input1 '
				)) . '</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">' . form_label("Agência: ") . '</label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'agencia_pes[]',
					'id'    => 'agencia_pes',
					'value' => set_value('agencia_pes[0]'),
					'class' => 'form-control  input1 '
				)) . '</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">' . form_label("Conta: ") . '</label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'conta_pes[]',
					'id'    => 'conta_pes',
					'value' => set_value('conta_pes[0]'),
					'class' => 'form-control  input1 '
				)) . '</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Nome Titular:</label>
		            <div class="col-md-9">
		                ' . form_input(array(
					'type'  => 'text',
					'name'  => 'nometitular_pes[]',
					'id'    => 'nometitular_pes',
					'value' => set_value('nometitular_pes[0]'),
					'class' => 'form-control  input1 '
				)) . '</div>
		        	</div>
		        	
		        	
		    ';


				echo '</div>
            </div><!--FECHA FORM-HORIZONTAL DADOS BANCÁRIOS-->';

				echo '<div class="tile p-15 form-horizontal clearfix">
            		<div class="form-group clearfix">
                		<div class="col-md-offset-2 col-md-10 m-t-10">
			' . form_submit(array('name' => 'btnSalvar', 'id' => 'btnSalvar', 'value' => 'Salvar e Voltar', 'class' => 'btn btn-primary')) .
					form_submit(array('name' => 'btnSalvar', 'id' => 'btnSalvar', 'value' => 'Salvar', 'class' => 'btn btn-primary')) .
					anchor('pessoa/index', "Voltar", array('class' => 'btn btn-danger')) .
					'
            
        				</div>
       		 		</div>
        		</div>
        ' . form_close() . '

    </div>';
			} elseif ($operacao == 'u') {
				//--------------------------------- Update ---------------------------------------------
				$id = pegaParam1($this->uri);

				if ($id == NULL) redirect('pessoa/index');

				$result = $this->mod->get_byid($id);
				$res = $result[0];

				$cidades = $this->mod->buscarCidadesbyid($res->codigo_est);
				$ddlCidades = array("" => "Selecione");
				foreach ($cidades as $key => $cada) {
					$ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
				}

				?>
    			<ol class="breadcrumb hidden-xs">
    				<li><a href="<?php echo site_url("pessoa/index") ?>">Pessoas</a></li>
    				<li class="active">Alterar Pessoa</li>
    			</ol>
    			<h4 class="page-title">
    				Pessoa

    				<p class="sub-title">Alterar Dados Pessoais</p>
    			</h4>

    			<div class="block-area clearfix">
    				<div class="tile p-15 form-horizontal clearfix p-t-20">
    					<?php

						$atributos = array('class' => 'form-signin', 'id' => 'form1');
						echo form_open('pessoa/edit/' . base64_encode($res->codigo_pes), $atributos, array('ativo_pes' => $res->ativo_pes, 'cd' => $res->codigo_pes));

						if (validation_errors() != '') {
							echo '<div class="alert alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
						}

						if ($this->session->flashdata('alterar')) {
							echo '<div class="clearfix alert alert-success">' . $this->session->flashdata('alterar') . '</div>';
						}


						echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Contabiliza Home:</label>
		            <div class="col-md-9">
		                ' . form_dropdown(array('name' => "contahome_pes", 'id' => 'contahome_pes', 'class' => 'form-control input1'), array('0' => 'Não', '1' => 'Sim'), set_value('contahome_pes', $res->contahome_pes)) . '
		            </div>
		        </div>';

						echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Enviar extrato mensal:</label>
		            <div class="col-md-9">
		                ' . form_dropdown(array('name' => "extrato_pes", 'id' => 'extrato_pes', 'class' => 'form-control input1'), array('0' => 'Não', '1' => 'Sim'), set_value('extrato_pes', $res->extrato_pes)) . '
		            </div>
		        </div>';


						echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Tipo: </label>
		            <div class="col-md-9">
		                ' . form_dropdown(array('name' => "tipo_pes", 'id' => 'ddlTipo', 'class' => 'form-control input1'), array('0' => 'Pessoa Física', '1' => 'Pessoa Jurídica'), set_value('tipo_pes', $res->tipo_pes)) . '
		            </div>
		        </div>';


						echo '<div class="form-group m-t-20 clearfix">
							<label class="col-md-2 control-label">Data de Nascimento: </label>
							<div class="col-md-9">
								' . form_input(array(
							'type'  => 'text',
							'name'  => 'dtnascimento_pes',
							'id'    => 'dtnascimento_pes',
							'value' => set_value('dtnascimento_pes', (!empty($res->dtnascimento_pes) ? inverterdata($res->dtnascimento_pes) : "")),
							'class' => 'form-control input1'
						)) . '
							</div>
						</div>';


						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Nome: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'nome_pes',
							'id'    => 'nomes_pes',
							'value' => set_value('nome_pes', $res->nome_pes),
							'class' => 'form-control input1'
						)) . '
		            </div>
				</div>';


						echo '<div class="form-group m-t-10 clearfix">
				<label class="col-md-2 control-label">Estado civil: </label>
				<div class="col-md-9">
					' . form_dropdown(array('name' => "est_civil_pes", 'id' => 'est_civil_pes', 'class' => 'form-control input1'), array('solteiro' => 'Solteiro(a)', 'casado' => 'Casado(a)', 'separado' => 'Separado(a)', 'divorciado' => 'Divorciado(a)', 'viuvo' => "Viúvo(a)", 'uniao_estavel' => 'União estável'), set_value('est_civil_pes', $res->est_civil_pes)) . '
				</div>
			</div>';


			if($res->est_civil_pes == "casado" || $res->est_civil_pes == "uniao_estavel"){
				echo '<div class="conjuge-data">';
			}else{
				echo '<div class="conjuge-data" style="display:none">';
			}


				echo '<div class="form-group m-t-20 clearfix">
				<label class="col-md-2 control-label">Nome Cônjuge: </label>
				<div class="col-md-9">
					' . form_input(array_merge(
					[
						'type'  => 'text',
						'name'  => 'nome_conjuge',
						'id'    => 'nome_conjuge',
						'value' => set_value('nome_conjuge',$res->nome_conjuge),
						'class' => 'form-control input1'
					]

				)) . '
			</div>
		</div>';

				echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">CPF Cônjuge: </label>
                <div class="col-md-9">
                    ' . form_input(array_merge(
					[
						'type'  => 'text',
						'name'  => 'cpf_conjuge',
						'id'    => 'cpf_conjuge',
						'value' => set_value('cpf_conjuge',$res->cpf_conjuge),
						'class' => 'form-control cpf input1'
					]
				)) . '
                </div>
            </div>';

				echo '<div class="form-group m-t-20 clearfix">
                    <label class="col-md-2 control-label">Nacionalidade Cônjuge: </label>
                    <div class="col-md-9">
                    ' . form_input(array_merge(
					[
						'type'  => 'text',
						'name'  => 'nacionalidade_conjuge',
						'id'    => 'nacionalidade_conjuge',
						'value' => set_value('nacionalidade_conjuge',$res->nacionalidade_conjuge),
						'class' => 'form-control input1'
					]
				)) . '
                </div>
            </div>';


				echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">Data de Nascimento Cônjuge: </label>
                <div class="col-md-9">
                    ' . form_input(array_merge(
					[
						'type'  => 'text',
						'name'  => 'dtnascimento_conjuge',
						'id'    => 'dtnascimento_conjuge',
						'value' => set_value('dtnascimento_conjuge',$res->dtnascimento_conjuge),
						'class' => 'form-control input1'
					]
				)) . '
                </div>
            </div>';
				echo '</div>';

					

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">CPF: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'cpf_pes',
							'id'    => 'cpf_pes',
							'value' => set_value('cpf_pes', $res->cpf_pes),
							'class' => 'form-control cpf input1'
						)) . '
		            </div>
		        </div>';

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">RG: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'rg_pes',
							'id'    => 'rg_pes',
							'value' => set_value('rg_pes', $res->rg_pes),
							'class' => 'form-control rg input1'
						)) . '
		            </div>
		        </div>';

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Razão Social:</label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'razao_pes',
							'id'    => 'razao_pes',
							'value' => set_value('razao_pes', $res->razao_pes),
							'class' => 'form-control input1'
						)) . '
		            </div>
		        </div>';

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">' . form_label("CNPJ: ") . '</label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'cnpj_pes',
							'id'    => 'cnpj_pes',
							'value' => set_value('cnpj_pes', $res->cnpj_pes),
							'class' => 'form-control cnpj input1'
						)) . '
		            </div>
		        </div>';


						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">CEP: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'cep_pes',
							'id'    => 'cep_pes',
							'value' => set_value('cep_pes', $res->cep_pes),
							'class' => 'form-control cep input1'
						)) . '
		            </div>
		        </div>';

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Endereco: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'endereco_pes',
							'id'    => 'endereco_pes',
							'value' => set_value('endereco_pes', $res->endereco_pes),
							'class' => 'form-control input1'
						)) . '
		            </div>
		        </div>';

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Bairro: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'bairro_pes',
							'id'    => 'bairro_pes',
							'value' => set_value('bairro_pes', $res->bairro_pes),
							'class' => 'form-control  input1'
						)) . '
		            </div>
		        </div>';

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Número: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'numero_pes',
							'id'    => 'numero_pes',
							'value' => set_value('numero_pes', $res->numero_pes),
							'class' => 'form-control  input1'
						)) . '
		            </div>
		        </div>';

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Complemento: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'complemento_pes',
							'id'    => 'complemento_pes',
							'value' => set_value('complemento_pes', $res->complemento_pes),
							'class' => 'form-control  input1'
						)) . '
		            </div>
		        </div>';

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Estado: </label>
		            <div class="col-md-9">
		                ' . form_dropdown(array('name' => "codigo_est", 'id' => 'ddlEstado', 'class' => 'form-control input1'), $estados, set_value('codigo_est', $res->codigo_est)) . '
		            </div>
		        </div>';
						$ddlCidades = array("" => "Selecione o Estado");
						if (!empty(set_value('codigo_cid', $res->codigo_cid))) {
							$cidades = $this->mod->buscarCidadesbyid(set_value('codigo_est', $res->codigo_est));
							foreach ($cidades as $key => $cada) {
								$ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
							}
						}

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Cidade:</label>
		            <div class="col-md-9">
		                ' . form_dropdown(array('name' => "codigo_cid", 'id' => 'ddlCidade', 'class' => 'form-control input1'), $ddlCidades, set_value('codigo_cid', $res->codigo_cid)) . '
		            </div>
		        </div>';


						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Telefone: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'telefone_pes',
							'id'    => 'telefones',
							'value' => set_value('telefone_pes', $res->telefone_pes),
							'class' => 'form-control dditelefone  input1 '
						)) . '</div>
		        	</div>';

						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Email:</label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'email_pes',
							'id'    => 'emails',
							'value' => set_value('email_pes', $res->email_pes),
							'class' => 'form-control  input1 '
						)) . '</div>
		        	</div>
		        	';


						echo '<h4 class="page-title p-l-0">
                        Dados Bancários
                            <a class="btn btn-default" id="addConta"><i class="fa fa-plus"></i></a>
                            <a class="btn btn-danger" id="removeConta"><i class="fa fa-minus"></i></a>
                    </h4>
					
				<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20">
					';


						echo '<div id="divBancos">';

						foreach (explode('|sep|', $res->banco_pes) as $key => $cada) :

							echo '<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20 eachBanco">
                <div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Banco: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
								'type'  => 'text',
								'name'  => 'banco_pes[]',
								'id'    => 'banco_pes',
								'value' => set_value('banco_pes[' . $key . ']', $cada),
								'class' => 'form-control  input1 '
							)) . '</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Número Banco: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
								'type'  => 'text',
								'name'  => 'numerobanco_pes[]',
								'id'    => 'numerobanco_pes',
								'value' => set_value('numerobanco_pes[' . $key . ']', explode('|sep|', $res->numerobanco_pes)[$key]),
								'class' => 'form-control  input1 '
							)) . '</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">' . form_label("Agência: ") . '</label>
		            <div class="col-md-9">
		                ' . form_input(array(
								'type'  => 'text',
								'name'  => 'agencia_pes[]',
								'id'    => 'agencia_pes',
								'value' => set_value('agencia_pes[' . $key . ']', explode('|sep|', $res->agencia_pes)[$key]),
								'class' => 'form-control  input1 '
							)) . '</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">' . form_label("Conta: ") . '</label>
		            <div class="col-md-9">
		                ' . form_input(array(
								'type'  => 'text',
								'name'  => 'conta_pes[]',
								'id'    => 'conta_pes',
								'value' => set_value('conta_pes[' . $key . ']', explode('|sep|', $res->conta_pes)[$key]),
								'class' => 'form-control  input1 '
							)) . '</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Nome Titular:</label>
		            <div class="col-md-9">
		                ' . form_input(array(
								'type'  => 'text',
								'name'  => 'nometitular_pes[]',
								'id'    => 'nometitular_pes',
								'value' => set_value('nometitular_pes[' . $key . ']', explode('|sep|', $res->nometitular_pes)[$key]),
								'class' => 'form-control  input1 '
							)) . '</div>
		        	</div>
		        	
		        	
		    </div><!--FECHA FORM-HORIZONTAL DADOS BANCÁRIOS-->';

						endforeach;

						echo '</div>';



						echo '<div class="tile m-b-0">
						<h2 class="tile-title">Dados Login</h2>
					</div>
					
				<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20">
					';

						echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Login: </label>
		            <div class="col-md-9">
		                <span class="control-label">' . $res->cpf_pes . '</span></div>
		        	</div>';

						echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Senha: </label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'senha_pes',
							'id'    => 'senha_pes',
							'value' => set_value('senha_pes'),
							'class' => 'form-control  input1 '
						)) . '</div>
		        	</div>';


						echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Assinatura Digital:</label>
		            <div class="col-md-9">
		                ' . form_input(array(
							'type'  => 'text',
							'name'  => 'digitalsign_pes',
							'id'    => 'digitalsign_pes',
							'value' => set_value('digitalsign_pes'),
							'class' => 'form-control  input1 '
						)) . '</div>
		        	</div>
		        	
		        	
		    </div><!--FECHA FORM-HORIZONTAL DADOS BANCÁRIOS-->';




						echo '<div class="tile p-15 form-horizontal clearfix">
            <div class="form-group clearfix">
                <div class="col-md-offset-2 col-md-10 m-t-10">' .
							form_submit(array('name' => 'btnSalvar', 'id' => 'btnSalvar', 'value' => 'Salvar', 'class' => 'btn btn-primary')) .
							anchor('pessoa/index', "Voltar", array('class' => 'btn btn-danger')) . '
            
           </div>
            </div>
        </div>
        ' . form_close() . '

    </div>';
					} elseif ($operacao == 'd') {
						//--------------------------------- Detalhar ---------------------------------------------
						$id = base64_decode($this->uri->segment(3));

						if ($id == NULL) redirect('pessoa/index');

						$result = $this->mod->get_byid($id);
						$res = $result[0];

						$cidades = $this->mod->buscarCidadesbyid($res->codigo_est);
						$ddlCidades = array("" => "Selecione");
						foreach ($cidades as $key => $cada) {
							$ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
						}

						?>
    					<ol class="breadcrumb hidden-xs">
    						<li><a href="<?php echo site_url("pessoa/index") ?>">Pessoas</a></li>
    						<li class="active">Detalhar pessoa</li>
    					</ol>

    					<h4 class="page-title clearfix p-t-35">
    						<div class="pull-left">
    							Detalhar
    							<p class="sub-title">Pessoa</p>
    						</div>
    						<div class="pull-right">
    							<a href="<?php echo site_url("pessoa/index") ?>" class="btn"> <i class="fa fa-undo"></i> Voltar</a>
    						</div>
    					</h4>

    					<div class="block-area clearfix">

    						<div class="tile">
    							<div class="listview icon-list">
    								<?php


									echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("Tipo: ") . '</div>
		            <div class="col-md-9">
		                ' . form_label(($res->tipo_pes ? "Pessoa Jurídica" : "Pessoa Física")) . '
		            </div>
		        </div>';

									echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("Nome | Nome Fantasia: ") . '</div>
		            <div class="col-md-9">
		                ' . form_label(($res->nome_pes)) . '
		            </div>
		        </div>';
									if (!$res->tipo_pes) {
										echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("CPF: ") . '</div>
		            <div class="col-md-9">
		                ' . form_label(($res->cpf_pes)) . '
		            </div>
		        </div>';

										echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("RG: ") . '</div>
		            <div class="col-md-9">
		                ' . form_label(($res->rg_pes)) . '
		            </div>
		        </div>';
									} else {
										echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("Razão Social: ") . '</div>
		            <div class="col-md-9">
		                ' . form_label(($res->razao_pes)) . '
		            </div>
		        </div>';

										echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("CNPJ: ") . '</div>
		            <div class="col-md-9">
		                ' . form_label(($res->cnpj_pes)) . '
		            </div>
		        </div>';
									}
									echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("CEP: ") . '</div>
		            <div class="col-md-9">
		                ' . form_label(($res->cep_pes)) . '
		            </div>
		        </div>';

									echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("Endereco: ") . '</div>
		            <div class="col-md-9">
		                ' . form_label(($res->endereco_pes . ", " . $res->numero_pes . " - " . $res->bairro_pes)) . '
		            </div>
		        </div>';


									echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("Complemento: ") . '</div>
		            <div class="col-md-9">
		                ' . form_label(($res->complemento_pes)) . '
		            </div>
		        </div>';

									echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("Estado: ") . '</div>
		            <div class="col-md-9">
		                ' . form_label($estados[$res->codigo_est]) . '
		            </div>
		        </div>';

									echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("Cidade: ") . '</div>
		            <div class="col-md-9">
		                ';
									if ($res->codigo_est != null) {
										echo $ddlCidades[$res->codigo_cid];
									} else {
										echo '';
										//exit;
									}
									echo '
		            </div>
		        </div>';


									echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("Telefone: ") . '</div>
		            <div class="col-md-9 input_field_telefone">';
									echo form_label($res->telefone_pes) . "<br/>";
									echo '</div>
		        </div>';

									echo '<div class="media clearfix">
		            <div class="col-md-2 control-label">' . form_label("Email: ") . '</div>
		            <div class="col-md-9 input_field_email">';
									echo form_label($res->email_pes) . "<br/>";
									echo '</div>
		        </div>'; ?>

    								<h4 class="page-title clearfix p-l-0 p-r-0 p-t-10">
    									Dados Bancários
    								</h4>
    								<div class="tile">
    									<?php
										$ul = "";
										$bancos = "";
										foreach (explode('|sep|', $res->banco_pes) as $key => $cada) {
											$ul .= '<li role="presentation" class="' . ($key == 0 ? 'active' : '') . '"><a href="#banco' . $key . '" aria-controls="banco' . $key . '" role="tab" data-toggle="tab">Banco ' . ($key + 1) . '</a></li>';
											$bancos .= '<div role="tabpanel" class="tab-pane ' . ($key == 0 ? 'active' : '') . '" id="banco' . $key . '"><div class="listview icon-list">
                                        <div class="media clearfix">
                                            <label class="col-md-1 control-label">Banco: </label>
                                            <div class="col-md-9">' . $cada . '</div>
                                        </div>
                                        <div class="media clearfix">
                                            <label class="col-md-1 control-label">Num. Banco: </label>
                                            <div class="col-md-9">' . explode('|sep|', $res->numerobanco_pes)[$key] . '</div>
                                        </div>
                                        <div class="media clearfix">
                                            <label class="col-md-1 control-label">Agência: </label>
                                            <div class="col-md-9">' . explode('|sep|', $res->agencia_pes)[$key] . '</div>
                                        </div>
                                        <div class="media clearfix">
                                            <label class="col-md-1 control-label">Conta: </label>
                                            <div class="col-md-9">' . explode('|sep|', $res->conta_pes)[$key] . '</div>
                                        </div>
                                        <div class="media clearfix">
                                            <label class="col-md-1 control-label">Nome Titular: </label>
                                            <div class="col-md-9">' . explode('|sep|', $res->nometitular_pes)[$key] . '</div>
                                        </div>
                                    </div></div>';
										}

										?>


    									<ul class="nav nav-tabs" role="tablist">
    										<?= $ul; ?>
    									</ul>

    									<!-- Tab panes -->
    									<div class="tab-content">
    										<?= $bancos ?>
    									</div>

    									<!--                    <div class="listview icon-list">-->
    									<!--                        <div class="media clearfix">-->
    									<!--                            <label class="col-md-1 control-label">Banco: </label>-->
    									<!--                            <div class="col-md-9">--><?php //echo $res->banco_pes 
																									?>
    									<!--</div>-->
    									<!--                        </div>-->
    									<!--                        <div class="media clearfix">-->
    									<!--                            <label class="col-md-1 control-label">Num. Banco: </label>-->
    									<!--                            <div class="col-md-9">--><?php //echo $res->numerobanco_pes 
																									?>
    									<!--</div>-->
    									<!--                        </div>-->
    									<!--                        <div class="media clearfix">-->
    									<!--                            <label class="col-md-1 control-label">Agência: </label>-->
    									<!--                            <div class="col-md-9">--><?php //echo $res->agencia_pes 
																									?>
    									<!--</div>-->
    									<!--                        </div>-->
    									<!--                        <div class="media clearfix">-->
    									<!--                            <label class="col-md-1 control-label">Conta: </label>-->
    									<!--                            <div class="col-md-9">--><?php //echo $res->conta_pes 
																									?>
    									<!--</div>-->
    									<!--                        </div>-->
    									<!--                        <div class="media clearfix">-->
    									<!--                            <label class="col-md-1 control-label">Nome Titular: </label>-->
    									<!--                            <div class="col-md-9">--><?php //echo $res->nometitular_pes 
																									?>
    									<!--</div>-->
    									<!--                        </div>-->
    									<!--                    </div>-->


    								</div>


    							<?php


								echo '</div></div></div>';
							} elseif ($operacao == 'import') {
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

										echo form_open_multipart('pessoa/import');
										if (validation_errors() != '') {
											echo '<div class="alert alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
										}

										if ($this->session->flashdata('erro')) {
											echo '<div class="alert alert-danger clearfix">' . $this->session->flashdata('cadastro') . '</div>';
										}

										echo '<div class="cada-input clearfix">
		            <div class="cada-nome">' . form_label("Arquivo de Importação: ") . '</div>
		            <div class="cada-elemento cada-elemento-2">
		                ' . form_input(array('type' => 'file', 'name' => 'importacao')) . '
		            </div>
		        </div>';

										echo '<div class="area-botao-salvar clearfix">
					' . form_submit(array('name' => 'btnSalvar', 'id' => 'btnSalvar', 'value' => 'Importar', 'class' => 'btn btn-primary')) .
											anchor('pessoa/index', "Voltar", array('class' => 'btn btn-danger')) .
											'
		            
		        </div>';

										echo form_close();






										echo '</section>';
									} elseif ($operacao == 'importado') {
										//--------------------------------- Update ---------------------------------------------
										?><div class="clearfix titulo-principal">
    										<h1>Importar Números</h1>
    									</div>

    									<section class="cada-conteudo clearfix">
    										<div class="titulo-secundario clearfix">
    											<h1>
    												<i class="fa fa-plus-square"></i> Arquivo
    												<?php echo anchor('pessoa/index', "Voltar", array('class' => 'btn btn-danger')); ?>
    											</h1>
    										</div>
    									<?php



										if (validation_errors() != '') {
											echo '<div class="alert alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
										}

										if ($this->session->flashdata('erro')) {
											echo '<div class="alert alert-danger clearfix">' . $this->session->flashdata('cadastro') . '</div>';
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
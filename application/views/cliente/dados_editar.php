<!-- Formulário de Edição de dados -->
<?php
//print_r($this->session->aluno); exit;
if ($id == NULL)
    redirect('acesso/home');

foreach ($cidades as $key => $cada) {
    $ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
}
?>

<ol class="breadcrumb hidden-xs">
    <li><a href="<?php echo site_url("cliente/meus_dados") ?>">Meu perfil</a></li>
    <li class="active">Alterar dados</li>
</ol>
<h4 class="page-title">
    Dados
    <p class="sub-title">Alterar</p>
</h4>
<div class="block-area clearfix">
    <div class="tile p-b-15 form-horizontal clearfix">


        <?php
        // print_r($res); exit;
        $atributos = array('class' => 'form-signin', 'id' => 'form1', 'method' => 'POST');
        echo form_open('cliente/meus_dados/meu_perfil/' . base64_encode($res->codigo_pes), $atributos, array('ativo_pes' => $res->ativo_pes, 'cd' => $res->codigo_pes, 'tipo_pes' => $res->tipo_pes));

        if (validation_errors() != '') {
            echo '<div class="alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
        }

        if ($this->session->flashdata('alterar')) {
            echo '<div class="clearfix alert-success">' . $this->session->flashdata('alterar') . '</div>';
        }

        echo '<div class="form-group m-t-20 clearfix">
                    <label class="col-md-2 control-label">Data de Nascimento: </label>
                    <div class="col-md-9">
                        '.form_input(array_merge([
                            'type'  => 'text',
                            'name'  => 'dtnascimento_pes',
                            'id'    => 'dtnascimento_pes',
                            'value' => set_value('dtnascimento_pes', (!empty($res->dtnascimento_pes) ? inverterdata($res->dtnascimento_pes) : "")),
                            'class' => 'form-control input1'],
                            !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                        )).'
                    </div>
                </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Nome: </label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                'type'  => 'text',
                'name'  => 'nome_pes',
                'id'    => 'nomes_pes',
                'value' => set_value('nome_pes',$res->nome_pes),
                'class' => 'form-control input1'],
                !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
            )).'
            </div>
        </div>';
        if($res->tipo_pes == 0)
        {
            echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">CPF: </label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                    'type'  => 'text',
                    'name'  => 'cpf_pes',
                    'id'    => 'cpf_pes',
                    'value' => set_value('cpf_pes',$res->cpf_pes),
                    'class' => 'form-control cpf input1'],
                    !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                )).'
		            </div>
		        </div>';
        }
        else
        {


            echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Razão Social:</label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                        'type'  => 'text',
                        'name'  => 'razao_pes',
                        'id'    => 'razao_pes',
                        'value' => set_value('razao_pes',$res->razao_pes),
                        'class' => 'form-control input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                    )).'
		            </div>
		        </div>';

            echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">'.form_label("CNPJ: ").'</label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                        'type'  => 'text',
                        'name'  => 'cnpj_pes',
                        'id'    => 'cnpj_pes',
                        'value' => set_value('cnpj_pes',$res->cnpj_pes),
                        'class' => 'form-control cnpj input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                    )).'
		            </div>
                </div>';
                
                
        }
            
        echo '<div class="form-group m-t-20 clearfix">
            <label class="col-md-2 control-label">RG: </label>
            <div class="col-md-9">
                '.form_input(array_merge([
            'type'  => 'text',
            'name'  => 'rg_pes',
            'id'    => 'rg_pes',
            'value' => set_value('rg_pes',$res->rg_pes),
            'class' => 'form-control rg input1'],
            !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
            )).'
            </div>
        </div>';
        
        echo '<div class="form-group m-t-20 clearfix">
            <label class="col-md-2 control-label">Org. Emissor: </label>
            <div class="col-md-9">
                '.form_input(array_merge([
            'type'  => 'text',
            'name'  => 'org_emissor_pes',
            'id'    => 'org_emissor_pes',
            'value' => set_value('org_emissor_pes', ''),
            'class' => 'form-control org_emissor_pes input1'],
            !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
            )).'
            </div>
        </div>';

        if($res->tipo_pes == 0) {

            echo '<div class="form-group m-t-20 clearfix">
            <label class="col-md-2 control-label">Estado Civil:</label>
            <div class="col-md-9">
                '.form_dropdown(
                    array_merge([
                        'name'=>"est_civil_pes", 
                        'id'=>'estCivil', 
                        'class'=>'form-control input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                    ), 
                    array(
                        '' => 'Selecione',
                        'solteiro' => 'Solteiro',
                        'casado' => 'Casado',
                        'separado' => 'Separado',
                        'divorciado' => 'Divorciado',
                        'viúvo' => 'Viúvo',
                        'união estável' => 'União Estável'
                    ),
                    set_value('est_civil_pes',$res->est_civil_pes)
                ).'
            </div>
        </div>';

        if ($res->est_civil_pes == 'casado') {
            echo '<div class="conjuge-data">';
        } else {
            echo '<div class="conjuge-data" style="display: none">';
        }

            echo '<div class="form-group m-t-20 clearfix">
                    <label class="col-md-2 control-label">Nome Cônjuge: </label>
                    <div class="col-md-9">
                        '.form_input(array_merge([
                    'type'  => 'text',
                    'name'  => 'nome_conjuge',
                    'id'    => 'nome_conjuge',
                    'value' => set_value('nome_conjuge',$res->nome_conjuge),
                    'class' => 'form-control input1'],
                    !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                )).'
                </div>
            </div>';

            echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">CPF Cônjuge: </label>
                <div class="col-md-9">
                    '.form_input(array_merge([
                'type'  => 'text',
                'name'  => 'cpf_conjuge',
                'id'    => 'cpf_conjuge',
                'value' => set_value('cpf_conjuge',$res->cpf_conjuge),
                'class' => 'form-control cpf input1'],
                !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
            )).'
                </div>
            </div>';

            echo '<div class="form-group m-t-20 clearfix">
                    <label class="col-md-2 control-label">Nacionalidade Cônjuge: </label>
                    <div class="col-md-9">
                    '.form_input(array_merge([
                    'type'  => 'text',
                    'name'  => 'nacionalidade_conjuge',
                    'id'    => 'nacionalidade_conjuge',
                    'value' => set_value('nacionalidade_conjuge',$res->nacionalidade_conjuge),
                    'class' => 'form-control input1'],
                    !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                )).'
                </div>
            </div>';


            echo '<div class="form-group m-t-20 clearfix">
                <label class="col-md-2 control-label">Data de Nascimento Cônjuge: </label>
                <div class="col-md-9">
                    '.form_input(array_merge([
                        'type'  => 'text',
                        'name'  => 'dtnascimento_conjuge',
                        'id'    => 'dtnascimento_conjuge',
                        'value' => set_value('dtnascimento_conjuge', (!empty($res->dtnascimento_conjuge) ? inverterdata($res->dtnascimento_conjuge) : "")),
                        'class' => 'form-control input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                    )).'
                </div>
            </div>';

        echo '</div>';

        }

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">CEP: </label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                        'type'  => 'text',
                        'name'  => 'cep_pes',
                        'id'    => 'cep_pes',
                        'value' => set_value('cep_pes',$res->cep_pes),
                        'class' => 'form-control cep input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                        )).'
		            </div>
		        </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Endereco: </label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                        'type'  => 'text',
                        'name'  => 'endereco_pes',
                        'id'    => 'endereco_pes',
                        'value' => set_value('endereco_pes',$res->endereco_pes),
                        'class' => 'form-control input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                        )).'
		            </div>
		        </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Bairro: </label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                        'type'  => 'text',
                        'name'  => 'bairro_pes',
                        'id'    => 'bairro_pes',
                        'value' => set_value('bairro_pes',$res->bairro_pes),
                        'class' => 'form-control input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                        )).'
		            </div>
		        </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Número: </label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                        'type'  => 'text',
                        'name'  => 'numero_pes',
                        'id'    => 'numero_pes',
                        'value' => set_value('numero_pes',$res->numero_pes),
                        'class' => 'form-control input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                        )).'
		            </div>
		        </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Complemento: </label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                        'type'  => 'text',
                        'name'  => 'complemento_pes',
                        'id'    => 'complemento_pes',
                        'value' => set_value('complemento_pes',$res->complemento_pes),
                        'class' => 'form-control  input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                        )).'
		            </div>
		        </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Estado: </label>
		            <div class="col-md-9">
		                '.form_dropdown(array_merge([
                            'name'=>"codigo_est", 
                            'id'=>'ddlEstado', 
                            'class'=>'form-control input1'],
                            !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []), 
                            $estados, 
                            set_value('codigo_est',$res->codigo_est)).'
		            </div>
		        </div>';
        $ddlCidades = array(""=>"Selecione o Estado");
        if(!empty(set_value('codigo_cid',$res->codigo_cid)))
        {
            $cidades = $this->mod->buscarCidadesbyEst(set_value('codigo_est',$res->codigo_est));
            foreach ($cidades as $key => $cada) {
                $ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
            }
        }

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Cidade:</label>
		            <div class="col-md-9">
		                '.form_dropdown(array_merge([
                            'name'=>"codigo_cid", 
                            'id'=>'ddlCidade', 
                            'class'=>'form-control input1'],
                            !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []), 
                            $ddlCidades, 
                            set_value('codigo_cid',$res->codigo_cid)).'
		            </div>
		        </div>';


        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Telefone: </label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                        'type'  => 'text',
                        'name'  => 'telefone_pes',
                        'id'    => 'telefones',
                        'value' => set_value('telefone_pes',$res->telefone_pes),
                        'class' => 'form-control dditelefone  input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                        )).'
                        </div>
		        	</div>
		        	';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Email:</label>
		            <div class="col-md-9">
		                '.form_input(array_merge([
                        'type'  => 'text',
                        'name'  => 'email_pes',
                        'id'    => 'emails',
                        'value' => set_value('email_pes',$res->email_pes),
                        'class' => 'form-control  input1'],
                        !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                        )).'</div>
		        	</div>		        
		        ';

        echo '
                <h4 class="page-title p-l-0 p-t-15">
                    Dados Bancários
                    <a class="btn btn-default" id="addConta" ' . (!isset($this->session->usuario) ? "disabled" : "") .'><i class="fa fa-plus"></i></a>
                    <a class="btn btn-danger" id="removeConta" ' . (!isset($this->session->usuario) ? "disabled" : "") .'><i class="fa fa-minus"></i></a>
                </h4>
					
				
				<div id="divBancos">';

            foreach(explode('|sep|',$res->banco_pes) as $key => $cada):

                echo '<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20 eachBanco">
						<div class="form-group m-t-10 clearfix">
							<label class="col-md-2 control-label">Banco: </label>
							<div class="col-md-9">
								'.form_input(array_merge([
								'type'  => 'text',
								'name'  => 'banco_pes[]',
								'id'    => 'banco_pes',
								'value' => set_value('banco_pes['.$key.']',$cada),
                                'class' => 'form-control  input1'],
                                !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                                )).'</div>
							</div>
						<div class="form-group m-t-20 clearfix">
							<label class="col-md-2 control-label">Número Banco: </label>
							<div class="col-md-9">
								'.form_input(array_merge([
								'type'  => 'text',
								'name'  => 'numerobanco_pes[]',
								'id'    => 'numerobanco_pes',
								'value' => set_value('numerobanco_pes['.$key.']',explode('|sep|',$res->numerobanco_pes)[$key]),
                                'class' => 'form-control  input1'],
                                !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                                )).'</div>
							</div>
						<div class="form-group m-t-20 clearfix">
							<label class="col-md-2 control-label">'.form_label("Agência: ").'</label>
							<div class="col-md-9">
								'.form_input(array_merge([
								'type'  => 'text',
								'name'  => 'agencia_pes[]',
								'id'    => 'agencia_pes',
								'value' => set_value('agencia_pes['.$key.']',explode('|sep|',$res->agencia_pes)[$key]),
                                'class' => 'form-control  input1'],
                                !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                                )).'</div>
							</div>
						<div class="form-group m-t-20 clearfix">
							<label class="col-md-2 control-label">'.form_label("Conta: ").'</label>
							<div class="col-md-9">
								'.form_input(array_merge([
								'type'  => 'text',
								'name'  => 'conta_pes[]',
								'id'    => 'conta_pes',
								'value' => set_value('conta_pes['.$key.']',explode('|sep|',$res->conta_pes)[$key]),
                                'class' => 'form-control  input1'],
                                !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                                )).'</div>
							</div>
						<div class="form-group m-t-20 clearfix">
							<label class="col-md-2 control-label">Nome Titular:</label>
							<div class="col-md-9">
								'.form_input(array_merge([
								'type'  => 'text',
								'name'  => 'nometitular_pes[]',
								'id'    => 'nometitular_pes',
								'value' => set_value('nometitular_pes['.$key.']',explode('|sep|',$res->nometitular_pes)[$key]),
                                'class' => 'form-control  input1'],
                                !isset($this->session->usuario) ? ['disabled' => 'disabled'] : []
                                )).'</div>
							</div>
							
							
					</div><!--FECHA FORM-HORIZONTAL DADOS BANCÁRIOS-->';

            endforeach;

        
        echo '</div>';

        echo '
                <h4 class="page-title p-l-0">
                    Dados Login
                </h4>
					
				<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20">
					';

        echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Login: </label>
		            <div class="col-md-9">
		                <span class="control-label">'.$res->cpf_pes.'</span></div>
		        	</div>';

        echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Alterar Senha: </label>
		            <div class="col-md-6">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'senha_pes',
                'id'    => 'senha_pes',
                'value' => set_value('senha_pes'),
                'class' => 'form-control  input1 senhaassinatura')).'</div>
		                <label class="col-md-4 m-t-10">*Sua senha deve conter 6 (seis) dígitos numéricos</label>
		        	</div>';

        echo '<div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Confirmação Alterar Senha: </label>
		            <div class="col-md-6">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'csenha_pes',
                'id'    => 'csenha_pes',
                'value' => set_value('csenha_pes'),
                'class' => 'form-control  input1 senhaassinatura')).'</div>
		        	</div>';


        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Assinatura Digital:</label>
		            <div class="col-md-6">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'digitalsign_pes',
                'id'    => 'digitalsign_pes',
                'value' => set_value('digitalsign_pes'),
                'class' => 'form-control  input1 senhaassinatura')).'</div>
		                <label class="col-md-4 m-t-10">*Sua Assinatura deve conter 6 (seis) dígitos numéricos</label>
		                
		        	</div>';
        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Confirma Assinatura Digital:</label>
		            <div class="col-md-6">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'cdigitalsign_pes',
                'id'    => 'cdigitalsign_pes',
                'value' => set_value('cdigitalsign_pes'),
                'class' => 'form-control  input1 senhaassinatura')).'</div>
		                
		        	</div>
		        	
		        	
		    </div><!--FECHA FORM-HORIZONTAL DADOS BANCÁRIOS-->';




        echo '<div class="tile p-b-15"><div class="form-group clearfix">
                <div class="col-md-offset-2 col-md-10 m-t-10">' .
                form_submit(array('name' => 'btnSalvar', 'id' => 'btnSalvar', 'value' => 'Salvar', 'class' => 'btn btn-primary')) .
                anchor('cliente/meus_dados', "Voltar", array('class' => 'btn btn-danger')) . '
                
                </div>
            </div></div>
        ' . form_close() . '

        </div>
    </div>';

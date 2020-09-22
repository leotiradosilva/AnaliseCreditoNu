	<?php
if ($operacao == "c") { // 
//----------------------------------------- Consulta --------------------------------------------------
    ?>

    <div class="titulo-principal clearfix">
        <h1>Alunos</h1>
        <div class="botoes-adicao">
            <!--<a href="add" role="button" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>-->
            <?php echo($permissao->inserir ? anchor('aluno/add', '<i class="fa fa-plus icone-botoes"></i> Adicionar', array('class' => 'btn btn-primary novo-registro')) : "") ?>

        </div>
    </div>

    <section class="cada-conteudo cada-conteudo-2 clearfix cada-conteudo-2-especial">

        <div id="divDados" class="div-dados clearfix">
            <?php
            //Cabecalho da tabela
            $total = 0;
            $linhas = '<table class="table table-bordered table-striped tablesorter table-responsive tabela-especial" id="tablesorter">
					<thead>
						<tr>
							<th data-name="Nome" data-placeholder="Filtrar Nome" >Nome</th>
							<th data-name="Nome" data-placeholder="Filtrar Nome" >CPF</th>
							<th data-name="Telefone" data-placeholder="Filtrar Telefone" >Telefone(s)</th>
							<th data-name="Email" data-placeholder="Filtrar Email" >Email(s)</th>
							<th data-name="Cidade" data-placeholder="Filtrar Cidade" >Cidade</th>
							<th data-name="UF" data-placeholder="Filtrar UF" >UF</th>
							
							<th data-name="Ação" data-sorter="false" class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o</th>
						</tr>
					</thead><tbody>';


            foreach ($dados as $cada) {
                $emails = $this->mod->buscarEmailAluno($cada['codigo_pes']);
                $telefones = $this->mod->buscarTelefoneAluno($cada['codigo_pes']);
                $emas = "";
                foreach ($emails as $key => $cada2) {
                    $emas .= $cada2['email_email'] . "<br/>";
                }

                $tels = "";
                foreach ($telefones as $key => $cada2) {
                    $tels .= $cada2['numero_tel'] . "<br/>";
                }


                //$editar = '<a href="edit/'.$apto['codigo_apto'].'" class="btn sumir-responsivo btn-default btn-acao-tabela invi" title="Editar"><i class="fa fa-edit"></i></a> ';
                //$excluir = '<a href="Javascript: Inativar(\''.$codigo.'\', \''.$nome.'\')" class="btn sumir-responsivo btn-default btn-acao-tabela inativar invi" title="Excluir"><i class="fa fa-trash-o"></i></a> ';

                $linhas .= '<tr class="" >

											<td class=" hover-data" >' . $cada['nome_pes'] . '</td>
											<td class=" hover-data" >' . ($cada['tipo_pes'] ? $cada['cnpj_pes'] : $cada['cpf_pes']) . '</td>
											<td class=" " >' . $tels . '</td>
											<td class=" hover-data" >' . $emas . '</td>
											<td class=" " >' . $cada['nome_cid'] . '</td>
											<td class=" " >' . $cada['uf_est'] . '</td>
											
											
											
											<td class=" sumir-impressao">' . ($permissao->alterar ? anchor("aluno/edit/" . base64_encode($cada['codigo_pes']), '<i class="fa fa-edit"></i>', array('class' => "btn btn-default btn-acao-tabela", "title" => 'Editar')) : "") .
                    ($permissao->detalhar ? anchor("aluno/detail/" . base64_encode($cada['codigo_pes']), '<i class="fa fa-plus-circle"></i>', array('class' => "btn btn-default btn-acao-tabela", "title" => 'Detalhar')) : "") .
                    ($permissao->excluir ? form_button(array('name' => 'btnExcluir', 'content' => '<i class="fa fa-trash-o"></i>', 'class' => "btn btn-default btn-acao-tabela", 'title' => 'Excluir', 'onClick' => 'inativar(' . $cada['codigo_pes'] . ')')) : "") . '</td>

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
            /* <tr>
              <td colspan="7"><center>Total de Dados: ' . $total . '</center></td>
              </tr>
              </tfoot></table>'; */

            echo $linhas;
            ?>
        </div>

        <div id="dialog-confirm"></div>

        <div id="divMensagem"></div>

    </section>

    <!-- Div do fancybox de detalhes do conteudo -->
    <div id="divDetalhes" class="div-detalhes-agenda"></div>
    <?php
} //-------------------------------------------------- Cadastro -------------------------------------------------
elseif ($operacao == 'u') {
//--------------------------------- Update ---------------------------------------------
$id = $this->session->aluno['codigo'];
//print_r($this->session->aluno); exit;
if ($id == NULL)
    redirect('acesso/home');

$result = $this->mod->get_byid($id);
$res = $result[0];
$resultemail = $this->mod->buscarEmails($res->codigo_pes);
$resulttel = $this->mod->buscarTelefones($res->codigo_pes);
$cidades = $this->mod->buscarCidadesbyid($res->codigo_est);
$ddlCidades = array("" => "Selecione");
foreach ($cidades as $key => $cada) {
    $ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
}
?>

<ol class="breadcrumb hidden-xs">
    <li><a href="<?php echo site_url("acesso/home") ?>">Meu perfil</a></li>
    <li class="active">Alterar dados</li>
</ol>
<h4 class="page-title">
    Dados
    <p class="sub-title">Alterar</p>
</h4>
<div class="block-area clearfix">
    <div class="tile p-b-15 form-horizontal clearfix">


        <?php
        //print_r($res); exit;
        $atributos = array('class' => 'form-signin', 'id' => 'form1', 'method' => 'POST');
        echo form_open('acesso/meu_perfil/' . base64_encode($res->codigo_pes), $atributos, array('ativo_pes' => $res->ativo_pes, 'cd' => $res->codigo_pes, 'tipo_pes' => $res->tipo_pes));

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
								'.form_input(array(
                'type'  => 'text',
                'name'  => 'dtnascimento_pes',
                'id'    => 'dtnascimento_pes',
                'value' => set_value('dtnascimento_pes', (!empty($res->dtnascimento_pes) ? inverterdata($res->dtnascimento_pes) : "")),
                'class' => 'form-control input1')).'
							</div>
						</div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Nome: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'nome_pes',
                'id'    => 'nomes_pes',
                'value' => set_value('nome_pes',$res->nome_pes),
                'class' => 'form-control input1')).'
		            </div>
		        </div>';
        if($res->tipo_pes == 0)
        {
            echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">CPF: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                    'type'  => 'text',
                    'name'  => 'cpf_pes',
                    'id'    => 'cpf_pes',
                    'value' => set_value('cpf_pes',$res->cpf_pes),
                    'class' => 'form-control cpf input1')).'
		            </div>
		        </div>';

            echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">RG: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                    'type'  => 'text',
                    'name'  => 'rg_pes',
                    'id'    => 'rg_pes',
                    'value' => set_value('rg_pes',$res->rg_pes),
                    'class' => 'form-control rg input1')).'
		            </div>
		        </div>';
        }
        else
        {


            echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Razão Social:</label>
		            <div class="col-md-9">
		                '.form_input(array(
                    'type'  => 'text',
                    'name'  => 'razao_pes',
                    'id'    => 'razao_pes',
                    'value' => set_value('razao_pes',$res->razao_pes),
                    'class' => 'form-control input1')).'
		            </div>
		        </div>';

            echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">'.form_label("CNPJ: ").'</label>
		            <div class="col-md-9">
		                '.form_input(array(
                    'type'  => 'text',
                    'name'  => 'cnpj_pes',
                    'id'    => 'cnpj_pes',
                    'value' => set_value('cnpj_pes',$res->cnpj_pes),
                    'class' => 'form-control cnpj input1')).'
		            </div>
		        </div>';

        }


        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">CEP: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'cep_pes',
                'id'    => 'cep_pes',
                'value' => set_value('cep_pes',$res->cep_pes),
                'class' => 'form-control cep input1')).'
		            </div>
		        </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Endereco: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'endereco_pes',
                'id'    => 'endereco_pes',
                'value' => set_value('endereco_pes',$res->endereco_pes),
                'class' => 'form-control input1')).'
		            </div>
		        </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Bairro: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'bairro_pes',
                'id'    => 'bairro_pes',
                'value' => set_value('bairro_pes',$res->bairro_pes),
                'class' => 'form-control  input1')).'
		            </div>
		        </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Número: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'numero_pes',
                'id'    => 'numero_pes',
                'value' => set_value('numero_pes',$res->numero_pes),
                'class' => 'form-control  input1')).'
		            </div>
		        </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Complemento: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'complemento_pes',
                'id'    => 'complemento_pes',
                'value' => set_value('complemento_pes',$res->complemento_pes),
                'class' => 'form-control  input1')).'
		            </div>
		        </div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Estado: </label>
		            <div class="col-md-9">
		                '.form_dropdown(array('name'=>"codigo_est", 'id'=>'ddlEstado', 'class'=>'form-control input1'), $estados, set_value('codigo_est',$res->codigo_est)).'
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
		                '.form_dropdown(array('name'=>"codigo_cid", 'id'=>'ddlCidade', 'class'=>'form-control input1'), $ddlCidades, set_value('codigo_cid',$res->codigo_cid)).'
		            </div>
		        </div>';


        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Telefone: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'telefone_pes',
                'id'    => 'telefones',
                'value' => set_value('telefone_pes',$res->telefone_pes),
                'class' => 'form-control dditelefone  input1 ')).'</div>
		        	</div>
		        	';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Email:</label>
		            <div class="col-md-9">
		                '.form_input(array(
                'type'  => 'text',
                'name'  => 'email_pes',
                'id'    => 'emails',
                'value' => set_value('email_pes',$res->email_pes),
                'class' => 'form-control  input1 ')).'</div>
		        	</div>
		        	
		        
		        ';


        echo '
                <h4 class="page-title p-l-0 p-t-15">
                    Dados Bancários
                    <a class="btn btn-default" id="addConta"><i class="fa fa-plus"></i></a>
                    <a class="btn btn-danger" id="removeConta"><i class="fa fa-minus"></i></a>
                </h4>
					
				
				<div id="divBancos">';

            foreach(explode('|sep|',$res->banco_pes) as $key => $cada):

                echo '<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20 eachBanco">
                <div class="form-group m-t-10 clearfix">
		            <label class="col-md-2 control-label">Banco: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                        'type'  => 'text',
                        'name'  => 'banco_pes[]',
                        'id'    => 'banco_pes',
                        'value' => set_value('banco_pes['.$key.']',$cada),
                        'class' => 'form-control  input1 ')).'</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Número Banco: </label>
		            <div class="col-md-9">
		                '.form_input(array(
                        'type'  => 'text',
                        'name'  => 'numerobanco_pes[]',
                        'id'    => 'numerobanco_pes',
                        'value' => set_value('numerobanco_pes['.$key.']',explode('|sep|',$res->numerobanco_pes)[$key]),
                        'class' => 'form-control  input1 ')).'</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">'.form_label("Agência: ").'</label>
		            <div class="col-md-9">
		                '.form_input(array(
                        'type'  => 'text',
                        'name'  => 'agencia_pes[]',
                        'id'    => 'agencia_pes',
                        'value' => set_value('agencia_pes['.$key.']',explode('|sep|',$res->agencia_pes)[$key]),
                        'class' => 'form-control  input1 ')).'</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">'.form_label("Conta: ").'</label>
		            <div class="col-md-9">
		                '.form_input(array(
                        'type'  => 'text',
                        'name'  => 'conta_pes[]',
                        'id'    => 'conta_pes',
                        'value' => set_value('conta_pes['.$key.']',explode('|sep|',$res->conta_pes)[$key]),
                        'class' => 'form-control  input1 ')).'</div>
		        	</div>
		        <div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Nome Titular:</label>
		            <div class="col-md-9">
		                '.form_input(array(
                        'type'  => 'text',
                        'name'  => 'nometitular_pes[]',
                        'id'    => 'nometitular_pes',
                        'value' => set_value('nometitular_pes['.$key.']',explode('|sep|',$res->nometitular_pes)[$key]),
                        'class' => 'form-control  input1 ')).'</div>
		        	</div>
		        	
		        	
		    </div><!--FECHA FORM-HORIZONTAL DADOS BANCÁRIOS-->';

            endforeach;
        



        
        echo '</div>';

//        $formconta = '<div class="tile p-15 m-b-0 form-horizontal clearfix p-t-20 eachBanco">
//                <div class="form-group m-t-10 clearfix">
//		            <label class="col-md-2 control-label">Banco: </label>
//		            <div class="col-md-9">
//		                '.form_input(array(
//                'type'  => 'text',
//                'name'  => 'banco_pes[]',
//                'id'    => 'banco_pes',
//                'value' => '',
//                'class' => 'form-control  input1 ')).'</div>
//		        	</div>'.'<div class="form-group m-t-20 clearfix">
//		            <label class="col-md-2 control-label">N&uacute;mero Banco: </label>
//		            <div class="col-md-9">
//		                '.form_input(array(
//                'type'  => 'text',
//                'name'  => 'numerobanco_pes[]',
//                'id'    => 'numerobanco_pes',
//                'value' => '',
//                'class' => 'form-control  input1 ')).'</div>
//		        	</div>'.'<div class="form-group m-t-20 clearfix">
//		            <label class="col-md-2 control-label">'.form_label("Ag&ecirc;ncia: ").'</label>
//		            <div class="col-md-9">
//		                '.form_input(array(
//                'type'  => 'text',
//                'name'  => 'agencia_pes[]',
//                'id'    => 'agencia_pes',
//                'value' => '',
//                'class' => 'form-control  input1 ')).'</div>
//		        	</div>'.'<div class="form-group m-t-20 clearfix">
//		            <label class="col-md-2 control-label">'.form_label("Conta: ").'</label>
//		            <div class="col-md-9">
//		                '.form_input(array(
//                'type'  => 'text',
//                'name'  => 'conta_pes[]',
//                'id'    => 'conta_pes',
//                'value' => '',
//                'class' => 'form-control  input1 ')).'</div>
//		        	</div>'.'<div class="form-group m-t-20 clearfix">
//		            <label class="col-md-2 control-label">Nome Titular:</label>
//		            <div class="col-md-9">
//		                '.form_input(array(
//                'type'  => 'text',
//                'name'  => 'nometitular_pes[]',
//                'id'    => 'nometitular_pes',
//                'value' => '',
//                'class' => 'form-control  input1 ')).'</div>
//		        	</div>
//		    </div>';
//
//        echo '<input type="hidden" id="hdBanco" value="'.base64_encode($formconta).'">';


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
                anchor('acesso/home', "Voltar", array('class' => 'btn btn-danger')) . '
                
                </div>
            </div></div>
        ' . form_close() . '

        </div>
    </div>';
        }elseif ($operacao == 'addAgenda') {
?>

<ol class="breadcrumb hidden-xs">
    <li><a href="<?php echo site_url("acesso/agenda") ?>">Agenda</a></li>
    <li class="active">Adicionar Agenda</li>
</ol>
<h4 class="page-title">
    Agenda
    <p class="sub-title">Adicionar</p>
</h4>
<div class="block-area clearfix">
    <div class="tile p-15 form-horizontal clearfix p-t-20">

        <?php
        //print_r($res); exit;
        $atributos = array('class' => 'form-signin', 'id' => 'form1');
        echo form_open('acesso/addAgenda/', $atributos, array('codigo_pes' => $this->session->userdata('aluno')['codigo']));

        if (validation_errors() != '') {
            echo '<div class="alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
        }

        if ($this->session->flashdata('alterar')) {
            echo '<div class="clearfix alert-success">' . $this->session->flashdata('alterar') . '</div>';
        }



                echo '<div class="form-group m-t-20 clearfix">
							<label class="col-md-2 control-label">Data: </label>
							<div class="col-md-9">
								'.form_input(array(
                'type'  => 'text',
                'name'  => 'data_age',
                'id'    => 'data_age',
                'value' => set_value('data_age'),
                'class' => 'form-control input1')).'
							</div>
						</div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Descrição: </label>
		            <div class="col-md-9">
		                '.form_textarea(array(
                'type'  => 'text',
                'name'  => 'desc_age',
                'id'    => 'desc_age',
                'value' => set_value('desc_age'),
                'class' => 'form-control input1')).'
		            </div>
		        </div>';

        echo '<div class="form-group clearfix">
            <div class="col-md-offset-2 col-md-10 m-t-10">' .
            form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar e Voltar', 'class'=>'btn btn-primary')).
            form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
            anchor('acesso/agenda', "Voltar", array('class'=> 'btn btn-danger')) . '
            
            </div>
        </div>
        ' . form_close() . '

        </div>
    </div>';
    
        }elseif ($operacao == 'editaAgenda') {
?>

<ol class="breadcrumb hidden-xs">
    <li><a href="<?php echo site_url("acesso/agenda") ?>">Agenda</a></li>
    <li class="active">Editar Agenda</li>
</ol>
<h4 class="page-title">
    Agenda
    <p class="sub-title">Alterar</p>
</h4>
<div class="block-area clearfix">
    <div class="tile p-15 form-horizontal clearfix p-t-20">

        <?php
        //print_r($agenda); exit;
        $atributos = array('class' => 'form-signin', 'id' => 'form1');
        echo form_open('acesso/alterarAgenda/'.base64_encode($agenda->codigo_age), $atributos, array('codigo_pes' => $this->session->userdata('aluno')['codigo']));

        if (validation_errors() != '') {
            echo '<div class="alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        </div>';
        }

        if ($this->session->flashdata('alterar')) {
            echo '<div class="clearfix alert-success">' . $this->session->flashdata('alterar') . '</div>';
        }



                echo '<div class="form-group m-t-20 clearfix">
							<label class="col-md-2 control-label">Data: </label>
							<div class="col-md-9">
								'.form_input(array(
                'type'  => 'text',
                'name'  => 'data_age',
                'id'    => 'data_age',
                'value' => set_value('data_age', Mysql_to_Data($agenda->data_age)),
                'class' => 'form-control input1')).'
							</div>
						</div>';

        echo '<div class="form-group m-t-20 clearfix">
		            <label class="col-md-2 control-label">Descrição: </label>
		            <div class="col-md-9">
		                '.form_textarea(array(
                'type'  => 'text',
                'name'  => 'desc_age',
                'id'    => 'desc_age',
                'value' => set_value('desc_age', $agenda->desc_age),
                'class' => 'form-control input1')).'
		            </div>
		        </div>';

        echo '<div class="form-group clearfix">
            <div class="col-md-offset-2 col-md-10 m-t-10">' .
            form_submit(array('name'=>'btnSalvar', 'id'=>'btnSalvar','value'=>'Salvar', 'class'=>'btn btn-primary')).
            anchor('acesso/agenda', "Voltar", array('class'=> 'btn btn-danger')) . '
            
            </div>
        </div>
        ' . form_close() . '

        </div>
    </div>';
        } elseif ($operacao == 'digital') {
        //--------------------------------- Home ---------------------------------------------
        $id = $this->session->aluno['codigo'];
        //print_r($this->session->aluno); exit;
        if ($id == NULL)
            redirect('acesso/home');

        $result = $this->mod->get_byid($id);
        $res = $result[0];

        $taxa = $this->mod->getTaxa();
        ?>


        <div class="meu-perfil cada-perfil" style="display: block;">

            <h4 class="page-title">Subscrição Digital</h4>

            <div class="block-area clearfix">
                <div class="tile">
                    <div class="listview icon-list">

                        <div class="media clearfix">
                            <label class="col-md-1 control-label">Taxa Vigente: </label>
                            <div class="col-md-9"><?php echo formata_cupom($taxa->taxa_emp)." % a.m. líquido de IR."?></div>
                        </div>

                        <div class="media clearfix">
                            <label class="col-md-1 control-label">Dados bancários para subscrição: </label>
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
                            <div class="col-md-9"><a class='btn  btn-acao-tabela' onclick='downloadEscritura()' title="Download Escritura"><i class='fa fa-cloud-download'></i> Download</a></div>
                        </div>
                    </div>
                </div>

                <h4 class="page-title p-l-0">Subscrições Pendentes</h4>
                <div class="tile">
                    <div class="listview icon-list">
                            <table class="tile table table-bordered table-striped tablesorter table-responsive"
                                   id="tablesorter">
                                <thead>
                                <tr>
                                    <th data-name="Código" data-placeholder="Filtrar Código">Código</th>
                                    <th data-name="Data" data-placeholder="Filtrar Data">Data Subscrição</th>
                                    <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                                    <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Valor Investido</th>
                                    <th data-name="" data-placeholder=""></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $subscricoes = $this->mod->buscaSubscricaoPendente($this->session->aluno['codigo']);
                                $saldoTotalCliente = 0;
                                if(!empty($subscricoes))
                                {
                                    foreach ($subscricoes as $key => $cada) {
                                        $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;
                                        echo "<tr>
                                            <td>" . $cada->codigo_subs . "</td>
                                            <td>" . inverterdata($cada->data_subs) . "</td>
                                            <td>" . formata_cupom($cada->taxa_subs) . "</td>
                                            <td>" . formata_moeda($cada->valor_subs) . "</td>
                                            <td>" . "<a class='btn btn-action-table tooltips' data-toggle='tooltip' data-placement='top' title='Aceitar Subscrição' onclick='aceitarSubscricao(".$cada->codigo_subs.", \"".inverterdata($cada->data_subs)."\", \"".$cada->taxa_subs."\", \"".formata_moeda($cada->valor_subs)."\")'><i class='fa fa-check'></i></a>" . "</td>
                                         </tr>";

                                        $saldoTotalCliente += $totalrendimento;
                                    }
                                }
                                else
                                {
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

            <h4 class="page-title">Subscrição</h4>
            <div class="block-area">

                <table class="tile table table-bordered table-striped tablesorter table-responsive"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Código" data-placeholder="Filtrar Código">Código</th>
                        <th data-name="Data" data-placeholder="Filtrar Data">Data Subscrição</th>
                        <th data-name="Cliente" data-placeholder="Filtrar Cliente">Cliente</th>
                        <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                        <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Valor Investido</th>
                        <th data-name="Rendimento" data-placeholder="Filtrar Rendimento">Rendimento</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);
                    $saldoTotalCliente = 0;

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

            <h4 class="page-title">Subscrição</h4>
            <div class="block-area">
                <table class="tile table table-bordered table-striped tablesorter table-responsive tabela-especial"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Código" data-placeholder="Filtrar Código">Código Subcrição</th>
                        <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                        <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Saldo Atual</th>
                        <th data-name="Ação" data-sorter="false"
                            class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);
                    $saldoTotalCliente = 0;

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
                <table class="tile table table-bordered table-striped tablesorter table-responsive"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Data" data-placeholder="Filtrar Data">Código Subscrição</th>
                        <th data-name="Data" data-placeholder="Filtrar Data">Cliente</th>
                        <th data-name="Data" data-placeholder="Filtrar Data">Data</th>
                        <th data-name="Valor" data-placeholder="Filtrar Valor">Valor</th>
                        <th data-name="Ação" data-sorter="false"
                            class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $resgates = $this->mod->buscaResgateCliente($this->session->aluno['codigo']);
                    $saldoTotalCliente = 0;

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

    <div class="modal fade" id="modal-extrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
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



    <div class="modal fade" id="modal-aceitar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirmar Subscrição</h4>
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
                                    <?php echo form_dropdown(array('name' => "rendimento_subs", 'id' => 'ddlRendimento', 'class' => 'form-control'), array(''=>"---------------","0" => "Resgatar Mensalmente","1" => "Reinvestir"), set_value("rendimento_subs")) ?>
                                </div>
                            </div>

                            <div class="form-group clearfix m-t-20">
                                <label class="col-md-2 control-label">Assinatura Digital: </label>
                                <div class="col-md-9">
                                    <?php
                                    echo form_input(array('type' => 'password',
                                        'name' => 'inscricao',
                                        'id' => 'inscricao',
                                        'class' => 'form-control  input1',
                                        'value' => (set_value("inscricao")))); ?>
                                </div>
                            </div>
                            <input type="hidden" id="codigoSubscricaoAceita" value="">
                            <?php
                            echo '</div>';
                            ?>
                        </div>

                    </div>

                    <div class="modal-footer m-t-0">
                        <button type="button" class="btn btn-success btn-reverse" id="btnConfirmarSubscricao"> <i class="fa fa-check"></i> Confirmar</button>
                        <button type="button" class="btn btn-danger btn-reverse" data-dismiss="modal"> <i class="fa fa-times"></i> Fechar</button>
                    </div>
                </div>
            </div>
        </div>


        <?php


    } elseif ($operacao == 'meus_dados') {
        //--------------------------------- Home ---------------------------------------------
        $id = $this->session->aluno['codigo'];
        //print_r($this->session->aluno); exit;
        if ($id == NULL)
            redirect('acesso/home');

        $result = $this->mod->get_byid($id);
        $res = $result[0];
        $resultemail = $this->mod->buscarEmails($res->codigo_pes);
        $resulttel = $this->mod->buscarTelefones($res->codigo_pes);
        $cidades = $this->mod->buscarCidadesbyEst($res->codigo_est);
        $ddlCidades = array("" => "Selecione");
        foreach ($cidades as $key => $cada) {
            $ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
        }//echo $ddlCidades[$res->codigo_cid]; exit;
        //print_r($ddlCidades); exit;
        ?>

<!--        <div class="meu-perfil cada-perfil" style="display: block;">-->

            <h4 class="page-title clearfix">
                <div class="pull-left">
                    Meus dados
                    <p class="sub-title">Dados pessoais</p>
                </div>

                <div class="pull-right">
                    <?php  echo anchor("acesso/meu_perfil", "<i class='fa fa-edit'></i> Editar Perfil", array('name' => "btnResgate", 'class' => "btn btn-acao-tabela", 'title' => 'Editar Perfil'))?>
                </div>
            </h4>

            <div class="block-area clearfix">

                <?php
                $msg2 = "";
                if(!empty($this->session->flashdata('pass')))
                {
                    $msg2 .= $this->session->flashdata('pass')."<br/>";
                }
                if(!empty($this->session->flashdata('sign')))
                {
                    $msg2 .= $this->session->flashdata('sign');
                }

                if(!empty($msg2))
                {
                    echo '<div class="alert alert-success">
                            '.$msg2.'
                          </div>';
                }




                    ?>

                <div class="tile">
                    <div class="listview icon-list">

                        <div class="media clearfix">
                            <label class="col-md-1 control-label">Nome: </label>
                            <div class="col-md-9"><?php echo $res->nome_pes ?></div>
                        </div>
                        <?php
                        if (!$res->tipo_pes) { ?>
                            <div class="media clearfix">
                                <label class="col-md-1 control-label">CPF: </label>
                                <div class="col-md-9">
                                    <?php

                                    echo $res->cpf_pes;

                                    ?>
                                </div>
                            </div>

                            <?php
                            if ($res->rg_pes) {
                                ?>
                                <div class="media clearfix">
                                    <label class="col-md-1 control-label">RG: </label>
                                    <span class="col-md-9"><?php echo $res->rg_pes ?></span>
                                </div>
                                <?php
                            }
                            if ($res->dtnascimento_pes) {
                                ?>
                                <div class="media clearfix">
                                    <label class="col-md-1 control-label">Nascimento: </label>
                                    <span class="col-md-9"><?php echo inverterdata($res->dtnascimento_pes) ?></span>
                                </div>
                                <?php
                            }
                        }
                        else {
                            ?>
                            <div class="media clearfix">
                                <label class="col-md-1 control-label">Razão Social: </label>
                                <div class="col-md-9">
                                    <?php

                                    echo $res->razao_pes;

                                    ?>
                                </div>
                            </div>
                            <div class="media clearfix">
                                <label class="col-md-1 control-label">CNPJ: </label>
                                <span class="col-md-9"><?php echo $res->cnpj_pes;?></span>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <h4 class="page-title clearfix p-l-0 p-r-0 p-t-10">
                    Dados gerais
                    <p class="sub-title">Endereço e contato</p>
                </h4>
                <div class="tile">
                    <div class="listview icon-list">
                        <div class="media clearfix">
                            <label class="col-md-1 control-label">CEP: </label>
                            <div class="col-md-9"><?php echo $res->cep_pes ?></div>
                        </div>

                        <div class="media clearfix">
                            <label class="col-md-1 control-label">Endereço: </label>
                            <div><?php echo $res->endereco_pes . ", " . $res->numero_pes . ", " . $res->bairro_pes ?></div>
                        </div>

                        <div class="media clearfix">
                            <label class="col-md-1 control-label">Compl.: </label>
                            <div><?php echo $res->complemento_pes ?></div>
                        </div>

                        <div class="media clearfix">
                            <label class="col-md-1 control-label">Cidade: </label>
                            <div><?php echo $ddlCidades[$res->codigo_cid] . ", " . "<strong>" . $res->uf_est . "</strong> - Brasil" ?></div>
                        </div>
                    </div>

                    <div class="listview icon-list">

                        <div class="media clearfix">
                            <label class="col-md-1 control-label">Telefone: </label>
                            <div><?php echo $res->telefone_pes ?></div>
                        </div>


                        <div class="media clearfix">
                            <label class="col-md-1 control-label">Email: </label>
                            <div><?php echo $res->email_pes ?></div>
                        </div>


                    </div>
                </div>

                <h4 class="page-title clearfix p-l-0 p-r-0 p-t-10">
                    Dados Bancários
                </h4>
                <div class="tile">
                    <?php
                    $ul = "";
                    $bancos = "";
                        foreach (explode('|sep|',$res->banco_pes) as $key => $cada)
                        {
                            $ul .= '<li role="presentation" class="'.($key == 0 ? 'active' : '').'"><a href="#banco'.$key.'" aria-controls="banco'.$key.'" role="tab" data-toggle="tab">Banco '.($key+1).'</a></li>';
                            $bancos .= '<div role="tabpanel" class="tab-pane '.($key == 0 ? 'active' : '').'" id="banco'.$key.'"><div class="listview icon-list">
                                        <div class="media clearfix">
                                            <label class="col-md-1 control-label">Banco: </label>
                                            <div class="col-md-9">'.$cada .'</div>
                                        </div>
                                        <div class="media clearfix">
                                            <label class="col-md-1 control-label">Num. Banco: </label>
                                            <div class="col-md-9">'.explode('|sep|',$res->numerobanco_pes )[$key].'</div>
                                        </div>
                                        <div class="media clearfix">
                                            <label class="col-md-1 control-label">Agência: </label>
                                            <div class="col-md-9">'.explode('|sep|',$res->agencia_pes )[$key].'</div>
                                        </div>
                                        <div class="media clearfix">
                                            <label class="col-md-1 control-label">Conta: </label>
                                            <div class="col-md-9">'.explode('|sep|',$res->conta_pes )[$key].'</div>
                                        </div>
                                        <div class="media clearfix">
                                            <label class="col-md-1 control-label">Nome Titular: </label>
                                            <div class="col-md-9">'.explode('|sep|',$res->nometitular_pes )[$key].'</div>
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
<!--                            <div class="col-md-9">--><?php //echo $res->banco_pes ?><!--</div>-->
<!--                        </div>-->
<!--                        <div class="media clearfix">-->
<!--                            <label class="col-md-1 control-label">Num. Banco: </label>-->
<!--                            <div class="col-md-9">--><?php //echo $res->numerobanco_pes ?><!--</div>-->
<!--                        </div>-->
<!--                        <div class="media clearfix">-->
<!--                            <label class="col-md-1 control-label">Agência: </label>-->
<!--                            <div class="col-md-9">--><?php //echo $res->agencia_pes ?><!--</div>-->
<!--                        </div>-->
<!--                        <div class="media clearfix">-->
<!--                            <label class="col-md-1 control-label">Conta: </label>-->
<!--                            <div class="col-md-9">--><?php //echo $res->conta_pes ?><!--</div>-->
<!--                        </div>-->
<!--                        <div class="media clearfix">-->
<!--                            <label class="col-md-1 control-label">Nome Titular: </label>-->
<!--                            <div class="col-md-9">--><?php //echo $res->nometitular_pes ?><!--</div>-->
<!--                        </div>-->
<!--                    </div>-->


                </div>

            </div>
<!--        </div>-->


        <div class="subscricoes cada-perfil">

            <h4 class="page-title">Subscrição</h4>
            <div class="block-area">

                <table class="tile table table-bordered table-striped tablesorter table-responsive"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Código" data-placeholder="Filtrar Código">Código</th>
                        <th data-name="Data" data-placeholder="Filtrar Data">Data Subscrição</th>
                        <th data-name="Cliente" data-placeholder="Filtrar Cliente">Cliente</th>
                        <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                        <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Valor Investido</th>
                        <th data-name="Rendimento" data-placeholder="Filtrar Rendimento">Rendimento</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);
                    $saldoTotalCliente = 0;

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

            <h4 class="page-title">Subscrição</h4>
            <div class="block-area">
                <table class="tile table table-bordered table-striped tablesorter table-responsive tabela-especial"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Código" data-placeholder="Filtrar Código">Código Subcrição</th>
                        <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                        <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Saldo Atual</th>
                        <th data-name="Ação" data-sorter="false"
                            class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);
                    $saldoTotalCliente = 0;

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


                <div class="accordion tile">
                    <div class="panel-group block" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle active" data-toggle="collapse" data-parent="#accordion"
                                       href="#collapseOne">
                                        Collapsible Group Item #1
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                    richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                    brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt
                                    aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                    Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente
                                    ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                    farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them
                                    accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                       href="#collapseTwo">
                                        Collapsible Group Item #2
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                    richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                    brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt
                                    aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                    Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente
                                    ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                    farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them
                                    accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                       href="#collapseThree">
                                        Collapsible Group Item #3
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                    richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                    brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt
                                    aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                    Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente
                                    ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                    farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them
                                    accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="resgates cada-perfil">
            <h4 class="page-title">
                <div class="pull-left">
                    Resgates
                </div>
            </h4>

            <div class="block-area">
                <table class="tile table table-bordered table-striped tablesorter table-responsive"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Data" data-placeholder="Filtrar Data">Código Subscrição</th>
                        <th data-name="Data" data-placeholder="Filtrar Data">Cliente</th>
                        <th data-name="Data" data-placeholder="Filtrar Data">Data</th>
                        <th data-name="Valor" data-placeholder="Filtrar Valor">Valor</th>
                        <th data-name="Ação" data-sorter="false"
                            class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $resgates = $this->mod->buscaResgateCliente($this->session->aluno['codigo']);
                    $saldoTotalCliente = 0;

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

    <div class="modal fade" id="modal-extrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
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

    <?php


    } elseif ($operacao == 'indicadores') {
        //--------------------------------- Home ---------------------------------------------
        $id = $this->session->aluno['codigo'];
        //print_r($this->session->aluno); exit;
        if ($id == NULL)
            redirect('acesso/home');


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

                    $subscricoes = $this->mod->buscaIndicadores();
                    if(!empty($subscricoes))
                    {
                        foreach ($subscricoes as $key => $cada) {



                            echo "<tr>
                                <td>" . Mes(splitData($cada->mes_ind)['month'])." / ". splitData($cada->mes_ind)['year'] . "</td>
                                <td>" . "<a class='btn  btn-action-table tooltips' data-toggle='tootilp' data-placement='top' title='Visualizar' href='javascript:visualizarIndicador(".$cada->codigo_ind.", \"".$cada->upload_ind."\", \"Indicador_". Mes(splitData($cada->mes_ind)['month'])."-". splitData($cada->mes_ind)['year'].".pdf\")'><i class='fa fa-search'></i></a>" . "</td>
                             </tr>";

                        }
                    }
                    else
                    {
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
                        <button type="button" class="btn btn-danger" id="btnDownload">Download PDF</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>



        <?php


    } elseif ($operacao == 'subscricao') {
        //--------------------------------- Home ---------------------------------------------
        $id = $this->session->aluno['codigo'];
        //print_r($this->session->aluno); exit;
        if ($id == NULL)
            redirect('acesso/home');

        $result = $this->mod->get_byid($id);
        $res = $result[0];
        $resultemail = $this->mod->buscarEmails($res->codigo_pes);
        $resulttel = $this->mod->buscarTelefones($res->codigo_pes);
        $cidades = $this->mod->buscarCidadesbyid($res->codigo_est);
        $ddlCidades = array("" => "Selecione");
        foreach ($cidades as $key => $cada) {
            $ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
        }//echo $ddlCidades[$res->codigo_cid]; exit;
        //print_r($ddlCidades); exit;
        ?>


        <div class="subscricoes">

            <h4 class="page-title">Subscrições</h4>
            <div class="block-area">
                <table class="tile table table-bordered table-striped tablesorter table-responsive"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Data" data-placeholder="Filtrar Data">Data</th>
                        <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                        <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Investimento (R$)</th>
                        <th data-name="Rendimento" data-placeholder="Filtrar Rendimento">Rendimento</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);
                    $saldoTotalCliente = 0;
                    $totalSubscrito = 0;
                    if(!empty($subscricoes))
                    {
                        foreach ($subscricoes as $key => $cada) {
                            $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;
                            echo "<tr>
                                <td>" . inverterdata($cada->data_subs) . "</td>
                                <td>" . formata_cupom($cada->taxa_subs) . "</td>
                                <td>" . formata_moeda($cada->valor_subs) . "</td>
                                <td>" . ($cada->rendimento_subs == 0 ? "Resgatar Mensalmente" : "Reinvestir") . "</td>
                             </tr>";

                            $saldoTotalCliente += $totalrendimento;
                            $totalSubscrito += $cada->valor_subs;
                        }
                    }
                    else
                    {
                        echo "<tr>
                                <td colspan='4'>Nenhuma Subcrição Encontrada!</td>
                             </tr>";
                    }


                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2">Total Subscrito</td>
                        <td> R$ <?php echo formata_moeda($totalSubscrito); ?></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
                <!--<div class="pager"> <span class="left">
                                Mostrar:
                                <a href="#" class="current">30</a>
                                <a href="#">50</a>
                                <a href="#">100</a>
                            </span>
                    <span class="center">
                                Total de Comissão: '.formata_moeda($totalComissao).'
                            </span>
                    <span class="right">
                                    <span class="prev">
                                        <img src="'.site_url('as!sets/tablesorter/css/images/prev.png').'" /> Ant&nbsp;
                                    </span>
                             <span class="pagecount"></span>
                             &nbsp;<span class="next">Prox
                                        <img src="'.site_url('as!sets/tablesorter/css/images/next.png').'" />
                                    </span>
                            </span>
                </div>-->
            </div>

        </div>

        <div class="modal fade" id="modal-extrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Extrato</h4>
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

        <?php


    } elseif ($operacao == 'mensagens') {
        //--------------------------------- Home ---------------------------------------------
        $id = $this->session->aluno['codigo'];
        //print_r($this->session->aluno); exit;
        ?>


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
                    $total = 0;
                    $mensagens = $this->mod->buscaMensagens($this->session->aluno['codigo']);
                    $saldoTotalCliente = 0;
                    $totalSubscrito = 0;
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
                                        <img src="<?php echo CLOUDFRONT.'tablesorter/css/images/prev.png'?>" /> Ant&nbsp;
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

        <?php


    } elseif ($operacao == 'agendas') {
        //--------------------------------- Home ---------------------------------------------
        $id = $this->session->aluno['codigo'];
        //print_r($this->session->aluno); exit;
        ?>

        <div class="subscricoes">

            <h4 class="page-title clearfix">
               <div class="pull-left m-t-10"> Agendas </div>
                <div class="pull-right">
                    <a href="<?=base_url('acesso/addAgenda')?>" class="btn" name="btnAddAgenda" title="Adicionar Agenda"> <i class="fa fa-plus"></i> Adicionar Agenda</a>
                    <?php  //echo anchor(base_url('acesso/addAgenda'),'Adicionar Agenda', array("content" => "<i class='fa fa-plus'></i> Adicionar Agenda", 'name' => "btnAddAgenda", 'class' => "btn", 'title' => 'Adicionar Agenda'))?>
                </div>
            </h4>

            <div class="block-area">

                <table class="tile table table-bordered table-striped tablesorter table-responsive"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Data" data-placeholder="Filtrar Data">Data</th>
                        <th data-name="Descrição" data-placeholder="Filtrar Descrição">Descrição</th>
                        <th data-name="Descrição" data-placeholder="Filtrar Descrição">Status</th>
                        <th data-name="Ação" data-placeholder="Filtrar Ação">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    $mensagens = $this->mod->buscaAgendas($this->session->aluno['codigo']);
                    $saldoTotalCliente = 0;
                    $totalSubscrito = 0;
                    if(!empty($mensagens))
                    {
                        foreach ($mensagens as $key => $cada) {
                            echo "<tr>
                                <td>" . Mysql_to_Data($cada->data_age) . "</td>
                                <td>" . ($cada->desc_age) . "</td>
                                <td>" . (empty($cada->concluido_age) ? "Pendente" : "Confirmado<br/> em: ".Mysql_to_Data($cada->concluido_age)) . "</td>
                                <td>" .
                                        (empty($cada->concluido_age) ? anchor("acesso/alterarAgenda/".base64_encode($cada->codigo_age), '<i class="fa fa-edit"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Editar'))." ".
                                        form_button( '', '<i class="fa fa-check"></i>', array('class'=>"btn btn-default btn-action-table btn-acao-tabela", "title"=>'Confirmar Tarefa', 'onclick'=>'confirmaConcluido('.$cada->codigo_age.')')) : "").
                                        form_button(array('name'=>'btnExcluir', 'content'=>'<i class="fa fa-trash-o"></i>', 'class'=>"btn btn-default btn-action-table btn-acao-tabela", 'title'=>'Excluir', 'onClick'=>'inativar('.$cada->codigo_age.')')).
                                "</td>
                             </tr>";

                            $total++;
                        }
                    }
                    else
                    {
                        echo "<tr>
                                <td colspan='4'>Nenhuma Agenda encontrada!</td>
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
                            <label class="col-md-1 m-t-5 control-label text-black">Assunto</label>
                            <div class="col-md-10">
                                <p id="assunto_message" class="text-black"></p>
                            </div>
                        </div>
                        <div class="form-group clearfix m-b-20">
                            <label class="col-md-1 m-t-5 control-label text-black">Mensagem</label>
                            <div class="col-md-10">
                                <p id="conteudo_message" class="text-black"></p>
                            </div>
                        </div>
                        <div class="form-group clearfix m-b-20">
                            <h3 class="col-md-12 m-t-5 control-label text-black">Marcar como Lido</h3>

                        </div>
                        <div class="form-group clearfix m-b-20">
                            <label class="col-md-1 m-t-5 control-label text-black">Assinatura Digital</label>
                            <div class="col-md-5">
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

        <?php


    } elseif ($operacao == 'resgate') {
        //--------------------------------- Home ---------------------------------------------
        $id = $this->session->aluno['codigo'];
        //print_r($this->session->aluno); exit;
        if ($id == NULL)
            redirect('acesso/home');

        $result = $this->mod->get_byid($id);
        $res = $result[0];
        $resultemail = $this->mod->buscarEmails($res->codigo_pes);
        $resulttel = $this->mod->buscarTelefones($res->codigo_pes);
        $cidades = $this->mod->buscarCidadesbyid($res->codigo_est);
        $ddlCidades = array("" => "Selecione");
        foreach ($cidades as $key => $cada) {
            $ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
        }//echo $ddlCidades[$res->codigo_cid]; exit;
        //print_r($ddlCidades); exit;
    //form_button(array("content" => "<i class='fa fa-money'></i>", 'name' => "btnResgate", 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'\',\'' . formata_moeda($totalAll) . '\')'))
    $subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);

    $saldoTotalCliente = 0;
    $ind = 0;
    $arrayRendimento = array();
    $arraySaldo = array();
    $htmlsub = "";


    if(!empty($subscricoes))
    {
        $totalAll = 0;
        $totalAllBruto = 0;
        $totalSubscricao = 0;
        $totalRendimento= 0;
        $totalResgates= 0;
        $totalAllRendimentoBruto = 0;
        foreach ($subscricoes as $key => $cada) {
            $rendimentoscalculabruto = $this->mod->buscarRendimentoMes($cada->codigo_subs, date("Y-m-01"), date("Y-m-31"));


            $rendimentobrutonovo = 0;
            $totalLiq = 0;
            $totalBruto = 0;





            if ($cada->datainiciocalculo == $cada->data_subs)
            {
                $rendimentoscalculabruto = $this->mod->buscarRendimentoNaoReinveste($cada->codigo_subs, $cada->datainiciocalculo);
                $resgatesSolicitados = $this->mod->buscarResgatesSolicitadosBruto($cada->codigo_subs, date("Y-m-01"), date("Y-m-31"));

                $totalInicio = $cada->valor_subs;
                $totalInicioBruto = $totalInicio;
                $cont = 0;


                foreach ($rendimentoscalculabruto as $keybr => $cadabr)
                {
                    if(!empty($resgatesSolicitados) && $resgatesSolicitados[0]->dataresgatado_resg == $cadabr->data_rend)
                    {
                        $cadaresg = array_shift($resgatesSolicitados);
                        $anttotalinicio = $totalInicio;
                        $anttotaliniciobruto = $totalInicioBruto;

                        $totalInicio -= $cadaresg->valor_resg;

                        $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;

                    }


                    $totalInicio += $cadabr->valor_rend;
                    if($cadabr->ultimodia <= 180)
                    {
                        $totalInicioBruto += $cadabr->valor_rend / 0.775;
                    }
                    elseif($cadabr->ultimodia >= 181 && $cadabr->ultimodia <= 360)
                    {
                        $totalInicioBruto += $cadabr->valor_rend / 0.8;
                    }
                    elseif($cadabr->ultimodia >= 361 && $cadabr->ultimodia <= 720)
                    {
                        $totalInicioBruto += $cadabr->valor_rend / 0.825;
                    }
                    elseif($cadabr->ultimodia >= 721)
                    {
                        $totalInicioBruto += $cadabr->valor_rend / 0.85;
                    }

                }


                if(!empty($resgatesSolicitados) && strtotime($resgatesSolicitados[0]->dataresgatado_resg) <= strtotime(date('Y-m-d')))
                {
                    $cadaresg = array_shift($resgatesSolicitados);
                    $anttotalinicio = $totalInicio;
                    $anttotaliniciobruto = $totalInicioBruto;

                    $totalInicio -= $cadaresg->valor_resg;

                    $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;



                }

                if($totalInicio >= -0.01 && $totalInicio <= 0.01)
                {
                    $totalInicioBruto = 0;
                }


                $totalrendimento = $totalInicio;
                $totalrendimentoBruto = $totalInicioBruto;



            }
            else
            {
                if($cada->ultimodia <= 180)
                {
                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.775;
                }
                elseif($cada->ultimodia >= 181 && $cada->ultimodia <= 360)
                {
                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.8;
                }
                elseif($cada->ultimodia >= 361 && $cada->ultimodia <= 720)
                {
                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.825;
                }
                elseif($cada->ultimodia >= 721)
                {
                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.85;
                }

                $diferencamesfixbruto = $rendimentobrutonovo - $cada->rendimentomesatual;


                $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;

                if($totalrendimento >= -0.01 && $totalrendimento <= 0.01)
                {
                    $totalrendimentoBruto = 0;
                }
                else
                    $totalrendimentoBruto = $totalrendimento + $diferencamesfixbruto    ;
            }

            $dtultimo = splitData($cada->ultimo);



            if($dtultimo['month'] == date('m') && $dtultimo['year'] == date("Y"))
            {
                $totalAll += $totalrendimento;
                $totalAllBruto += $totalrendimentoBruto;
            }
            else
            {
                $totalrendimento = 0; $totalrendimentoBruto = 0;
            }


            $totalSubscricao += $cada->valor_subs;
            $totalRendimento += $cada->rendimento;
            $totalResgates += $cada->resgate;
            $saldoTotalCliente += $totalrendimento;
            $totalAllRendimentoBruto += $cada->rendimentobruto;



        }
    }
    ?>



        <div class="resgates ">
            <h4 class="page-title clearfix">
              <div class="pull-left m-t-10"> Resgates </div>

                <div class="pull-right">
                    <?php  echo form_button(array("content" => "<i class='fa fa-money'></i> Solicitar Resgate", 'name' => "btnResgate", 'class' => "btn", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'\',\'' . formata_moeda($totalAll) . '\')'))?>
                </div>
            </h4>
            <div class="block-area">

                <table class="tile table table-bordered table-striped tablesorter table-responsive"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Data" data-placeholder="Filtrar Data">Data da Solicitação</th>
                        <th data-name="Valor" data-placeholder="Filtrar Valor">Valor (R$)</th>
                        <th data-name="Data" data-placeholder="Filtrar Data">Data do Resgate</th>
                        <th data-name="Data" data-placeholder="Filtrar Data">Origem</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $resgates = $this->mod->buscaResgateCliente($this->session->aluno['codigo']);
                    $saldoTotalCliente = 0;
                    $saldoCupom = 0;
                    $saldoSolicitado = 0;

                    if (!empty($resgates)) {
                        foreach ($resgates as $key => $cada) {
                            echo "<tr>
								<td>" . inverterdata($cada->data_resg) . "</td>
								<td>" . formata_moeda($cada->valor_resg) . "</td>
								<td>" . (!empty($cada->dataresgatado_resg) ? inverterdata($cada->dataresgatado_resg) : "-") . "</td>
								<td>" . ($cada->tipo_resg == 0 ? "Cupom" : "Resgate") . "</td>
							 </tr>";
                            if(!empty($cada->dataresgatado_resg))
                            {
                                $saldoTotalCliente += $cada->valor_resg;
                                if($cada->tipo_resg == 0)
                                {
                                    $saldoCupom += $cada->valor_resg;
                                }
                                else
                                {
                                    $saldoSolicitado += $cada->valor_resg;
                                }
                            }

                        }
                    } else {
                        echo "<tr>
								<td colspan='4'>" . "Não há valores resgatados" . "</td>
							 </tr>";
                    }


                    ?>
                    </tbody>
                    <tfoot>
                   <tr>
                        <td colspan="3">Total Cupom</td>
                        <td> R$ <?php echo formata_moeda($saldoCupom); ?></td>
                    </tr><tr>
                        <td colspan="3">Total Solicitado</td>
                        <td> R$ <?php echo formata_moeda($saldoSolicitado); ?></td>
                    </tr> <tr>
                        <td colspan="3">Total Resgatado</td>
                        <td> R$ <?php echo formata_moeda($saldoTotalCliente); ?></td>
                    </tr>
                    </tfoot>
                </table>


            </div>

        </div>

        <div class="modal fade" id="modal-extrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Extrato</h4>
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

        <?php


    }
    elseif ($operacao == 'saldo') {
    //--------------------------------- Home ---------------------------------------------
    $id = $this->session->aluno['codigo'];
    //print_r($this->session->aluno); exit;
    if ($id == NULL)
        redirect('acesso/home');

    $result = $this->mod->get_byid($id);
    $res = $result[0];
    $resultemail = $this->mod->buscarEmails($res->codigo_pes);
    $resulttel = $this->mod->buscarTelefones($res->codigo_pes);
    $cidades = $this->mod->buscarCidadesbyid($res->codigo_est);
    $ddlCidades = array("" => "Selecione");
    foreach ($cidades as $key => $cada) {
        $ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
    }//echo $ddlCidades[$res->codigo_cid]; exit;
    //print_r($ddlCidades); exit;
    ?>


    <div class="saldo">

        <h4 class="page-title">Saldos</h4>
        <div class="block-area">
            <!--<table class="tile table table-bordered table-striped tablesorter table-responsive tabela-especial"
                       id="tablesorter">
                    <thead>
                    <tr>
                        <th data-name="Código" data-placeholder="Filtrar Código">Código Investimento</th>
                        <th data-name="Taxa" data-placeholder="Filtrar Taxa">Cupom (%)</th>
                        <th data-name="Valor Inicial" data-placeholder="Filtrar Valor Inicial">Saldo Atual</th>
                        <th data-name="Ação" data-sorter="false"
                            class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">A&ccedil;&atilde;o
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
			/*
            $subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);
            $saldoTotalCliente = 0;

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
            } */

            ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3">Saldo Total</td>
                        <td><?php // echo formata_moeda($saldoTotalCliente); ?></td>
                    </tr>
                    </tfoot>
                </table>-->


            <div class="accordion tile">
                <div class="panel-group block" id="accordion">
                    <?php
                    $subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);

                    $saldoTotalCliente = 0;
                    $ind = 0;
                    $arrayRendimento = array();
                    $arraySaldo = array();
                    $htmlsub = "";


                    if(!empty($subscricoes))
                    {
                        $totalAll = 0;
                        $totalAllBruto = 0;
                        $totalSubscricao = 0;
                        $totalRendimento= 0;
                        $totalResgates= 0;
                        $totalCupom= 0;
                        $totalSolicitado= 0;
                        $totalAllRendimentoBruto = 0;
                        $totalAllRendimentoLiquido = 0;

                        foreach ($subscricoes as $key => $cada) {
                            //print_r($cada); exit;
                            $dadosGraph = $controller->dadosGraficos($cada->codigo_subs);
                            $rendimentoscalculabruto = $this->mod->buscarRendimentoMes($cada->codigo_subs, date("Y-m-01"), date("Y-m-31"));


                            $rendimentobrutonovo = 0;
                            $totalLiq = 0;
                            $totalBruto = 0;



                            $htmlsub .= '<div class="panel panel-default">
                                            <div class="panel-heading panel-personalizado">
                                                <h3 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapse'.$key.'">
                                                        '.($key+1)."ª Subscrição".' - '.inverterdata($cada->data_subs).'
                                                    </a>
                                                </h3>
                                            </div>
                                            <div id="collapse'.$key.'" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <div>
                                                        <table
                                                            class="tile table table-bordered table-striped tablesorter table-responsive tabela-especial"
                                                            id="tablesorter">
                                                            <thead>
                                                            <tr>
                                                                
                                                                <th data-name="Status" data-placeholder="Filtrar Status">
                                                                    Status
                                                                </th>
                                                                <th data-name="Código" data-placeholder="Filtrar Código">Investimento (R$)
                                                                </th>
                                                                <th data-name="Taxa" data-placeholder="Filtrar Taxa">Remuneração Mensal Líquida (%)</th>
                                                                <th data-name="Saldo Atual" data-placeholder="Filtrar Saldo Atual">
                                                                    Saldo Bruto (R$)
                                                                </th>
                                                                <th data-name="Saldo Atual" data-placeholder="Filtrar Saldo Atual">
                                                                    Saldo Líquido (R$)
                                                                </th>
                                                               
                                                                <th data-name="Ação" data-sorter="false"
                                                                    class="columnSelector-false filter-false sorter-false sorter-false sumir-impressao">
                                                                    A&ccedil;&atilde;o
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>';

                                                            if ($cada->datainiciocalculo == $cada->data_subs)
                                                            {

                                                                $rendimentoscalculabruto = $this->mod->buscarRendimentoNaoReinveste($cada->codigo_subs, $cada->datainiciocalculo);
                                                                $resgatesSolicitados = $this->mod->buscarResgatesSolicitadosBruto($cada->codigo_subs, date("Y-m-01"), date("Y-m-31"));

                                                                $totalInicio = $cada->valor_subs;
                                                                $totalInicioBruto = $totalInicio;
                                                                $cont = 0;

                                                                foreach ($rendimentoscalculabruto as $keybr => $cadabr)
                                                                {
                                                                    if(!empty($resgatesSolicitados) && $resgatesSolicitados[0]->dataresgatado_resg == $cadabr->data_rend)
                                                                    {
                                                                        $cadaresg = array_shift($resgatesSolicitados);
                                                                        $anttotalinicio = $totalInicio;
                                                                        $anttotaliniciobruto = $totalInicioBruto;


                                                                        $totalInicio -= $cadaresg->valor_resg;

                                                                        $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;

                                                                        //$totalAllRendimentoBruto += $totalInicioBruto;

                                                                        //echo $totalInicio." - ".$totalInicioBruto; exit;


                                                                    }


                                                                    $totalInicio += $cadabr->valor_rend;
                                                                    $totalAllRendimentoLiquido += $cadabr->valor_rend;
                                                                    if($cadabr->ultimodia <= 180)
                                                                    {
                                                                        $totalInicioBruto += $cadabr->valor_rend / 0.775;
                                                                        $totalAllRendimentoBruto += $cadabr->valor_rend / 0.775;
                                                                    }
                                                                    elseif($cadabr->ultimodia >= 181 && $cadabr->ultimodia <= 360)
                                                                    {
                                                                        $totalInicioBruto += $cadabr->valor_rend / 0.8;
                                                                        $totalAllRendimentoBruto += $cadabr->valor_rend / 0.8;
                                                                    }
                                                                    elseif($cadabr->ultimodia >= 361 && $cadabr->ultimodia <= 720)
                                                                    {
                                                                        $totalInicioBruto += $cadabr->valor_rend / 0.825;
                                                                        $totalAllRendimentoBruto += $cadabr->valor_rend / 0.825;
                                                                    }
                                                                    elseif($cadabr->ultimodia >= 721)
                                                                    {
                                                                        $totalInicioBruto += $cadabr->valor_rend / 0.85;
                                                                        $totalAllRendimentoBruto += $cadabr->valor_rend / 0.85;
                                                                    }

                                                                    //echo $totalAllRendimentoBruto."<br>";

                                                                }
                                                                if(!empty($resgatesSolicitados) && strtotime($resgatesSolicitados[0]->dataresgatado_resg) <= strtotime(date('Y-m-d')))// && $resgatesSolicitados[0]->dataresgatado_resg == date('Y-m-d')
                                                                {
                                                                    $cadaresg = array_shift($resgatesSolicitados);
                                                                    $anttotalinicio = $totalInicio;
                                                                    $anttotaliniciobruto = $totalInicioBruto;

                                                                    $totalInicio -= $cadaresg->valor_resg;

                                                                    $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;

                                                                    //$totalAllRendimentoBruto += $totalInicioBruto;

                                                                }

                                                                if($totalInicio >= -0.01 && $totalInicio <= 0.01)
                                                                {
                                                                    $totalInicioBruto = 0;
                                                                }


                                                                $totalrendimento = $totalInicio;
                                                                $totalrendimentoBruto = $totalInicioBruto;



                                                            }
                                                            else
                                                            {
                                                                if($cada->ultimodia <= 180)
                                                                {
                                                                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.775;
                                                                    $rendimentobrutonovoaux = $cada->rendimento/ 0.775;
                                                                    //$totalAllRendimentoBruto += $cada->rendimentomesatual / 0.775;

                                                                }
                                                                elseif($cada->ultimodia >= 181 && $cada->ultimodia <= 360)
                                                                {
                                                                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.8;
                                                                    $rendimentobrutonovoaux = $cada->rendimento/ 0.8;
                                                                   // $totalAllRendimentoBruto += $cada->rendimentomesatual / 0.8;

                                                                }
                                                                elseif($cada->ultimodia >= 361 && $cada->ultimodia <= 720)
                                                                {
                                                                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.825;
                                                                    $rendimentobrutonovoaux = $cada->rendimento/ 0.825;
                                                                    //$totalAllRendimentoBruto += $cada->rendimentomesatual / 0.825;

                                                                }
                                                                elseif($cada->ultimodia >= 721)
                                                                {
                                                                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.85;
                                                                    $rendimentobrutonovoaux = $cada->rendimento/ 0.85;
                                                                    //$totalAllRendimentoBruto += $cada->rendimentomesatual / 0.85;

                                                                }

                                                                $diferencamesfixbruto = $rendimentobrutonovo - $cada->rendimentomesatual;


                                                                $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;

                                                                //echo $rendimentobrutonovo." - ".$cada->rendimentomesatual."<br/>";
                                                                $totalAllRendimentoLiquido += $cada->rendimento;
                                                                $totalAllRendimentoBruto += $rendimentobrutonovoaux;

                                                                if($totalrendimento >= -0.01 && $totalrendimento <= 0.01)
                                                                {
                                                                    $totalrendimentoBruto = 0;
                                                                }
                                                                else
                                                                {
                                                                    $totalrendimentoBruto = $totalrendimento + $diferencamesfixbruto    ;
                                                                }
                                                            }

                                                            $dtultimo = splitData($cada->ultimo);



                                                            if($dtultimo['month'] == date('m') && $dtultimo['year'] == date("Y"))
                                                            {
                                                                $totalAll += $totalrendimento;
                                                                $totalAllBruto += $totalrendimentoBruto;
                                                            }
                                                            else
                                                            {
                                                                $totalrendimento = 0; $totalrendimentoBruto = 0;
                                                            }

                                                            // $totalrendimento = $cada->total_liquito;
															// $totalrendimentoBruto = $cada->total_bruto;
															// $totalAll += $totalrendimento;
															// $totalAllBruto += $totalrendimentoBruto;
															// $totalAllRendimentoLiquido += $cada->total_rend_liquido;
															// $totalAllRendimentoBruto = $cada->total_rend_bruto;

                                                            $htmlsub .= "<tr>
                                                                <td>" . (!empty($cada->contabiliza_subs) ? "Inativo" : "Ativo") . "</td>    
                                                                <td>" . formata_moeda($cada->valor_subs) . "</td>
                                                                <td>" . formata_cupom($cada->taxa_subs) . " </td>
                                                                <td>" . formata_moeda($totalrendimentoBruto) . "</td>
                                                                <td>" . formata_moeda($totalrendimento) . "</td>
                                                                <td>" . form_button(array("content" => "<i class='fa fa-file-text'></i>", 'name' => "btnExtrato", 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Extrato', 'onClick' => 'visualizarExtrato(\'' . base64_encode($cada->codigo_subs) . '\')'))
                                                                //. " " . form_button(array("content" => "<i class='fa fa-dollar'></i>", 'name' => "btnSimulaSaldo", 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Simulação de Saldo', 'onClick' => 'simularSaldo(\'' . base64_encode($cada->codigo_subs) . '\', \'' . formata_cupom($cada->taxa_subs) . '\', \'' . formata_moeda($totalrendimento) . '\')'))
                                                                //. " " . form_button(array("content" => "<i class='fa fa-money'></i>", 'name' => "btnResgate", 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'' . base64_encode($cada->codigo_subs) . '\', \'' . formata_moeda($totalrendimento) . '\')'))
                                                                . "</td>";

                                                            $totalSubscricao += $cada->valor_subs;
                                                            $totalRendimento += $cada->rendimento;
                                                            $totalResgates += $cada->resgate;
                                                            $totalSolicitado += $cada->resgateSolicitado;
                                                            $totalCupom += $cada->resgateCupom;
                                                            $saldoTotalCliente += $totalrendimento;
                                                            //$totalAllRendimentoBruto += $cada->rendimentobruto;



                            $htmlsub .= '</tbody>
                                                        </table>
                                                    </div>
        
                                                    ';
                            /*
                               <div class="tile">
                                                        <h2 class="tile-title">Rendimentos <span class="badge tooltips" data-toggle="tooltip" data-placement="right" title="Histórico do rendimento líquido mensal da subscrição em questão">?</span></h2>

                                                        <div class="p-10">
                                                            <div id="line-chart-rendimento-'.$cada->codigo_subs.'"
                                                                 class="main-chart line-chart" style="height: 250px"
                                                                 data-dados="'.base64_encode($dadosGraph['rendimento']).'"></div>
                                                        </div>
                                                    </div>

                                                    <div class="tile">
                                                        <h2 class="tile-title">Saldo Líquido <span class="badge tooltips" data-toggle="tooltip" data-placement="right" title="Histórico do saldo líquido mensal da subscrição em questão">?</span></h2>

                                                        <div class="p-10">
                                                            <div id="line-chart-saldo-'.$cada->codigo_subs.'"
                                                                 class="main-chart line-chart" style="height: 250px"
                                                                 data-dados="'.base64_encode($dadosGraph['saldo']).'"></div>
                                                        </div>
                                                    </div>
                             */

                                                            $dadosGraph['rendimentoarray'] = array_reverse($dadosGraph['rendimentoarray']);
                                                            foreach($dadosGraph['rendimentoarray'] as $keyrend => $cadarend)
                                                            {
                                                                $flag = 0;
                                                                foreach ($arrayRendimento as $keyarray => $cadaarray)
                                                                {
                                                                    if($cadaarray[0] == $cadarend[0])
                                                                    {
                                                                        $arrayRendimento[$keyarray][1] += $cadarend[1];
                                                                        $flag = 1;
                                                                    }
                                                                }
                                                                if(!$flag)
                                                                {
                                                                    array_unshift($arrayRendimento, $cadarend);
                                                                }
                                                            }


                                                            $dadosGraph['saldoarray'] = array_reverse($dadosGraph['saldoarray']);
                                                            foreach($dadosGraph['saldoarray'] as $keyrend => $cadarend)
                                                            {
                                                                $flag = 0;
                                                                foreach ($arraySaldo as $keyarray => $cadaarray)
                                                                {
                                                                    if($cadaarray[0] == $cadarend[0])
                                                                    {
                                                                        $arraySaldo[$keyarray][1] += $cadarend[1];

                                                                        $flag = 1;
                                                                    }
                                                                }
                                                                if(!$flag)
                                                                {
                                                                    array_unshift($arraySaldo, $cadarend);
                                                                }
                                                            }




                                        $htmlsub .= '</div>
                                            </div>
                                        </div>';



                                    $ind++;
                            }?>
                        <?php
                                $ordenarendimento = array();
                                $ordenasaldo = array();
                                $graphTotalRendimento = array();
                                $graphTotalSaldo = array();
                                $graphDatas = array();
                                $graphDatasSaldo = array();

//                                print_r($arraySaldo); exit;

                                foreach ($arrayRendimento as $keyarray => $cadaarray)
                                {
                                    $graphDatas[] = $cadaarray[0];
                                    $graphDatasSaldo[] = $cadaarray[0];
                                    $ordenarendimento[] = $cadaarray[1];
                                    $ordenasaldo[] = $arraySaldo[$keyarray][1];
                                }
                                 //   print_r($graphDatas); echo "<br/>"; print_r($ordenarendimento); echo "<br/>"; print_r($ordenasaldo);  echo "<br/>";
                                array_multisort($graphDatas, $ordenarendimento);
                                array_multisort($graphDatasSaldo, $ordenasaldo);

                                foreach ($graphDatas as $keydata => $cadadata)
                                {
                                    $graphTotalRendimento[] = array($cadadata, $ordenarendimento[$keydata]);
                                    $graphTotalSaldo[] = array($cadadata, $ordenasaldo[$keydata]);
                                }

                               // echo "<pre>"; print_r($graphTotalRendimento); exit;

                        ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading panel-personalizado">
                                            <h3 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapseTotal">
                                                    <?php echo "Total"; ?>
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="collapseTotal" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div>
                                                    <table
                                                        class="tile table table-bordered table-striped tablesorter table-responsive tabela-especial"
                                                        id="tablesorter">
                                                        <thead>
                                                        <tr>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Investimento (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Resgates (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Cupom Recebido (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Lucro Bruto (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Saldo Bruto (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Lucro Líquido (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Saldo Líquido (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Ação</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        echo "<tr>
                                                                    <td>" . formata_moeda($totalSubscricao) . "</td>
                                                                    <td>" . formata_moeda($totalSolicitado) . "</td>
                                                                    <td>" . formata_moeda($totalCupom) . "</td>
                                                                    <td>" . formata_moeda($totalAllRendimentoBruto) . "</td>
                                                                    <td>" . formata_moeda($totalAllBruto) . "</td>
                                                                    <td>" . formata_moeda($totalAllRendimentoLiquido) . "</td>
                                                                    <td>" . formata_moeda($totalAll) . "</td>
                                                                    <td>" . form_button(array("content" => "<i class='fa fa-file-text'></i>", 'data-toggle'=> 'tooltip', 'data-placement'=> 'top', 'title'=> 'Extrato', 'name' => "btnExtrato", 'class' => "btn tooltips btn-action-table btn-acao-tabela", 'onClick' => 'visualizarExtratoTotal(\'' . base64_encode($this->session->userdata('aluno')['codigo']) . '\')')).
                                                                            form_button(array("content" => "<i class='fa fa-undo'></i> ", 'data-toggle'=> 'tooltip', 'data-placement'=> 'top', 'name' => "btnResgate", 'class' => "btn tooltips btn-action-table btn-acao-tabela", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'\',\'' . formata_moeda($totalAll) . '\')')) .
                                                                            form_button(array("content" => "<i class='fa fa-dollar'></i> ", 'data-toggle'=> 'tooltip', 'data-placement'=> 'top', 'name' => "btnSimulaSaldo", 'class' => "btn tooltips btn-action-table btn-acao-tabela", 'title' => 'Simulação de Saldo', 'onClick' => 'simularSaldo(\'' . base64_encode($cada->codigo_subs) . '\', \'' . formata_cupom($cada->taxa_subs) . '\', \'' . formata_moeda($totalAll) . '\')')).

                                                            "</td>
                                                              </tr>";

                                                        ?>

                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="tile">
                                                    <h2 class="tile-title p-l-0">Rendimentos <span class="badge badge-blue m-l-5 tooltips" data-toggle="tooltip" data-placement="right" title="Rendimentos acumulados ao mês de todas as subscrições ativas">?</span></h2>

                                                    <div class="p-10">
                                                        <div id="line-chart-rendimento-total"
                                                             class="main-chart line-chart" style="height: 250px;"
                                                             data-dados="<?php echo base64_encode(json_encode($graphTotalRendimento)); ?>"></div>
                                                    </div>
                                                </div>

                                                <div class="tile">
                                                    <h2 class="tile-title p-l-0">Saldo Líquido<span class="badge badge-blue m-l-5 tooltips" data-toggle="tooltip" data-placement="right" title="Somatória dos saldos líquidos ao mês de todas as subscrições ativas">?</span></h2>

                                                    <div class="p-10" >
                                                        <div id="line-chart-saldo-total"
                                                             class="main-chart line-chart" style="height: 250px"
                                                             data-dados="<?php echo base64_encode(json_encode($graphTotalSaldo)); ?>"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                    <?php echo $htmlsub;
                            }
                     ?>

                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="modal-extrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Extrato</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group clearfix m-b-20">
                        <label class="col-md-2 m-t-10 control-label text-black">Data Inicial</label>
                        <div class="col-md-9">
                            <?php
                            $predata = (removeXMonthIntoDate(date('Y-m-d'),1));

                            echo form_input(array('type' => 'text',
                                'name' => 'dtinicio',
                                'id' => 'dtinicio',
                                'readonly' => '',
                                'style'=>"",
                                'class' => 'form-control  input1',
                                'value' => inverterdata(set_value("dtinicio", $predata)))); ?>
                        </div>
                    </div>
                    <div class="form-group clearfix m-b-20">
                        <label class="col-md-2 m-t-10 control-label text-black">Data Final</label>
                        <div class="col-md-9">
                            <?php
                            $posdata = ((date('Y-m-d')));

                            echo form_input(array('type' => 'text',
                                'name' => 'dtfinal',
                                'id' => 'dtfinal',
                                'readonly' => '',
                                'style'=>"",
                                'class' => 'form-control  input1',
                                'value' => inverterdata(set_value("dtfinal", $posdata)))); ?>
                        </div>
                    </div>
                    <div class="form-group clearfix m-b-20">
                        <label class="col-md-2 m-t-10 control-label text-black">Rendimento</label>
                        <div class="col-md-6">
                            <?php
                            echo form_dropdown(array('name'=>"tipoRendimento", 'id'=>'tipoRendimento', 'class'=>'form-control input1', 'style'=>'color: black;'), array('0'=>'Diário', '1'=>'Mensal'), 0) ?>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger" id="btnAtualizarExtrato" name="btnAtualizarExtrato" onclick="AtualizaExtratoModal()">Gerar Extrato</button>
                            <button type="button" class="btn btn-danger" id="btnExportarPDF" name="btnExportarPDF" onclick="gerarPDF()">Exportar PDF</button>

                        </div>
                       <!-- <div class="col-md-2">
                            </div>-->
                    </div>


                    <div id="divExtrato"></div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>



        <div class="modal fade" id="modal-simulacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 900px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Simulação de Saldo</h4>
                    </div>

                    <div class="modal-body">
                        <div class="tile m-b-0">
                            <h2 class="tile-title tile-reverse">Simular</h2>
                        </div>

                        <div class="tile tile-reverse">
                            <div class="listview icon-list">
                                <div class="media clearfix">
                                    <label class="col-md-1 control-label p-l-0 m-b-0">Data: </label>
                                    <div class="col-md-9"><?php echo date('d/m/Y'); ?></div>
                                </div>

                                <div class="media clearfix">
                                    <label class="col-md-1 control-label p-l-0 m-b-0">Saldo Atual: </label>
                                    <div class="col-md-9">
                                        R$ <span id="saldoAtual"></span></div>
                                </div>
                            </div>
                        </div>

                        <div class="tile m-b-0">
                            <h2 class="tile-title tile-reverse">Remuneração Mensal Líquida e Data</h2>
                        </div>

                        <div class="tile tile-reverse p-15 form-horizontal clearfix p-t-20 p-b-0">

                            <div class="form-group clearfix">
                                <label class="col-md-2 control-label">Remuneração Mensal Líquida %: </label>
                                <div class="col-md-7">
                                    <?php echo form_input(array('type' => 'text',
                                        'name' => 'cupom',
                                        'id' => 'cupom',
                                        'class' => 'form-control cupom',
                                        'readonly' => true,
                                        'value' => set_value("cupom"))); ?>
                                </div>
                            </div>

                            <div class="form-group clearfix m-t-20">
                                <label class="col-md-2 control-label">Simular Para: </label>
                                <div class="col-md-7">
                                    <?php
                                    $predata = (addDayIntoDate(date('Y-m-d')));

                                    echo form_input(array('type' => 'text',
                                        'name' => 'data_simulacao',
                                        'id' => 'data_simulacao',
                                        'readonly' => '',
                                        'class' => 'form-control  input1',
                                        'value' => inverterdata(set_value("data_simulacao", $predata)))); ?>
                                </div>
                            </div>
                            <input type="hidden" id="codigoSimulacao" value=""/>
                            <input type="hidden" id="preencheData" value="<?php echo inverterdata($predata); ?>"/>
                        </div>

                        <div id="divMostraSimulacao" class=""></div>
                    </div>

                    <div class="modal-footer m-t-0">
                        <button type="button" class="btn btn-success" id="btnSimularSaldo">Simular</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>

            <?php


            }
    elseif ($operacao == 'home') {
    //--------------------------------- Home ---------------------------------------------
    $id = $this->session->aluno['codigo'];
    //print_r($this->session->aluno); exit;
    if ($id == NULL)
        redirect('acesso/home');

    $result = $this->mod->get_byid($id);
    $res = $result[0];
    $resultemail = $this->mod->buscarEmails($res->codigo_pes);
    $resulttel = $this->mod->buscarTelefones($res->codigo_pes);
    $cidades = $this->mod->buscarCidadesbyid($res->codigo_est);
    $ddlCidades = array("" => "Selecione");
    foreach ($cidades as $key => $cada) {
        $ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
    }//echo $ddlCidades[$res->codigo_cid]; exit;
    //print_r($ddlCidades); exit;
    ?>

  <!--   <h4 class="page-title">
        Home
            <p class="sub-title">Total</p>
     </h4>-->

  <!--  <div class="saldo">

        <div class="block-area">-->
                    <?php

            $subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);
            $saldoTotalCliente = 0;

            if($subscricoes === false)
            {
                $subscricoes = array();
            }

            foreach ($subscricoes as $key => $cada) {
                $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;
                $saldoTotalCliente += $totalrendimento;
            }

            ?>
                    <!--</tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3">Saldo Total</td>
                        <td><?php echo formata_moeda($saldoTotalCliente); ?></td>
                    </tr>
                    </tfoot>
                </table>-->


            <!--<div class="accordion tile">
                <div class="panel-group block" id="accordion">-->
                    <?php
                    $subscricoes = $this->mod->buscaSubscricao($this->session->aluno['codigo']);

                    $saldoTotalCliente = 0;
                    $ind = 0;
                    $arrayRendimento = array();
                    $arraySaldo = array();
                    $htmlsub = "";


                    if(!empty($subscricoes))
                    {
                        $totalAll = 0;
                        $totalAllBruto = 0;
                        $totalSubscricao = 0;
                        $totalRendimento= 0;
                        $totalResgates= 0;
                        $totalCupom= 0;
                        $totalSolicitado= 0;
                        $totalAllRendimentoBruto = 0;
                        $totalAllRendimentoLiquido = 0;
                        foreach ($subscricoes as $key => $cada) {
                            $dadosGraph = $controller->dadosGraficos($cada->codigo_subs);
                            $rendimentoscalculabruto = $this->mod->buscarRendimentoMes($cada->codigo_subs, date("Y-m-01"), date("Y-m-31"));


                            $rendimentobrutonovo = 0;
                            $totalLiq = 0;
                            $totalBruto = 0;





                            if ($cada->datainiciocalculo == $cada->data_subs)
                            {

                                $rendimentoscalculabruto = $this->mod->buscarRendimentoNaoReinveste($cada->codigo_subs, $cada->datainiciocalculo);
                                $resgatesSolicitados = $this->mod->buscarResgatesSolicitadosBruto($cada->codigo_subs, date("Y-m-01"), date("Y-m-31"));

                                $totalInicio = $cada->valor_subs;
                                $totalInicioBruto = $totalInicio;
                                $cont = 0;

                                foreach ($rendimentoscalculabruto as $keybr => $cadabr)
                                {
                                    if(!empty($resgatesSolicitados) && $resgatesSolicitados[0]->dataresgatado_resg == $cadabr->data_rend)
                                    {
                                        $cadaresg = array_shift($resgatesSolicitados);
                                        $anttotalinicio = $totalInicio;
                                        $anttotaliniciobruto = $totalInicioBruto;

                                        $totalInicio -= $cadaresg->valor_resg;

                                        $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;

                                        //$totalAllRendimentoBruto += $totalInicioBruto;



                                    }


                                    $totalInicio += $cadabr->valor_rend;
                                    $totalAllRendimentoLiquido += $cadabr->valor_rend;
                                    if($cadabr->ultimodia <= 180)
                                    {
                                        $totalInicioBruto += $cadabr->valor_rend / 0.775;
                                        $totalAllRendimentoBruto += $cadabr->valor_rend / 0.775;
                                    }
                                    elseif($cadabr->ultimodia >= 181 && $cadabr->ultimodia <= 360)
                                    {
                                        $totalInicioBruto += $cadabr->valor_rend / 0.8;
                                        $totalAllRendimentoBruto += $cadabr->valor_rend / 0.8;
                                    }
                                    elseif($cadabr->ultimodia >= 361 && $cadabr->ultimodia <= 720)
                                    {
                                        $totalInicioBruto += $cadabr->valor_rend / 0.825;
                                        $totalAllRendimentoBruto += $cadabr->valor_rend / 0.825;
                                    }
                                    elseif($cadabr->ultimodia >= 721)
                                    {
                                        $totalInicioBruto += $cadabr->valor_rend / 0.85;
                                        $totalAllRendimentoBruto += $cadabr->valor_rend / 0.85;
                                    }

                                }
                                if(!empty($resgatesSolicitados) && strtotime($resgatesSolicitados[0]->dataresgatado_resg) <= strtotime(date('Y-m-d')))// && $resgatesSolicitados[0]->dataresgatado_resg == date('Y-m-d')
                                {
                                    $cadaresg = array_shift($resgatesSolicitados);
                                    $anttotalinicio = $totalInicio;
                                    $anttotaliniciobruto = $totalInicioBruto;

                                    $totalInicio -= $cadaresg->valor_resg;

                                    $totalInicioBruto = ($totalInicio * $anttotaliniciobruto) / $anttotalinicio;

                                    //$totalAllRendimentoBruto += $totalInicioBruto;//$anttotaliniciobruto - $totalInicioBruto;

                                }

                                if($totalInicio >= -0.01 && $totalInicio <= 0.01)
                                {
                                    $totalInicioBruto = 0;
                                }


                                $totalrendimento = $totalInicio;
                                $totalrendimentoBruto = $totalInicioBruto;



                            }
                            else
                            {
                                if($cada->ultimodia <= 180)
                                {
                                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.775;
                                    $rendimentobrutonovoaux = $cada->rendimento / 0.775;
                                    //$totalAllRendimentoBruto += $cada->rendimentomesatual / 0.775;

                                }
                                elseif($cada->ultimodia >= 181 && $cada->ultimodia <= 360)
                                {
                                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.8;
                                    $rendimentobrutonovoaux = $cada->rendimento / 0.8;
                                    // $totalAllRendimentoBruto += $cada->rendimentomesatual / 0.8;

                                }
                                elseif($cada->ultimodia >= 361 && $cada->ultimodia <= 720)
                                {
                                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.825;
                                    $rendimentobrutonovoaux = $cada->rendimento / 0.825;
                                    //$totalAllRendimentoBruto += $cada->rendimentomesatual / 0.825;

                                }
                                elseif($cada->ultimodia >= 721)
                                {
                                    $rendimentobrutonovo = $cada->rendimentomesatual / 0.85;
                                    $rendimentobrutonovoaux = $cada->rendimento / 0.85;
                                    //$totalAllRendimentoBruto += $cada->rendimentomesatual / 0.85;

                                }

                                $diferencamesfixbruto = $rendimentobrutonovo - $cada->rendimentomesatual;


                                $totalrendimento = $cada->valor_subs + $cada->rendimento - $cada->resgate;
                                $totalAllRendimentoLiquido += $cada->rendimento;
                                $totalAllRendimentoBruto += $rendimentobrutonovoaux;

                                if($totalrendimento >= -0.01 && $totalrendimento <= 0.01)
                                {
                                    $totalrendimentoBruto = 0;
                                }
                                else
                                {
                                    $totalrendimentoBruto = $totalrendimento + $diferencamesfixbruto    ;
                                }
                            }

                            $dtultimo = splitData($cada->ultimo);



                            if($dtultimo['month'] == date('m') && $dtultimo['year'] == date("Y"))
                            {
                                $totalAll += $totalrendimento;
                                $totalAllBruto += $totalrendimentoBruto;
                            }
                            else
                            {
                                $totalrendimento = 0; $totalrendimentoBruto = 0;
                            }

                            $totalSubscricao += $cada->valor_subs;
                            $totalRendimento += $cada->rendimento;
                            $totalResgates += $cada->resgate;
                            $totalSolicitado += $cada->resgateSolicitado;
                            $totalCupom += $cada->resgateCupom;
                            $saldoTotalCliente += $totalrendimento;
                            //$totalAllRendimentoBruto += $cada->rendimentobruto;
                                    $ind++;
                            }?>
                        <?php
                                $ordenarendimento = array();
                                $ordenasaldo = array();
                                $graphTotalRendimento = array();
                                $graphTotalSaldo = array();
                                $graphDatas = array();
                                $graphDatasSaldo = array();

                                foreach ($arrayRendimento as $keyarray => $cadaarray)
                                {
                                    $graphDatas[] = $cadaarray[0];
                                    $graphDatasSaldo[] = $cadaarray[0];
                                    $ordenarendimento[] = $cadaarray[1];
                                    $ordenasaldo[] = $arraySaldo[$keyarray][1];
                                }
                                 //   print_r($graphDatas); echo "<br/>"; print_r($ordenarendimento); echo "<br/>"; print_r($ordenasaldo);  echo "<br/>";
                                array_multisort($graphDatas, $ordenarendimento);
                                array_multisort($graphDatasSaldo, $ordenasaldo);

                                foreach ($graphDatas as $keydata => $cadadata)
                                {
                                    $graphTotalRendimento[] = array($cadadata, $ordenarendimento[$keydata]);
                                    $graphTotalSaldo[] = array($cadadata, $ordenasaldo[$keydata]);
                                }

                               // echo "<pre>"; print_r($graphTotalRendimento); exit;




                        ?>
                                    <!--<div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapseTotal">
                                                    <?php echo "Total"; ?>
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="collapseTotal" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div>
                                                    <table
                                                        class="tile table table-bordered table-striped tablesorter table-responsive tabela-especial"
                                                        id="tablesorter">
                                                        <thead>
                                                        <tr>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Valor Investido (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Resgates (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Cupom Recebido (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Lucro Bruto (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Saldo Bruto (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Lucro Líquido (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Saldo Líquido (R$)</th>
                                                            <th data-name="Total" data-placeholder="Filtrar Total">Ação</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        <?php
                                                        echo "<tr>
                                                                    <td>" . formata_moeda($totalSubscricao) . "</td>
                                                                    <td>" . formata_moeda($totalSolicitado) . "</td>
                                                                    <td>" . formata_moeda($totalCupom) . "</td>
                                                                    <td>" . formata_moeda($totalAllRendimentoBruto) . "</td>
                                                                    <td>" . formata_moeda($totalAllBruto) . "</td>
                                                                    <td>" . formata_moeda($totalAllRendimentoLiquido) . "</td>
                                                                    <td>" . formata_moeda($totalAll) . "</td>
                                                                    <td>" . form_button(array("content" => "<i class='fa fa-file-text'></i>", 'name' => "btnExtrato", 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Extrato', 'onClick' => 'visualizarExtratoTotal(\'' . base64_encode($this->session->userdata('aluno')['codigo']) . '\')')).
                                                                            form_button(array("content" => "<i class='fa fa-money'></i>", 'name' => "btnResgate", 'class' => "btn btn-default btn-action-table btn-acao-tabela", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'\',\'' . formata_moeda($totalAll) . '\')')) . "</td>
                                                              </tr>";

                                                        ?>

                                                        </tbody>
                                                    </table>
                                                /div>

                                                <div class="tile">
                                                    <h2 class="tile-title">Rendimentos <span class="badge tooltips" data-toggle="tooltip" data-placement="right" title="Rendimentos acumulados ao mês de todas as subscrições ativas">?</span></h2>

                                                    <div class="p-10">
                                                        <div id="line-chart-rendimento-total"
                                                             class="main-chart line-chart" style="height: 250px;"
                                                             data-dados="<?php echo base64_encode(json_encode($graphTotalRendimento)); ?>"></div>
                                                    </div>
                                                </div>

                                                <div class="tile">
                                                    <h2 class="tile-title">Saldo Líquido<span class="badge tooltips" data-toggle="tooltip" data-placement="right" title="Somatória dos saldos líquidos ao mês de todas as subscrições ativas">?</span></h2>

                                                    <div class="p-10">
                                                        <div id="line-chart-saldo-total"
                                                             class="main-chart line-chart" style="height: 250px"
                                                             data-dados="<?php echo base64_encode(json_encode($graphTotalSaldo)); ?>"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>-->

                           <!-- </div>
                        </div>-->


                    <div class="block-area clearfix body-sistema p-t-35">
                        <div class="listview listview-valores icon-list">
                            <div class="item-valores">
                                <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/valor-investido.svg')?>" alt="">
                                </span>
                                <div class="aux clearfix">
                                    <p class="valor"><span>R$</span> <?php echo formata_moeda($totalSubscricao)?></p>
                                    <label class="desc">Valor Investido </label>
                                </div>
                            </div>

                            <div class="item-valores">
                                 <span class="icone">
                                    <img class="resgate" src="<?php echo CLOUDFRONT.('imagem/icone/resgate.svg')?>" alt="">
                                 </span>
                                <div class="aux clearfix">
                                    <p class="valor"><span>R$</span><?php echo formata_moeda($totalSolicitado)?></p>
                                    <label class="desc">Resgates</label>
                                </div>
                            </div>

                            <div class="item-valores">
                                <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/cupom-recebido.svg')?>" alt="">
                                </span>
                                <div class="aux clearfix">
                                    <p class="valor"><span>R$</span><?php echo formata_moeda($totalCupom)?></p>
                                    <label class="desc">Cupom Recebido</label>
                                </div>
                            </div>

                            <div class="item-valores">
                                <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/lucro-bruto.svg')?>" alt="">
                                </span>
                                <div class="aux clearfix">
                                    <p class="valor"><span>R$</span><?php echo formata_moeda($totalAllRendimentoBruto)?></p>
                                    <label class="desc">Lucro Bruto</label>
                                </div>
                            </div>

                            <div class="item-valores">
                                <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/saldo-bruto.svg')?>" alt="">
                                </span>
                                <div class="aux clearfix">
                                    <p class="valor"><span>R$</span><?php echo formata_moeda($totalAllBruto)?></p>
                                    <label class="desc">Saldo Bruto</label>
                                </div>
                            </div>

                            <div class="item-valores">
                                 <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/lucro-liquido.svg')?>" alt="">
                                 </span>
                                <div class="aux clearfix">
                                    <p class="valor"><span>R$</span><?php echo formata_moeda($totalAllRendimentoLiquido)?></p>
                                    <label class="desc">Lucro Líquido (R$): </label>
                                </div>
                            </div>

                            <div class="item-valores">
                                 <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/saldo-liquido.svg')?>" alt="">
                                 </span>
                                <div class="aux clearfix">
                                   <p class="valor"><span>R$</span><?php echo formata_moeda($totalAll)?></p>
                                    <label class="desc">Saldo Líquido (R$): </label>
                                </div>
                            </div>

                            <div class="item-valores">
                                <div class="aux acoes clearfix">
                                        <?php echo form_button(array("content" => "<i class='fa fa-file-text'></i> Extrato", 'name' => "btnExtrato", 'class' => "btn btn-extrato", 'title' => 'Extrato', 'onClick' => 'visualizarExtratoTotal(\'' . base64_encode($this->session->userdata('aluno')['codigo']) . '\')')).
                                            form_button(array("content" => "<i class='fa fa-money'></i> Resgate", 'name' => "btnResgate", 'class' => "btn btn-resgate", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'\',\'' . formata_moeda($totalAll) . '\')'))?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php echo $htmlsub;
                            }else
                    {?>


                        <div class="block-area clearfix body-sistema p-t-35">
                            <div class="listview listview-valores icon-list">
                                <div class="item-valores">
                                <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/valor-investido.svg')?>" alt="">
                                </span>
                                    <div class="aux clearfix">
                                        <p class="valor"><span>R$</span> <?php echo formata_moeda(0)?></p>
                                        <label class="desc">Valor Investido </label>
                                    </div>
                                </div>

                                <div class="item-valores">
                                 <span class="icone">
                                    <img class="resgate" src="<?php echo CLOUDFRONT.('imagem/icone/resgate.svg')?>" alt="">
                                 </span>
                                    <div class="aux clearfix">
                                        <p class="valor"><span>R$</span><?php echo formata_moeda(0)?></p>
                                        <label class="desc">Resgates</label>
                                    </div>
                                </div>

                                <div class="item-valores">
                                <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/cupom-recebido.svg')?>" alt="">
                                </span>
                                    <div class="aux clearfix">
                                        <p class="valor"><span>R$</span><?php echo formata_moeda(0)?></p>
                                        <label class="desc">Cupom Recebido</label>
                                    </div>
                                </div>

                                <div class="item-valores">
                                <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/lucro-bruto.svg')?>" alt="">
                                </span>
                                    <div class="aux clearfix">
                                        <p class="valor"><span>R$</span><?php echo formata_moeda(0)?></p>
                                        <label class="desc">Lucro Bruto</label>
                                    </div>
                                </div>

                                <div class="item-valores">
                                <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/saldo-bruto.svg')?>" alt="">
                                </span>
                                    <div class="aux clearfix">
                                        <p class="valor"><span>R$</span><?php echo formata_moeda(0)?></p>
                                        <label class="desc">Saldo Bruto</label>
                                    </div>
                                </div>

                                <div class="item-valores">
                                 <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/lucro-liquido.svg')?>" alt="">
                                 </span>
                                    <div class="aux clearfix">
                                        <p class="valor"><span>R$</span><?php echo formata_moeda(0)?></p>
                                        <label class="desc">Lucro Líquido (R$): </label>
                                    </div>
                                </div>

                                <div class="item-valores">
                                 <span class="icone">
                                    <img src="<?php echo CLOUDFRONT.('imagem/icone/saldo-liquido.svg')?>" alt="">
                                 </span>
                                    <div class="aux clearfix">
                                        <p class="valor"><span>R$</span><?php echo formata_moeda(0)?></p>
                                        <label class="desc">Saldo Líquido (R$): </label>
                                    </div>
                                </div>

                                <div class="item-valores">
                                    <div class="aux acoes clearfix">
                                        <?php echo form_button(array("content" => "<i class='fa fa-file-text'></i> Extrato", 'name' => "btnExtrato", 'class' => "btn btn-extrato", 'title' => 'Extrato', 'onClick' => 'visualizarExtratoTotal(\'' . base64_encode($this->session->userdata('aluno')['codigo']) . '\')')).
                                            form_button(array("content" => "<i class='fa fa-money'></i> Resgate", 'name' => "btnResgate", 'class' => "btn btn-resgate", 'title' => 'Resgate', 'onClick' => 'modalResgate(\'\',\'' . formata_moeda(0) . '\')'))?>
                                    </div>
                                </div>
                            </div>
                        </div>



                    <?php
                    }
                     ?>

               <!-- </div>
            </div>-->

       <!-- </div>
    </div>-->


    <div class="modal fade" id="modal-extrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Extrato</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group clearfix m-b-20">
                        <label class="col-md-2 m-t-10 control-label text-black">Data Inicial</label>
                        <div class="col-md-9">
                            <?php
                            $predata = (removeXMonthIntoDate(date('Y-m-d'),1));

                            echo form_input(array('type' => 'text',
                                'name' => 'dtinicio',
                                'id' => 'dtinicio',
                                'readonly' => '',
                                'style'=>"color: black;",
                                'class' => 'form-control  input1',
                                'value' => inverterdata(set_value("dtinicio", $predata)))); ?>
                        </div>
                    </div>

                    

                    <div class="form-group clearfix m-b-20">
                        <label class="col-md-2 m-t-10 control-label text-black">Data Final</label>
                        <div class="col-md-5 m-b-10">
                            <?php
                            $posdata = ((date('Y-m-d')));

                            echo form_input(array('type' => 'text',
                                'name' => 'dtfinal',
                                'id' => 'dtfinal',
                                'readonly' => '',
                                'style'=>"color: black;",
                                'class' => 'form-control  input1',
                                'value' => inverterdata(set_value("dtfinal", $posdata)))); ?>
                        </div>
                        <div class="col-md-4 m-t-3">
                            <button type="button" class="btn btn-danger" id="btnAtualizarExtrato" name="btnAtualizarExtrato" onclick="AtualizaExtratoModal()">Gerar Extrato</button>
                            <button type="button" class="btn btn-danger" id="btnExportarPDF" name="btnExportarPDF" onclick="gerarPDF()">Exportar PDF</button>
                        </div>
                        <!--<div class="col-md-2 m-t-3">
                            </div>-->
                    </div>


                    <div id="divExtrato"></div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>



        <div class="modal fade" id="modal-simulacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 1200px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Simulação de Saldo</h4>
                    </div>

                    <div class="modal-body">
                        <div class="tile m-b-0">
                            <h2 class="tile-title tile-reverse">Simular</h2>
                        </div>

                        <div class="tile tile-reverse">
                            <div class="listview icon-list">
                                <div class="media clearfix">
                                    <label class="col-md-1 control-label">Data: </label>
                                    <div class="col-md-9"><?php echo date('d/m/Y'); ?></div>
                                </div>

                                <div class="media clearfix">
                                    <label class="col-md-1 control-label">Saldo Atual: </label>
                                    <div class="col-md-9">
                                        R$ <span id="saldoAtual"></span></div>
                                </div>
                            </div>
                        </div>

                        <div class="tile m-b-0">
                            <h2 class="tile-title tile-reverse">Remuneração Mensal Líquida e Data</h2>
                        </div>

                        <div class="tile tile-reverse p-15 form-horizontal clearfix p-t-20">

                            <div class="form-group clearfix">
                                <label class="col-md-2 control-label">Remuneração Mensal Líquida %: </label>
                                <div class="col-md-9">
                                    <?php echo form_input(array('type' => 'text',
                                        'name' => 'cupom',
                                        'id' => 'cupom',
                                        'class' => 'form-control cupom',
                                        'readonly' => true,
                                        'value' => set_value("cupom"))); ?>
                                </div>
                            </div>

                            <div class="form-group clearfix m-t-20">
                                <label class="col-md-2 control-label">Simular Para: </label>
                                <div class="col-md-9">
                                    <?php
                                    $predata = (addDayIntoDate(date('Y-m-d')));

                                    echo form_input(array('type' => 'text',
                                        'name' => 'data_simulacao',
                                        'id' => 'data_simulacao',
                                        'readonly' => '',
                                        'class' => 'form-control  input1',
                                        'value' => inverterdata(set_value("data_simulacao", $predata)))); ?>
                                </div>
                            </div>
                            <input type="hidden" id="codigoSimulacao" value=""/>
                            <input type="hidden" id="preencheData" value="<?php echo inverterdata($predata); ?>"/>
                        </div>

                        <div id="divMostraSimulacao" class=""></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnSimularSaldo">Simular</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>

            <?php


            } elseif ($operacao == 'gerarContrato') {
                //--------------------------------- Update ---------------------------------------------
                $id = $this->session->aluno['codigo'];
                //print_r($this->session->aluno); exit;
                if ($id == NULL)
                    redirect('acesso/home');

                $result = $this->mod->get_byid($id);
                $res = $result[0];
                $resultemail = $this->mod->buscarEmails($res->codigo_pes);
                $resulttel = $this->mod->buscarTelefones($res->codigo_pes);
                $cidades = $this->mod->buscarCidadesbyid($res->codigo_est);
                $ddlCidades = array("" => "Selecione");

                foreach ($cidades as $key => $cada) {
                    $ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
                }
                ?>
                <div class="meu-perfil">
                    <div class="clearfix titulo-principal">
                        <h1 class="titulo-principal titulo-principal-2 cor-titulo-1">CONTRATO DO ALUNO</h1>
                    </div>

                    <section class="cada-conteudo clearfix container_12">
                        <h1 class="titulo-principal titulo-principal-3 cor-titulo-1">CONTRATO</h1>
                        <div class="div-total-categoria">
                            <?php echo anchor('acesso/meu_perfil', '<i class="fa fa-edit"></i> Editar Dados', array('class' => 'btn btn-primary novo-registro')); ?>
                        </div>
                        <?php
                        $atributos = array('class' => 'form-signin', 'id' => 'form1');
                        echo form_open('acesso/gerarcontrato/' . base64_encode($res->codigo_pes), $atributos, array('ativo_pes' => $res->ativo_pes, 'cd' => $res->codigo_pes, 'tipo_pes' => 0, 'codigo_contr' => $res->codigo_contr, 'pago_pagcont' => 0));


                        if (validation_errors() != '') {
                            echo '<div class="alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        	</div>';
                        }

                        if ($this->session->flashdata('alterar')) {
                            echo '<div class="clearfix alert-success">' . $this->session->flashdata('alterar') . '</div>';
                        }

                        echo '<div class="cada-input clearfix"><p>'
                            . form_label("Nome: ") . ' ' . form_label(($res->nome_pes)) . "<br/>";
                        if (!$res->tipo_pes) {
                            echo form_label("CPF: ") . ' ' . form_label(($res->cpf_pes)) . "<br/>";
                            if ($res->rg_pes)
                                echo form_label("RG: ") . ' ' . form_label(($res->rg_pes)) . "<br/>";
                        } else {
                            echo form_label("Razão Social: ") . ' ' . form_label(($res->razao_pes)) . "<br/>";

                            echo form_label("CNPJ: ") . ' ' . form_label(($res->cnpj_pes)) . "<br/>";
                        }

                        echo form_label("CEP: ") . ' ' . form_label(($res->cep_pes)) . "<br/>";

                        echo form_label("Endereco: ") . ' ' . form_label(($res->endereco_pes)) . ', ' . form_label(($res->numero_pes)) . " - " . form_label(($res->bairro_pes)) . "<br/>";
                        if ($res->complemento_pes)
                            echo form_label("Complemento: ") . ' ' . form_label(($res->complemento_pes)) . "<br/>";

                        echo form_label("Cidade: ") . " " . $ddlCidades[$res->codigo_cid] . ', ' . form_label($res->uf_est) . " - Brasil<br/>";

                        echo form_label("Instituição: ") . ' ' . form_label($res->nome_inst) . " <br/>Curso: " . form_label($res->nome_cur) . "<br/>";

                        echo form_label("Telefone: ") . " ";
                        foreach ($resulttel as $key => $cada) {
                            if ($key == 0)
                                echo form_label($cada['numero_tel']);
                            else
                                echo " | " . form_label($cada['numero_tel']);
                        }
                        echo "<br/>";

                        echo form_label("Email: ") . ' ';
                        foreach ($resultemail as $key => $cada) {
                            if ($key == 0)
                                echo form_label($cada['email_email']);
                            else
                                echo " | " . form_label($cada['email_email']);
                        }
                        echo '</p>
		            
		        </div>';

                        echo '<div class="titulo-secundario clearfix">
				            <h1>
				                <i class="fa fa-money"></i> Formas de Pagamentos
				            </h1>
				        </div>';

                        echo '<div class="cada-input clearfix">';

                        $ant = "";
                        $forms = $this->mod->buscarFormaPagamentos($this->session->aluno['codigo']);
                        if (!empty($forms)) {
                            echo '<div><div class="clearfix titulo-secundario titulo-secundario-despesa titulo-secundario-despesa-3 titulo-personalizado">
					                        <h1 class="categoria pointer"><p class="nome-forma"><p class="nome-forma">' . $forms[0]->descricao_formpag . ' - ' . ($forms[0]->completo_formpag ? "Completo" : "Parcial") . '<div class="div-total-categoria">' . form_button(array('id' => "selecionaFormpag", 'name' => 'seleciona', "class" => "btn btn-danger botoes-mais", "content" => '<i class="fa fa-check"></i> Selecionar', 'onClick' => 'selecionarFormPag(' . $forms[0]->codigo_formpag . ')')) . '</div></p></h1>
					                    </div><table class="table table-bordered table-striped2 tablesorter tabela-despesa table-responsive">
			            	<thead>
			            		<tr>
			            			<th>DESCRIÇÃO</th>
			            			<th>PARCELAS</th>
			            			<th>VALOR</th>
			            			<th>INICIO PAGAMENTO</th>
			            			<th>FIM PAGAMENTO</th>
			            			<th></th>
			            		</tr>
			            	</thead>
			            	<tbody>';
                            foreach ($forms as $key => $cada) {
                                if ($key == 0) {
                                    $ant = $cada->descricao_formpag;
                                    echo '<tr>
											<td>' . $cada->desc_tppag . '</td>
											<td>' . $cada->qtdparc_tppag . '</td>
											<td>' . number_format($cada->valor_tppag, 2, ",", ".") . '</td>
											<td>' . inverterdata($cada->dtinicio_tppag) . '</td>
											<td>' . inverterdata($cada->dtfim_tppag) . '</td>
											<td></td>
										  </tr>';
                                } else {
                                    if ($cada->descricao_formpag == $ant) {
                                        echo '<tr>
											<td>' . $cada->desc_tppag . '</td>
											<td>' . $cada->qtdparc_tppag . '</td>
											<td>' . $cada->valor_tppag . '</td>
											<td>' . inverterdata($cada->dtinicio_tppag) . '</td>
											<td>' . inverterdata($cada->dtfim_tppag) . '</td>
											<td></td>
										  </tr>';
                                    } else {
                                        $ant = $cada->descricao_formpag;
                                        echo '</tbody></table></div><div><div class="clearfix titulo-secundario titulo-secundario-despesa titulo-secundario-despesa-3 titulo-personalizado">
					                        <h1 class="categoria pointer"><p class="nome-forma"><p class="nome-forma">' . $cada->descricao_formpag . ' - ' . ($cada->completo_formpag ? "Completo" : "Parcial") . '<div class="div-total-categoria">' . form_button(array('id' => "selecionaFormpag", 'name' => 'seleciona', "class" => "btn btn-danger botoes-mais", "content" => '<i class="fa fa-check"></i> Selecionar', 'onClick' => 'selecionarFormPag(' . $cada->codigo_formpag . ')')) . '</div></p></h1>
					                    </div><table class="table table-bordered table-striped2 tablesorter tabela-despesa table-responsive">
									            	<thead>
									            		<tr>
									            			<th>DESCRIÇÃO</th>
									            			<th>PARCELAS</th>
									            			<th>VALOR</th>
									            			<th>INICIO PAGAMENTO</th>
									            			<th>FIM PAGAMENTO</th>
									            			<th></th>
									            		</tr>
									            	</thead>
									            	<tbody><tr>
											<td>' . $cada->desc_tppag . '</td>
											<td>' . $cada->qtdparc_tppag . '</td>
											<td>' . number_format($cada->valor_tppag, 2, ",", ".") . '</td>
											<td>' . inverterdata($cada->dtinicio_tppag) . '</td>
											<td>' . inverterdata($cada->dtfim_tppag) . '</td>
											<td></td>
										  </tr>';
                                    }
                                }
                            }
                            echo '</tbody></table></div>';
                        }

                        echo '</div>';

                        echo '<h1 class="titulo-principal titulo-principal-3 cor-titulo-1">CONTRATO</h1>';

                        echo '<div class="cada-input clearfix" id="divParcelas">';
                        if (!empty(set_value('dtcombinado_pagcont[]'))) {
                            $modos = $this->db->where('ativo_modpag', 1)->get('modo_pagamento')->result();

                            $optmodos = "<option value=''>Selecione</option>";
                            foreach ($modos as $key => $cada) {
                                $optmodos .= "<option value='" . $cada->codigo_modpag . "'>" . $cada->desc_modpag . "</option>";
                            }
                            echo '<table id="dados_fp"class="table table-bordered table-striped2 table-responsive">
								<thead>
									<tr>
										<td>Data Combinado</td>
										<td>Forma de Pagamento</td>
										<td>Valor da Parcela</td>
									</tr>
								</thead>
								<tbody>';
                            for ($i = 0; !empty(set_value('valor_pagcont[' . $i . ']')); $i++) {
                                echo '<tr>
								<td>
									<input type="text"id="dados_fp' . $i . '"name="dtcombinado_pagcont[]"class="input-cria-1 form-control data picker" placeholder="Data Combinado" data-inicio="" data-fim="" value="' . (set_value('dtcombinado_pagcont[' . $i . ']') ? set_value('dtcombinado_pagcont[' . $i . ']') : "") . '">
								</td>
								<td>
									<select id="dados_fp' . $i . '"name="codigo_modpag[]"class="selectfp form-control input-cria-1" data-selecionado="' . (set_value('codigo_modpag[' . $i . ']') ? set_value('codigo_modpag[' . $i . ']') : "") . '">
										' . $optmodos . '
									</select>
								</td>
								<td>
									<input placeholder="Valor" type="text"id="dados_fp' . $i . '"name="valor_pagcont[]"value="' . set_value('valor_pagcont[' . $i . ']') . '" readonly class="form-control input-cria-1 valor numero">
								</td>
							</tr>';
                            }
                            echo '</tbody>
								</table>';
                        }

                        echo '</div>';


                        echo '<div class="area-botao-salvar clearfix">' .
                            form_submit(array('name' => 'btnSalvar', 'id' => 'btnSalvar', 'value' => 'Salvar', 'class' => 'btn btn-primary')) .
                            anchor('acesso/home', "Voltar", array('class' => 'btn btn-danger')) . '
            
        </div>
        ' . form_close() . '

    ';
                        ?>
                    </section>
                </div>
                <?php
            }
            elseif ($operacao == 'contratoGerado') {
            //--------------------------------- Update ---------------------------------------------
            $id = $this->session->aluno['codigo'];
            //print_r($this->session->aluno); exit;
            if ($id == NULL)
                redirect('acesso/home');

            $result = $this->mod->get_byid($id);
            $res = $result[0];
            $resultemail = $this->mod->buscarEmails($res->codigo_pes);
            $resulttel = $this->mod->buscarTelefones($res->codigo_pes);
            $cidades = $this->mod->buscarCidadesbyid($res->codigo_est);
            $pagamentos = $this->mod->buscarPagamentos($id);
            $ddlCidades = array("" => "Selecione");
            foreach ($cidades as $key => $cada) {
                $ddlCidades[$cada->codigo_cid] = $cada->nome_cid;
            }
            ?>
            <section class="area-aluno-logado container_12 clearfix" style="padding-top: 80px;">
                <div class="meu-perfil clarfix">
                    <h1 class="titulo-principal titulo-principal-2 cor-titulo-1">CONTRATO DO ALUNO</h1>

                    <section class="cada-conteudo clearfix container_12">
                        <div class="titulo-secundario clearfix">
                        </div>
                        <?php
                        $atributos = array('class' => 'form-signin', 'id' => 'form1');
                        echo form_open('acesso/gerarcontrato/' . base64_encode($res->codigo_pes), $atributos, array('ativo_pes' => $res->ativo_pes, 'cd' => $res->codigo_pes, 'tipo_pes' => 0, 'codigo_contr' => $res->codigo_contr, 'pago_pagcont' => 0));


                        if (validation_errors() != '') {
                            echo '<div class="alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        	</div>';
                        }

                        if ($this->session->flashdata('alterar')) {
                            echo '<div class="clearfix alert-success">' . $this->session->flashdata('alterar') . '</div>';
                        }

                        echo '<div class="grid_5 clearfix"><p>';
                        ?>
                        <h1 class="titulo-principal titulo-principal-3 cor-titulo-1">CONTRATO</h1>
                        <div class="cada-informacao">
                            <label>Nome: </label>
                            <span><?php echo $res->nome_pes; ?></span>
                        </div>


                        <?php
                        if (!$res->tipo_pes) {
                            // echo form_label("CPF: ") . ' ' . form_label(($res->cpf_pes)) . "<br/>";
                            ?>
                            <div class="cada-informacao">
                                <label>CPF: </label>
                                <span><?php echo $res->cpf_pes; ?></span>
                            </div>
                            <?php
                            if ($res->rg_pes) {
                                ?>
                                <div class="cada-informacao">
                                    <label>RG: </label>
                                    <span><?php echo $res->rg_pes; ?></span>
                                </div>
                                <?php
                            }
                            //echo form_label("RG: ") . ' ' . form_label(($res->rg_pes)) . "<br/>";
                        } else {
                            //echo form_label("Razão Social: ") . ' ' . form_label(($res->razaosocial_pes)) . "<br/>";
                            //echo form_label("CNPJ: ") . ' ' . form_label(($res->cnpj_pes)) . "<br/>";
                            ?>
                            <div class="cada-informacao">
                                <label>Razão Social: </label>
                                <span><?php echo $res->razao_pes; ?></span>
                            </div>
                            <div class="cada-informacao">
                                <label>CNPJ: </label>
                                <span><?php echo $res->cnpj_pes; ?></span>
                            </div>
                            <?php
                        }
                        //form_label("Nome: ") . ' ' . form_label(()) . "<br/>";
                        //			if (!$res->tipo_pes) {
                        //			    echo form_label("CPF: ") . ' ' . form_label(($res->cpf_pes)) . "<br/>";
                        //			    if ($res->rg_pes)
                        //				echo form_label("RG: ") . ' ' . form_label(($res->rg_pes)) . "<br/>";
                        //			}
                        //			else {
                        //			    echo form_label("Razão Social: ") . ' ' . form_label(($res->razaosocial_pes)) . "<br/>";
                        //
                        //			    echo form_label("CNPJ: ") . ' ' . form_label(($res->cnpj_pes)) . "<br/>";
                        //			}
                        //    echo form_label("CEP: ") . ' ' . form_label(($res->cep_pes)) . "<br/>";
                        ?>

                        <div class="cada-informacao">
                            <label>CEP: </label>
                            <span><?php echo $res->cep_pes; ?></span>
                        </div>

                        <div class="cada-informacao">
                            <label>Endereço: </label>
                            <span><?php echo $res->endereco_pes . ', ' . $res->numero_pes . ', bairro: ' . $res->bairro_pes; ?></span>
                        </div>

                        <?php
                        if ($res->complemento_pes) {
                            ?>
                            <div class="cada-informacao">
                                <label>Complemento: </label>
                                <span><?php echo $res->complemento_pes; ?></span>
                            </div>

                            <?php
                        }
                        // echo form_label("Endereco: ") . ' ' . form_label(($res->logradouro_pes)) . ', ' . form_label(($res->numero_pes)) . " - " . form_label(($res->bairro_pes)) . "<br/>";
                        // if ($res->complemento_pes)
                        //echo form_label("Complemento: ") . ' ' . form_label(($res->complemento_pes)) . "<br/>";
                        ?>

                        <div class="cada-informacao">
                            <label>Cidade: </label>
                            <span><?php echo $ddlCidades[$res->codigo_cid] . ', <strong>' . $res->uf_est . '</strong> - Brasil'; ?></span>
                        </div>

                        <div class="cada-informacao">
                            <label>Instituição: </label>
                            <span><?php echo $res->nome_inst; ?></span>
                        </div>

                        <div class="cada-informacao">
                            <label>Curso: </label>
                            <span><?php echo $res->nome_cur; ?></span>
                        </div>

                        <div class="cada-informacao">
                            <label>Telefone(s): </label>
                            <span><?php
                                foreach ($resulttel as $key => $cada) {
                                    if ($key == 0)
                                        echo $cada['numero_tel'];
                                    else
                                        echo " | " . $cada['numero_tel'];
                                }
                                ?></span>
                        </div>

                        <div class="cada-informacao">
                            <label>E-mail(s): </label>
                            <span><?php
                                foreach ($resultemail as $key => $cada) {
                                    if ($key == 0)
                                        echo form_label($cada['email_email']);
                                    else
                                        echo " | " . form_label($cada['email_email']);
                                }
                                ?></span>
                        </div>
                        <?php
                        //			echo form_label("Cidade: ") . " " . $ddlCidades[$res->codigo_cid] . ', ' . form_label($res->uf_est) . " - Brasil<br/>";
                        //echo form_label("Instituição: ") . ' ' . form_label($res->nome_inst) . " <br/>Curso: " . form_label($res->nome_cur) . "<br/>";
                        //echo form_label("Telefone: ") . " ";
                        //			foreach ($resulttel as $key => $cada) {
                        //			    if ($key == 0)
                        //				echo form_label($cada['numero_tel']);
                        //			    else
                        //				echo " | " . form_label($cada['numero_tel']);
                        //			}
                        //echo "<br/>";

                        //echo form_label("Email: ") . ' ';
                        //			foreach ($resultemail as $key => $cada) {
                        //			    if ($key == 0)
                        //				echo form_label($cada['email_email']);
                        //			    else
                        //				echo " | " . form_label($cada['email_email']);
                        //			}
                        echo '</p>
		            
		        </div>';


                        echo '';

                        echo '<div class="grid_7 clearfix" id="divParcelas"><div class="titulo-secundario clearfix">		           
    			<h1 class="titulo-principal titulo-principal-3 cor-titulo-1">PARCELAS</h1>
		        </div>';
                        if (!empty($pagamentos)) {
                            echo '<table id="dados_fp"class="table table-bordered table-striped2 table-responsive">
								<thead>
									<tr>
										<td>Data Combinado</td>
										<td>Forma de Pagamento</td>
										<td>Valor da Parcela</td>
										<td>Status</td>
										<td></td>
									</tr>
								</thead>
								<tbody>';
                            foreach ($pagamentos as $key => $cada2) {
                                //print_r($cada2); exit;
                                echo '<tr>
									<td>
										<input type="text"id="dados_fp' . $key . '"name="dtcombinado_pagcont[]"class="input-cria-1 form-control data picker" placeholder="Data Combinado" readonly data-inicio="" data-fim="" value="' . inverterdata($cada2->dtcombinado_pagcont) . '"/>
									</td>
									<td>
										<input type="text"id="dados_fp' . $key . '"name="tipo_pagcon[]"class="input-cria-1 form-control " readonly value="' . $cada2->desc_modpag . '"/>
									</td>
									<td>
										<input placeholder="Valor" type="text"id="dados_fp' . $key . '"name="valor_pagcont[]"value="' . formata_moeda($cada2->valor_pagcont) . '" readonly class="form-control input-cria-1 valor numero"/>
									</td>
									<td>
										<input type="text"id="dados_fp' . $key . '"name="status_pagcont[]"value="' . ($cada2->pago_pagcont ? "Pago" : "Não Pago") . '" readonly class="form-control input-cria-1" />
									</td>
									<td>	
										' . ($cada2->pago_pagcont ? "" : ($cada2->codigo_modpag == 1 ? anchor("acesso/boleto/" . base64_encode($cada2->codigo_pagcont), '<i class="fa fa-barcode"></i>', array('class' => "btn btn-default btn-acao-tabela", "title" => 'Gerar Boleto', 'target' => "_blank")) : "")) . '
									</td>
								</tr>';
                            }

                            echo '</tbody>
								</table>';
                        }

                        echo '</div>';


                        echo '<div class="area-botao-salvar clearfix">' .
                            anchor('acesso/geraTodosBoletos', "Gerar Boletos", array('class' => 'btn btn-success', 'style' => 'width: 185px; padding: 18.5px; margin-right:10px;')) .
                            anchor('acesso/home', "Voltar", array('class' => 'btn btn-danger')) . '
            
        </div>
        ' . form_close();
                        } elseif ($operacao == 'fazerResgate') {
                        //--------------------------------- Update ---------------------------------------------
                        $id = $this->session->aluno['codigo'];
                        //print_r($this->session->aluno); exit;
                        if ($id == NULL)
                            redirect('acesso/home');

                        $result = $this->mod->get_byid($id);
                        $res = $result[0];

                        $saldoAtual = $dadosResgate->valor_subs + $dadosResgate->rendimento - $dadosResgate->resgate;

                        ?>

                        <h4 class="page-title">
                            Solicitação de Resgate
                        </h4>

                        <div class="block-area clearfix">

                            <div class="tile m-b-0">
                                <h2 class="tile-title">Realizar solicitação</h2>
                            </div>
                            <div class="tile">
                                <div class="listview icon-list">
                                    <div class="media clearfix">
                                        <label class="col-md-1 control-label">Data: </label>
                                        <span class="col-md-9"> <?php echo date('d/m/Y'); ?></span>
                                    </div>

                                    <div class="media clearfix">
                                        <label class="col-md-1 control-label">Saldo Atual: </label>
                                        <span class="col-md-9">R$ <?php echo formata_moeda($saldoAtual); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="tile m-b-0">
                                <h2 class="tile-title">Valor e data</h2>
                            </div>
                            <div class="tile p-15 form-horizontal clearfix p-t-20">

                                <?php
                                $atributos = array('class' => 'form-signin', 'id' => 'form1');
                                echo form_open('acesso/fazerResgate/' . base64_encode($dadosResgate->codigo_subs), $atributos, array('ativo_pes' => $res->ativo_pes));


                                if (validation_errors() != '') {
                                    echo '<div class="alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        	</div>';
                                }

                                if ($this->session->flashdata('alterar')) {
                                    echo '<div class="clearfix alert alert-success">' . $this->session->flashdata('alterar') . '</div>';
                                }

                                echo '<div class="grid_5 clearfix"><p>';
                                ?>

                                <div class="form-group clearfix">
                                    <label class="col-md-2 control-label">Valor do Resgate: </label>
                                    <div class="col-md-9">
                                        <?php echo form_input(array('type' => 'text',
                                            'name' => 'valor_resg',
                                            'id' => 'valor_resg',
                                            'class' => 'form-control  input1 preco',
                                            'value' => set_value("valor_resg"))); ?>
                                    </div>
                                </div>

                                <div class="form-group clearfix m-t-20">
                                    <label class="col-md-2 control-label">Agendar Para: </label>
                                    <div class="col-md-9">
                                        <?php
                                        $predata = (addDayIntoDate(date('Y-m-d')));

                                        echo form_input(array('type' => 'text',
                                            'name' => 'data_resg',
                                            'id' => 'data_resg',
                                            'readonly' => '',
                                            'class' => 'form-control  input1',
                                            'value' => inverterdata(set_value("data_resg", $predata)))); ?>
                                    </div>
                                </div>


                                <?php
                                echo '</div>';


                                echo '<div class="form-group clearfix">
                                <div class="col-md-offset-2 col-md-10 m-t-10">' .
                                    form_input(array("type" => 'submit', 'class' => 'btn btn-success', 'name' => 'btnResgatar', 'value' => "Salvar")) .
                                    anchor('acesso/home', "Voltar", array('class' => 'btn btn-danger')) . '
            
                                </div>
                            </div>
        ' . form_close();
                                } elseif ($operacao == 'agendarSubscricao') {
                                //--------------------------------- Update ---------------------------------------------

                                ?>

                                <ol class="breadcrumb hidden-xs">
                                    <li><a href="<?php echo site_url("acesso/saldo") ?>">Subscrições</a></li>
                                    <li class="active">Agendar Subscrição</li>
                                </ol>
                                <h4 class="page-title">
                                    Agendar Subscrição
                                </h4>


                                <div class="block-area clearfix">
                                    <div class="tile m-b-0">
                                        <h2 class="tile-title">Adicionar</h2>
                                    </div>
                                    <div class="tile p-15 form-horizontal clearfix p-t-20">
                                        <?php
                                        $atributos = array('class' => 'form-signin', 'id' => 'form1', 'enctype' => 'multipart/form-data');
                                        echo form_open('acesso/agendarSubscricao', $atributos, array('ativo_subs' => 1, 'codigo_pes' => $this->session->aluno['codigo']));

                                        if (validation_errors() != '') {
                                            echo '<div class="alert alert-danger clearfix">
		            ' . validation_errors('<p>', ' </p>') . '
		        	</div>';
                                        }

                                        if ($this->session->flashdata('alterar')) {
                                            echo '<div class="clearfix alert alert-success">' . $this->session->flashdata('alterar') . '</div>';
                                        }

                                        ?>
                                        <div class="form-group m-t-20 clearfix">
                                            <label class="col-md-2 control-label">Data Agendamento: </label>
                                            <div class="col-md-9 ">
                                                <?php

                                                $predata = (addDayIntoDate(date('Y-m-d')));


                                                echo form_input(array('type' => 'text',
                                                    'name' => 'data_subs',
                                                    'id' => 'data_subs',
                                                    'readonly' => '',
                                                    'class' => 'form-control  input1',
                                                    'value' => inverterdata(set_value("data_subs", $predata)))); ?>
                                            </div>
                                        </div>

                                        <div class="form-group m-t-20 clearfix">
                                            <label class="col-md-2 control-label">Taxa Vigente: </label>
                                            <div class="col-md-9 ">
                                                <?php echo form_input(array('type' => 'text',
                                                    'name' => 'taxa_subs',
                                                    'id' => 'taxa_subs',
                                                    'class' => 'form-control  input1 cupom',
                                                    'value' => set_value("taxa_subs"))); ?>
                                            </div>
                                        </div>

                                        <div class="form-group m-t-20 clearfix">
                                            <label class="col-md-2 control-label">Valor: </label>
                                            <div class="col-md-9 ">
                                                <?php echo form_input(array('type' => 'text',
                                                    'name' => 'valor_subs',
                                                    'id' => 'valor_subs',
                                                    'class' => 'form-control  input1 preco',
                                                    'value' => formata_moeda(set_value("valor_subs", 0)))); ?>
                                            </div>
                                        </div>

                                        <div class="form-group m-t-20 clearfix">
                                            <label class="col-md-2 control-label">Rendimento: </label>
                                            <div class="col-md-9 ">
                                                <?php echo form_dropdown(array('name' => "rendimento_subs", 'id' => 'ddlRendimento', 'class' => 'form-control input1'), array("0" => "Resgatar Mensalmente", "1" => "Reinvestir"), set_value('rendimento_subs')); ?>
                                            </div>
                                        </div>

                                        <div class="form-group m-t-20 clearfix">
                                            <label class="col-md-2 control-label">Comprovante: </label>
                                            <div class="col-md-9 ">
                                                <?php echo form_input(array('type' => 'file',
                                                    'name' => 'comprovante_subs',
                                                    'id' => 'comprovante_subs',
                                                    'class' => 'form-control  input1',
                                                    'value' => set_value("comprovante_subs"))); ?>
                                            </div>
                                        </div>

                                        <?php


                                        echo '<div class="form-group clearfix">
                                                <div class="col-md-offset-2 col-md-10 m-t-10">' .
                                                form_input(array("type" => 'submit', 'class' => 'btn btn-success', 'name' => 'btnResgatar', 'value' => "Salvar")) ." ".
                                                anchor('acesso/saldo', "Voltar", array('class' => 'btn btn-danger')) . '</div>'
                                                . form_close() . '
                                        
                                                </div>
                                              </div>';

                                        } elseif ($operacao == 'fazerSimulacao') {
                                        //--------------------------------- Update ---------------------------------------------
                                        $id = $this->session->aluno['codigo'];
                                        //print_r($this->session->aluno); exit;
                                        if ($id == NULL)
                                            redirect('acesso/home');

                                        $result = $this->mod->get_byid($id);
                                        $res = $result[0];

                                        $saldoAtual = $dadosResgate->valor_subs + $dadosResgate->rendimento - $dadosResgate->resgate;

                                        ?>
                                        <h4 class="page-title">
                                            Simulação de Saldo
                                        </h4>
                                        <div class="block-area clearfix">
                                            <div class="tile m-b-0">
                                                <h2 class="tile-title">Simular</h2>
                                            </div>

                                            <div class="tile tile-reverse">
                                                <div class="listview icon-list">
                                                    <div class="media clearfix">
                                                        <label class="col-md-1 control-label">Data: </label>
                                                        <div class="col-md-9"><?php echo date('d/m/Y'); ?></div>
                                                    </div>

                                                    <div class="media clearfix">
                                                        <label class="col-md-1 control-label">Saldo Atual: </label>
                                                        <div class="col-md-9">
                                                            R$ <?php echo formata_moeda($saldoAtual); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tile m-b-0">
                                                <h2 class="tile-title">Remuneração Mensal Líquida e Data</h2>
                                            </div>

                                            <div class="tile p-15 form-horizontal clearfix p-t-20">

                                                <?php
                                                $atributos = array('class' => 'form-signin', 'id' => 'form1');
                                                echo form_open('acesso/fazerSimulacao/' . base64_encode($dadosResgate->codigo_subs), $atributos, array('ativo_pes' => $res->ativo_pes));


                                                if (validation_errors() != '') {
                                                    echo '<div class="alert-danger clearfix"> ' . validation_errors('<p>', ' </p>') . '</div>';
                                                }

                                                if ($this->session->flashdata('alterar')) {
                                                    echo '<div class="clearfix alert-success">' . $this->session->flashdata('alterar') . '</div>';
                                                }

                                                echo '<div class="grid_5 clearfix"><p>';
                                                ?>

                                                <div class="form-group clearfix">
                                                    <label class="col-md-2 control-label">Remuneração Mensal Líquida %: </label>
                                                    <div class="col-md-9">
                                                        <?php echo form_input(array('type' => 'text',
                                                            'name' => 'cupom',
                                                            'id' => 'cupom',
                                                            'class' => 'form-control cupom',
                                                            'value' => set_value("cupom", formata_cupom($dadosResgate->taxa_subs)))); ?>
                                                    </div>
                                                </div>

                                                <div class="form-group clearfix m-t-20">
                                                    <label class="col-md-2 control-label">Simular Para: </label>
                                                    <div class="col-md-9">
                                                        <?php
                                                        $predata = (addDayIntoDate(date('Y-m-d')));

                                                        echo form_input(array('type' => 'text',
                                                            'name' => 'data_resg',
                                                            'id' => 'data_resg',
                                                            'readonly' => '',
                                                            'class' => 'form-control  input1',
                                                            'value' => inverterdata(set_value("data_resg", $predata)))); ?>
                                                    </div>
                                                </div>


                                                <?php


                                                echo '<div class="form-group clearfix">
                                                    <div class="col-md-offset-2 col-md-10 m-t-10">' .
                                                    form_input(array("type" => 'submit', 'class' => 'btn btn-success', 'name' => 'btnResgatar', 'value' => "Simular")) .
                                                    anchor('acesso/home', "Voltar", array('class' => 'btn btn-danger')) . '
            
                                                     </div>
                                                </div>
        ' . form_close();
                                                }
                                                ?>
                                            </div>
                                        </div>


                                        <?php

                                        if (!empty($simulacao))
                                            echo $simulacao;

                                        ?>

                                    </div>

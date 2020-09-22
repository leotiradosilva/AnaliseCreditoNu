

<h4 class="page-title clearfix">
    <div class="pull-left">
        Meus dados
        <p class="sub-title">Dados pessoais</p>
    </div>

    <div class="pull-right">
        <?php  echo anchor("cliente/meus_dados/meu_perfil", "<i class='fa fa-edit'></i> Editar Perfil", array('name' => "btnResgate", 'class' => "btn btn-acao-tabela", 'title' => 'Editar Perfil'))?>
    </div>
</h4>

<div class="block-area clearfix">
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
                if ($res->org_emissor_pes) {
                    ?>
                    <div class="media clearfix">
                        <label class="col-md-1 control-label">Org. Emissor: </label>
                        <span class="col-md-9"><?php echo strtoupper($res->org_emissor_pes) ?></span>
                    </div>
                    <?php
                }
                if ($res->est_civil_pes) {
                    ?>
                    <div class="media clearfix">
                        <label class="col-md-1 control-label">Estado Civil: </label>
                        <span class="col-md-9"><?php echo ucwords($res->est_civil_pes) ?></span>
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

                
    <?php if ($res->est_civil_pes == 'casado') { ?>

        <h4 class="page-title clearfix p-l-0 p-r-0 p-t-10">
            Dados Cônjuge
        </h4>
        <div class="tile">
            <div class="listview icon-list">
                <div class="media clearfix">
                    <label class="col-md-1 control-label">Nome: </label>
                    <div><?php echo $res->nome_conjuge ?></div>
                </div>

                <div class="media clearfix">
                    <label class="col-md-1 control-label">CPF: </label>
                    <div><?php echo $res->cpf_conjuge ?></div>
                </div>

                <div class="media clearfix">
                    <label class="col-md-1 control-label">Nascimento: </label>
                    <div><?php echo $res->dtnascimento_conjuge ?></div>
                </div>

                <div class="media clearfix">
                    <label class="col-md-1 control-label">Nacionalidade: </label>
                    <div><?php echo $res->nacionalidade_conjuge ?></div>
                </div>
            </div>
        </div>
    <?php } ?>

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

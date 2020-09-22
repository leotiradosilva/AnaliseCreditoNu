<ol class="breadcrumb hidden-xs">
    <li><a href="<?php echo site_url("cliente/Minha_agenda") ?>">Agenda</a></li>
    <li class="active">Editar Agenda</li>
</ol>
<h4 class="page-title">
    Agenda
    <p class="sub-title">Alterar</p>
</h4>
<div class="block-area clearfix">
    <div class="tile p-15 form-horizontal clearfix p-t-20">

        <?php
            $atributos = array('class' => 'form-signin', 'id' => 'form1');
            echo form_open('cliente/Minha_agenda/alterarAgenda/'.base64_encode($agenda->codigo_age), $atributos, array('codigo_pes' => $this->session->userdata('aluno')['codigo']));

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
            anchor('cliente/Minha_agenda', "Voltar", array('class'=> 'btn btn-danger')) . '
            
            </div>
        </div>
        ' . form_close() . '

        </div>
    </div>';
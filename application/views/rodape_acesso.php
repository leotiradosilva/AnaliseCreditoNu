</section><!--content-->
</section><!--main-->
<!---->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>-->
<!--<script src="--><?php //echo CLOUDFRONT; ?><!--js/bootstrap/bootstrap.min.js"></script>-->
<!--<script src="--><?php //echo CLOUDFRONT; ?><!--js/scroll/jquery.mCustomScrollbar.min.js"></script>-->


<!-- jQuery -->
 <!-- jQuery Library -->
 <script src="<?php echo CLOUDFRONT; ?>superadmin/js/jquery.min.js"></script>
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/jquery-ui.min.js"></script> <!-- jQuery UI -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/jquery.easing.1.3.js"></script> <!-- jQuery Easing - Requirred for Lightbox + Pie Charts-->

<!-- Bootstrap -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/bootstrap.min.js"></script>

<!--  Form Related -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/icheck.js"></script> <!-- Custom Checkbox + Radio -->

<!-- UX -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/scroll.min.js"></script> <!-- Custom Scrollbar -->

<!-- All JS functions -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/functions.js"></script>


<script src="<?php echo CLOUDFRONT; ?>js/site/script.js"></script>
<script src="<?php echo CLOUDFRONT; ?>js/bootbox.min.js"></script>

<!-- ALL js rodape -->
<script src="<?php echo CLOUDFRONT; ?>js/jquery.datetimepicker.js"></script>
<script src="<?php echo CLOUDFRONT; ?>cliente/js/rodape_acesso.js"></script>
<script src="<?php echo CLOUDFRONT; ?>cliente/js/geral.js"></script>

<style>
	.loader {
		position: absolute;
		border: 16px solid #f3f3f3; /* Light grey */
		border-top: 16px solid #3498db; /* Blue */
		border-radius: 50% !important;
		width: 120px;
		height: 120px;
		top: 40%;
		left: 40%;
		animation: spin 2s linear infinite;
		z-index: 5;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
</style>

<?php
if (!empty($js_link)) {
    foreach ($js_link as $cada) {
        echo '<script src="' . $cada . '" type="text/javascript"></script>';
    }
}

if (!empty($js)) {
    foreach ($js as $cada) {
        echo '<script src="' . $cada . '" type="text/javascript"></script>';
    }
}
?>



<script type="text/javascript">
    $(document).ready(function (e) {
        $("#data_agenda").datetimepicker({
            lang:"pt-BR",
            scrollInput:false,
            timepicker:false,
            format:"d/m/Y",
        });
        
        $("#data_age").datetimepicker({
             lang:"pt-BR",
             scrollInput:false,
             timepicker:false,
             format:"d/m/Y",
        });



        $("#menu-resgata").removeAttr('href');
        $("#menu-subscricao").removeAttr('href');

        $('#modal-resgate').on('hidden.bs.modal', function () {
            $("#btnConfirmarResgate").removeAttr('disabled')
            $('.loader').css('display', 'none');
        });


////////////////////////////////////////////////////////////////////////////////

$("#ckbTotal").on("ifChecked", function(event){
     $("#valor_resg").attr("readonly",true);
     $("#valor_resg").val($("#valorSaldoTotal").val());
 });

$("#ckbTotal").on("ifUnchecked", function(event){
      $("#valor_resg").removeAttr("readonly",true);
      $("#valor_resg").val(0);
 });

///////////////////////////////////////////////////////////////////////////////

        $(".line-chart").each(function(){
            var d1 = JSON.parse(window.atob($(this).data("dados")));
            $.plot("#"+$(this).attr("id"), [ {
                data: d1,
                label: "Data",
    
            },],
    
                {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 1,
                            fill: 0.25,
                        },
    
//                                                        color: \'rgba(255,255,255,0.7)\',
                        color: '#239acb',
                        shadowSize: 0,
                        points: {
                            show: true,
                        }
                    },
    
                    yaxis: {
//                                                        tickColor: \'rgba(255,255,255,0.15)\',
                        tickColor: '#ececec',
                        tickDecimals: 2,
                        tickFormatter: formatar,
                        font :{
                            lineHeight: 13,
                            style: "normal",
//                                                            color: "rgba(255,255,255,0.8)",
                            color: "#34474f",
                        },
                        shadowSize: 0,
                    },
                    xaxis: {
                        tickColor: 'rgba(255,255,255,0)',
                        mode: "time",
                        timezone: "browser",
                        minTickSize: [1, "month"],
                        tickDecimals: 0,
                        timeformat: "%b/%Y",
                        monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                        //tickFormatter: someFunc,
                        font :{
                            lineHeight: 13,
                            style: "normal",
//                                                            color: "rgba(255,255,255,0.8)",
                            color: "#34474f",
                        }
                    },
                    grid: {
                        borderWidth: 1,
                        borderColor: 'rgba(255,255,255,0)',
                        labelMargin:10,
                        hoverable: true,
                        clickable: true,
                        mouseActiveRadius:6,
                    },
                    legend: {
                        show: false,
                        color: "#000"
                    }
                });

            $("#"+$(this).attr("id")).bind("plothover", function (event, pos, item) {
                if (item) {
                        labelgraph = "";
                        /*nomes = item.series.xaxis.ticks;
                        
                        for(i=0 ; i< nomes.length ; i++)
                        {
                            //console.log(nomes[i].v);
                            //console.log(item.datapoint[0]);

                            if(nomes[i].v == item.datapoint[0])
                                labelgraph = nomes[i].label;
                        }
                        
                        console.log(nomes);
                        console.log(item.datapoint);*/
                    var x = timeConverter((item.datapoint[0]/1000)+86400),
                        y = item.datapoint[1].toFixed(2);
                        
                    $("#linechart-tooltip").html(x+"<br/>Total " + " : " + formatar(y)).css({top: item.pageY-55, left: item.pageX-50}).fadeIn(200);
                }
                else {
                    $("#linechart-tooltip").hide();
                }
            });
    
            $("<div id='linechart-tooltip' class='chart-tooltip'></div>").appendTo("body");
        })
    




      // <?php if (isset($script_pagina)) echo $script_pagina; ?>

    });

	//<?php if (isset($function_pagina)) echo $function_pagina; ?>





</script>

<div class="modal fade" id="modal-resgate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Resgate</h4>
            </div>

            <div class="modal-body">
				<div class="loader" style="display:none;"></div>
                <div class="form-group">
                    <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse">Dados Investimento</h2>
                    </div>
                    <div class="tile tile-reverse">
                        <div class="listview icon-list">
                            <div class="media clearfix p-t-15">
                                <label class="col-md-2 control-label p-l-0 m-b-0">Data: </label>
                                <span class="col-md-9"> <?php echo date('d/m/Y'); ?></span>
                            </div>

                            <div class="media clearfix p-t-15">
                                <label class="col-md-2 control-label p-l-0 m-b-0">Saldo Atual: </label>
                                <span class="col-md-9" id="spanSaldoResgate">R$ </span>
                            </div>
                        </div>
                    </div>
                    <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse">Dados Resgate</h2>
                    </div>
                    <div class="tile tile-reverse p-15 p-t-0 m-b-0 form-horizontal clearfix">

                        <div class="form-group clearfix">
                            <label class="col-md-3 control-label p-l-0 m-t-5">Valor do Resgate: </label>
                            <div class="col-md-9">
                                <?php echo form_input(array('type' => 'text',
                                    'name' => 'valor_resg',
                                    'id' => 'valor_resg',
                                    'class' => 'form-control  input1 preco',
                                    'value' => set_value("valor_resg"))); ?>
                            </div>
                            <div class="col-md-12 m-t-5 p-l-25">
                                <div class="checkbox">
                                    <label>
                                        <div class="aux-check">
                                            <input type="checkbox" id="ckbTotal" ontoggle="valorTotal()" >
                                        </div>
                                        Resgatar valor total
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix m-t-20 m-b-0">
                            <label class="col-md-3 control-label p-l-0 m-t-5">Data da Solicitação: </label>
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
                        <input type="hidden" id="valorSaldoTotal" value="">

                        <?php
                        echo '</div>';
                        ?>
                    </div>

                </div>

                <div class="modal-footer clearfix  m-t-0">
                    <button type="button" class="btn btn-success btn-reverse" id="btnConfirmarResgate" onClick="confirmarResgateModal()"> <i class="fa fa-check"></i> Confirmar</button>
                    <button type="button" class="btn btn-danger btn-reverse" data-dismiss="modal"> <i class="fa fa-times"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-agendar-subscricao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Aviso de Investimento</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <div class="tile m-b-0">
                        <h2 class="tile-title tile-reverse p-l-0">Dados Investimento</h2>
                    </div>
                    <div class="tile tile-reverse">
                        <div class="listview icon-list">
                            <div class="form-group clearfix m-t-20">
                                <label class="col-md-2 control-label">Data: </label>
                                <div class="col-md-9">
                                    <?php
                                    $predata = ((date('Y-m-d')));

                                    echo form_input(array('type' => 'text',
                                        'name' => 'data_agenda',
                                        'id' => 'data_agenda',
                                        'class' => 'form-control  input1',
                                        'value' => inverterdata($predata))); ?>
                                </div>
                            </div>
                            <div class="form-group clearfix m-t-20">
                                <label class="col-md-2 control-label">Valor: </label>
                                <div class="col-md-9">
                                    <?php

                                    echo form_input(array('type' => 'text',
                                        'name' => 'valor_agenda',
                                        'id' => 'valor_agenda',
                                        'class' => 'form-control input1 preco',
                                        'value' => '')); ?>
                                </div>
                            </div>

                            <!-- <div class="form-group clearfix m-t-20">
                                <label class="col-md-2 control-label">Tipo: </label>
                                <div class="col-md-9">
                                    <?php

                                    //echo form_dropdown(array('name'=>"tipo_subs", 'id'=>'tipo_subs', 'class'=>'form-control input1'), $tipos, set_value('tipo_subs'))?>
                                </div>
                            </div> -->

                            <div class="form-group clearfix m-t-20">
                                <label class="col-md-2 control-label">Comprovante: </label>
                                <div class="col-md-9">
                                    <?php

                                    echo form_input(array('type' => 'file',
                                        'name' => 'comprovante',
                                        'id' => 'comprovante',
                                        'class' => 'form-control input1',
                                        'value' => '')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" id="nameAgendarSubscricao" value="<?php echo base64_encode($this->session->userdata['aluno']['nome']); ?>">
                    <input type="hidden" id="codigoAgendarSubscricao" value="<?php echo $this->session->userdata['aluno']['codigo']; ?>">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-reverse" id="btnConfirmaAgendaSubscricao" onclick="ConfirmaAgendaSubscricao('<?php echo base64_encode($this->session->userdata['aluno']['nome'])?>','<?php echo $this->session->userdata['aluno']['codigo']; ?>')"> <i class="fa fa-check"></i> Confirmar</button>
                    <button type="button" class="btn btn-danger btn-reverse" data-dismiss="modal"> <i class="fa fa-times"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" class="fade modal" id="modalFeedBack" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">DEIXE AQUI O SEU FEED BACK</h4>
            </div>
            <div class="clearfix modal-body">

                <h1 class="margin1 titulo1">O que você achou do L8Control? </h1>

                <p class="margin1 texto-feedback">
                    Este é seu espaço para você deixar suas impressões a respeito do L8Control.<br />
                    Suas sugestões são muito bem-vindas.
                </p>

                <div class="borda1 cada-input clearfix">
                    <textarea class="form-control input1" id="tbxComentarioFeedBack" placeholder="Digite seu Comentário"></textarea>
                </div>

                <div class="cada-input clearfix">
                    <input class="form-control" id="tbxNomeFeedBack" placeholder="Digite seu Nome" type="text" />
                </div>

                <div class="cada-input">
                    <input class="form-control" id="tbxEmailFeedBack" placeholder="Digite seu E-mail" type="email" />
                </div>

            </div>
            <div class="modal-footer">
                <div class="enviando">
                    Enviando
                    <img src="<?php echo CLOUDFRONT; ?>imagens/icone/enviando.gif" />
                </div>

                <div class="alert alert-success mensagem" id="divAlertaSucesso">
                </div>

                <div class="alert alert-danger mensagem" id="divAlertaErro">
                </div>

                <button class="btn btn-default" data-dismiss="modal" type="button">Fechar</button>
                <input class="btn btn-primary" onclick="FeedBack()" type="button" value="Enviar" />
            </div>
        </div>
    </div>
</div>


</body>
</html>

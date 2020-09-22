<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Contrato</title>

    <style type="text/css">
        body {
            font-family: arial serif;
        }

        table {
            width: 800px;
            border-collapse: collapse;
        }

        th {
            font-size: 15px;
            border: 1px solid black;
        }

        td {
            text-align: left;
            border: 1px solid black;
            font-size: 13px;
        }

        .clear td {
            border: 0px solid black;
        }

        tr,
        td,
        th {
            padding: 0px 12px 12px 12px;
            height: 50px;
        }

        .normalTable tr,
        td,
        th {
            padding: 15px;
            height: 50px;
            font-size: 15px;
        }

        thead td {
            background: lightgray;
            text-align: center;
            font-weight: bold;
        }

        .theadHorizontal {
            padding: 15px;
            background: lightgray;
            width: 300px;
            font-weight: bold;
        }

        .table-cel {
            vertical-align: text-top;
        }

        .header {
            font-size: 11px;
            font-weight: bold;
        }

        .data {
            font-size: 12px;
        }

        .opcional {
            background: lightgray;
        }

        .opcional td {
            height: 60px;
        }

        .pg {
            text-align: right;
            width: 7in;
            right: 0px;
            font-size: 10px;
        }

        .twoLine {
            border-top-width: 1px;
            border-bottom-width: 1px;
            border-top-style: solid;
            border-bottom-style: double;
            padding: 1px;
            width: 7in
        }

        .center {
            display: flex;
            text-align: center;
            justify-content: center;
        }

        .redbox {
            background: #922924;
            color: white;
        }

        .legenda {
            font-size: 10px;
        }

        .border {
            border: 1px solid black;
            padding: 5px;
        }

        .marca {
            position: absolute;

        }
    </style>
</head>

<?php $series = [
     '20ª Série' => '0.10',
     '19ª Série' => '0.20',
     '18ª Série' => '0.30',
     '17ª Série' => '0.40',
     '16ª Série' => '0.50',
     '15ª Série' => '0.60',
     '14ª Série' => '0.70',
     '13ª Série' => '0.80',
     '12ª Série' => '0.90',
     '11ª Série' => '1.00',
     '01ª Série' => '1.10',
     '02ª Série' => '1.20',
     '03ª Série' => '1.30',
     '04ª Série' => '1.40',
     '05ª Série' => '1.50',
     '06ª Série' => '1.60',
     '07ª Série' => '1.70',
     '08ª Série' => '1.80',
     '09ª Série' => '1.90',
     '10ª Série' => '2.00',
];

$serie = array_search($cliente->taxa_subs, $series);
?>

<body>

    <htmlpageheader name="header" style="display:none">

    <?php 

        if ((isset($this->session->usuario) && ($cliente->ip_subs == null || $cliente->ip_subs == '')) || (!isset($this->session->usuario) && ($cliente->ip_subs == null || $cliente->ip_subs == ''))) {

            echo "
                <div class='twoLine' style='position: absolute'></div>
                <img src='" . CLOUDFRONT . 'imagens/marca_dagua.jpeg' . "' class='marca' />
                <div style='position: fixed;right: -50px;rotate:-90;width:11in;font-size: 12;text-align:center'>
                Assinatura: ____________________ <br/>
                <b>".$cliente->nome_pes."</b> <br/>
                <b>".$cliente->doc_cliente."</b> <br/>
                </div>";
            
        } else {

            echo "
                <div class='twoLine' style='position: absolute'></div>
                <img src='" . CLOUDFRONT . 'imagens/marca_dagua.jpeg' . "' class='marca' />
                <div style='position: fixed;right: -50px;rotate:-90;width:11in;font-size: 12;text-align:center'>
                    Rubricado digitalmente pelo e-mail <b>".$cliente->email_pes."</b> propriedade de <b>".$cliente->nome_pes."</b>, identificado na rede mundial de computadores pelo 
                    Protocolo de Internet (IP) de número <b>".$cliente->ip."</b> do dia <b>".$cliente->data_aceita_subscricao."</b> - <b>".mb_strtoupper($cliente->nome_pes)." - ".$cliente->doc_cliente."</b><br/>
                </div>";
        }
    ?>
    </htmlpageheader>

    <sethtmlpageheader name="header" value="on" show-this-page="1" />

    <div class="center">
        <img src="<?= CLOUDFRONT . 'imagens/logo_pdf.png' ?>" width="200" />
        <p>
            <b>FMI SECURITIZADORA S.A.</b><br />
            Companhia Fechada 
        </p>
        <p>
            R. George Ohm, 206, Torre A, 9º andar, Cidade Monções <br />
            CEP 04576-020, São Paulo/SP <br /><br />
            CNPJ/MF 20.541.441/0001-08 <br /><br />
            ---------------o0o---------------
        </p>
        <p>
            <b>BOLETIM DE SUBSCRIÇÃO DE DEBÊNTURES NÃO CONVERSÍVEIS EM AÇÕES, COM GARANTIA REAL, <?= mb_strtoupper($serie) ?>, DA FMI SECURITIZADORA S.A.</b>
        </p>
        <div class="center">
            <span class='redbox'>
                <b>BOLETIM DE SUBSCRIÇÃO Nº <?= $cliente->num_subs.'/'.$cliente->ano ?></b>
            </span>
        </div>
    </div>

    <p class='border'>
        Boletim de subscrição (“Boletim de Subscrição”) referente à emissão de debêntures com Garantias Reais, Não Conversíveis em Ações, em 7 (sete) séries, para Distribuição Privada da FMI SECURITIZADORA S.A. 
        (Emissora), aprovada pela Assembleia Geral Extraordinária da Emissora realizada em 14 de outubro de 2015 e regulamentada pela Escritura de Emissão anexa da ata da referida assembleia, a qual 
        foi arquivada na Junta Comercial do Estado de São Paulo (JUCESP), sob o nº 0756890/15-9, em sessão de 31 de agosto de 2015.
        <br /><br />

        Exceto se especificamente definidos neste Boletim de Subscrição, os termos aqui utilizados iniciados em letras maiúsculas terão o significado a eles atribuído na Escritura de Emissão.
    </p>

    <div class="center">
        <p>
            <b>I. QUALIFICAÇÃO DO DEBENTURISTA SUBSCRITOR</b>
        </p>
    </div>

    <table>
        <tbody>
            <tr>

                <td class="table-cel" colspan=4>
                    <div class="header"> 1. Nome </div>
                    <div class="data"><?= ucwords($cliente->nome_pes) ?></div>
                </td>

                <td class="table-cel">
                    <div class="header"> 2. Nacionalidade </div>
                    <div class="data">Brasileiro</div>
                </td>

                <td class="table-cel">
                    <div class="header"> 3. Data Nascimento </div>
                    <div class="data"><?= $cliente->dtnascimento_pes ? Mysql_to_Data($cliente->dtnascimento_pes) : '' ?></div>
                </td>

            </tr>

            <tr>
                <td class="table-cel" colspan=2>
                    <div class="header"> 4. CPF/CNPJ </div>
                    <div class="data"><?= $cliente->cnpj_pes ? $cliente->cnpj_pes : $cliente->cpf_pes ?></div>
                </td>

                <td class="table-cel" colspan=2>
                    <div class="header"> 5. Doc. de Identidade </div>
                    <div class="data"><?= $cliente->rg_pes ?></div>
                </td>

                <td class="table-cel">
                    <div class="header"> 6. Órgão Emissor </div>
                    <div class="data"><?= $cliente->org_emissor_pes ?></div>
                </td>

                <td class="table-cel">
                    <div class="header"> 7. Estado Civil </div>
                    <div class="data"><?= $cliente->est_civil_pes ?></div>
                </td>

            </tr>

            <tr class='opcional'>

                <td class="table-cel" colspan=3>
                    <div class="header"> 7.1. Nome do Cônjuge (se aplicável) </div>
                    <div class="data"><?= $cliente->nome_conjuge != '' & $cliente->nome_conjuge != null && $cliente->ativo_conjuge == 1 ? $cliente->nome_conjuge : '' ?></div>
                </td>

                <td class="table-cel">
                    <div class="header"> 7.1.1. Nacionalidade </div>
                    <div class="data"><?= $cliente->nacionalidade_conjuge != '' & $cliente->nacionalidade_conjuge != null && $cliente->ativo_conjuge == 1 ? $cliente->nacionalidade_conjuge : '' ?></div>
                </td>

                <td class="table-cel">
                    <div class="header"> 7.1.2. Data Nascimento </div>
                    <div class="data"><?= $cliente->dtnascimento_conjuge != '' & $cliente->dtnascimento_conjuge != null && $cliente->ativo_conjuge == 1 ? Mysql_to_Data($cliente->dtnascimento_conjuge) : '' ?></div>
                </td>

                <td class="table-cel">
                    <div class="header"> 7.1.3. CPF</div>
                    <div class="data"><?= $cliente->cpf_conjuge != '' & $cliente->cpf_conjuge != null && $cliente->ativo_conjuge == 1 ? $cliente->cpf_conjuge : '' ?></div>
                </td>

            </tr>

            <tr>

                <td class="table-cel" colspan=4>
                    <div class="header"> 8. Endereço (Rua, Av.) </div>
                    <div class="data"><?= ucwords($cliente->endereco_pes) ?></div>
                </td>

                <td class="table-cel">
                    <div class="header"> 8.1. Nº </div>
                    <div class="data"><?= $cliente->numero_pes ?></div>
                </td class="table-cel">

                <td class="table-cel">
                    <div class="header"> 8.2. Complemento </div>
                    <div class="data"><?= ucwords($cliente->complemento_pes) ?></div>
                </td>

            </tr>

            <tr>

                <td class="table-cel">
                    <div class="header"> 8.3. Bairro </div>
                    <div class="data"><?= ucwords($cliente->bairro_pes) ?></div>
                </td>

                <td class="table-cel"> 
                    <div class="header"> 8.4. CEP </div>
                    <div class="data"><?= $cliente->cep_pes ?></div>
                </td>

                <td class="table-cel" colspan=2>
                    <div class="header"> 8.5. Cidade </div>
                    <div class="data"><?= ucwords($cliente->nome_cid) ?></div>
                </td>

                <td class="table-cel">
                    <div class="header"> 8.6. UF </div>
                    <div class="data"><?= $cliente->uf_est ?></div>
                </td>

                <td class="table-cel">
                    <div class="header"> 9. E-mail </div>
                    <div class="data"><?= $cliente->email_pes ?></div>
                </td>

            </tr>

            <tr>

                <td class="table-cel" colspan=2>
                    <div class="header"> 10. Telefone residencial </div>
                </td>

                <td class="table-cel" colspan=2>
                    <div class="header"> 11. Telefone comercial </div>
                    <div class="data"><?= strlen($cliente->telefone_pes) <= 13 ? $cliente->telefone_pes : '' ?></div>
                </td>

                <td class="table-cel" colspan=2>
                    <div class="header"> 12. Telefone celular </div>
                    <div class="data"><?= strlen($cliente->telefone_pes) >= 14 ? $cliente->telefone_pes : '' ?></div>
                </td>

            </tr>

            <tr class='opcional'>

                <td class="table-cel" colspan=4>
                    <div class="header"> 13. Nome Completo do(s) Representante(s) Legal(is) (se aplicável) </div>
                </td>

                <td class="table-cel" colspan=2>
                    <div class="header"> 13.1. CPF </div>
                </td>

            </tr>

            <tr class='opcional'>

                <td class="table-cel" colspan=2>
                    <div class="header"> 13.2. Endereço (Rua, Av.) </div>
                </td>

                <td class="table-cel" colspan=2>
                    <div class="header"> 13.3. Nº </div>
                </td>

                <td class="table-cel" colspan=2>
                    <div class="header"> 13.4. Complementos </div>
                </td>

            </tr>

            <tr class='opcional'>

                <td class="table-cel">
                    <div class="header"> 13.5. Bairro </div>
                </td>

                <td class="table-cel" colspan=2>
                    <div class="header"> 13.6. CEP </div>
                </td>

                <td class="table-cel">
                    <div class="header"> 13.7. Cidade </div>
                </td>

                <td class="table-cel">
                    <div class="header"> 13.8. UF </div>
                </td>

                <td class="table-cel">
                    <div class="header"> 13.9. E-mail </div>
                </td>

            </tr>

            <tr class='opcional'>

                <td class="table-cel" colspan=2>
                    <div class="header"> 13.10. Telefone residencial </div>
                </td>

                <td class="table-cel" colspan=2>
                    <div class="header"> 13.11. Telefone comercial </div>
                </td>

                <td class="table-cel" colspan=2>
                    <div class="header"> 13.12. Telefone celular </div>
                </td>

            </tr>

        </tbody>

    </table>

    <div class="center">
        <p>
            <b>II. DEBÊNTURES SUBSCRITAS</b>
        </p>
    </div>

    <table>

        <thead>

            <tr>

                <td>Espécie</td>
                <td>Forma</td>
                <td>Série</td>
                <td>Quantidade</td>
                <td>Valor Nominal Unitário em R$</td>
                <td>Valor Total Subscrito em R$</td>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>Com Garantia Real</td>
                <td>Nominativa</td>
                <td><?= $serie ?></td>
                <td><?= $cliente->quantidade ?></td>
                <td>1.000,00</td>
                <td><?= $cliente->valor_subscricao ?></td>

            </tr>

        </tbody>

    </table>

    <br />

    <div class="center">
        <p>
            <b>III. FORMA DE INTEGRALIZAÇÃO</b>
        </p>
    </div>

    <p>
        As Debêntures serão integralizadas em moeda corrente nacional, mediante transferência de recursos oriundos da conta indicada no item III.1 abaixo para conta corrente de titularidade da Emissora indicada no item III.2 abaixo.
    </p>

    <table class="normalTable">

        <tbody>

            <tr>

                <td class='theadHorizontal'>III.1 Conta de Origem dos Recursos</td>

                <td>
                    <p>
                        Banco - <?= explode('|sep|', $cliente->banco_pes)[0] ?><br />
                        Agência nº <?= explode('|sep|', $cliente->agencia_pes)[0] ?><br />
                        Conta corrente nº <?= explode('|sep|', $cliente->conta_pes)[0] ?><br />
                        Titular da conta: <?= explode('|sep|', $cliente->nometitular_pes)[0] ?><br />
                    </p>
                </td>

            </tr>

            <tr>

                <td class='theadHorizontal'>III.2 Conta da Emissora</td>

                <td>
                    <p>
                        Banco Itaú - nº 341 <br />
                        Agência nº 8719 <br />
                        Conta corrente nº 27505-2 <br />
                        Titular da conta: FMI SECURITIZADORA S.A.<br />
                    </p>
                </td>

            </tr>

        </tbody>

    </table>

    <p class="legenda">
        (Ressalva-se a possibilidade de alteração de contas, devidamente comunicada à Emissora, nos moldes constantes da Escritura de Emissão)
    </p>

    <br />
    <pagebreak />

    <div class="center">
        <p>
            <b>IV. FORMA DE DEVOLUÇÃO</b>
        </p>
    </div>

    <p>
        Os valores pecuniários da Remuneração Líquida, da Recompra, da Aquisição Facultativa, do Vencimento Antecipado e da Opção de Liquidação serão pagos, pela Emissora, em moeda corrente nacional, mediante a transferência para conta corrente de titularidade do Debenturista Subscritor indicada abaixo (“<u>Conta de Devolução</u>”).
    </p>

    <table class="normalTable">

        <tbody>

            <tr>

                <td class='theadHorizontal'>Conta de Devolução</td>

                <td>
                    <p>
                        Banco - <?= explode('|sep|', $cliente->banco_pes)[0] ?><br />
                        Agência nº <?= explode('|sep|', $cliente->agencia_pes)[0] ?><br />
                        Conta corrente nº <?= explode('|sep|', $cliente->conta_pes)[0] ?><br />
                        Titular da conta: <?= explode('|sep|', $cliente->nometitular_pes)[0] ?><br />
                    </p>
                </td>

            </tr>

        </tbody>

    </table>

    <p class="legenda">
        (Ressalva-se a possibilidade de alteração de contas, devidamente comunicada à Emissora, nos moldes constantes da Escritura de Emissão)
    </p>

    <br />

    <div class="center">
        <p>
            <b>V. CAPITALIZAÇÃO DA REMUNERAÇÃO LÍQUIDA</b>
        </p>
    </div>

    <p>
        O Debenturista Subscritor, mediante a assinalação da opção afirmativa e a assinatura nos espaços abaixo, opta pela Capitalização da Remuneração Líquida, conforme definida e regulamentada na Escritura de Emissão.
    </p>

    <table class="normalTable">

        <tbody>

            <tr>

                <td class='theadHorizontal'>
                    Escolha se opta ou não pela Capitalização da Remuneração Líquida, assinale abaixo e assine ao lado: <br /><br />

                    <?php if ($cliente->reinvestir) {
                        echo'( X ) Sim, opto &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (&nbsp;&nbsp;&nbsp;) Não opto';
                    } else {
                        echo'(&nbsp;&nbsp;&nbsp;) Sim, opto &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( X ) Não opto';
                    }
                    
                    ?>
                </td>

                <td>
                    <?php if (!empty($cliente->ip_subs)) {
                            echo "  <p>

                                        Assinado digitalmente pelo e-mail <b>".$cliente->email_pes."</b> propriedade de <b>".$cliente->nome_pes."</b>, identificado na rede mundial de computadores pelo <br/>
                                        Protocolo de Internet (IP) de número <b>".$cliente->ip."</b> do dia <b>".$cliente->data_aceita_subscricao."</b> - <b>".mb_strtoupper($cliente->nome_pes)." - ".$cliente->doc_cliente."</b><br/>

                                    </p>";
                        } else {
                            echo '  <p>
                                        Assinatura: <br /><br /><br /><br />
                                        _____________________________________
                                    </p>';
                        }
                    ?>                    
                </td>

            </tr>

        </tbody>

    </table>

    <br />

    <sethtmlpageheader name="header" value="off" />

    <div class="center">
        <p>
            <b>VI. CLÁUSULAS CONTRATUAIS</b>
        </p>
    </div>

    <p class='border'>

        1. O Debenturista Subscritor declara que, por ter pleno conhecimento da Escritura de Emissão, de seu inteiro teor e de todos os seus termos e condições, a ela se vincula, pelo presente ato, como a parte lá definida como “Debenturista”.
        <br /><br />

        2. Este Boletim de Subscrição tem efeito, ainda, de Autorização de Subscrição, nos termos da Escritura de Emissão.
        <br /><br />

        3. Nos termos deste Boletim de Subscrição, a Emissora entrega ao Debenturista Subscritor, identificado no item I acima, as Debêntures indicadas no item II acima.
        <br /><br />

        4. As Debêntures serão integralizadas pelo Valor Nominal Unitário de cada uma, em moeda corrente nacional, mediante transferência de recursos para conta corrente de titularidade da Emissora identificada acima.
        <br /><br />

        5. Nos termos do que consta na Escritura de Emissão, este Boletim de Subscrição é celebrado em caráter irrevogável e irretratável, obrigando as partes por si e por seus sucessores a qualquer título.
        <br /><br />

        6. Para dirimir as questões oriundas deste Boletim de Subscrição ou da Escritura de Emissão, com renúncia expressa a qualquer foro, por mais privilegiado que seja ou venha a ser, as partes obrigam-se ao procedimento de Resolução Amigável de Disputa e à Arbitragem, conforme definidos na Escritura de Emissão.
        <br /><br />

        7. Para todos os efeitos jurídicos, considera-se que o presente Boletim de Subscrição foi celebrado na Comarca de São Paulo/SP.
    </p>

    <p class="border">
        <b>
            POR FIM, EU, DEBENTURISTA SUBSCRITOR, DECLARO (1) TER OBTIDO PREVIAMENTE EXEMPLAR DA ESCRITURA DE EMISSÃO E (2) TER CONHECIMENTO DOS RISCOS DA OPERAÇÃO, EM ESPECIAL OS RELACIONADOS AO PAGAMENTO DA REMUNERAÇÃO 
            E DO VALOR NOMINAL UNITÁRIO DAS DEBÊNTURES INTEGRALIZADAS E AO INADIMPLIMENTO DE RECEBÍVEIS JÁ ADQUIRIDOS OU QUE VENHAM A SER ADQUIRIDOS.
        </b>
    </p>

    <p>
        E, por assim estarem justas e contratadas, firmam as partes o presente Boletim de Subscrição, apondo suas assinaturas nos campos abaixo, em três vias de igual teor e para um só efeito.
    </p>

    <?php if (empty($cliente->ip_subs))  {?>

        <table class="clear">

            <tbody>

                <tr>

                    <td class="center">
                        <p>
                            São Paulo, <?= $cliente->data_subscricao ?> <br /><br /><br /><br />
                            _______________________________ <br /><br />
                            <b>CLIENTE</b> <br />
                        </p>
                    </td>

                    <td class="center">
                        <p>
                            São Paulo, <?= $cliente->data_subscricao ?> <br /><br /><br /><br />
                            _______________________________ <br /><br />
                            <b>FMI SECURITIZADORA S.A.</b> <br />
                        </p>
                    </td>

                </tr>

                <tr>

                    <td>
                        <p><br /><br /><br />
                            TESTEMUNHAS <br /><br /><br /><br />
                            _________________________________________ <br /><br />
                            NOME: <br />
                            CPF:
                        </p>
                    </td>

                    <td>
                        <p><br /><br /><br />
                            <br /><br /><br /><br />
                            _________________________________________ <br /><br />
                            NOME: <br />
                            CPF:
                        </p>
                    </td>

                </tr>

            </tbody>

        </table>

    <?php } else { ?>

        <br>
        <br>
    
        <div>
    
            <b>
                <u><?= mb_strtoupper($cliente->nome_pes) ?> - <?= $cliente->cnpj_pes ? 'CNPJ '.$cliente->cnpj_pes : 'CPF '.$cliente->cpf_pes ?></u>
            </b>
    
            <p>
                Assinado digitalmente pelo e-mail <b><?= $cliente->email_pes ?></b> propriedade de <b><?= $cliente->nome_pes ?></b>, identificado na rede mundial de computadores pelo <br/>
                Protocolo de Internet (IP) de número <b><?= $cliente->ip ?></b> do dia <b><?= $cliente->data_aceita_subscricao ?></b> - <b><?= mb_strtoupper($cliente->nome_pes) . ' - ' . $cliente->doc_cliente ?></b><br/>
            </p>
    
        </div>
    
        <br>
    
        <div>
    
            <b>
                <u>FMI SECURITIZADORA S.A. Companhia Fechada - CNPJ/MF 20.541.441/0001-08</u>
            </b>
    
            <p>Assinado digitalmente na plataforma gerida pela empresa na rede mundial de computadores 
            (<a><u style="color:blue">www.fmisa.com.br</u><a/>).</p>
    
        </div>
        
    <?php } ?>

</body>

</html>
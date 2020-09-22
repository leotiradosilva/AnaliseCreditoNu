<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 07/03/18
 * Time: 10:48
 */?>

<!DOCTYPE html>
<html>
<head>
    <title>Extrato - FMI SECURITIZADORA S/A</title>
    <style type="text/css">
        #outtable{
            margin-top: 0px !important;
            padding: 0px;
            #border:1px solid #e3e3e3;
            width:600px;
            border-radius: 5px;
        }
        .short{
            width: 50px;
        }
        .normal{
            width: 150px;
        }
        table{
            border-collapse: collapse;
            font-family: arial;
            color:#5E5B5C;
        }
        thead th{
            text-align: left;
            padding: 10px;
            color: white;
            background-color: #00ade6;
        }
        tbody td{
            border-top: 1px solid #e3e3e3;
            padding: 10px;
        }
        tbody tr:nth-child(even){
            background: #F6F5FA;
        }
        tbody tr:hover{
            background: #EAE9F5
        }
    </style>
</head>
<body>
<div id="outtable">
    <div style="padding: 0px;">
        <h3>Extrato Subscrição - FMI SECURITIZADORA S/A</h3>
        <p><span>Subscrição: Todos</span><span style="padding-left: 100px;">Cliente: <?= $user?></span></p>
        <p>Periodo: <?= $datai ?> - <?= $dataf ?></p>
    </div>
    <table>
        <thead>
        <tr>
            <th class="short">Data</th>
            <th class="normal">Descrição</th>
            <th class="normal">Valor</th>
            <th class="normal">Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $no=1; ?>
        <?php foreach($extrato as $user): ?>
            <tr>
                <td><?php echo $user['data']; ?></td>
                <td><?php echo $user['description']; ?></td>
                <td><?php echo $user['value']; ?></td>
                <td><?php echo $user['total']; ?></td>
            </tr>
            <?php $no++; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>

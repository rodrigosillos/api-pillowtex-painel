<?php

include('call-api.php');
include('connection-db.php');

$stmt = $pdo->prepare("select operation_code, operation_type, commission_amount from invoices where issue_date between '2021-01-01' and '2021-07-31'");
$stmt->execute();
$movimentacoes = $stmt->fetchAll();

foreach ($movimentacoes as $movimentacao) {

    $operacaoCodigo = $movimentacao["operation_code"];
    $operacaoTipo = $movimentacao["operation_type"];
    $comissaoMovimentacao = $movimentacao["commission_amount"];

    

}

$pdo = null;

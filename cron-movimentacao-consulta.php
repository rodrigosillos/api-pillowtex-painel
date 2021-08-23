<?php

include('call-api.php');
include('connection-db.php');

$stmt = $pdo->prepare("select cod_operacao from lista_movimentacao");
$stmt->execute();
$movimentacoes = $stmt->fetchAll();

foreach ($movimentacoes as $movimentacao) {

    $codOperacao = $movimentacao["cod_operacao"];

    $dataConsultaMovimentacao = [
        'tipo_operacao' => $operationType,
        'cod_operacao' => $valueListaMovimentacao['cod_operacao'],
        'ujuros' => 'false',
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];
    
    $responseConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $dataConsultaMovimentacao);
    $resultConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaMovimentacao), true);

}

$pdo = null;

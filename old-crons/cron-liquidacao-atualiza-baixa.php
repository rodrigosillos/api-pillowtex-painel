<?php

include('call-api.php');
include('connection-db.php');

$stmt = $pdo->prepare("select numero_lancamento from lancamentos where efetuado = 0");
$stmt->execute();
$lancamentos = $stmt->fetchAll();

foreach ($lancamentos as $lancamento) {

    $numeroLancamento = $lancamento['numero_lancamento'];

    $queryParams = [
        'lancamento' => trim($numeroLancamento),
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];

    $responseTitulosReceberConsulta = CallAPI('GET', 'titulos_receber/consulta', $queryParams);
    $resultTitulosReceberConsulta = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseTitulosReceberConsulta), true);

    $dataPagamento = date_create($resultTitulosReceberConsulta['value'][0]['data_pagamento']);
    $dataPagamento = date_format($dataPagamento, "Y-m-d H:i:s");
    $efetuado = $resultTitulosReceberConsulta['value'][0]['efetuado'];

    print($numeroLancamento . ' -- ' . $efetuado) . "\xA";

}

$pdo = null;

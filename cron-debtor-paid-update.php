<?php

include('call-api.php');
include('connection-db.php');

$fh = fopen('data-bookentry-0308.txt','r');
while ($lancamento = fgets($fh)) {

    $queryParams = [
        'lancamento' => trim($lancamento),
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];

    $responseTitulosReceberConsulta = CallAPI('GET', 'titulos_receber/consulta', $queryParams);
    $resultTitulosReceberConsulta = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseTitulosReceberConsulta), true);

    $dataPagamento = date_create($resultTitulosReceberConsulta['value'][0]['data_pagamento']);
    $dataPagamento = date_format($dataPagamento, "Y-m-d H:i:s");
    $efetuado = $resultTitulosReceberConsulta['value'][0]['efetuado'];

    $bindParams = [
        'paid_date' => $dataPagamento,
        'effected' => $efetuado,
    ];

    $stmt = $pdo->prepare("update debtors SET paid_date = :paid_date, effected = :effected  where id = :debtor_id");
    $stmt->execute($bindParams);

}
fclose($fh);

$pdo = null;

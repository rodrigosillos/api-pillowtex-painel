<?php

include('connection-db.php');

$sql = "select ";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$representantes = $stmt->fetchAll();

foreach ($representantes as $representante) {

    $representanteID = $representante["agent_id2"];
    $representanteCodigo = $representante["agent_code"];

    $data = [
        'efetuado' => $efetuado,
        'data_pagamento' => $dataPagamento,
        'numero_lancamento' => $lancamentoValue['lancamento'],
        'numero_documento' => $lancamentoValue['n_documento'],
    ];

    $sql = "update lancamentos set representante = :representante where representante = '".$representanteID."' and numero_lancamento = '".$lancamentoNumero."'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

$pdo = null;

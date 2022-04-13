<?php

include('call-api.php');
include('connection-db.php');

$sql = "select n_documento, origem from titulos_receber where data_pagamento between '2022-03-01' and '2022-03-31'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$titulosReceber = $stmt->fetchAll();

foreach ($titulosReceber as $tituloReceber) {

    $tituloNumero = explode('/', $tituloReceber["n_documento"]);
    $origem = $tituloReceber["origem"];

    $numeroParcelas = $pdo->query("select count(*) from titulos_receber where n_documento like '%".$tituloNumero[0]."%'")->fetchColumn();
    print('n_documento: ' . $tituloNumero[0] . ' - origem: ' . $origem . ' - n parcelas: ' . $numeroParcelas . "\xA");

}

$pdo = null;

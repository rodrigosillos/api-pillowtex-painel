<?php

include('call-api-novo.php');
include('connection-db.php');

$sql = "select n_documento, origem from titulos_receber where data_pagamento between '2022-03-01' and '2022-03-31'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$titulosReceber = $stmt->fetchAll();

foreach ($titulosReceber as $tituloReceber) {

    $tituloNumero = explode('/', $tituloReceber["n_documento"]);
    $origem = $tituloReceber["origem"];

    if($origem) {

        $sql = "select valor_comissao from movimentacao where cod_operacao = :cod_operacao";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cod_operacao', $origem, PDO::PARAM_STR);
        $stmt->execute();
        $movimentacao = $stmt->fetch(\PDO::FETCH_ASSOC);

        $valorComissao = 0;

        if ($stmt->rowCount() > 0)
            $valorComissao = $movimentacao['valor_comissao'];

        $numeroParcelas = $pdo->query("select count(*) from titulos_receber where n_documento like '%".$tituloNumero[0]."%'")->fetchColumn();
        print('n_documento: ' . $tituloNumero[0] . ' - origem: ' . $origem . ' - n parcelas: ' . $numeroParcelas . ' - valor comissão: ' . $valorComissao . "\xA");
    } 

}

$pdo = null;

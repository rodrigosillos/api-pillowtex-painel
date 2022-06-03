<?php

include('call-api.php');
include('connection-db.php');

$sql = "select cod_operacao from movimentacao where tipo_pedido like '%PET%'";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$movimentacoes = $stmt->fetchAll();

foreach ($movimentacoes as $movimentacaoNF) {

    $data = [
        'cod_operacao' => $movimentacaoNF['cod_operacao'],
    ];

    $sql = "delete from movimentacao where cod_operacao = :cod_operacao";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

$pdo = null;

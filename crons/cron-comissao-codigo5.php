<?php

include('connection-db.php');

$sql = "select cod_operacao, romaneio, ticket, notas, tipo_pedido, evento from movimentacao where notas = ''";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$movimentacoes = $stmt->fetchAll();

foreach ($movimentacoes as $movimentacao) {

    $codOperacao = $movimentacao['cod_operacao'];
    $romaneio = $movimentacao['romaneio'];
    $ticket = $movimentacao['ticket'];
    $notas = $movimentacao['notas'];
    $tipoPedido = $movimentacao['tipo_pedido'];
    $evento = $movimentacao['evento'];

    $sql = "select cod_operacao, tipo_pedido FROM movimentacao where ticket = :romaneio";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':romaneio', $romaneio, PDO::PARAM_STR);
    $stmt->execute();
    $movimentacaoCodigo5 = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0)
        print('tipo pedido: ' . $tipoPedido . ' -------- tipo de pedido sem nota: ' . $movimentacaoCodigo5['tipo_pedido'] . "\xA");

}

$pdo = null;

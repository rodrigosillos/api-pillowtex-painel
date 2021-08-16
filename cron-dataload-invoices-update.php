<?php

include('call-api.php');
include('connection-db.php');

$countItem = 0;
$invoiceFilial = 0;

// $sql = "select operation_code, operation_type from invoices where issue_date between '2021-07-01' and '2021-07-31'";
// $sql = "select operation_code, operation_type from invoices where agent_id = '263'";
$sql = "select operation_code, operation_type from invoices where operation_code = '543791'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoices = $stmt->fetchAll();

foreach ($invoices as $invoice__) {

    $operationCode = $invoice__["operation_code"];  
    $operationType = $invoice__["operation_type"];

    $dataConsultaMovimentacao = [
        'tipo_operacao' => $operationType,
        'cod_operacao' => $operationCode,
        'ujuros' => 'false',
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];
    
    $responseConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $dataConsultaMovimentacao);
    $resultConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaMovimentacao), true);

    $pedido = $resultConsultaMovimentacao['value'][0]['produtos'][0]['pedido'];

    $dataConsultaPedidoVenda = [
        'pedidov' => $pedido,
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];

    $responseConsultaPedidoVenda = CallAPI('GET', 'pedido_venda/consulta_simples', $dataConsultaPedidoVenda);
    $resultConsultaPedidoVenda = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaPedidoVenda), true);
    $invoiceType = $resultConsultaPedidoVenda['value'][0]['tipo_pedido'];

    $data = [
        'invoice_type' => $invoiceType,
        'operation_code' => $operationCode,
    ];
    
    $sql = "update invoices SET invoice_type = :invoice_type where operation_code = :operation_code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

    $countItem++;
    print($countItem . ' - ' . $operationCode . "\xA");

}

$pdo = null;

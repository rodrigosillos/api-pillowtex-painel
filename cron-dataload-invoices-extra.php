<?php

include('call-api.php');
include('connection-db.php');

$operationTypes = ['S', 'E']; // Entrada (Dedução) / Saida (Faturamento 50% / Substituição / Liquidição)

$countItem = 0;
$invoiceFilial = 0;

//$sql = "select operation_code, operation_type from invoices where issue_date between '2021-06-01' and '2021-05-08'";
$sql = "select operation_code, operation_type from invoices";
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

    // join client
    $dataConsultaCliente = [
        'cliente' => $resultConsultaMovimentacao['value'][0]['cliente'],
        '$format' => 'json',
    ];

    $responseConsultaCliente = CallAPI('GET', 'clientes/consultasimples', $dataConsultaCliente);
    $resultConsultaCliente = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaCliente), true);
    
    $clientCode = '';
    $clientName = '';
    $clientAddress = '';

    if ($resultConsultaCliente['odata.count'] > 0) {
        $clientCode = $resultConsultaCliente['value'][0]['cod_cliente'];
        $clientName = $resultConsultaCliente['value'][0]['nome'];
        $clientAddress = $resultConsultaCliente['value'][0]['estado'];
    }

    /*
    $dataConsultaRepresentante = [
        'representante' => $resultConsultaMovimentacao['value'][0]['representante'],
        '$format' => 'json',
    ];

    $responseConsultaRepresentante = CallAPI('GET', 'representantes/consulta', $dataConsultaRepresentante);
    $resultConsultaRepresentante = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaRepresentante), true);
    
    $agentCode = '';
    $agentName = '';

    if ($resultConsultaRepresentante['odata.count'] > 0) {
        $agentCode = $resultConsultaRepresentante['value'][0]['cod_representante'];
        $agentName = $resultConsultaRepresentante['value'][0]['geradores'][0]['nome'];
    }
    */

    $data = [
        'client_code' => $clientCode,
        'client_name' => $clientName,
        'client_address' => $clientAddress,
        'operation_code' => $operationCode,
    ];
    
    $sql = "update invoices SET client_code = :client_code, client_name = :client_name, client_address = :client_address where operation_code = :operation_code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

    $countItem++;
    print($countItem . ' - ' . $operationType . "\xA");

}

$pdo = null;

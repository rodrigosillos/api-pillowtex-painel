<?php

include('call-api.php');
include('connection-db.php');

$countItem = 0;
$invoiceFilial = 0;

//$sql = "select operation_code, operation_type from invoices where issue_date between '2021-06-01' and '2021-05-08'";
$sql = "select operation_code, operation_type from invoices where operation_code = '539722'";
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

    $valorTotal = $resultConsultaMovimentacao['value'][0]['total'];

    $data = [
        'amount_withouttax' => $valorTotal,
        'operation_code' => $operationCode,
    ];
    
    $sql = "update invoices SET amount_withouttax = :amount_withouttax where operation_code = :operation_code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

    $countItem++;
    print($countItem . ' - ' . $operationCode . "\xA");

}

$pdo = null;

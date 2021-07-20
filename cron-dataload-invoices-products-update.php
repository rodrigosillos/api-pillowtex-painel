<?php

include('call-api.php');
include('connection-db.php');

$countItem = 0;

//$sql = "select operation_code, operation_type from invoices where issue_date between '2021-06-01' and '2021-05-08'";
$sql = "select operation_code, operation_type from invoices where agent_id = '263'";
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

    foreach($resultConsultaMovimentacao['value'][0]['produtos'] as $valueProduct) {
        
        $productApplied = $valueProduct['preco_aplicado'];
        $productGross = $valueProduct['preco_bruto'];

        $data = [
            'price_applied' => $productApplied,
            'price_gross' => $productGross,
            'operation_code' => $operationCode,
        ];
        
        $sql = "update invoices_product SET price_applied = :price_applied, price_gross = :price_gross where operation_code = :operation_code";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
    
        $countItem++;
        print($countItem . ' - ' . $operationCode . "\xA");
    }



}

$pdo = null;

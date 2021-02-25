<?php

include('call-api.php');

$operationType = 'E'; // Entrada / Saida

$dataListaMovimentacao = [
    'datai' => '2021-01-20',
    'dataf' => '2021-01-20',
    '$format' => 'json',
    'tipo_operacao' => $operationType,
];

$responseListaMovimentacao = CallAPI('GET', 'movimentacao/lista_movimentacao', $dataListaMovimentacao);
$resultListaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseListaMovimentacao), true);

$pdo = new PDO('mysql:host=db;dbname=pillowtex', 'root', 'qcLkozSAB3L4rp2TTUN7rJVlJa9C1CTb9hcdSLhcuiA=');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach ($resultListaMovimentacao['value'] as $valueListaMovimentacao) {
    
    $dataConsultaMovimentacao = [
        'tipo_operacao' => $operationType,
        'cod_operacao' => $valueListaMovimentacao['cod_operacao'],
        'ujuros' => 'false',
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];

    $responseConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $dataConsultaMovimentacao);
    $resultConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaMovimentacao), true);

    $invoiceFilial = $resultConsultaMovimentacao['value'][0]['filial'];

    $issue_date = date_create($resultConsultaMovimentacao['value'][0]['data']);
    $issue_date = date_format($issue_date, "Y-m-d H:i:s");

    // client
    $dataConsultaCliente = [
        'cliente' => $resultConsultaMovimentacao['value'][0]['cliente'],
        '$format' => 'json',
    ];

    $responseConsultaCliente = CallAPI('GET', 'clientes/consulta', $dataConsultaCliente);
    $resultConsultaCliente = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaCliente), true);
    
    $client_name = "";
    $client_address = "";
    if ($resultConsultaCliente['odata.count'] > 0) {
        $client_name = $resultConsultaCliente['value'][0]['geradores'][0]['nome'];
        $client_address = $resultConsultaCliente['value'][0]['geradores'][0]['ufie'];
    }

    // agent
    $dataConsultaRepresentante = [
        'representante' => $resultConsultaMovimentacao['value'][0]['representante'],
        '$format' => 'json',
    ];

    $responseConsultaRepresentante = CallAPI('GET', 'representantes/consulta', $dataConsultaRepresentante);
    $resultConsultaRepresentante = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaRepresentante), true);
    
    $agent_name = "";
    if ($resultConsultaRepresentante['odata.count'] > 0)
        $agent_name = $resultConsultaRepresentante['value'][0]['geradores'][0]['nome'];

    $data = [
        'operation_code' => $valueListaMovimentacao['cod_operacao'],
        'document' => $resultConsultaMovimentacao['value'][0]['romaneio'],
        'issue_date' => $issue_date,
        'client_id' => $resultConsultaMovimentacao['value'][0]['cliente'],
        'client_name' => $client_name,
        'client_address' => $client_address,
        'agent_id' => $resultConsultaMovimentacao['value'][0]['representante'],
        'agent_name' => $agent_name,
        'price_list' => $resultConsultaMovimentacao['value'][0]['tabela'],
        'amount' => $resultConsultaMovimentacao['value'][0]['total'],
        'invoice_type' => 'Dedução',
        'operation_type' => $operationType,
    ];

    if($invoiceFilial == 12 || $invoiceFilial == 16) {

        $sql  = "INSERT INTO invoices (
            operation_code,
            document,
            issue_date, 
            client_id, 
            client_name, 
            client_address, 
            agent_id,
            agent_name,
            price_list,
            amount, 
            invoice_type,
            operation_type) VALUES (
                                :operation_code,
                                :document,
                                :issue_date,
                                :client_id,
                                :client_name,
                                :client_address,
                                :agent_id,
                                :agent_name,
                                :price_list,
                                :amount,
                                :invoice_type,
                                :operation_type)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }
}

$pdo = null;

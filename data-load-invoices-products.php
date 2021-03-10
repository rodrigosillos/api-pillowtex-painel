<?php

include('call-api.php');
include('connection-db.php');

$sql = "select operation_code from invoices";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoicesAgents = $stmt->fetchAll();

$operationType = 'S';

foreach ($invoicesAgents as $invoice__) {
    $operationCode = $invoice__["operation_code"];

    $dataConsultaMovimentacao = [
        'tipo_operacao' => $operationType,
        'cod_operacao' => $operationCode,
        'ujuros' => 'false',
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];

    $responseConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $dataConsultaMovimentacao);
    $resultConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaMovimentacao), true);

    $invoiceFilial = 0;
    $invoiceAgent = 0;

    if ($resultConsultaMovimentacao['odata.count'] > 0) {
        $invoiceFilial = $resultConsultaMovimentacao['value'][0]['filial'];
        $invoiceAgent = $resultConsultaMovimentacao['value'][0]['representante'];
    }

    foreach($resultConsultaMovimentacao['value'][0]['produtos'] as $valueProduct) {

        // product
        $dataConsultaProduto = [
            'produto' => $valueProduct['produto'],
            '$format' => 'json',
        ];

        $responseConsultaProduto = CallAPI('GET', 'produtos/consulta', $dataConsultaProduto);
        $resultConsultaProduto = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaProduto), true);
        
        $productNname = "";
        $divisionId = "";
        
        if($resultConsultaProduto['odata.count'] > 0) {
            $productNname = $resultConsultaProduto['value'][0]['descricao1'];
            $divisionId = $resultConsultaProduto['value'][0]['divisao'];
        }

        // category
        $dataConsultaDivisao = [
            'divisao' => $divisionId,
            '$format' => 'json',
        ];

        $responseConsultaDivisao = CallAPI('GET', 'divisoes/consulta', $dataConsultaDivisao);
        $resultConsultaDivisao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaDivisao), true);

        $divisionCode = 000;
        $divisionDescription = "";
        
        if($resultConsultaDivisao['odata.count'] > 0) {
            $divisionCode = $resultConsultaDivisao['value'][0]['cod_divisao'];
            $divisionDescription = $resultConsultaDivisao['value'][0]['descricao'];
        }

        $data = [
            'operation_code' => $operationCode,
            'document' => $resultConsultaMovimentacao['value'][0]['romaneio'],
            'order_id' => $valueProduct['pedido'],
            'invoice' => $valueProduct['nota'],
            'product_id' => $valueProduct['produto'],
            'product_name' => $productNname,
            'division_id' => $divisionId,
            'division_code' => $divisionCode,
            'division_description' => $divisionDescription,
            'quantity' => $valueProduct['quantidade'],
            'price' => $valueProduct['preco'],
            'discount' => $valueProduct['desconto'],
        ];

        $sql  = "INSERT INTO invoices_product (
                                            operation_code,
                                            document,
                                            order_id, 
                                            invoice, 
                                            product_id,
                                            product_name,
                                            division_id,
                                            division_code,
                                            division_description,
                                            quantity,
                                            price, 
                                            discount) VALUES (
                                                            :operation_code,
                                                            :document,
                                                            :order_id,
                                                            :invoice,
                                                            :product_id,
                                                            :product_name,
                                                            :division_id,
                                                            :division_code,
                                                            :division_description,
                                                            :quantity,
                                                            :price,
                                                            :discount)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }

}

$pdo = null;

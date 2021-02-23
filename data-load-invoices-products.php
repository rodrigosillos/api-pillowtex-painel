<?php

include('call-api.php');

$dataListaMovimentacao = [
    'datai' => '2021-01-04',
    'dataf' => '2021-01-04',
    '$format' => 'json',
    'tipo_operacao' => 'S',
];

$responseListaMovimentacao = CallAPI('GET', 'movimentacao/lista_movimentacao', $dataListaMovimentacao);
$resultListaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseListaMovimentacao), true);

$pdo = new PDO('mysql:host=db;dbname=pillowtex', 'root', 'qcLkozSAB3L4rp2TTUN7rJVlJa9C1CTb9hcdSLhcuiA=');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach ($resultListaMovimentacao['value'] as $valueListaMovimentacao) {
    
    $dataConsultaMovimentacao = [
        'tipo_operacao' => 'S',
        'cod_operacao' => $valueListaMovimentacao['cod_operacao'],
        'ujuros' => 'false',
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];

    $responseConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $dataConsultaMovimentacao);
    $resultConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaMovimentacao), true);

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

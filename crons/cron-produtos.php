<?php

include('call-api.php');
include('connection-db.php');

// $sql = "select operation_code, operation_type, client_address, price_list from invoices where agent_id = 263";
$sql = "select cod_operacao, tipo_operacao, cliente_estado, tabela from movimentacao where data_emissao between '2022-02-01' and '2022-02-28'";
// $sql = "select cod_operacao, tipo_operacao, cliente_estado, tabela from movimentacao where cod_operacao = 41500";
// $sql = "select operation_code, operation_type, client_address, price_list from invoices where operation_code in ('62130')";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoicesAgents = $stmt->fetchAll();

foreach ($invoicesAgents as $invoice__) {
    
    $operationCode = $invoice__["cod_operacao"];
    $operationType = $invoice__["tipo_operacao"];
    $clientAddress = $invoice__["cliente_estado"];
    $tableId = $invoice__["tabela"];

    // print('- - - consultando venda: ' . $operationCode . "\xA");

    $sql = "select id from invoices_product WHERE operation_code = :operation_code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':operation_code', $operationCode, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() == 0) {

        $dataConsultaMovimentacao = [
            'tipo_operacao' => $operationType,
            'cod_operacao' => $operationCode,
            'ujuros' => 'false',
            '$format' => 'json',
            '$dateformat' => 'iso',
        ];
    
        $responseConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $dataConsultaMovimentacao);
        $resultConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaMovimentacao), true);
    
        if ($resultConsultaMovimentacao['odata.count'] > 0) {

            $invoiceFilial = $resultConsultaMovimentacao['value'][0]['filial'];
            $invoiceAgent = $resultConsultaMovimentacao['value'][0]['representante'];

            if(isset($resultConsultaMovimentacao['value'][0]['produtos'])){

                $commissionAmount = 0;
                $invoiceFilial = 0;
                $invoiceAgent = 0;
                $commissionPercentage = 0;

                foreach($resultConsultaMovimentacao['value'][0]['produtos'] as $valueProduct) {

                    // print('cadastrando produto da venda: ' . $operationCode . "\xA");

                    $productDiscount = $valueProduct['desconto'];
                    $productPrice = $valueProduct['preco'];
                    $productApplied = $valueProduct['preco_aplicado'];
                    $productGross = $valueProduct['preco_bruto'];
                    $productQty = $valueProduct['quantidade'];
    
                    // product
                    $dataConsultaProduto = [
                        'produto' => $valueProduct['produto'],
                        '$format' => 'json',
                    ];

                    print('produto ID: ' . $valueProduct['produto'] . "\xA");
            
                    $responseConsultaProdutoCodigo = CallAPI('GET', 'produtos/consultacodigo', $dataConsultaProduto);
                    $resultConsultaProdutoCodigo = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaProdutoCodigo), true);
                    
                    $productCode = "";
            
                    if($resultConsultaProdutoCodigo['odata.count'] > 0)
                        $productCode = $resultConsultaProdutoCodigo['value'][0]['cod_produto'];
                    
                    $productName = "";
                    $divisionId = "";

                    $responseConsultaProduto = CallAPI('GET', 'produtos/consulta', $dataConsultaProduto);
                    $resultConsultaProduto = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaProduto), true);
                    
                    if($resultConsultaProduto['odata.count'] > 0) {
                        $productName = $resultConsultaProduto['value'][0]['descricao1'];
                        $divisionId = $resultConsultaProduto['value'][0]['divisao'];
                    }
            
                    // category
                    $dataConsultaDivisao = [
                        'divisao' => $divisionId,
                        '$format' => 'json',
                    ];

                    print('divisao ID: ' . $divisionId . "\xA");
            
                    $responseConsultaDivisao = CallAPI('GET', 'divisoes/consulta', $dataConsultaDivisao);
                    $resultConsultaDivisao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaDivisao), true);
            
                    $divisionCode = 000;
                    $divisionDescription = "";
                    
                    if($resultConsultaDivisao['odata.count'] > 0) {
                        $divisionCode = $resultConsultaDivisao['value'][0]['cod_divisao'];
                        $divisionDescription = $resultConsultaDivisao['value'][0]['descricao'];
                    }

                    $tableCode = 214;

                    if($clientAddress == null)
                        $clientAddress = 'SP';
            
                    if($tableId == 104)
                        $tableCode = 187;
                    
                    $sql = "SELECT percentage FROM commission_settings WHERE product_division = :product_division AND price_list = :price_list";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':product_division', $divisionCode, PDO::PARAM_STR);
                    $stmt->bindParam(':price_list', $tableCode, PDO::PARAM_STR);
                    $stmt->execute();
                    $resultSettings = $stmt->fetch(\PDO::FETCH_ASSOC);

                    if ($stmt->rowCount() > 0)
                        $commissionPercentage = $resultSettings['percentage'];

                    if($tableCode == 187 && $clientAddress != 'SP' && $productDiscount < 5)
                        $commissionPercentage = 3;

                    if($tableCode == 214 && $productDiscount > 5)
                        $commissionPercentage = ($commissionPercentage / 2);
                        
                    $commissionAmount = floor(($productApplied * $productQty) * $commissionPercentage) / 100;

                    if($tableCode == 214 && $productDiscount > 5)
                        $commissionAmount = ($commissionAmount / 2);
        
                    $commissionAmount += $commissionAmount;
            
                    $data = [
                        'operation_code' => $operationCode,
                        'document' => $resultConsultaMovimentacao['value'][0]['romaneio'],
                        'order_id' => $valueProduct['pedido'],
                        'invoice' => $valueProduct['nota'],
                        'product_id' => $valueProduct['produto'],
                        'product_code' => $productCode,
                        'product_name' => $productName,
                        'division_id' => $divisionId,
                        'division_code' => $divisionCode,
                        'division_description' => $divisionDescription,
                        'quantity' => $valueProduct['quantidade'],
                        'price' => $productPrice,
                        'price_applied' => $productApplied,
                        'price_gross' => $productGross,
                        'discount' => $valueProduct['desconto'],
                    ];
            
                    $sql  = "INSERT INTO invoices_product (
                                                        operation_code,
                                                        document,
                                                        order_id, 
                                                        invoice, 
                                                        product_id,
                                                        product_code,
                                                        product_name,
                                                        division_id,
                                                        division_code,
                                                        division_description,
                                                        quantity,
                                                        price, 
                                                        price_applied, 
                                                        price_gross, 
                                                        discount) VALUES (
                                                                        :operation_code,
                                                                        :document,
                                                                        :order_id,
                                                                        :invoice,
                                                                        :product_id,
                                                                        :product_code,
                                                                        :product_name,
                                                                        :division_id,
                                                                        :division_code,
                                                                        :division_description,
                                                                        :quantity,
                                                                        :price,
                                                                        :price_applied,
                                                                        :price_gross,
                                                                        :discount)";
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($data);
            
                }

                $data = [
                    'commission_amount' => $commissionAmount,
                    'operation_code' => $operationCode,
                ];
        
                $sql = "update invoices SET commission_amount = :commission_amount where operation_code = :operation_code";
                $stmt = $pdo->prepare($sql);
                // $stmt->execute($data);

            } else {

                $txt = "nao tem produto: " . $operationCode;
                $myfile = file_put_contents('log-dataload-invoices-products.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

            }


        } else {

            $txt = "erro no metodo (movimentacao/consulta): operacao: " . $operationCode;
            $myfile = file_put_contents('log-dataload-invoices-products.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

        }            

    }

}

$pdo = null;

<?php

include('call-api.php');
include('connection-db.php');

// $sql = "select operation_code, client_address, price_list, invoice_type, issue_date from invoices where agent_id = '263'";
// $sql = "select operation_code, client_address, price_list, invoice_type, issue_date from invoices where operation_code in (42045)";
// $sql = "select operation_code, client_address, price_list, invoice_type, issue_date from invoices where hidden = 0 and issue_date between '2022-03-22' and '2022-03-25'";
$sql = "select operation_code, operation_type, client_address, price_list, invoice_type, issue_date from invoices where invoice_type = 'ZC PEDIDO ESPECIAL'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoices = $stmt->fetchAll();

$lastMonth = date("m", strtotime("first day of previous month"));

foreach ($invoices as $invoice) {

    $operationCode = $invoice['operation_code'];
    $operationType = $invoice['operation_type'];
    $clientAddress = $invoice['client_address'];
    $tableId = $invoice['price_list'];
    $invoiceType = $invoice['invoice_type'];
    $issueDate = $invoice['issue_date'];

    $issueDate = date_create($issueDate);

    $commissionAmountTotal = 0;

    $sql = "select division_code, quantity, price, price_applied, price_gross, discount, product_name, product_code from invoices_product where operation_code = :operation_code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':operation_code', $operationCode, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll();
    
    foreach ($products as $product) {
        
        $divisionCode = $product['division_code'];
        $productName = $product['product_name'];
        $productCode = $product['product_code'];
        $quantity = $product['quantity'];
        $price = $product['price'];
        $priceApplied = $product['price_applied'];
        $discount = $product['discount'];
        
        if($clientAddress == null)
            $clientAddress = 'SP';
    
        $tableCode = 214;

        if($tableId == 4)
            $tableCode = 214;
    
        if($tableId == 104)
            $tableCode = 187;
    
        $sql = "select percentage from commission_settings where product_division = :product_division and price_list = :price_list";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_division', $divisionCode, PDO::PARAM_STR);
        $stmt->bindParam(':price_list', $tableCode, PDO::PARAM_STR);
        $stmt->execute();
        $resultSettings = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        $commissionPercentage = 0;

        if ($stmt->rowCount() > 0)
            $commissionPercentage = $resultSettings['percentage'];
    
        if($tableCode == 187 && $clientAddress != 'SP' && $discount < 5)
            $commissionPercentage = 3;

        if($invoiceType == 'ZC PEDIDO ESPECIAL') {

            $params = [
                'tipo_operacao' => $operationType,
                'cod_operacao' => $operationCode,
                'ujuros' => 'false',
                '$format' => 'json',
            ];
            
            $movimentacaoBody = CallAPI('GET', 'movimentacao/consulta', $params);
            $movimentacaoJson = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $movimentacaoBody), true);
            $commissionPercentage = $movimentacaoJson['value'][0]['comissao_r'];
    
        }
        
        $priceProduct = $priceApplied == 0 ? $price : $priceApplied;

        $commissionAmount = ($priceProduct * $quantity) * $commissionPercentage / 100;
    
        if($tableCode == 214 && $discount > 5)
            $commissionAmount = ($commissionAmount / 2);
    
        $commissionAmountTotal += $commissionAmount;
    }

    $percentualFaturamento = 50;
    $valorFaturamento = 0;

    if ($invoiceType == 'ANTECIPADO' || $invoiceType == 'ANTECIPADO ZC')
        $percentualFaturamento = 80;

    // if (date_format($issueDate, "m") == $lastMonth)
    $valorFaturamento = ($percentualFaturamento / 100) * $commissionAmountTotal;
    
    $data = [
        'commission_amount' => $commissionAmountTotal,
        'valor_faturamento' => $valorFaturamento,
        'operationCode' => $operationCode,
    ];
    
    $sql = "update invoices set commission_amount = :commission_amount, valor_faturamento = :valor_faturamento where operation_code = :operationCode";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

$pdo = null;

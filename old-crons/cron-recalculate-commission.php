<?php

include('connection-db.php');

// $sql = "select operation_code, client_address, price_list from invoices where agent_id = '263'";
// $sql = "select operation_code, client_address, price_list from invoices where operation_code in (535816, 535950, 535958, 535985, 536219, 537208, 537280, 538063, 538512, 539171, 539324, 539716, 540454, 540485, 540507, 540631, 540856, 541031, 541698, 541838, 542097)";
$sql = "select operation_code, client_address, price_list from invoices where hidden = 0 and issue_date between '2021-01-01' and '2021-07-31'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoices = $stmt->fetchAll();

$countItem = 0;

$lastMonth = date("m", strtotime("first day of previous month"));

foreach ($invoices as $invoice) {

    $operationCode = $invoice['operation_code'];
    $clientAddress = $invoice['client_address'];
    $tableId = $invoice['price_list'];

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
    
        if($tableId == 216)
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
            $commissionPercentage = 4;
    
        if($tableCode == 214 && $discount > 5)
            $commissionPercentage = ($commissionPercentage / 2);
        
        // print('codigo: ' . $productCode . ' - produto: ' . $productName . ' - divisao: ' . $divisionCode . ' - tabela: ' . $tableCode . ' - percentual: ' . $commissionPercentage . "\xA");
        print('codigo: ' . $productCode . "\xA");
        $commissionAmount = ($priceApplied * $quantity) * $commissionPercentage / 100;
    
        if($tableCode == 214 && $discount > 5)
            $commissionAmount = ($commissionAmount / 2);
    
        $commissionAmountTotal += $commissionAmount;
    }

    $data = [
        'commission_amount' => $commissionAmountTotal,
        'operationCode' => $operationCode,
    ];
    
    $sql = "update invoices SET commission_amount = :commission_amount where operation_code = :operationCode";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

$pdo = null;

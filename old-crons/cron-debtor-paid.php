<?php

include('call-api.php');
include('connection-db.php');

function searchForId($division, $table, $array)
{
    foreach ($array as $key => $val) {
        if ($val['division'] == $division && $val['table'] == $table) {
            return $key;
        }
    }
    return null;
}

$divisionDb = [
    [
        'division' => '001',
        'table' => '214',
        'percentage' => 8,
    ],
    [
        'division' => '001',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '002',
        'table' => '214',
        'percentage' => 8,
    ],
    [
        'division' => '002',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '003',
        'table' => '214',
        'percentage' => 7.04,
    ],
    [
        'division' => '003',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '004',
        'table' => '214',
        'percentage' => 7.04,
    ],
    [
        'division' => '004',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '005',
        'table' => '214',
        'percentage' => 0,
    ],
    [
        'division' => '005',
        'table' => '187',
        'percentage' => 0,
    ],
    [
        'division' => '007',
        'table' => '214',
        'percentage' => 7,
    ],
    [
        'division' => '007',
        'table' => '187',
        'percentage' => 7,
    ],
    [
        'division' => '008',
        'table' => '214',
        'percentage' => 4,
    ],
    [
        'division' => '008',
        'table' => '187',
        'percentage' => 4,
    ],
    [
        'division' => '009',
        'table' => '214',
        'percentage' => 6,
    ],
    [
        'division' => '009',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '010',
        'table' => '214',
        'percentage' => 4,
    ],
    [
        'division' => '010',
        'table' => '187',
        'percentage' => 4,
    ],
    [
        'division' => '011',
        'table' => '214',
        'percentage' => 4,
    ],
    [
        'division' => '011',
        'table' => '187',
        'percentage' => 4,
    ],
    [
        'division' => '012',
        'table' => '214',
        'percentage' => 6,
    ],
    [
        'division' => '012',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '013',
        'table' => '214',
        'percentage' => 4,
    ],
    [
        'division' => '013',
        'table' => '187',
        'percentage' => 4,
    ],
    [
        'division' => '014',
        'table' => '214',
        'percentage' => 6,
    ],
    [
        'division' => '014',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '017',
        'table' => '214',
        'percentage' => 4,
    ],
    [
        'division' => '017',
        'table' => '187',
        'percentage' => 4,
    ],
    [
        'division' => '020',
        'table' => '214',
        'percentage' => 6,
    ],
    [
        'division' => '020',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '021',
        'table' => '214',
        'percentage' => 8,
    ],
    [
        'division' => '021',
        'table' => '187',
        'percentage' => 8,
    ],
    [
        'division' => '022',
        'table' => '214',
        'percentage' => 7,
    ],
    [
        'division' => '022',
        'table' => '187',
        'percentage' => 7,
    ],
    [
        'division' => 'L01',
        'table' => '214',
        'percentage' => 0,
    ],
    [
        'division' => 'L01',
        'table' => '187',
        'percentage' => 0,
    ],
    [
        'division' => 'indefinido',
        'table' => '214',
        'percentage' => 0,
    ],
    [
        'division' => 'indefinido',
        'table' => '187',
        'percentage' => 0,
    ],
];



$sql = "select operation_code, operation_type from invoices where issue_date between '2021-07-29' and '2021-07-31'";
//$sql = "select operation_code, operation_type from invoices where operation_code = '534463'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoicesAgents = $stmt->fetchAll();

foreach ($invoicesAgents as $invoice__) {

    $commissionPercentage = 0;

    $operationCode = $invoice__["operation_code"];
    $operationType = $invoice__["operation_type"];

    $sql = "select id from debtors WHERE low_payment = 0 and operation_code = :operation_code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':operation_code', $operationCode, PDO::PARAM_STR);
    $stmt->execute();
    $countDebtors = $stmt->rowCount();

    if($countDebtors > 0) {

        $dataConsultaMovimentacao = [
            'tipo_operacao' => $operationType,
            'cod_operacao' => $operationCode,
            'ujuros' => 'false',
            '$format' => 'json',
            '$dateformat' => 'iso',
        ];
    
        $responseConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $dataConsultaMovimentacao);
        $resultConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaMovimentacao), true);
    
        $invoiceFilial = $resultConsultaMovimentacao['value'][0]['filial'];
    
        $dataConsultaLancamento = [
            'tipo_operacao' => $operationType,
            'cod_operacao' => $operationCode,
            'tipo' => 'R',
            '$format' => 'json',
            '$dateformat' => 'iso',
        ];
    
        $responseConsultaLancamento = CallAPI('GET', 'movimentacao/consulta_lancamentos', $dataConsultaLancamento);
        $resultConsultaLancamento = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaLancamento), true);
    
        foreach ($resultConsultaLancamento['value'] as $valueConsultaLancamento) {
    
            $effected = $valueConsultaLancamento['efetuado'];
            $bookEntry = $valueConsultaLancamento['lancamento'];
    
            $sql = "select quantity, price, division_code, discount from invoices_product where operation_code = :operation_code";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':operation_code', $operationCode, PDO::PARAM_STR);
            $stmt->execute();
            $invoiceProducts = $stmt->fetchAll();
    
            $commissionDebtors = 0;
            $bookEntryCommissionTotal = 0;
    
            foreach($invoiceProducts as $productKey => $product__) {
    
                $productQty = $product__["quantity"];
                $productPrice = $product__["price"];
                $productDiscount = $product__["discount"];
                $divisionCode = $product__["division_code"];
    
                $sql = "select price_list, client_address from invoices WHERE operation_code = :operation_code";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':operation_code', $operationCode, PDO::PARAM_STR);
                $stmt->execute();
                $resultInvoices = $stmt->fetch(\PDO::FETCH_ASSOC);
    
                $tableId = $resultInvoices['price_list'];
                $clientAddress = $resultInvoices['client_address'];
    
                if($clientAddress == null)
                    $clientAddress = 'SP';
    
                $tableCode = 214;
    
                if($tableId == 4)
                    $tableCode = 214;
            
                if($tableId == 216)
                    $tableCode = 187;
    
                $divisionKey = searchForId($divisionCode, $tableCode, $divisionDb);
    
                if($divisionKey)
                    $commissionPercentage = $divisionDb[$divisionKey]['percentage'];
    
                if($tableCode == 187 && $clientAddress != 'SP' && $productDiscount < 5)
                    $commissionPercentage = 4;
                
                // commission amout
                $commissionAmount = floor(($productPrice * $productQty) * $commissionPercentage) / 100;
                $commissionDebtors += $commissionAmount;
    
                if($tableCode == 214 && $productDiscount > 5)
                    $commissionAmount = ($commissionAmount / 2);
            
            }
    
            if($effected == 1) {

                print($operationCode . "\xA");
    
                $dataConsultaTitulo = [
                    'lancamento' => $bookEntry,
                    '$format' => 'json',
                    '$dateformat' => 'iso',
                ];
    
                $responseConsultaTitulo = CallAPI('GET', 'titulos_receber/consulta', $dataConsultaTitulo);
                $resultConsultaTitulo = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaTitulo), true);
                $paidDate = $resultConsultaTitulo['value'][0]['data_pagamento'];
    
                $paidDate = date_create($paidDate);
                $paidDate = date_format($paidDate, "Y-m-d H:i:s");
    
                $bookEntryCommission = (($commissionDebtors / 2) / $countDebtors);
                $bookEntryCommissionTotal += $bookEntryCommission;
    
                $data = [
                    'effected' => $effected,
                    'commission' => $bookEntryCommission,
                    'book_entry' => $bookEntry,
                    'paid_date' => $paidDate,
                ];
        
                $sql = "update debtors SET effected = :effected, commission = :commission, paid_date = :paid_date where book_entry = :book_entry";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data);
    
            }

            $data = [
                'commission_debtors' => $bookEntryCommissionTotal,
                'operation_code' => $operationCode,
            ];
    
            $sql = "update invoices SET commission_debtors = :commission_debtors where operation_code = :operation_code";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);

            $commissionDebtors = 0;
    
        }

    }

}

$pdo = null;

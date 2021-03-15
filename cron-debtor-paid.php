<?php

include('call-api.php');
include('connection-db.php');

$sql = "select operation_code from invoices";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoicesAgents = $stmt->fetchAll();

$operationType = 'S';

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

function searchForId($division, $table, $array)
{
    foreach ($array as $key => $val) {
        if ($val['division'] == $division && $val['table'] == $table) {
            return $key;
        }
    }
    return null;
}

foreach ($invoicesAgents as $invoice__) {

    $operationCode = $invoice__["operation_code"];

    $sql = "select id from debtors WHERE operation_code = :operation_code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':operation_code', $operationCode, PDO::PARAM_STR);
    $stmt->execute();
    $countDebtors = $stmt->rowCount();

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

        //$effected = $valueConsultaLancamento['efetuado'];
        $effected = 1;
        $bookEntry = $valueConsultaLancamento['lancamento'];

        $sql = "select quantity, price, division_code, discount from invoices_product where operation_code = :operation_code";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':operation_code', $operationCode, PDO::PARAM_STR);
        $stmt->execute();
        $invoiceProducts = $stmt->fetchAll();

        $commissionDebtors = 0;

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

            if($tableCode == 214) {
                if($productDiscount > 5)
                    $commissionAmount = ($commissionAmount / 2);
            }

            if($tableCode == 187) {
                if($clientAddress != 'SP' && $productDiscount < 5)
                    $commissionPercentage = 4;
            }
            
            // commission amout
            $commissionAmount = floor(($productPrice * $productQty) * $commissionPercentage) / 100;
            $commissionDebtors += $commissionAmount;
        
        }

        if($effected == 1) {

            $bookEntryCommission = (($commissionDebtors / 2) / $countDebtors);

            $data = [
                'effected' => $effected,
                'commission' => $bookEntryCommission,
                'book_entry' => $bookEntry,
            ];
    
            $sql = "update debtors SET effected = :effected, commission = :commission where book_entry = :book_entry";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);

        }

        $commissionDebtors = 0;

    }

}

$pdo = null;

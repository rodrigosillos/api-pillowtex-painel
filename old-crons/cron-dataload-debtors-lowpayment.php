<?php

include('call-api.php');
include('connection-db.php');

//$sql = "select distinct(operation_code) as operation_code from debtors where substituted = 1";
$sql = "select operation_code, commission_amount from invoices where issue_date between '2021-07-24' and '2021-07-31'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$debtorSubstituted = $stmt->fetchAll();

$lastMonth = date("m", strtotime("first day of previous month"));

foreach ($debtorSubstituted as $debtor) {

    $operationCode = $debtor["operation_code"];
    $commissionAmount = $debtor['commission_amount'];

    $sql = "select book_entry from debtors where operation_code = :operation_code and substituted = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':operation_code', $operationCode, PDO::PARAM_STR);
    $stmt->execute();
    $resultbookEntry = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0)
        $bookEntryOld = $resultbookEntry['book_entry'];

    $dataSearch = [
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];

    $dataSearch['lancamento'] = $bookEntryOld;
    $dataSearch['parcela_null'] = 'text';

    $responseListaBaixas = CallAPI('GET', 'titulos/lista_baixas', $dataSearch);
    $resultListaBaixas = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseListaBaixas), true);
    $lowPayment = $resultListaBaixas['value'][0]['baixa'];
    
    unset($dataSearch['lancamento'], $dataSearch['parcela_null']);
    $dataSearch['baixa'] = $lowPayment;
    $dataSearch['status_baixa'] = 'N';
    
    $responseListaPorBaixa = CallAPI('GET', 'titulos/lista_por_baixa', $dataSearch);
    $resultListaPorBaixa = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseListaPorBaixa), true);
    
    unset($dataSearch['baixa'], $dataSearch['status_baixa']);

    $qtyDebtors = $resultListaPorBaixa['odata.count'];
    $bookEntryCommission = 0;
    $bookEntryCommissionTotal = 0;

    foreach($resultListaPorBaixa['value'] as $baixa) {

        $bookEntryNew = $baixa['lancamento'];
        $dataSearch['lancamento'] = $bookEntryNew;

        $responseTitulosReceberConsulta = CallAPI('GET', 'titulos_receber/consulta', $dataSearch);
        $resultTitulosReceberConsulta = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseTitulosReceberConsulta), true);

        $document = $resultTitulosReceberConsulta['value'][0]['n_documento'];
        $amount = $resultTitulosReceberConsulta['value'][0]['valor_inicial'];

        $dueDate = date_create($resultTitulosReceberConsulta['value'][0]['data_vencimento']);
        $dueDate = date_format($dueDate, "Y-m-d H:i:s");
        
        $effected = $resultTitulosReceberConsulta['value'][0]['efetuado'];
        $substituted = $resultTitulosReceberConsulta['value'][0]['substituido'];

        $paidDate = null;

        if(!is_null($resultTitulosReceberConsulta['value'][0]['data_pagamento']) && $substituted == false) {
            $paidDateCreate = date_create($resultTitulosReceberConsulta['value'][0]['data_pagamento']);
            
            $paidDate = date_format($paidDateCreate, "Y-m-d H:i:s");
            $paidDateMonth = date_format($paidDateCreate, "m");

            $bookEntryCommission = (($commissionAmount / 2) / $qtyDebtors);

            if($paidDateMonth == $lastMonth) {
                $bookEntryCommissionTotal += $bookEntryCommission;
            }
        }

        $data = [
            'book_entry' => $bookEntryNew,
            'operation_code' => $operationCode,
            'document' => $document,
            'due_date' => $dueDate,
            'paid_date' => $paidDate,
            'effected' => $effected,
            'substituted' => $substituted,
            'amount' => $amount,
            'commission' => $bookEntryCommission,
            'low_payment' => 1,
        ];

        $sql = "INSERT INTO debtors (
                                book_entry,
                                operation_code,
                                document, 
                                due_date,
                                paid_date, 
                                effected, 
                                substituted, 
                                amount,
                                commission,
                                low_payment) VALUES (
                                                :book_entry,
                                                :operation_code,
                                                :document,
                                                :due_date,
                                                :paid_date,
                                                :effected,
                                                :substituted,
                                                :amount,
                                                :commission,
                                                :low_payment)";

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

    print($operationCode . "\xA");

}

$pdo = null;

<?php

include('call-api.php');
include('connection-db.php');

$sql = "select operation_code, operation_type, commission_amount from invoices";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoicesAgents = $stmt->fetchAll();

foreach ($invoicesAgents as $invoice__) {

    $operationCode = $invoice__["operation_code"];
    $operationType = $invoice__["operation_type"];
    $commissionAmount = $invoice__["commission_amount"];

    print('operacao: ' . $operationCode . "\xA");

    $dataSearchDefault = [
        'tipo_operacao' => $operationType,
        'cod_operacao' => $operationCode,
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];

    $dataSearchDefault['ujuros'] = 'false';

    $responseConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $dataSearchDefault);
    $resultConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaMovimentacao), true);
    
    unset($dataSearchDefault['ujuros']);

    $dataSearchDefault['tipo'] = 'R';

    $responseConsultaLancamento = CallAPI('GET', 'movimentacao/consulta_lancamentos', $dataSearchDefault);
    $resultConsultaLancamento = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaLancamento), true);
    $qtyDebtors = $resultConsultaLancamento['odata.count'];

    $bookEntryCommissionTotal = 0;

    foreach ($resultConsultaLancamento['value'] as $valueConsultaLancamento) {

        $document = $valueConsultaLancamento['documento'];
        $amount = $valueConsultaLancamento['valor_inicial'];
        $bookEntry = $valueConsultaLancamento['lancamento'];
        $effected = $valueConsultaLancamento['efetuado'];

        $dataConsultaTitulo = [
            'lancamento' => $bookEntry,
            '$format' => 'json',
            '$dateformat' => 'iso',
        ];

        $responseConsultaTitulo = CallAPI('GET', 'titulos_receber/consulta', $dataConsultaTitulo);
        $resultConsultaTitulo = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaTitulo), true);

        $substituted = $resultConsultaTitulo['value'][0]['substituido'];

        $dueDate = date_create($valueConsultaLancamento['data_vencimento']);
        $dueDate = date_format($dueDate, "Y-m-d H:i:s");

        $bookEntryCommission = 0;
        $paidDate = null;

        if(!is_null($resultConsultaTitulo['value'][0]['data_pagamento'])) {

            $paidDateCreate = date_create($resultConsultaTitulo['value'][0]['data_pagamento']);
            
            $paidDate = date_format($paidDateCreate, "Y-m-d H:i:s");
            $paidDateMonth = date_format($paidDateCreate, "m");

            $bookEntryCommission = (($commissionAmount / 2) / $qtyDebtors);

            if($paidDateMonth == '05') {
                $bookEntryCommissionTotal += $bookEntryCommission;
                print('liquidacao: ' . $bookEntryCommissionTotal . "\xA");
            }
       
        }

        $data = [
            'book_entry' => $bookEntry,
            'operation_code' => $operationCode,
            'document' => $document,
            'due_date' => $dueDate,
            'paid_date' => $paidDate,
            'effected' => $effected,
            'substituted' => $substituted,
            'amount' => $amount,
            'commission' => $bookEntryCommission,
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
                                    commission) VALUES (
                                                    :book_entry,
                                                    :operation_code,
                                                    :document,
                                                    :due_date,
                                                    :paid_date,
                                                    :effected,
                                                    :substituted,
                                                    :amount,
                                                    :commission)";

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

}

$pdo = null;

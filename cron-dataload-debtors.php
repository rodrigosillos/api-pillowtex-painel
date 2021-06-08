<?php

include('call-api.php');
include('connection-db.php');

$operationTypes = ['E', 'S'];
$countItem = 0;

foreach($operationTypes as $operationType) {

    $sql = "select operation_code from invoices where operation_type = '".$operationType."'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $invoicesAgents = $stmt->fetchAll();
    
    foreach ($invoicesAgents as $invoice__) {

        $operationCode = $invoice__["operation_code"];

        $sql = "select id from debtors WHERE operation_code = :operation_code";
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
        
                $data = [
                    'book_entry' => $bookEntry,
                    'operation_code' => $operationCode,
                    'document' => $document,
                    'due_date' => $dueDate,
                    'effected' => $effected,
                    'substituted' => $substituted,
                    'amount' => $amount,
                ];
        
                $stmt->bindParam(':operation_code', $invoice__["operation_code"], PDO::PARAM_STR);
                $stmt->execute();
                $sql = "INSERT INTO debtors (
                                            book_entry,
                                            operation_code,
                                            document, 
                                            due_date, 
                                            effected, 
                                            substituted, 
                                            amount) VALUES (
                                                            :book_entry,
                                                            :operation_code,
                                                            :document,
                                                            :due_date,
                                                            :effected,
                                                            :substituted,
                                                            :amount)";
        
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data);
            
            }            
        
        }
    
    }

}

$pdo = null;

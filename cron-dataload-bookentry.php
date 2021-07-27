<?php

include('call-api.php');
include('connection-db.php');

$fh = fopen('data-bookentry.txt','r');
while ($line = fgets($fh)) {
    //echo($line);

    $dataSearch = [
        'lancamento' => trim($line),
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];


  $responseTitulosReceberConsulta = CallAPI('GET', 'titulos_receber/consulta', $dataSearch);
  $resultTitulosReceberConsulta = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseTitulosReceberConsulta), true);

  $document = $resultTitulosReceberConsulta['value'][0]['n_documento'];
  $amount = $resultTitulosReceberConsulta['value'][0]['valor_inicial'];

  $dueDate = date_create($resultTitulosReceberConsulta['value'][0]['data_vencimento']);
  $dueDate = date_format($dueDate, "Y-m-d H:i:s");
  
  $effected = $resultTitulosReceberConsulta['value'][0]['efetuado'];
  $substituted = $resultTitulosReceberConsulta['value'][0]['substituido'];

  $paidDate = null;
  $bookEntryCommission = 0;

  if(!is_null($resultTitulosReceberConsulta['value'][0]['data_pagamento'])) {
      $paidDateCreate = date_create($resultTitulosReceberConsulta['value'][0]['data_pagamento']);
      
      $paidDate = date_format($paidDateCreate, "Y-m-d H:i:s");
      $paidDateMonth = date_format($paidDateCreate, "m");

      $bookEntryCommission = (($commissionAmount / 2) / $qtyDebtors);
  }

  $data = [
      'book_entry' => trim($line),
      'operation_code' => '',
      'document' => $document,
      'due_date' => $dueDate,
      'paid_date' => $paidDate,
      'effected' => $effected,
      'substituted' => $substituted,
      'amount' => $amount,
      'commission' => $bookEntryCommission,
      'low_payment' => 0,
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
fclose($fh);

$pdo = null;

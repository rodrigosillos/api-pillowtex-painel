<?php

include('connection-db.php');

$sql = "select operation_code, document from invoices where invoice = ''";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultInvoices = $stmt->fetchAll();

foreach ($resultInvoices as $invoice__) {

    $operationCode = $invoice__['operation_code'];
    $document = $invoice__['document'];
    $invoiceNumber = '';

    $sql3 = "SELECT invoice FROM invoices WHERE ticket = :document";
    $stmt3 = $pdo->prepare($sql3);
    $stmt3->bindParam(':document', $document, PDO::PARAM_STR);
    $stmt3->execute();
    
    $resultTicket = $stmt3->fetch(\PDO::FETCH_ASSOC);

    if ($stmt3->rowCount() > 0)
        $invoiceNumber = $resultTicket['invoice'];

    if(!empty($invoiceNumber)) {

        print($invoiceNumber . "\xA");

        $data = [
            'invoice_number' => $invoiceNumber,
            'operationCode' => $operationCode,
        ];

        $sql2 = "update invoices SET invoice = :invoice_number where operation_code = :operationCode";
        $stmt2 = $pdo->prepare($sql2);
        // $stmt2->execute($data);
    }

}

$pdo = null;

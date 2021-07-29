<?php

include('call-api.php');
include('connection-db.php');

$sql = "select operation_code, operation_type, commission_amount from invoices where issue_date between '2021-02-01' and '2021-07-31'";
//$sql = "select operation_code, operation_type, commission_amount from invoices where agent_id = 263";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoices = $stmt->fetchAll();

foreach ($invoices as $invoice__) {

    $operationCode = $invoice__["operation_code"];
    $commissionAmount = $invoice__["commission_amount"];

    $qtyDebtors = $pdo->query('select count(*) from debtors where substituted = 0 and operation_code = '.$operationCode)->fetchColumn();

    $sql = "select id from debtors where substituted = 0 and commission = 0 and operation_code = :operation_code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':operation_code', $operationCode, PDO::PARAM_STR);
    $stmt->execute();
    $debtors = $stmt->fetchAll();

    foreach ($debtors as $debtor__) {

        $debtorId = $debtor__["id"];
        $debtorCommission = (($commissionAmount / 2) / $qtyDebtors);
        print($debtorCommission . "\xA");

        $data = [
            'commission' => $debtorCommission,
            'debtor_id' => $debtorId,
        ];
    
        $sql = "update debtors SET commission = :commission where id = :debtor_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }

}

$pdo = null;

<?php

include('call-api.php');
include('connection-db.php');

// $sql = "select operation_code, operation_type, commission_amount from invoices where issue_date between '2021-07-01' and '2021-07-31'";
$sql = "select operation_code, operation_type, commission_amount from invoices where operation_code in (535816, 535950, 535958, 535985, 536219, 537208, 537280, 538063, 538512, 539171, 539324, 539716, 540454, 540485, 540507, 540631, 540856, 541031, 541698, 541838, 542097, 528562)";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoices = $stmt->fetchAll();

foreach ($invoices as $invoice__) {

    $operationCode = $invoice__["operation_code"];
    $commissionAmount = $invoice__["commission_amount"];

    $qtyDebtors = $pdo->query('select count(*) from lancamentos where substituido = 0 and origem = '.$operationCode)->fetchColumn();

    $sql = "select id from lancamentos where substituido = 0 and valor_comissao = 0 and origem = :origem";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':origem', $operationCode, PDO::PARAM_STR);
    $stmt->execute();
    $debtors = $stmt->fetchAll();

    foreach ($debtors as $debtor__) {

        $debtorId = $debtor__["id"];
        $debtorCommission = (($commissionAmount / 2) / $qtyDebtors);
        print($debtorCommission . "\xA");

        $data = [
            'valor_comissao' => $debtorCommission,
            'debtor_id' => $debtorId,
        ];
    
        $sql = "update lancamentos SET valor_comissao = :valor_comissao where id = :debtor_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }

}

$pdo = null;

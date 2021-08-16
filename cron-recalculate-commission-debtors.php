<?php

include('call-api.php');
include('connection-db.php');

// $sql = "select operation_code, operation_type, commission_amount from invoices where issue_date between '2021-07-01' and '2021-07-31'";
// $sql = "select operation_code, operation_type, commission_amount, invoice_type from invoices where operation_code in (543791)";
$sql = "select operation_code, operation_type, commission_amount, invoice_type from invoices where issue_date between '2021-07-01' and '2021-07-31' and agent_id = '232'";
$stmt->execute();
$invoices = $stmt->fetchAll();

foreach ($invoices as $invoice__) {

    $operationCode = $invoice__["operation_code"];
    $commissionAmount = $invoice__["commission_amount"];

    $qtyDebtors = $pdo->query('select count(*) from lancamentos where substituido = 0 and origem = '.$operationCode)->fetchColumn();

    $sql = "select id from lancamentos where substituido = 0 and origem = :origem";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':origem', $operationCode, PDO::PARAM_STR);
    $stmt->execute();
    $debtors = $stmt->fetchAll();

    $percentualLiquidacao = 50;

    foreach ($debtors as $debtor__) {

        $debtorId = $debtor__["id"];

        if ($invoice__["invoice_type"] == 'ANTECIPADO' || $invoice__["invoice_type"] == 'ANTECIPADO ZC')
            $percentualLiquidacao = 20;

        print($percentualLiquidacao);
        $debtorCommission = (($percentualLiquidacao / 100) * $commissionAmount / $qtyDebtors);
        // print($debtorCommission . "\xA");

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

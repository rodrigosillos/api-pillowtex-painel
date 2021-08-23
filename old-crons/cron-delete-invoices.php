<?php

include('call-api.php');
include('connection-db.php');

$sql = "select operation_code, hidden from invoices where invoice_type in (
'ZC LINK DE PGTO',
'TRANSFERENCIA',
'TI',
'SAC - TROCA',
'SAC',
'RESERVADO',
'PROMO - ZCRIATIVA',
'PROMO - FEIRA ZC',
'PRE-FEIRA ZC',
'PAGTO ANTECIPADO',
'MOSTRUARIO MASTER',
'MOSTRUA. ZCRIATIVA',
'MASTERCOMFORT_PV',
'MASTERCOMFORT',
'LOJAS ZC',
'LEROY',
'INDEFINIDO',
'FEIRA VAREJO ZC',
'FEIRA MASTERCOMFORT',
'CRAZY4CUPS-PROPRIA',
'CRAZY4CUPS-MKT',
'CRAZY4CUPS-FRANQUIA',
'CONSIGNADO',
'BONIFICADO - ZC',
'BONIFICADO - MC',
'B2C_ORRAQBARATO',
'B2C_MKT_ORRA',
'B2C_MARKETPLACE',
'B2C_CRAZY4MUGS',
'B2C',
'B2B_MASTERCOMFORT_E',
'B2B_MASTERCOMFORT',
'ANTECIPADO ZC'
)";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoices = $stmt->fetchAll();

$countItem = 0;

foreach ($invoices as $invoice__) {

    $operationCode = $invoice__["operation_code"];
    //echo $invoice__["hidden"];
    
    $countItem++;
    print($countItem . ' - ' . $operationCode . "\xA");

    // $sql = "delete from invoices_product where operation_code = " . $operationCode;
    // $stmt = $pdo->prepare($sql);
    // //$stmt->execute();

    // $sql = "delete from debtors where operation_code = " . $operationCode;
    // $stmt = $pdo->prepare($sql);
    // //$stmt->execute();

    // $sql = "delete from invoices where operation_code = " . $operationCode;
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute();

}

$pdo = null;

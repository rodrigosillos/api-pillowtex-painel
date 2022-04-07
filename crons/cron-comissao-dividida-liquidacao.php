<?php

include('call-api.php');
include('connection-db.php');

$sql = "select operation_code, operation_type, commission_amount, invoice_type from invoices where agent_id in (select representante from lancamentos where valor_comissao = '0.00' group by representante)";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoices = $stmt->fetchAll();


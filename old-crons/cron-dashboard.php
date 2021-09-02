<?php

include('../connection-db.php');

$dataInicio = '2021-08-01';
$dataFim = '2021-08-31';

$sql = "select sum(price * quantity) as total, sum(quantity) as quantidade from invoices_product where division_id = 73 and operation_code in (select operation_code from invoices where hidden = 0 and issue_date between '".$dataInicio."' and '".$dataFim."') order by division_id;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalDivision73 = $stmt->fetch(\PDO::FETCH_ASSOC);

$sql = "select sum(price * quantity) as total, sum(quantity) as quantidade from invoices_product where division_id = 3 and operation_code in (select operation_code from invoices where hidden = 0 and issue_date between '".$dataInicio."' and '".$dataFim."') order by division_id;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalDivision3 = $stmt->fetch(\PDO::FETCH_ASSOC);

$sql = "select sum(price * quantity) as total, sum(quantity) as quantidade from invoices_product where division_id = 202 and operation_code in (select operation_code from invoices where hidden = 0 and issue_date between '".$dataInicio."' and '".$dataFim."') order by division_id;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalDivision202 = $stmt->fetch(\PDO::FETCH_ASSOC);

$sql = "select sum(price * quantity) as total, sum(quantity) as quantidade from invoices_product where division_id = 207 and operation_code in (select operation_code from invoices where hidden = 0 and issue_date between '".$dataInicio."' and '".$dataFim."') order by division_id;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalDivision207 = $stmt->fetch(\PDO::FETCH_ASSOC);

$sql = "select sum(price * quantity) as total, sum(quantity) as quantidade from invoices_product where division_id = 2 and operation_code in (select operation_code from invoices where hidden = 0 and issue_date between '".$dataInicio."' and '".$dataFim."') order by division_id;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalDivision2 = $stmt->fetch(\PDO::FETCH_ASSOC);

$sql = "select sum(price * quantity) as total, sum(quantity) as quantidade from invoices_product where division_id = 71 and operation_code in (select operation_code from invoices where hidden = 0 and issue_date between '".$dataInicio."' and '".$dataFim."') order by division_id;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalDivision71 = $stmt->fetch(\PDO::FETCH_ASSOC);

$sql = "select sum(price * quantity) as total, sum(quantity) as quantidade from invoices_product where division_id = 212 and operation_code in (select operation_code from invoices where hidden = 0 and issue_date between '".$dataInicio."' and '".$dataFim."') order by division_id;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalDivision212 = $stmt->fetch(\PDO::FETCH_ASSOC);

$sql = "select sum(price * quantity) as total, sum(quantity) as quantidade from invoices_product where division_id = 150490655 and operation_code in (select operation_code from invoices where hidden = 0 and issue_date between '".$dataInicio."' and '".$dataFim."') order by division_id;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalDivision150490655 = $stmt->fetch(\PDO::FETCH_ASSOC);

print('IMPORTADO ' . $totalDivision73['total'] . ' - ' . $totalDivision73['quantidade'] . "\xA");
print('IMPORTADO-LICENCIADO ' . $totalDivision3['total'] . ' - ' . $totalDivision3['quantidade'] . "\xA");
print('IMPORTADO-LICENCIADO-FL PROMOO ' . $totalDivision202['total'] . ' - ' . $totalDivision202['quantidade'] . "\xA");
print('IMPORTADO; FL PROMOO ' . $totalDivision207['total'] . ' - ' . $totalDivision207['quantidade'] . "\xA");
print('NACIONAL-LICENCIADO ' . $totalDivision2['total'] . ' - ' . $totalDivision2['quantidade'] .  "\xA");
print('NACIONAL ' . $totalDivision71['total'] . ' - ' . $totalDivision71['quantidade'] . "\xA");
print('IMPORTADO-NG ' . $totalDivision212['total'] . ' - ' . $totalDivision212['quantidade'] . "\xA");
print('LOJAS ZONA CRIATIVA ' . $totalDivision150490655['total'] .  ' - ' . $totalDivision150490655['quantidade'] . "\xA");

$pdo = null;

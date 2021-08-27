<?php

// include('call-api.php');
include('connection-db.php');

$currentYear = date("Y");
$previousMonth = date("m", strtotime("first day of previous month"));
$lastDayPreviousMonth = date("d", strtotime("last day of previous month"));

$sql = "
SELECT agent_id, agent_name, invoice_type, commission_amount, issue_date
FROM invoices
WHERE issue_date BETWEEN '".$currentYear."-".$previousMonth."-01' AND '".$currentYear."-".$previousMonth."-".$lastDayPreviousMonth."'
AND hidden = 0
AND agent_id = 92
GROUP BY agent_id, agent_name, invoice_type, commission_amount, issue_date
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$movimentacoes = $stmt->fetchAll();

$totalFaturamento = 0;

foreach($movimentacoes as $movimentacao) {

    $dataEmissao = date_create($movimentacao['issue_date']);

    $percentualFaturamento = 50;

    if ($movimentacao['invoice_type'] == 'ANTECIPADO' || $movimentacao['invoice_type'] == 'ANTECIPADO ZC')
        $percentualFaturamento = 80;

    if (date_format($dataEmissao, "m") == $previousMonth)
        $valorFaturamento = ($percentualFaturamento / 100) * $movimentacao['commission_amount'];

    $totalFaturamento += $valorFaturamento;
    // print($movimentacao['agent_id'] .' - '. $movimentacao['agent_name'] .' - '. $valorFaturamento) . "\xA";

}

print($totalFaturamento) . "\xA";

$pdo = null;

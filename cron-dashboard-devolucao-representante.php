<?php

// include('call-api.php');
include('connection-db.php');

$currentYear = date("Y");
$previousMonth = date("m", strtotime("first day of previous month"));
$lastDayPreviousMonth = date("d", strtotime("last day of previous month"));

// $sql = "
// SELECT agent_id, agent_name, SUM(`amount`) as valorDevolucao
// FROM (SELECT agent_id, agent_name, `amount`, 
//              IF(@lastAgent=(@lastAgent:=agent_id), @auto:=@auto+1, @auto:=1) indx 
//       FROM invoices, (SELECT @lastAgent:=0, @auto:=1) A 
//       WHERE operation_type = 'E' AND issue_date BETWEEN '2021-07-01' AND '2021-07-31'
//       ORDER BY agent_id, `amount`) AS A  
// WHERE indx <= 5
// GROUP BY agent_id, agent_name LIMIT 5;
// ";

// $sql = "
// SELECT agent_id, agent_name, SUM(`amount`) as valor_venda
// FROM (SELECT agent_id, agent_name, `amount`, 
//         IF(@lastAgent=(@lastAgent:=agent_id), @auto:=@auto+1, @auto:=1) indx 
//     FROM invoices, (SELECT @lastAgent:=0, @auto:=1) A 
//     WHERE operation_type = 'S' AND issue_date BETWEEN '".$currentYear."-".$previousMonth."-01' AND '".$currentYear."-".$previousMonth."-".$lastDayPreviousMonth."'
//     ORDER BY agent_id, `amount`) AS A  
// WHERE indx <= 5
// GROUP BY agent_id, agent_name LIMIT 5;
// ";

$sql = "
SELECT agent_id, agent_name, SUM(`commission_amount`) as valor_comissao
FROM (SELECT agent_id, agent_name, `commission_amount`, 
        IF(@lastAgent=(@lastAgent:=agent_id), @auto:=@auto+1, @auto:=1) indx 
    FROM invoices, (SELECT @lastAgent:=0, @auto:=1) A 
    WHERE issue_date BETWEEN '".$currentYear."-".$previousMonth."-01' AND '".$currentYear."-".$previousMonth."-".$lastDayPreviousMonth."'
    ORDER BY agent_id, `commission_amount`) AS A  
WHERE indx <= 5
GROUP BY agent_id, agent_name LIMIT 5;
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$movimentacoes = $stmt->fetchAll();

foreach($movimentacoes as $movimentacao) {

    // print($movimentacao['agent_id'] . "\xA");
    print_r($movimentacao) . "\xA";

}

$pdo = null;

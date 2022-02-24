<?php

include('connection-db.php');

$sql = "select u.agent_id2, u.agent_code, l.numero_lancamento from lancamentos l left join users u on l.representante = u.agent_id2 where l.representante_codigo is null";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$lancamentos = $stmt->fetchAll();

foreach ($lancamentos as $lancamento) {

    $representanteID = $lancamento["agent_id2"];
    $representanteCodigo = $lancamento["agent_code"];
    $lancamentoNumero = $lancamento["numero_lancamento"];

    if(!empty($representanteCodigo)) {
        $sql = "update lancamentos set representante_codigo = '".$representanteCodigo."' where representante = '".$representanteID."' and numero_lancamento = '".$lancamentoNumero."'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

}

$pdo = null;

<?php

include('connection-db.php');

$sql = "select u.agent_id2, u.agent_code, l.numero_documento from lancamentos l left join users u on l.representante = u.agent_id2 where l.representante_codigo = 0";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$lancamentos = $stmt->fetchAll();

foreach ($lancamentos as $lancamento) {

    $representanteID = $lancamento["agent_id2"];
    $representanteCodigo = $lancamento["agent_code"];
    $numeroDocumento = $lancamento["numero_documento"];

    if(!empty($representanteCodigo)) {
        $sql = "update lancamentos set representante_codigo = '".$representanteCodigo."' where representante = '".$representanteID."' and numero_documento = '".$numeroDocumento."'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

}

$pdo = null;

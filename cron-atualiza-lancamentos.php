<?php

include('call-api.php');
include('connection-db.php');

$sql = "select agent_id, agent_id2, agent_code from users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$representantes = $stmt->fetchAll();

foreach ($representantes as $representante__) {

    $representante_id = $representante__["agent_id"];
    $representante_id2 = $representante__["agent_id2"];
    $representante_codigo = $representante__["agent_code"];

    $representante_ids = '';

    if(!empty($representante_id )) {
        $representante_ids = $representante_id;
    }

    if(!empty($representante_id2 )) {
        $representante_ids .= ',' .$representante_id2;
    }

    $representante_codigo = $representante_codigo;

    if(!empty($representante_id)) {
        $sql = "update lancamentos SET representante_codigo = '".$representante_codigo."' where representante in (".$representante_ids.")";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

}

$pdo = null;

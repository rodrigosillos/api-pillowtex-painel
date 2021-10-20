<?php

include('call-api.php');
include('connection-db.php');

//$countItem = 0;

$sql = "select agent_id from users where user_profile_id = 3";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$representantes = $stmt->fetchAll();

foreach ($representantes as $representante__) {

    $representante_id = $representante__["agent_id"];

    $consultaRepresentante = [
        'representante' => $representante_id,
        '$format' => 'json',
    ];
    
    $responseconsultaRepresentante = CallAPI('GET', 'representantes/consulta', $consultaRepresentante);
    $resultconsultaRepresentante = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseconsultaRepresentante), true);

    $representanteRegiao = $resultconsultaRepresentante['value'][0]['regiao'];

    $data = [
        'regiao' => $representanteRegiao,
        'representante_id' => $representante_id,
    ];
    
    $sql = "update users SET regiao = :regiao where agent_id = :representante_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

    //$countItem++;
    //print($countItem . ' - ' . $operationCode . "\xA");

}

$pdo = null;

<?php

include('connection-db.php');

$sql = "select id, n_documento from titulos_receber where origem is null";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$titulosReceber = $stmt->fetchAll();

$contador = 1;

foreach ($titulosReceber as $titulo) {

    $tituloID = $titulo["id"];
    $numeroDocumento = $titulo["n_documento"];

    $sql = "select origem from lancamentos where numero_documento = :numero_documento";
    // $sql = "select origem from lancamentos_base_antiga where numero_documento = :numero_documento";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':numero_documento', $numeroDocumento, PDO::PARAM_STR);
    $stmt->execute();
    $tituloBaseAntiga = $stmt->fetch(\PDO::FETCH_ASSOC);

    if(isset($tituloBaseAntiga['origem'])) {

        $data = [
            'origem' => $tituloBaseAntiga['origem'],
            'id' => $tituloID,
        ];
    
        print_r($data);
    
        $sql = "update titulos_receber set origem = :origem where id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
    }

}

$pdo = null;

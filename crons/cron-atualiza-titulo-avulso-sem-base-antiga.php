<?php

include('connection-db.php');

$sql = "select n_documento, origem, representante_cliente from titulos_receber where representante_pedido is null";
// $sql = "select n_documento, origem from titulos_receber where n_documento = '111535/E'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$titulosReceber = $stmt->fetchAll();

foreach ($titulosReceber as $titulo) {

    $numeroDocumento = $titulo["n_documento"];
    $representanteCliente = $titulo["representante_cliente"];

    $data = [
        'representante_pedido' => $representanteCliente,
        'n_documento' => $numeroDocumento,
    ];

    print_r($data);

    $sql = "update titulos_receber set representante_pedido = :representante_pedido where n_documento = :n_documento";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

$pdo = null;

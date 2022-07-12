<?php

include('connection-db.php');

$sql = "select id, n_documento, origem from titulos_receber where cliente_nome = '' and data_pagamento between '2022-07-01' and '2022-07-31'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$titulosReceber = $stmt->fetchAll();

$contador = 1;

foreach ($titulosReceber as $titulo) {

    $tituloID = $titulo["id"];
    $numeroDocumento = $titulo["n_documento"];
    $origem = $titulo["origem"];

    $sql = "select representante, representante_cod, representante_nome, cliente_nome from movimentacao where cod_operacao = :origem";
    // $sql = "select agent_id, agent_code, agent_name, client_name from invoices where operation_code = :origem";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':origem', $origem, PDO::PARAM_STR);
    $stmt->execute();
    $movimentacao = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {

        $representanteID = $movimentacao['representante'];
        $representanteCodigo = $movimentacao['representante_cod'];
        $representanteNome = $movimentacao['representante_nome'];
        $clienteNome = $movimentacao['cliente_nome'];

        // $representanteID = $movimentacao['agent_id'];
        // $representanteCodigo = $movimentacao['agent_code'];
        // $representanteNome = $movimentacao['agent_name'];
        // $clienteNome = $movimentacao['client_name'];

        $representante = $representanteCodigo . ' - ' . $representanteNome;

        $data = [
            'cliente_nome' => $clienteNome,
            // 'representante_movimento' => $representante,
            // 'representante_pedido' => $representante,
            'n_documento' => $numeroDocumento,
        ];

        print_r($data);

        // $sql = "update titulos_receber set cliente_nome = :cliente_nome, representante_movimento = :representante_movimento, representante_pedido = :representante_pedido where n_documento = :n_documento";
        $sql = "update titulos_receber set cliente_nome = :cliente_nome where n_documento = :n_documento";
        // $sql = "update titulos_receber set origem = :origem where n_documento = :n_documento";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
    }

}

$pdo = null;

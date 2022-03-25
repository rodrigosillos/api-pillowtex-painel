<?php

include('connection-db.php');

$sql = "select n_documento, origem from titulos_receber where cliente_nome = ''"; // data_pagamento between '2022-01-01' and '2022-01-31'
$stmt = $pdo->prepare($sql);
$stmt->execute();
$titulosReceber = $stmt->fetchAll();

$contador = 1;

foreach ($titulosReceber as $titulo) {

    $numeroDocumento = $titulo["n_documento"];
    $origem = $titulo["origem"];

    // print($numeroDocumento . "\xA");

    // $sql = "select origem from lancamentos_base_antiga where numero_documento = :numero_documento";
    // $stmt = $pdo->prepare($sql);
    // $stmt->bindParam(':numero_documento', $numeroDocumento, PDO::PARAM_STR);
    // $stmt->execute();
    // $tituloBaseAntiga = $stmt->fetch(\PDO::FETCH_ASSOC);

    // if ($stmt->rowCount() == 0)
    //     print($contador++ . ' --- n_documento: ' . $numeroDocumento . ' não encontrado na base antiga' . "\xA");

    // if ($stmt->rowCount() > 0) {

        // print($contador++ . ' --- n_documento: ' . $numeroDocumento . ' encontrado na base antiga --- origem: ' . $tituloBaseAntiga['origem'] . "\xA");

        $sql = "select agent_code, agent_name, client_name from invoices where operation_code = :origem";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':origem', $origem, PDO::PARAM_STR);
        $stmt->execute();
        $movimentacao = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($stmt->rowCount() > 0) {

            $representanteCodigo = $movimentacao['agent_code'];
            $representanteNome = $movimentacao['agent_name'];
            $clienteNome = $movimentacao['client_name'];

            print($contador++ . ' --- cliente: ' . $clienteNome . "\xA");

            $representante = $representanteCodigo . ' - ' . $representanteNome;

            $data = [
                'cliente_nome' => $clienteNome,
                'representante_movimento' => $representante,
                'representante_pedido' => $representante,
                'n_documento' => $numeroDocumento,
            ];

            // print_r($data);

            $sql = "update titulos_receber set cliente_nome = :cliente_nome, representante_movimento = :representante_movimento, representante_pedido = :representante_pedido where n_documento = :n_documento";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }

    // }

}

$pdo = null;

<?php

include('connection-db.php');

$sql = "select numero_documento from lancamentos where data_pagamento between '2022-01-01' and '2022-01-31'"; // data_pagamento between '2022-01-01' and '2022-01-31'
$stmt = $pdo->prepare($sql);
$stmt->execute();
$lancamentos = $stmt->fetchAll();

foreach ($lancamentos as $lancamento) {

    $numeroDocumento = $lancamento["numero_documento"];

    // print($numeroDocumento . "\xA");

    $sql = "select origem from lancamentos_base_antiga where numero_documento = :numero_documento";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':numero_documento', $numeroDocumento, PDO::PARAM_STR);
    $stmt->execute();
    $tituloBase = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 0) {
        $sql = "select origem from lancamentos where numero_documento = :numero_documento";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':numero_documento', $numeroDocumento, PDO::PARAM_STR);
        $stmt->execute();
        $tituloBase = $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    if ($stmt->rowCount() > 0) {

        $origem = $tituloBase['origem'];

        print($origem . "\xA");

        $sql = "select agent_code from invoices where operation_code = :origem";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':origem', $origem, PDO::PARAM_STR);
        $stmt->execute();
        $movimentacao = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($stmt->rowCount() > 0) { 

            $representanteCodigo = $movimentacao['agent_code'];

            $data = [
                'representante_codigo' => $representanteCodigo,
                'origem' => $origem,
                'numero_documento' => $numeroDocumento,
            ];

            // print_r($data);

            $sql = "update lancamentos set representante_codigo = :representante_codigo, origem = :origem where numero_documento = :numero_documento";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }
    
    }

}

$pdo = null;

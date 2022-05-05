<?php

include('connection-db.php');

// $sql = "select id, n_documento, origem from titulos_receber where representante_pedido is null";
$sql = "select id, n_documento, origem from titulos_receber where cliente_nome = ''";
// $sql = "select id, n_documento, origem from titulos_receber where n_documento = '111535/E'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$titulosReceber = $stmt->fetchAll();

$contador = 1;

foreach ($titulosReceber as $titulo) {

    $tituloID = $titulo["id"];
    $numeroDocumento = $titulo["n_documento"];

    $sql = "select origem from lancamentos_base_antiga where numero_documento = :numero_documento";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':numero_documento', $numeroDocumento, PDO::PARAM_STR);
    $stmt->execute();
    $tituloBaseAntiga = $stmt->fetch(\PDO::FETCH_ASSOC);

    if(isset($tituloBaseAntiga['origem'])) {

        $sql = "select representante, representante_cod, representante_nome, cliente_nome from movimentacao where cod_operacao = :origem";
        // $sql = "select agent_id, agent_code, agent_name, client_name from invoices where operation_code = :origem";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':origem', $tituloBaseAntiga['origem'], PDO::PARAM_STR);
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
                'representante_movimento' => $representante,
                'representante_pedido' => $representante,
                'n_documento' => $numeroDocumento,
            ];

            print_r($data);

            $sql = "update titulos_receber set cliente_nome = :cliente_nome, representante_movimento = :representante_movimento, representante_pedido = :representante_pedido where n_documento = :n_documento";
            // $sql = "update titulos_receber set origem = :origem where n_documento = :n_documento";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }

    }

}

$pdo = null;

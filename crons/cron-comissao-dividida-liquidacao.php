<?php

include('call-api-novo.php');
include('connection-db.php');

$sql = "select id, n_documento, origem from titulos_receber where data_pagamento between '2023-02-01' and '2023-02-28'";
// $sql = "select id, n_documento, origem from titulos_receber where origem = 8803";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$titulosReceber = $stmt->fetchAll();

foreach ($titulosReceber as $tituloReceber) {

    $tituloID = $tituloReceber["id"];
    $tituloNumero = explode('/', $tituloReceber["n_documento"]);
    $origem = $tituloReceber["origem"];
    
    $valorComissao = 0;

    if($origem) {

        // $sql = "select issue_date, commission_amount from invoices where operation_code = :cod_operacao";
        // $stmt = $pdo->prepare($sql);
        // $stmt->bindParam(':cod_operacao', $origem, PDO::PARAM_STR);
        // $stmt->execute();
        // $movimentacao = $stmt->fetch(\PDO::FETCH_ASSOC);

        $sql = "select valor_comissao, data_emissao from movimentacao where cod_operacao = :cod_operacao";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cod_operacao', $origem, PDO::PARAM_STR);
        $stmt->execute();
        $movimentacao = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($stmt->rowCount() > 0) {

            $valorComissao = $movimentacao['valor_comissao'];
            // $valorComissao = $movimentacao['commission_amount'];
            $numeroParcelas = $pdo->query("select count(*) from titulos_receber where n_documento like '".$tituloNumero[0]."%'")->fetchColumn();
            
            if($valorComissao > 0) {
                
                print('n parcelas: ' . $numeroParcelas . ' - valor comissão: ' . $valorComissao . ' - comissão título: ' . ( ( $valorComissao / 2 ) / $numeroParcelas ) .  "\xA");

                $data = [
                    'valor_comissao' => ( ( $valorComissao / 2 ) / $numeroParcelas ),
                    'id' => $tituloID,
                ];
            
                $sql = "update titulos_receber set valor_comissao = :valor_comissao where id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data);
            }
                
        }

    } 

}

$pdo = null;

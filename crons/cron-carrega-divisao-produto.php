<?php

include('call-api.php');
include('connection-db.php');
    
$paramsListaDivisao = [
    '$format' => 'json',
];

$bodyListaDivisao = CallAPI('GET', 'divisoes/lista', $paramsListaDivisao);
$jsonListaDivisao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyListaDivisao), true);

if(isset($jsonListaDivisao['value'])) {

    foreach ($jsonListaDivisao['value'] as $listaDivisao) {

        $data = [
            'tabela' => 214,
            'cod_divisao' => $listaDivisao['cod_divisao'],
            'descricao_divisao' => $listaDivisao['descricao'],
            'percentual_comissao' => 0,
        ];

        // print_r($data);

        $sql = "INSERT INTO percentual_comissao (
                                        tabela,
                                        cod_divisao,
                                        descricao_divisao,
                                        percentual_comissao) VALUES (:tabela,
                                                                    :cod_divisao,
                                                                    :descricao_divisao,
                                                                    :percentual_comissao)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }

}

$pdo = null;

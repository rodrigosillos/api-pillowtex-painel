<?php

include('call-api.php');
include('connection-db.php');
    
$params = [
    '$format' => 'json',
];

$body = CallAPI('GET', 'tipos_pgtos/lista', $params);
$json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $body), true);

if(isset($json['value'])) {

    foreach ($json['value'] as $item) {

        $data = [
            'tipo_pgto' => $item['tipo_pgto'],
            'descricao' => $item['descricao'],
            'oculto' => 0,
        ];

        // print_r($data);

        $sql = "INSERT INTO tipos_pgto (
                                        tipo_pgto,
                                        descricao,
                                        oculto) VALUES (:tipo_pgto,
                                                        :descricao,
                                                        :oculto)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }

}

$pdo = null;

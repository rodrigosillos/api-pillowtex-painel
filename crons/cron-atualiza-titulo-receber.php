<?php

include('call-api-novo.php');
include('connection-db.php');

$sql = "select n_documento, lancamento, cod from titulos_receber";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$titulosReceber = $stmt->fetchAll();

foreach ($titulosReceber as $tituloReceber) {

    $numeroDocumento = $tituloReceber["n_documento"];
    $lancamento = $tituloReceber["lancamento"];
    $cod = $tituloReceber["cod"];

    $paramsConsultaTitulo = [
        'n_documento' => $numeroDocumento,
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];
    
    $bodyConsultaTitulo = CallAPI('GET', 'titulos_receber/consultartitulosreceber', 'novo', $paramsConsultaTitulo);
    $jsonConsultaTitulo = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaTitulo), true);

    if($jsonConsultaTitulo['odata.count'] > 0) {

        // print('tipo_pgto : ' . $jsonConsultaTitulo['value'][0]['tipo_pgto'] . ' - desc_tipo_pgto: ' . $jsonConsultaTitulo['value'][0]['desc_tipo_pgto'] . "\xA");

        $data = [
            'tipo_pagto' => $jsonConsultaTitulo['value'][0]['tipo_pgto'],
            'desc_tipo_pgto' => $jsonConsultaTitulo['value'][0]['desc_tipo_pgto'],
            'n_documento' => $jsonConsultaTitulo['value'][0]['n_documento'],
            'lancamento' => $lancamento,
            'cod' => $cod,
        ];

        print_r($data);

        $sql = "update titulos_receber set tipo_pagto = :tipo_pagto,
                                                        desc_tipo_pgto = :desc_tipo_pgto 
                                                        where n_documento = :n_documento and
                                                        lancamento = :lancamento and
                                                        cod = :cod";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }

}

$pdo = null;

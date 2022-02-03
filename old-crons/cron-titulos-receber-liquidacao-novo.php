<?php

include('call-api-novo.php');
include('connection-db.php');

$sql = "select numero_documento from lancamentos where data_emissao between '2021-10-01' and '2021-12-31'"; // where numero_documento = '112895/A'
$stmt = $pdo->prepare($sql);
$stmt->execute();
$lancamentos = $stmt->fetchAll();

foreach ($lancamentos as $lancamento__) {

    $parametros = [
        'n_documento' => $lancamento__["numero_documento"],
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];

    $consultaLancamentos = CallAPI('GET', 'titulos_receber/consultartitulosreceber', $parametros);
    $jsonConsultaLancamentos = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $consultaLancamentos), true);
    
    if($jsonConsultaLancamentos['odata.count'] <> 0) {

        $efetuado = 1;

        if($jsonConsultaLancamentos['value'][0]['efetuado'] == '' || $jsonConsultaLancamentos['value'][0]['efetuado'] == false) {
            $efetuado = 0;
        }
    
        $dataPagamento = null;
    
        if($efetuado == 1){
            $dataPagamento = date_create($jsonConsultaLancamentos['value'][0]['data_pagamento']);
            $dataPagamento = date_format($dataPagamento, "Y-m-d H:i:s");
        }
    
        $parametrosUpdate = [
            'efetuado' => $efetuado,
            'data_pagamento' => $dataPagamento,
            'numero_documento' => $lancamento__["numero_documento"],
        ];
        
        $sql = "update lancamentos SET efetuado = :efetuado, data_pagamento = :data_pagamento where numero_documento = :numero_documento";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($parametrosUpdate);
    
        print($lancamento__["numero_documento"] . "\xA");
    } else {
        print('- - - nao encontrado: ' . $lancamento__["numero_documento"] . "\xA");
    }


}

$pdo = null;

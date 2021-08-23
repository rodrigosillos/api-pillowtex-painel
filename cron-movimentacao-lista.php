<?php

include('call-api.php');
include('connection-db.php');

$operacaoTipos = ['S', 'E']; // Saida (Faturamento / Liquidição / Substituição) | Entrada (Dedução)

foreach($operacaoTipos as $tipoOperacao) {

    $parametrosMovimentacaoLista = [
        'tipo_operacao' => $tipoOperacao,
        '$format' => 'json',
        'datai' => '2021-08-01',
        'dataf' => '2021-08-19',
    ];
    
    $MovimentacaoLista = CallAPI('GET', 'movimentacao/lista_movimentacao', $parametrosMovimentacaoLista);
    $jsonMovimentacaoLista = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $MovimentacaoLista), true);
    
    foreach ($jsonMovimentacaoLista['value'] as $movimentacao) {

        $codOperacao = $movimentacao['cod_operacao'];

        $parametrosMovimentacaoConsulta = [
            'tipo_operacao' => $tipoOperacao,
            'cod_operacao' => $codOperacao,
            'ujuros' => 'false',
            '$format' => 'json',
            '$dateformat' => 'iso',
        ];
        
        $movimentacaoConsulta = CallAPI('GET', 'movimentacao/consulta', $parametrosMovimentacaoConsulta);
        $jsonMovimentacaoConsulta = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $movimentacaoConsulta), true);

        $filial = $jsonMovimentacaoConsulta['value'][0]['filial'];

        if($filial == 12 || $filial == 16) {

            $cliente = $jsonMovimentacaoConsulta['value'][0]['cliente'];
            $representante = $jsonMovimentacaoConsulta['value'][0]['representante'];
            $cancelada = $jsonMovimentacaoConsulta['value'][0]['cancelada'];

            if(!is_null($cliente) && !is_null($representante) && $cancelada == false) {
                print($filial . "\xA");
            }

        }       
    
    }

}

$pdo = null;

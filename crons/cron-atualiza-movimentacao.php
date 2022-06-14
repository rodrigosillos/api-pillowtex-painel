<?php

include('call-api.php');
include('connection-db.php');

$sql = "select cod_operacao, tipo_operacao from movimentacao where cod_operacao = 88367";
// $sql = "select cod_operacao, tipo_operacao from movimentacao where tipo_operacao = 'S' and notas is null";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$movimentacoes = $stmt->fetchAll();

foreach ($movimentacoes as $movimentacao) {

    $codOperacao = $movimentacao['cod_operacao'];
    $tipoOperacao = $movimentacao['tipo_operacao'];

    $paramsConsultaMovimentacao = [
        'tipo_operacao' => $tipoOperacao,
        'cod_operacao' => $codOperacao,
        'ujuros' => 'false',
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];
    
    $bodyConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $paramsConsultaMovimentacao);
    $jsonConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaMovimentacao), true);

    if($jsonConsultaMovimentacao['odata.count'] > 0) {

        // $codPedidoV = null;
        // $notas = null;
        // $tipoPedido = '';

        // $pedido = $jsonConsultaMovimentacao['value'][0]['produtos'][0]['pedido'];

        $desconto = $jsonConsultaMovimentacao['value'][0]['caixas']['cortesias']['desconto'];
        $tipoDesc = $jsonConsultaMovimentacao['value'][0]['caixas']['cortesias']['tipo_desc'];
        $correcao = $jsonConsultaMovimentacao['value'][0]['caixas']['cortesias']['correcao'];

        // if ($pedido != null) {

        //     $paramsConsultaPedidoVenda = [
        //         'pedidov' => $pedido,
        //         '$format' => 'json',
        //         '$dateformat' => 'iso',
        //     ];
    
        //     $bodyConsultaPedidoVenda = CallAPI('GET', 'pedido_venda/consulta_simples', $paramsConsultaPedidoVenda);
        //     $jsonConsultaPedidoVenda = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaPedidoVenda), true);
    
        //     if($jsonConsultaPedidoVenda['odata.count'] > 0) {
    
        //         $codPedidoV = $jsonConsultaPedidoVenda['value'][0]['cod_pedidov'];
        //         $notas = $jsonConsultaPedidoVenda['value'][0]['notas'];
        //         $tipoPedido = $jsonConsultaPedidoVenda['value'][0]['tipo_pedido'];
            
        //     }

        // }
    
        // $data = [
        //     'cod_operacao' => $codOperacao,
        //     'pedidov' => $pedido,
        //     'cod_pedidov' => $codPedidoV,
        //     'notas' => $notas,
        //     'tipo_pedido' => $tipoPedido,
        // ];

        $data = [
            'cod_operacao' => $codOperacao,
            'correcao' => $correcao,
            'desconto' => $desconto,
            'tipo_desc' => $tipoDesc,
        ];

        print_r($data);
        
        $sql = "update movimentacao SET correcao = :correcao,
                                        desconto = :desconto,
                                        tipo_desc = :tipo_desc
                                    where cod_operacao = :cod_operacao";

        $stmt = $pdo->prepare($sql);
        // $stmt->execute($data);

    }

}

$pdo = null;

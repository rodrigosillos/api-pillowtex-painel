<?php

include('call-api.php');
include('connection-db.php');

$movimentacoes = [
    '87420',
    '86338',
    '85342',
    '85339',
    '84905',
    '84343',
    '84040',
    '85103',
];

foreach ($movimentacoes as $movimentacao) {

    $paramsConsultaMovimentacao = [
        'tipo_operacao' => 'S',
        'cod_operacao' => $movimentacao,
        'ujuros' => 'false',
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];
    
    $bodyConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $paramsConsultaMovimentacao);
    $jsonConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaMovimentacao), true);

    if(isset($jsonConsultaMovimentacao['value'])) {

        $codOperacao = $jsonConsultaMovimentacao['value'][0]['cod_operacao'];

        $sql = "select id from movimentacao WHERE cod_operacao = :cod_operacao";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cod_operacao', $codOperacao, PDO::PARAM_STR);
        $stmt->execute();
    
        if($stmt->rowCount() == 0) {

            $filial = $jsonConsultaMovimentacao['value'][0]['filial'];
            $cliente = $jsonConsultaMovimentacao['value'][0]['cliente'];
            $cancelada = $jsonConsultaMovimentacao['value'][0]['cancelada'];          
            
            print($filial  . ' - ' . $cliente . ' - ' . $cancelada . "\xA");
    
            if($filial == 12 && $cliente <> null && $cancelada == 0 || $filial == 16 && $cliente <> null && $cancelada == 0) {   
                
                
                print('CADASTRANDO NOVA MOVIMENTACAO - cod operacao: ' . $codOperacao . "\xA");
                
                $tipoOperacao = $jsonConsultaMovimentacao['value'][0]['tipo_operacao'];
                $romaneio = $jsonConsultaMovimentacao['value'][0]['romaneio'];
                $ticket = $jsonConsultaMovimentacao['value'][0]['ticket'];
                $dataEmissao = date_format(date_create($jsonConsultaMovimentacao['value'][0]['data']), "Y-m-d H:i:s");
                $cliente = $jsonConsultaMovimentacao['value'][0]['cliente'];
                $representante = $jsonConsultaMovimentacao['value'][0]['representante'];
                $representanteCliente = $jsonConsultaMovimentacao['value'][0]['representante_cliente'];
                $evento = $jsonConsultaMovimentacao['value'][0]['evento'];
                $tabela = $jsonConsultaMovimentacao['value'][0]['tabela'];
                $filial = $jsonConsultaMovimentacao['value'][0]['filial'];
                $cortesia = $jsonConsultaMovimentacao['value'][0]['cortesia'];
                $comissaoF = $jsonConsultaMovimentacao['value'][0]['comissao_f'];
                $comissaoG = $jsonConsultaMovimentacao['value'][0]['comissao_g'];
                $comissaoR = $jsonConsultaMovimentacao['value'][0]['comissao_r'];
                $comissaoRCli = $jsonConsultaMovimentacao['value'][0]['comissao_r_cli'];
                $comissaoS = $jsonConsultaMovimentacao['value'][0]['comissao_s'];
                $tipoComissaoF = $jsonConsultaMovimentacao['value'][0]['tipo_comissao_f'];
                $tipoComissaoR = $jsonConsultaMovimentacao['value'][0]['tipo_comissao_r'];
                $tipoComissaoRCli = $jsonConsultaMovimentacao['value'][0]['tipo_comissao_r_cli'];
                $tipoComissaoROri = $jsonConsultaMovimentacao['value'][0]['tipo_comissao_r_ori'];
                $tipoConsignacao = $jsonConsultaMovimentacao['value'][0]['tipo_consignacao'];
                $valorFinal = $jsonConsultaMovimentacao['value'][0]['valor_final'];
                $total = $jsonConsultaMovimentacao['value'][0]['total'];
                $qtde = $jsonConsultaMovimentacao['value'][0]['qtde'];
                $tipo = $jsonConsultaMovimentacao['value'][0]['tipo'];
                $cancelada = $jsonConsultaMovimentacao['value'][0]['cancelada'];
                $pedidoV = $jsonConsultaMovimentacao['value'][0]['produtos'][0]['pedido'];
                $condicoesPgto = $jsonConsultaMovimentacao['value'][0]['condicoes_pgto'];
    
                // pedido venda

                $codPedidoV = '';
                $notas = '';
                $tipoPedido = '';

                if(!is_null($pedidoV)) {

                    $paramsConsultaPedidoVenda = [
                        'pedidov' => $pedidoV,
                        '$format' => 'json',
                        '$dateformat' => 'iso',
                    ];
            
                    $bodyConsultaPedidoVenda = CallAPI('GET', 'pedido_venda/consulta_simples', $paramsConsultaPedidoVenda);
                    $jsonConsultaPedidoVenda = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaPedidoVenda), true);
        
                    if($jsonConsultaPedidoVenda['odata.count'] > 0) {
        
                        $codPedidoV = $jsonConsultaPedidoVenda['value'][0]['cod_pedidov'];
                        $notas = $jsonConsultaPedidoVenda['value'][0]['notas'];
                        $tipoPedido = $jsonConsultaPedidoVenda['value'][0]['tipo_pedido'];
                    
                    }                            

                }
    
                // pedido venda fim
    
                // consulta cliente
    
                $paramsCliente = [
                    'cliente' => $cliente,
                    '$format' => 'json',
                ];
            
                $bodyConsultaCliente = CallAPI('GET', 'clientes/consultasimples', $paramsCliente);
                $jsonConsultaCliente = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaCliente), true);
                
                $clienteCodigo = '';
                $clienteNome = '';
                $clientUF = '';
    
                if ($jsonConsultaCliente['odata.count'] > 0) {
                    $clienteCodigo = $jsonConsultaCliente['value'][0]['cod_cliente'];
                    $clienteNome = $jsonConsultaCliente['value'][0]['nome'];
                    $clientUF = $jsonConsultaCliente['value'][0]['estado'];
                }
    
                // fim consulta cliente
    
                // consulta representante
    
                $paramsConsultaRepresentante = [
                    'representante' => $representante,
                    '$format' => 'json',
                ];
            
                $bodyConsultaRepresentante = CallAPI('GET', 'representantes/consulta', $paramsConsultaRepresentante);
                $jsonConsultaRepresentante = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaRepresentante), true);
                
                $representanteCodigo = '';
                $representanteNome = '';
    
                if ($jsonConsultaRepresentante['odata.count'] > 0) {
                    $representanteCodigo = $jsonConsultaRepresentante['value'][0]['cod_representante'];
                    $representanteNome = $jsonConsultaRepresentante['value'][0]['geradores'][0]['nome'];
                }
    
                // fim consulta representante
    
                // consulta representante cliente
    
                $paramsConsultaRepresentante = [
                    'representante' => $representanteCliente,
                    '$format' => 'json',
                ];
            
                $bodyConsultaRepresentante = CallAPI('GET', 'representantes/consulta', $paramsConsultaRepresentante);
                $jsonConsultaRepresentante = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaRepresentante), true);
                
                $representanteClienteCodigo = '';
                $representanteClienteNome = '';
    
                if ($jsonConsultaRepresentante['odata.count'] > 0) {
                    $representanteClienteCodigo = $jsonConsultaRepresentante['value'][0]['cod_representante'];
                    $representanteClienteNome = $jsonConsultaRepresentante['value'][0]['geradores'][0]['nome'];
                }
    
                // fim consulta representante cliente
    
                $data = [
                    'cod_operacao' => $codOperacao,
                    'tipo_operacao' => $tipoOperacao,
                    'romaneio' => $romaneio,
                    'ticket' => $ticket,
                    'data_emissao' => $dataEmissao,
                    'cliente' => $cliente,
                    'cliente_codigo' => $clienteCodigo,
                    'cliente_nome' => substr($clienteNome, 0, 60),
                    'cliente_estado' => $clientUF,
                    'representante' => $representante,
                    'representante_cod' => $representanteCodigo,
                    'representante_nome' => $representanteNome,
                    'representante_cliente' => $representanteCliente,
                    'representante_cliente_cod' => $representanteClienteCodigo,
                    'representante_cliente_nome' => $representanteClienteNome,
                    'evento' => $evento,
                    'tabela' => $tabela,
                    'filial' => $filial,
                    'cortesia' => $cortesia,
                    'comissao_f' => $comissaoF,
                    'comissao_g' => $comissaoG,
                    'comissao_r' => $comissaoR,
                    'comissao_r_cli' => $comissaoRCli,
                    'comissao_s' => $comissaoS,
                    'tipo_comissao_f' => $tipoComissaoF,
                    'tipo_comissao_r' => $tipoComissaoR,
                    'tipo_comissao_r_cli' => $tipoComissaoRCli,
                    'tipo_comissao_r_ori' => $tipoComissaoROri,
                    'tipo_consignacao' => $tipoConsignacao,
                    'valor_final' => $valorFinal,
                    'total' => $total,
                    'qtde' => $qtde,
                    'tipo' => $tipo,
                    'cancelada' => $cancelada == false ? 0 : 1,
                    'notas' => $notas,
                    'pedidov' => $pedidoV,
                    'cod_pedidov' => $codPedidoV,
                    'tipo_pedido' => $tipoPedido,
                    'condicoes_pgto' => $condicoesPgto,
                    'oculto' => 0,
                ];
            
                $sql  = "INSERT INTO movimentacao (cod_operacao,
                                                    tipo_operacao,
                                                    romaneio,
                                                    ticket,
                                                    data_emissao,
                                                    cliente,
                                                    cliente_codigo,
                                                    cliente_nome,
                                                    cliente_estado,
                                                    representante,
                                                    representante_cod,
                                                    representante_nome,
                                                    representante_cliente,
                                                    representante_cliente_cod,
                                                    representante_cliente_nome,
                                                    evento,
                                                    tabela,
                                                    filial,
                                                    cortesia,
                                                    comissao_f,
                                                    comissao_g,
                                                    comissao_r,
                                                    comissao_r_cli,
                                                    comissao_s,
                                                    tipo_comissao_f,
                                                    tipo_comissao_r,
                                                    tipo_comissao_r_cli,
                                                    tipo_comissao_r_ori,
                                                    tipo_consignacao,
                                                    valor_final,
                                                    total,
                                                    qtde,
                                                    tipo,
                                                    cancelada,
                                                    notas,
                                                    pedidov,
                                                    cod_pedidov,
                                                    tipo_pedido,
                                                    condicoes_pgto,
                                                    oculto) VALUES (:cod_operacao,
                                                                    :tipo_operacao,
                                                                    :romaneio, 
                                                                    :ticket,
                                                                    :data_emissao,
                                                                    :cliente,
                                                                    :cliente_codigo,
                                                                    :cliente_nome,
                                                                    :cliente_estado,
                                                                    :representante,
                                                                    :representante_cod,
                                                                    :representante_nome,
                                                                    :representante_cliente,
                                                                    :representante_cliente_cod,
                                                                    :representante_cliente_nome,
                                                                    :evento,
                                                                    :tabela,
                                                                    :filial,
                                                                    :cortesia,
                                                                    :comissao_f,
                                                                    :comissao_g,
                                                                    :comissao_r,
                                                                    :comissao_r_cli,
                                                                    :comissao_s,
                                                                    :tipo_comissao_f,
                                                                    :tipo_comissao_r,
                                                                    :tipo_comissao_r_cli,
                                                                    :tipo_comissao_r_ori,
                                                                    :tipo_consignacao,
                                                                    :valor_final,
                                                                    :total,
                                                                    :qtde,
                                                                    :tipo,
                                                                    :cancelada,
                                                                    :notas,
                                                                    :pedidov,
                                                                    :cod_pedidov,
                                                                    :tipo_pedido,
                                                                    :condicoes_pgto,
                                                                    :oculto)";
        
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data);
    
            }

        } else {

            print($filial  . ' - ' . $cliente . ' - ' . $cancelada . "\xA");
            print('- - - MOVIMENTACAO JA EXISTE NA BASE - cod operacao: ' . $codOperacao . "\xA");

        }

    }

}

$pdo = null;

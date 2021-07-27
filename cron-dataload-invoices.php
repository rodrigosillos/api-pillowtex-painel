<?php

include('call-api.php');
include('connection-db.php');

$operationTypes = ['S', 'E']; // Entrada (Dedução) / Saida (Faturamento 50% / Substituição / Liquidição)

$countItem = 0;
$invoiceFilial = 0;

foreach($operationTypes as $operationType) {

    $dataListaMovimentacao = [
        'datai' => '2021-07-09',
        'dataf' => '2021-07-23',
        '$format' => 'json',
        'tipo_operacao' => $operationType,
    ];
    
    $responseListaMovimentacao = CallAPI('GET', 'movimentacao/lista_movimentacao', $dataListaMovimentacao);
    $resultListaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseListaMovimentacao), true);
    
    foreach ($resultListaMovimentacao['value'] as $valueListaMovimentacao) {

        print(' . ' . "\xA");
    
        $dataConsultaMovimentacao = [
            'tipo_operacao' => $operationType,
            'cod_operacao' => $valueListaMovimentacao['cod_operacao'],
            'ujuros' => 'false',
            '$format' => 'json',
            '$dateformat' => 'iso',
        ];
        
        $responseConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $dataConsultaMovimentacao);
        $resultConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaMovimentacao), true);

        if($resultConsultaMovimentacao['odata.count'] > 0) {

            if($resultConsultaMovimentacao['value'][0]['cliente'] != null && $resultConsultaMovimentacao['value'][0]['cancelada'] == false){

                $invoiceFilial = $resultConsultaMovimentacao['value'][0]['filial'];
                //$invoiceAgentId = $resultConsultaMovimentacao['value'][0]['representante_cliente'];
                
                if($invoiceFilial == 12 || $invoiceFilial == 16) {
        
                    $orderId = $resultConsultaMovimentacao['value'][0]['produtos'][0]['pedido'];
                    $orderCode = '';
                    $invoiceNumber = isset($resultConsultaMovimentacao['value'][0]['notas'][0]) ? $resultConsultaMovimentacao['value'][0]['notas'][0]['nota'] : '';
                    $invoiceType = '';
                
                    if(!is_null($orderId) && !empty($invoiceNumber)) {
                
                        $dataConsultaPedidoVenda = [
                            'pedidov' => $orderId,
                            '$format' => 'json',
                            '$dateformat' => 'iso',
                        ];
                
                        $responseConsultaPedidoVenda = CallAPI('GET', 'pedido_venda/consulta_simples', $dataConsultaPedidoVenda);
                        $resultConsultaPedidoVenda = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaPedidoVenda), true);
                
                        if($resultConsultaPedidoVenda['odata.count'] > 0){

                            $orderCode = $resultConsultaPedidoVenda['value'][0]['cod_pedidov'];
                            $invoiceNumber = $resultConsultaPedidoVenda['value'][0]['notas'];
                            $invoiceType = $resultConsultaPedidoVenda['value'][0]['tipo_pedido'];
                        
                        } else {
                            print('erro no metodo (pedido_venda/consulta_simples): operacao: ' . $valueListaMovimentacao['cod_operacao'] . ' - pedido: ' . $orderId . "\xA");
                            $txt = "erro no metodo (pedido_venda/consulta_simples): operacao: " . $valueListaMovimentacao['cod_operacao'] . " - pedido: " . $orderId;
                            $myfile = file_put_contents('log-dataload-invoices.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

                        }
                
                    }
                
                    $issueDate = date_create($resultConsultaMovimentacao['value'][0]['data']);
                    $issueDate = date_format($issueDate, "Y-m-d H:i:s");
                
                    // join client
                    $dataConsultaCliente = [
                        'cliente' => $resultConsultaMovimentacao['value'][0]['cliente'],
                        '$format' => 'json',
                    ];
                
                    $responseConsultaCliente = CallAPI('GET', 'clientes/consultasimples', $dataConsultaCliente);
                    $resultConsultaCliente = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaCliente), true);
                    
                    $clientCode = '';
                    $clientName = '';
                    $clientAddress = '';

                    if ($resultConsultaCliente['odata.count'] > 0) {
                        $clientCode = $resultConsultaCliente['value'][0]['cod_cliente'];
                        $clientName = $resultConsultaCliente['value'][0]['nome'];
                        $clientAddress = $resultConsultaCliente['value'][0]['estado'];
                    }

                    $dataConsultaRepresentante = [
                        'representante' => $resultConsultaMovimentacao['value'][0]['representante'],
                        '$format' => 'json',
                    ];
                
                    $responseConsultaRepresentante = CallAPI('GET', 'representantes/consulta', $dataConsultaRepresentante);
                    $resultConsultaRepresentante = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseConsultaRepresentante), true);
                    
                    $agentCode = '';
                    $agentName = '';
        
                    if ($resultConsultaRepresentante['odata.count'] > 0) {
                        $agentCode = $resultConsultaRepresentante['value'][0]['cod_representante'];
                        $agentName = $resultConsultaRepresentante['value'][0]['geradores'][0]['nome'];
                    }
                
                    $data = [
                        'operation_code' => $valueListaMovimentacao['cod_operacao'],
                        'document' => $resultConsultaMovimentacao['value'][0]['romaneio'],
                        'ticket' => $resultConsultaMovimentacao['value'][0]['ticket'],
                        'issue_date' => $issueDate,
                        'client_id' => $resultConsultaMovimentacao['value'][0]['cliente'],
                        'client_code' => $clientCode,
                        'client_name' => $clientName,
                        'client_address' => $clientAddress,
                        'agent_id' => $resultConsultaMovimentacao['value'][0]['representante'],
                        'agent_code' => $agentCode,
                        'agent_name' => $agentName,
                        'price_list' => $resultConsultaMovimentacao['value'][0]['tabela'],
                        'amount' => $resultConsultaMovimentacao['value'][0]['valor_final'],
                        'invoice_type' => $invoiceType,
                        'operation_type' => $operationType,
                        'canceled' => $resultConsultaMovimentacao['value'][0]['cancelada'],
                        'order_code' => $orderCode,
                        'invoice' => $invoiceNumber,
                        'courtesy' => $resultConsultaMovimentacao['value'][0]['cortesia'],
                        'hidden' => 0,
                    ];
                
                    $sql  = "INSERT INTO invoices (
                                                    operation_code,
                                                    document,
                                                    ticket,
                                                    issue_date, 
                                                    client_id, 
                                                    client_code, 
                                                    client_name, 
                                                    client_address, 
                                                    agent_id,
                                                    agent_code,
                                                    agent_name,
                                                    price_list,
                                                    amount, 
                                                    invoice_type,
                                                    operation_type,
                                                    canceled,
                                                    order_code,
                                                    invoice,
                                                    courtesy,
                                                    hidden) VALUES (
                                                                    :operation_code,
                                                                    :document,
                                                                    :ticket,
                                                                    :issue_date,
                                                                    :client_id,
                                                                    :client_code,
                                                                    :client_name,
                                                                    :client_address,
                                                                    :agent_id,
                                                                    :agent_code,
                                                                    :agent_name,
                                                                    :price_list,
                                                                    :amount,
                                                                    :invoice_type,
                                                                    :operation_type,
                                                                    :canceled,
                                                                    :order_code,
                                                                    :invoice,
                                                                    :courtesy,
                                                                    :hidden)";
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($data);

                    $countItem++;
                    print($countItem . ' - ' . $operationType . "\xA");

                }

            }
        
        }
        
    }

}

$pdo = null;

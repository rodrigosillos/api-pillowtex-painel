<?php

include('call-api.php');
include('connection-db.php');

// $stmt = $pdo->prepare("select client_name, operation_code, operation_type, commission_amount from invoices where issue_date between '2021-12-01' and '2021-12-30'");
// $stmt = $pdo->prepare("select client_name, operation_code, operation_type, commission_amount from invoices where agent_id in (232, 263, 261)");
$stmt = $pdo->prepare("select client_name, operation_code, operation_type, commission_amount from invoices where agent_id = 6 and hidden = 0 and issue_date between '2021-12-01' and '2021-12-31'");
$stmt->execute();
$movimentacoes = $stmt->fetchAll();

foreach ($movimentacoes as $movimentacao) {

    $clienteNome = $movimentacao["client_name"];
    $operacaoTipo = $movimentacao["operation_type"];
    $operacaoCodigo = $movimentacao["operation_code"];
    $movimentacaoComissao = $movimentacao["commission_amount"];

    $lancamentosJaExiste = $pdo->query('select id from lancamentos where origem = '.$operacaoCodigo)->fetchColumn();

    // if($lancamentosJaExiste == 0) {

        $parametros = [
            'tipo_operacao' => $operacaoTipo,
            'cod_operacao' => $operacaoCodigo,
            'tipo' => 'R',
            '$format' => 'json',
            '$dateformat' => 'iso',
        ];
    
        $consultaLancamentos = CallAPI('GET', 'movimentacao/consulta_lancamentos', $parametros);
        $jsonConsultaLancamentos = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $consultaLancamentos), true);
        
        $qtdLancamentos = $jsonConsultaLancamentos['odata.count'];
    
        foreach ($jsonConsultaLancamentos['value'] as $lancamentoValue) {
    
            print($lancamentoValue['lancamento'] . "\xA");
    
            $parametros = [
                'lancamento' => $lancamentoValue['lancamento'],
                '$format' => 'json',
                '$dateformat' => 'iso',
            ];
        
            $consultaTitulos = CallAPI('GET', 'titulos_receber/consulta', $parametros);
            $jsonConsultaTitulos = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $consultaTitulos), true);
    
            $dataEmissao = date_create($jsonConsultaTitulos['value'][0]['data_emissao']);
            $dataEmissao = date_format($dataEmissao, "Y-m-d H:i:s");
    
            $dataVencimento = date_create($jsonConsultaTitulos['value'][0]['data_vencimento']);
            $dataVencimento = date_format($dataVencimento, "Y-m-d H:i:s");

            $dataPagamento = null;

            // print($jsonConsultaTitulos['value'][0]['data_pagamento'] . "\xA");
    
            $efetuado = $jsonConsultaTitulos['value'][0]['efetuado'] == false ? 0 : 1;
            $substituido = $jsonConsultaTitulos['value'][0]['substituido'] == false ? 0 : 1;
    
            $valorComissao = 0;
            if($efetuado == 1 && $substituido == 0) {
                $valorComissao = (($movimentacaoComissao / 2) / $qtdLancamentos);

                $dataPagamento = date_create($jsonConsultaTitulos['value'][0]['data_pagamento']);
                $dataPagamento = date_format($dataPagamento, "Y-m-d H:i:s");
            }                
    
            $clienteNome = substr($clienteNome, 0, 100);

            $data = [
                'conta' => $jsonConsultaTitulos['value'][0]['conta'],
                'numero_lancamento' => $jsonConsultaTitulos['value'][0]['lancamento'],
                'numero_documento' => $jsonConsultaTitulos['value'][0]['n_documento'],
                'data_emissao' => $dataEmissao,
                'data_vencimento' => $dataVencimento,
                'data_pagamento' => $dataPagamento,
                'efetuado' => $efetuado,
                'substituido' => $substituido,
                'valor_inicial' => $jsonConsultaTitulos['value'][0]['valor_inicial'],
                'valor_pago' => is_null($jsonConsultaTitulos['value'][0]['valor_pago']) ? 0 : $jsonConsultaTitulos['value'][0]['valor_pago'],
                'valor_comissao' => $valorComissao,
                'filial' => $jsonConsultaTitulos['value'][0]['filial'],
                'origem' => $jsonConsultaTitulos['value'][0]['origem'],
                'tipo' => $jsonConsultaTitulos['value'][0]['tipo'],
                'representante' => $jsonConsultaTitulos['value'][0]['representante'],
                'cliente_nome' => $clienteNome,
                'obs' => $jsonConsultaTitulos['value'][0]['obs'],
            ];
            
            $stmt = $pdo->prepare("INSERT INTO lancamentos (
                                                            conta,
                                                            numero_lancamento,
                                                            numero_documento,
                                                            data_emissao,
                                                            data_vencimento,
                                                            data_pagamento, 
                                                            efetuado, 
                                                            substituido, 
                                                            valor_inicial,
                                                            valor_pago,
                                                            valor_comissao,
                                                            filial,
                                                            origem,
                                                            tipo,
                                                            representante,
                                                            cliente_nome,
                                                            obs) VALUES (
                                                                        :conta,
                                                                        :numero_lancamento,
                                                                        :numero_documento,
                                                                        :data_emissao,
                                                                        :data_vencimento,
                                                                        :data_pagamento,
                                                                        :efetuado,
                                                                        :substituido,
                                                                        :valor_inicial,
                                                                        :valor_pago,
                                                                        :valor_comissao,
                                                                        :filial,
                                                                        :origem,
                                                                        :tipo,
                                                                        :representante,
                                                                        :cliente_nome,
                                                                        :obs)");
    
            // $stmt->execute($data);
    
        }

    // }

}

$pdo = null;

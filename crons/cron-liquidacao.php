<?php

include('call-api-novo.php');
include('connection-db.php');

// $sql = "select distinct(agent_id) from invoices where issue_date between '2022-01-01' and '2022-01-26'"; // where numero_documento = '112895/A'
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $lancamentos = $stmt->fetchAll();

// foreach ($lancamentos as $lancamento__) {

$count = 0;

$parametros = [
    'efetuado' => 'true',
    'substituido' => 'false',
    // 'representante' => 5,
    '$format' => 'json',
    '$dateformat' => 'iso',
];

$consultaLancamentos = CallAPI('GET', 'titulos_receber/consulta_receber_recebidos', 'novo', $parametros);
$jsonConsultaLancamentos = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $consultaLancamentos), true);

if($jsonConsultaLancamentos['odata.count'] > 0) {

    foreach ($jsonConsultaLancamentos['value'] as $lancamentoValue) {

        $sql = "select efetuado, data_pagamento from lancamentos where numero_lancamento = :numero_lancamento and numero_documento = :numero_documento";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':numero_lancamento', $lancamentoValue['lancamento'], PDO::PARAM_STR);
        $stmt->bindParam(':numero_documento', $lancamentoValue['n_documento'], PDO::PARAM_STR);
        $stmt->execute();
        $lancamento = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($stmt->rowCount() == 0) {

            print($count++ . "\xA");
            
            $dataEmissao = date_create($lancamentoValue['data_emissao']);
            $dataEmissao = date_format($dataEmissao, "Y-m-d H:i:s");

            $dataVencimento = date_create($lancamentoValue['data_vencimento']);
            $dataVencimento = date_format($dataVencimento, "Y-m-d H:i:s");

            $dataPagamento = date_create($lancamentoValue['data_pagamento']);
            $dataPagamento = date_format($dataPagamento, "Y-m-d H:i:s");

            $efetuado = $lancamentoValue['efetuado'] == false ? 0 : 1;
            $substituido = $lancamentoValue['substituido'] == false ? 0 : 1;

            $devolucao = 0;
            $movimentacaoComissao = 0;
            $clienteNome = '';
            $representanteCodigo = 0;
            $valorComissao = 0;

            $data = [
                'conta' => is_null($lancamentoValue['pconta']) ? '' : $lancamentoValue['pconta'],
                'numero_lancamento' => $lancamentoValue['lancamento'],
                'numero_documento' => $lancamentoValue['n_documento'],
                'data_emissao' => $dataEmissao,
                'data_vencimento' => $dataVencimento,
                'data_pagamento' => $dataPagamento,
                'efetuado' => $efetuado,
                'substituido' => $substituido,
                'valor_inicial' => $lancamentoValue['valor_inicial'],
                'valor_pago' => is_null($lancamentoValue['valor_pago']) ? 0 : $lancamentoValue['valor_pago'],
                'valor_comissao' => $valorComissao,
                'filial' => $lancamentoValue['filial'],
                'origem' => $lancamentoValue['origem'],
                'tipo' => $lancamentoValue['tipo'],
                'representante' => $lancamentoValue['representante'],
                'representante_codigo' => $representanteCodigo,
                'cliente_nome' => $clienteNome,
                'obs' => $lancamentoValue['obs'],
                'devolucao' => $devolucao,
            ];
            
            $stmt = $pdo->prepare("INSERT INTO lancamentos (conta,
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
                                                            representante_codigo,
                                                            cliente_nome,
                                                            obs,
                                                            devolucao) VALUES (:conta,
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
                                                                                :representante_codigo,
                                                                                :cliente_nome,
                                                                                :obs,
                                                                                :devolucao)");
            $stmt->execute($data);

        }

        // if ($lancamentoValue['representante_cliente'] == '0005 - CAISA GIFT') {



            // $explodeOrigem = explode('/', $lancamentoValue['n_documento']);
            // $lancamentoValue['origem'] = $explodeOrigem[0];

            // if(strpos($dataPagamento, '2022-01-') !== false) {

                // $sql = "select efetuado, data_pagamento from lancamentos where numero_lancamento = :numero_lancamento and numero_documento = :numero_documento";
                // $stmt = $pdo->prepare($sql);
                // $stmt->bindParam(':numero_lancamento', $lancamentoValue['lancamento'], PDO::PARAM_STR);
                // $stmt->bindParam(':numero_documento', $lancamentoValue['n_documento'], PDO::PARAM_STR);
                // $stmt->execute();
                // $lancamento = $stmt->fetch(\PDO::FETCH_ASSOC);                
            
                // if ($stmt->rowCount() > 0) {

                //     $data = [
                //         'efetuado' => $efetuado,
                //         'data_pagamento' => $dataPagamento,
                //         'numero_lancamento' => $lancamentoValue['lancamento'],
                //         'numero_documento' => $lancamentoValue['n_documento'],
                //     ];
                    
                //     $sql = "update lancamentos SET efetuado = :efetuado, data_pagamento = :data_pagamento where substituido = 0 and numero_lancamento = :numero_lancamento and numero_documento = :numero_documento";
                //     $stmt = $pdo->prepare($sql);
                //     $stmt->execute($data);

                // } else {

            // $parametros = [
            //     'tipo_operacao' => 'S',
            //     'cod_operacao' => $lancamentoValue['origem'],
            //     'tipo' => 'R',
            //     '$format' => 'json',
            //     '$dateformat' => 'iso',
            // ];
        
            // $consultaParcelas = CallAPI('GET', 'movimentacao/consulta_lancamentos', 'old server', $parametros);
            // $jsonConsultaParcelas = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $consultaParcelas), true);
            // $quantidadeParcelas = $jsonConsultaParcelas['odata.count'];

            // Movimentação
            // $sql = "select commission_amount, client_name from invoices where operation_code = :origem";
            // $stmt = $pdo->prepare($sql);
            // $stmt->bindParam(':origem', $lancamentoValue['origem'], PDO::PARAM_STR);
            // $stmt->execute();
            // $movimentacao = $stmt->fetch(\PDO::FETCH_ASSOC);

            // $movimentacaoComissao = 0;
            // $clienteNome = 'Cliente Nulo - Origem nao encontrada';

            // if ($stmt->rowCount() > 0) {
            //     $movimentacaoComissao = $movimentacao['commission_amount'];
            //     $clienteNome = substr($movimentacao['client_name'], 0, 100);
            //     print($clienteNome . ' - ' . $lancamentoValue['origem'] . "\xA");
            // }

            // if ($stmt->rowCount() == 0)
            //     print($clienteNome . ' - ' . $lancamentoValue['origem'] . "\xA");

            // Representante
            // $sql = "select agent_code from users where agent_id2 = :representante";
            // $stmt = $pdo->prepare($sql);
            // $stmt->bindParam(':representante', $lancamentoValue['representante'], PDO::PARAM_STR);
            // $stmt->execute();
            // $representante = $stmt->fetch(\PDO::FETCH_ASSOC);

            // $representanteCodigo = $representante['agent_code'];

            // $valorComissao = 0;

            // if($quantidadeParcelas > 0)
            //     $valorComissao = (($movimentacaoComissao / 2) / $quantidadeParcelas);



                // }

            // }
            
        // }

    }
    
}

// }

$pdo = null;

<?php

include('../call-api-novo.php');
include('../connection-db.php');

// $sql = "select distinct(agent_id) from invoices where issue_date between '2022-01-01' and '2022-01-26'"; // where numero_documento = '112895/A'
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $lancamentos = $stmt->fetchAll();

// foreach ($lancamentos as $lancamento__) {

    $parametros = [
        'efetuado' => 'true',
        'substituido' => 'false',
        'representante' => 5,
        '$format' => 'json',
        '$dateformat' => 'iso',
    ];

    $consultaLancamentos = CallAPI('GET', 'titulos_receber/consulta_receber_recebidos', 'novo', $parametros);
    $jsonConsultaLancamentos = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $consultaLancamentos), true);

    // print($jsonConsultaLancamentos['odata.count'] . "\xA");

    if($jsonConsultaLancamentos['odata.count'] > 0) {

        foreach ($jsonConsultaLancamentos['value'] as $lancamentoValue) {

            $dataEmissao = date_create($lancamentoValue['data_emissao']);
            $dataEmissao = date_format($dataEmissao, "Y-m-d H:i:s");

            $dataVencimento = date_create($lancamentoValue['data_vencimento']);
            $dataVencimento = date_format($dataVencimento, "Y-m-d H:i:s");

            $dataPagamento = date_create($lancamentoValue['data_pagamento']);
            $dataPagamento = date_format($dataPagamento, "Y-m-d H:i:s");

            if(strpos($dataPagamento, '2022-01-') !== false) {

                $sql = "select efetuado, data_pagamento from lancamentos where substituido = 0 and numero_documento = :numero_documento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':numero_documento', $lancamentoValue['n_documento'], PDO::PARAM_STR);
                $stmt->execute();
                $lancamento = $stmt->fetch(\PDO::FETCH_ASSOC);

                // if ($stmt->rowCount() > 1)
                //     print($stmt->rowCount() . ' - ' . $lancamentoValue['n_documento'] . "\xA");
            
                if ($stmt->rowCount() > 0) {

                    // print($lancamentoValue['n_documento'] . '  ' . $dataPagamento . "\xA");
                    // print($lancamento['efetuado'] . '  ' . $lancamento['data_pagamento'] . ' -- ' . $dataPagamento . "\xA");

                    $data = [
                        'efetuado' => $lancamentoValue['efetuado'],
                        'data_pagamento' => $dataPagamento,
                        'numero_documento' => $lancamentoValue['n_documento'],
                    ];
                    
                    $sql = "update lancamentos SET efetuado = :efetuado, data_pagamento = :data_pagamento where substituido = 0 and numero_documento = :numero_documento";
                    $stmt = $pdo->prepare($sql);
                    // $stmt->execute($data);

                } else {

                    print('cadastrando: ' . $lancamentoValue['n_documento'] . "\xA");

                    $parametros = [
                        'tipo_operacao' => 'S',
                        'cod_operacao' => $lancamentoValue['origem'],
                        'tipo' => 'R',
                        '$format' => 'json',
                        '$dateformat' => 'iso',
                    ];
                
                    $consultaParcelas = CallAPI('GET', 'movimentacao/consulta_lancamentos', 'old server', $parametros);
                    $jsonConsultaParcelas = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $consultaParcelas), true);
                    $quantidadeParcelas = $jsonConsultaParcelas['odata.count'];

                    $sql = "select commission_amount, client_name from invoices where operation_code = :origem";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':origem', $lancamentoValue['origem'], PDO::PARAM_STR);
                    $stmt->execute();
                    $movimentacao = $stmt->fetch(\PDO::FETCH_ASSOC);

                    $movimentacaoComissao = $movimentacao['commission_amount'];
                    $clienteNome = substr($movimentacao['client_name'], 0, 100);

                    $valorComissao = (($movimentacaoComissao / 2) / $quantidadeParcelas);

                    $efetuado = $lancamentoValue['efetuado'] == false ? 0 : 1;
                    $substituido = $lancamentoValue['substituido'] == false ? 0 : 1;

                    $data = [
                        'conta' => $lancamentoValue['pconta'],
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
                        'cliente_nome' => $clienteNome,
                        'obs' => $lancamentoValue['obs'],
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

            }

        }
        
    }

// }

$pdo = null;

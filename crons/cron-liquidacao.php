<?php

include('call-api-novo.php');
include('connection-db.php');

// $sql = "select distinct(agent_id) from invoices where issue_date between '2022-01-01' and '2022-01-26'"; // where numero_documento = '112895/A'
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $lancamentos = $stmt->fetchAll();

// foreach ($lancamentos as $lancamento__) {

$parametros = [
    'efetuado' => 'true',
    'substituido' => 'false',
    // 'representante' => 5,
    '$format' => 'json',
    '$dateformat' => 'iso',
    'tipo' => 'R',
    'protestado' => 'false',
    'gerador' => 'C',
    'dataip' => '2022-01-01',
    'datafp' => '2022-03-31',
];

$consultaLancamentos = CallAPI('GET', 'titulos_receber/consulta_receber_recebidos', 'novo', $parametros);
$jsonConsultaLancamentos = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $consultaLancamentos), true);

if($jsonConsultaLancamentos['odata.count'] > 0) {

    foreach ($jsonConsultaLancamentos['value'] as $lancamentoValue) {

        $sql = "select origem from titulos_receber where lancamento = :lancamento and n_documento = :n_documento and cod = :cod";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':lancamento', $lancamentoValue['lancamento'], PDO::PARAM_INT);
        $stmt->bindParam(':n_documento', $lancamentoValue['n_documento'], PDO::PARAM_STR);
        $stmt->bindParam(':cod', $lancamentoValue['cod'], PDO::PARAM_INT);
        $stmt->execute();
        $tituloReceber = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($stmt->rowCount() == 0) {

            print($lancamentoValue['n_documento'] . "\xA");

            $sql = "select client_name from invoices where operation_code = :origem";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':origem', $tituloReceber['origem'], PDO::PARAM_STR);
            $stmt->execute();
            $movimentacao = $stmt->fetch(\PDO::FETCH_ASSOC);

            $clienteNome = "";

            if ($stmt->rowCount() > 0)
                $clienteNome = $movimentacao['client_name'];
            
            $dataEmissao = date_create($lancamentoValue['data_emissao']);
            $dataEmissao = date_format($dataEmissao, "Y-m-d H:i:s");

            $dataVencimento = date_create($lancamentoValue['data_vencimento']);
            $dataVencimento = date_format($dataVencimento, "Y-m-d H:i:s");

            $dataPagamento = date_create($lancamentoValue['data_pagamento']);
            $dataPagamento = date_format($dataPagamento, "Y-m-d H:i:s");

            $data = [
                'lancamento' => $lancamentoValue['lancamento'],
                'n_documento' => $lancamentoValue['n_documento'],
                'data_emissao' => $dataEmissao,
                'data_vencimento' => $dataVencimento,
                'data_pagamento' => $dataPagamento,
                'valor_inicial' => $lancamentoValue['valor_inicial'],
                'acres_decres' => $lancamentoValue['acres_decres'],
                'valor_pago' => $lancamentoValue['valor_pago'],
                'obs' => $lancamentoValue['obs'],
                'filial' => $lancamentoValue['filial'],
                'pconta' => $lancamentoValue['pconta'],
                'efetuado' => $lancamentoValue['efetuado'] == false ? 0 : 1,
                'cod' => $lancamentoValue['cod'],
                'banco_titulo' => $lancamentoValue['banco_titulo'],
                'agencia' => $lancamentoValue['agencia'],
                'c_c' => $lancamentoValue['c_c'],
                'prorrogado' => $lancamentoValue['prorrogado'] == false ? 0 : 1,
                'devolvido' => $lancamentoValue['devolvido'] == false ? 0 : 1,
                'cartorio' => $lancamentoValue['cartorio'] == false ? 0 : 1,
                'protesto' => $lancamentoValue['protesto'] == false ? 0 : 1,
                'tit_banco' => $lancamentoValue['tit_banco'],
                'carteira' => $lancamentoValue['carteira'],
                'desc_tipo_pgto' => $lancamentoValue['desc_tipo_pgto'],
                'desc_pconta' => $lancamentoValue['desc_pconta'],
                'desc_gerador' => $lancamentoValue['desc_gerador'],
                'banco' => $lancamentoValue['banco'],
                'gerador' => $lancamentoValue['gerador'],
                'substituido' => $lancamentoValue['substituido'] == false ? 0 : 1,
                'origem' => $lancamentoValue['origem'],
                'tipo' => $lancamentoValue['tipo'],
                'representante_pedido' => $lancamentoValue['representante_pedido'],
                'representante' => $lancamentoValue['representante'],
                'representante_cliente' => $lancamentoValue['representante_cliente'],
                'representante_movimento' => $lancamentoValue['representante_movimento'],
                'cliente_nome' => $clienteNome,
            ];
            
            $stmt = $pdo->prepare("INSERT INTO titulos_receber (lancamento,
                                                                n_documento,
                                                                data_emissao,
                                                                data_vencimento,
                                                                data_pagamento,
                                                                valor_inicial,
                                                                acres_decres,
                                                                valor_pago,
                                                                obs,
                                                                filial,
                                                                pconta,
                                                                efetuado,
                                                                cod,
                                                                banco_titulo,
                                                                agencia,
                                                                c_c,
                                                                prorrogado,
                                                                devolvido,
                                                                cartorio,
                                                                protesto,
                                                                tit_banco,
                                                                carteira,
                                                                desc_tipo_pgto,
                                                                desc_pconta,
                                                                desc_gerador,
                                                                banco,
                                                                gerador,
                                                                substituido,
                                                                origem,
                                                                tipo,
                                                                representante_pedido,
                                                                representante,
                                                                representante_cliente,
                                                                representante_movimento,
                                                                cliente_nome) VALUES (:lancamento,
                                                                                    :n_documento,
                                                                                    :data_emissao,
                                                                                    :data_vencimento,
                                                                                    :data_pagamento,
                                                                                    :valor_inicial,
                                                                                    :acres_decres,
                                                                                    :valor_pago,
                                                                                    :obs,
                                                                                    :filial,
                                                                                    :pconta,
                                                                                    :efetuado,
                                                                                    :cod,
                                                                                    :banco_titulo,
                                                                                    :agencia,
                                                                                    :c_c,
                                                                                    :prorrogado,
                                                                                    :devolvido,
                                                                                    :cartorio,
                                                                                    :protesto,
                                                                                    :tit_banco,
                                                                                    :carteira,
                                                                                    :desc_tipo_pgto,
                                                                                    :desc_pconta,
                                                                                    :desc_gerador,
                                                                                    :banco,
                                                                                    :gerador,
                                                                                    :substituido,
                                                                                    :origem,
                                                                                    :tipo,
                                                                                    :representante_pedido,
                                                                                    :representante,
                                                                                    :representante_cliente,
                                                                                    :representante_movimento,
                                                                                    :cliente_nome)");
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

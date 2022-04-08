<?php

include('call-api-novo.php');
include('connection-db.php');

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

            $sql = "select client_name from invoices where operation_code = :origem";
            $stmt2 = $pdo->prepare($sql);
            $stmt2->bindParam(':origem', $lancamentoValue['origem'], PDO::PARAM_STR);
            $stmt2->execute();
            $movimentacao = $stmt2->fetch(\PDO::FETCH_ASSOC);

            $clienteNome = "";

            if ($stmt2->rowCount() > 0)
                $clienteNome = $movimentacao['client_name'];
            
            $dataEmissao = date_create($lancamentoValue['data_emissao']);
            $dataEmissao = date_format($dataEmissao, "Y-m-d H:i:s");

            $dataVencimento = date_create($lancamentoValue['data_vencimento']);
            $dataVencimento = date_format($dataVencimento, "Y-m-d H:i:s");

            $dataPagamento = date_create($lancamentoValue['data_pagamento']);
            $dataPagamento = date_format($dataPagamento, "Y-m-d H:i:s");

            print($lancamentoValue['n_documento'] . "\xA");

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

    }
    
}

$pdo = null;
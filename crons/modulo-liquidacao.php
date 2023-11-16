<?php

include('call-api-novo.php');
include('connection-db.php');

// $parametros = [
//     // 'efetuado' => 'true',
//     // 'substituido' => 'false',
//     // 'representante' => '7',
//     '$format' => 'json',
//     '$dateformat' => 'iso',
//     'tipo' => 'R',
//     // 'protestado' => 'false',
//     // 'gerador' => 'C',
//     'datai' => '2022-01-01',
//     'dataf' => '2023-05-31',
// ];

$parametros = [
    'repassado' => 'false',
    '$dateformat' => 'iso',
    // 'representante' => '6',
    'tipo' => 'R',
    'dataip' => '2023-11-01',
    'datafp' => '2023-11-30',
    'efetuado' => 'true',
    'substituido' => 'false',
    '$format' => 'json',
    'protestado' => 'false',
    'cartorio' => 'false',
    'previsao' => 'false',
    'devolvido' => 'false',
];

$consultaLancamentos = CallAPI('GET', 'titulos_receber/consulta_receber_recebidos', 'novo', $parametros);
$jsonConsultaLancamentos = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $consultaLancamentos), true);

print_r($jsonConsultaLancamentos);

if(isset($jsonConsultaLancamentos['value'])) {

    foreach ($jsonConsultaLancamentos['value'] as $lancamentoValue) {

        $dataPagamento = null;

        if($lancamentoValue['data_pagamento'] != null) {
            $dataPagamento = date_create($lancamentoValue['data_pagamento']);
            $dataPagamento = date_format($dataPagamento, "Y-m-d H:i:s");
        }

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

            print('----------- cadastrando novo titulo: ' . $lancamentoValue['n_documento'] . ' data pagamento: ' . $dataPagamento . "\xA");

            $data = [
                'lancamento' => $lancamentoValue['lancamento'],
                'n_documento' => $lancamentoValue['n_documento'],
                'tipo_pagto' => $lancamentoValue['tipo_pagto'],
                'data_emissao' => $dataEmissao,
                'data_vencimento' => $dataVencimento,
                'data_pagamento' => $dataPagamento,
                'valor_inicial' => $lancamentoValue['valor_inicial'],
                'acres_decres' => $lancamentoValue['acres_decres'],
                'valor_pago' => $lancamentoValue['valor_pago'] == null ? 0 : $lancamentoValue['valor_pago'],
                'obs' => $lancamentoValue['obs'] == null ? '' : $lancamentoValue['obs'],
                'filial' => $lancamentoValue['filial'],
                'pconta' => $lancamentoValue['pconta'],
                'efetuado' => $lancamentoValue['efetuado'] == false ? 0 : 1,
                'cod' => $lancamentoValue['cod'] == null ? 0 : $lancamentoValue['cod'],
                'banco_titulo' => $lancamentoValue['banco_titulo'],
                'agencia' => $lancamentoValue['agencia'],
                'c_c' => $lancamentoValue['c_c'],
                'prorrogado' => $lancamentoValue['prorrogado'] == false ? 0 : 1,
                'devolvido' => $lancamentoValue['devolvido'] == false ? 0 : 1,
                'cartorio' => $lancamentoValue['cartorio'] == false ? 0 : 1,
                'protesto' => $lancamentoValue['protesto'] == false ? 0 : 1,
                'tit_banco' => $lancamentoValue['tit_banco'],
                'carteira' =>  substr($lancamentoValue['carteira'], 0, 2),
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
                                                                tipo_pagto,
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
                                                                                    :tipo_pagto,
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

        } else {

            $data = [
                'efetuado' => $lancamentoValue['efetuado'] == false ? 0 : 1,
                'data_pagamento' => $dataPagamento,
                'valor_pago' => $lancamentoValue['valor_pago'] == null ? 0 : $lancamentoValue['valor_pago'],
                'valor_inicial' => $lancamentoValue['valor_inicial'] == null ? 0 : $lancamentoValue['valor_inicial'],
                'tipo_pagto' => $lancamentoValue['tipo_pagto'],
                'lancamento' => $lancamentoValue['lancamento'],
                'n_documento' => $lancamentoValue['n_documento'],
                'cod' => $lancamentoValue['cod'] == null ? 0 : $lancamentoValue['cod'],
            ];

            print_r('--- atualizando titulo: ' . $lancamentoValue['n_documento'] . ' data pagamento: ' . $dataPagamento . "\xA");

            $sql = "update titulos_receber SET efetuado = :efetuado,
                                                data_pagamento = :data_pagamento,
                                                valor_inicial = :valor_inicial,
                                                valor_pago = :valor_pago,
                                                tipo_pagto = :tipo_pagto
                                                where lancamento = :lancamento and n_documento = :n_documento and cod = :cod limit 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);

        }

    }
    
}

$pdo = null;

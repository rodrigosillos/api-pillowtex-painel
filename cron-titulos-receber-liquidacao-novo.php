<?php

include('call-api-novo.php');
include('connection-db.php');

$parametros = [
    'datai' => '2021-01-01',
    'dataf' => '2021-12-29',
    'efetuado' => 'true',
    'substituido' => 'false',
    'gerador' => 'text',
    'representante' => '5',
    '$format' => 'json',
    '$dateformat' => 'iso',
];

$consultaLancamentos = CallAPI('GET', 'titulos_receber/consultartitulosreceber', $parametros);
$jsonConsultaLancamentos = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $consultaLancamentos), true);

$qtdLancamentos = $jsonConsultaLancamentos['odata.count'];

foreach ($jsonConsultaLancamentos['value'] as $lancamentoValue) {

    $data = [
        'conta' => $lancamentoValue['pconta'],
        'numero_lancamento' => $lancamentoValue['lancamento'],
        'numero_documento' => $lancamentoValue['n_documento'],
        'data_emissao' => $lancamentoValue['data_emissao'],
        'data_vencimento' => $$lancamentoValue['data_vencimento'],
        'data_pagamento' => $lancamentoValue['data_pagamento'],
        'efetuado' => $lancamentoValue['efetuado'],
        'substituido' => false,
        'valor_inicial' => $lancamentoValue['valor_inicial'],
        'valor_pago' => is_null($lancamentoValue['valor_pago']) ? 0 : $lancamentoValue['valor_pago'],
        'valor_comissao' => 0,
        'filial' => $lancamentoValue['filial'],
        // 'origem' => $jsonConsultaTitulos['value'][0]['origem'],
        // 'tipo' => $jsonConsultaTitulos['value'][0]['tipo'],
        'representante' => $lancamentoValue['filial'],
        'cliente_nome' => $lancamentoValue['nome_representante_cliente'],
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

// $pdo = null;

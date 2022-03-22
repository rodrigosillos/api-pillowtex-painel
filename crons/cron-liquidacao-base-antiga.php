<?php

include('connection-db.php');

function parser($data) {
    $data = str_replace('.', '', $data);
    $data = str_replace(' ', '', $data);
    // $data = str_replace('ORIGEM', '', $data);
    return $data;
}

function parserDateTime($data) {
    $data = str_replace('.', '-', $data);
    $data = str_replace(' 00:00', '', $data);
    $explodeData = explode('-', $data);

    $dia = isset($explodeData[0]) ? $explodeData[0] : '08';
    $mes = isset($explodeData[1]) ? $explodeData[1] : '03';
    $ano = isset($explodeData[2]) ? $explodeData[2] : '2022';

    $dia = str_replace('B', '08', $dia);
    $dia = str_replace('C', '08', $dia);
    $dia = str_replace('VENDA DE PRODUTOS', '08', $dia);
    $dia = str_replace('DE VENDAS/MOSTRUARIO-DEVOL', '08', $dia);
    $dia = str_replace('ADIANTAMENTO 00OMISSAO (+/', '08', $dia);
    $dia = str_replace('DEMAIS SERVI00OS NAO ESPE00', '08', $dia);
    $dia = str_replace('DES00ONTOS O00TIDOS', '08', $dia);
    $dia = str_replace('RESGATE SO00RE APLI00A00OES', '08', $dia);
    $dia = str_replace('DATA_EMISSAO', '08', $dia);
    $dia = str_replace('DEVOL', '08', $dia);
    $dia = str_replace('DATA_VEN00IMENTO', '08', $dia);
    $dia = str_replace('DA', '08', $dia);
    $dia = substr($dia, 0, 2);
    
    $mes = str_replace(' DE VENDAS/MOSTRUARIO-DEVOL', '00', $mes);
    $mes = str_replace(')', '00', $mes);
    $mes = str_replace(' OUTROS', '00', $mes);
    $mes = str_replace(' DE VENDAS/MOSTRUARIO', '00', $mes);

    $data = $ano . '-' . $mes . '-' . $dia . ' 00:00:00';

    return $data;
}

$row = 1;
if (($handle = fopen("titulos_antigos.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);
    // echo "<p> $num fields in line $row: <br /></p>\n";
    $row++;
    for ($c=0; $c < $num; $c++) {
        // print($data[$c] . "\xA");

        if(isset($data[$c])) {
            $explodeTitulo = explode(';', $data[$c]);

            if(isset($explodeTitulo[0]) && !empty($explodeTitulo[0])) {
                $numeroLancamento = parser($explodeTitulo[0]);
                // print($numeroLancamento . "\xA");
            }
    
            if(isset($explodeTitulo[1]) && !empty($explodeTitulo[1])) {
                $numeroDocumento = parser($explodeTitulo[1]);
                // print($numeroDocumento . "\xA");
            }
    
            if(isset($explodeTitulo[4]) && !empty($explodeTitulo[4])) {
                $dataEmissao = parserDateTime($explodeTitulo[4]);
                // print('--> ' . $dataEmissao . "\xA");
            }
    
            if(isset($explodeTitulo[5]) && !empty($explodeTitulo[5])) {
                $dataVencimento = parserDateTime($explodeTitulo[5]);
                // print('--> ' . $dataVencimento . "\xA");
            }
    
            if(isset($explodeTitulo[6]) && !empty($explodeTitulo[6])) {
                $dataPagamento = parserDateTime($explodeTitulo[6]);
                // print('--> ' . $dataPagamento . "\xA");
            }
    
            if(isset($explodeTitulo[7]) && !empty($explodeTitulo[7])) {
                $valorInicial = parserDateTime($explodeTitulo[7]);
                // print('--> ' . $valorInicial . "\xA");
            }
    
            if(isset($explodeTitulo[33]) && !empty($explodeTitulo[33])) {
                $origem = parser($explodeTitulo[33]);
                // print('--> ' . $origem . "\xA");
            }
    
            if(isset($explodeTitulo[34]) && !empty($explodeTitulo[34])) {
                $filial = parser($explodeTitulo[34]);
                // print('--> ' . $filial . "\xA");
            }
    
            if(isset($explodeTitulo[35]) && !empty($explodeTitulo[35])) {
                $tipo = parser($explodeTitulo[35]);
                // print('--> ' . $tipo . "\xA");
            }
    
            if(isset($explodeTitulo[39]) && !empty($explodeTitulo[39])) {
                $representanteCodigo = parser($explodeTitulo[39]);
                // print('--> ' . $representanteCodigo . "\xA");
            }
    
            if(isset($explodeTitulo[41]) && !empty($explodeTitulo[41])) {
                $representanteID = parser($explodeTitulo[41]);
                // print('--> ' . $representanteID . "\xA");
            }
    
            $data = [
                'conta' => '',
                'numero_lancamento' => $numeroLancamento,
                'numero_documento' => $numeroDocumento,
                'data_emissao' => $dataEmissao,
                'data_vencimento' => $dataVencimento,
                'data_pagamento' => $dataPagamento,
                'efetuado' => 0,
                'substituido' => 0,
                'valor_inicial' => 0,
                'valor_pago' => 0,
                'valor_comissao' => 0,
                'filial' => $filial,
                'origem' => $origem,
                'tipo' => $tipo,
                'representante' => $representanteID,
                'representante_codigo' => $representanteCodigo,
                'cliente_nome' => '',
                'obs' => '',
                'devolucao' => 0,
            ];
            
            $stmt = $pdo->prepare("INSERT INTO lancamentos_base_antiga (conta,
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


    }
}
  fclose($handle);
}

exit();

if($jsonConsultaLancamentos['odata.count'] > 0) {

    foreach ($jsonConsultaLancamentos['value'] as $lancamentoValue) {

        $dataEmissao = date_create($lancamentoValue['data_emissao']);
        $dataEmissao = date_format($dataEmissao, "Y-m-d H:i:s");

        $dataVencimento = date_create($lancamentoValue['data_vencimento']);
        $dataVencimento = date_format($dataVencimento, "Y-m-d H:i:s");

        $dataPagamento = date_create($lancamentoValue['data_pagamento']);
        $dataPagamento = date_format($dataPagamento, "Y-m-d H:i:s");

        $efetuado = $lancamentoValue['efetuado'] == false ? 0 : 1;
        $substituido = $lancamentoValue['substituido'] == false ? 0 : 1;

        $devolucao = 0;

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
        
        $stmt = $pdo->prepare("INSERT INTO lancamentos_base_antiga (conta,
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
        // $stmt->execute($data);

    }
    
}


$pdo = null;

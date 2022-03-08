<?php

include('connection-db.php');

function parser($data) {
    $data = str_replace('.', '', $data);
    $data = str_replace(' ', '', $data);
    return $data;
}

function parserDateTime($data) {
    $data = str_replace('.', '-', $data);
    $data = str_replace(' 00:00', '', $data);
    $explodeData = explode('-', $data);

    if(isset($explodeData[2]) && isset($explodeData[1])) {
        $data = $explodeData[2] . '-' . $explodeData[1] . '-' . $explodeData[0];
        

    }

    if(checkdate($explodeData[1], $explodeData[0], $explodeData[2]) == false) {
        $data = '0000-00-00';
    }

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
            print('--> ' . $dataEmissao . "\xA");
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

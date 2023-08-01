<?php

include('call-api.php');
include('connection-db.php');

// $sql = "select cod_operacao, tipo_operacao, cliente_estado, tabela, comissao_r, evento, tipo_pedido from movimentacao where representante_cod = '0055' and data_emissao between '2022-05-01' and '2022-05-31'";
$sql = "select cod_operacao, tipo_operacao, cliente_estado, tabela, comissao_r, evento, tipo_pedido from movimentacao where tipo_operacao = 'S' and data_emissao between '2023-07-24' and '2023-07-28'";
// $sql = "select cod_operacao, tipo_operacao, cliente_estado, tabela, comissao_r, evento, tipo_pedido from movimentacao where cod_operacao = 87006";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$movimentacoes = $stmt->fetchAll();

foreach ($movimentacoes as $movimentacao) {
    
    $codOperacao = $movimentacao["cod_operacao"];
    $tipoOperacao = $movimentacao["tipo_operacao"];
    $clienteEstado = $movimentacao["cliente_estado"];
    $tabela = $movimentacao["tabela"];
    $comissaoR = $movimentacao["comissao_r"];
    $evento = $movimentacao["evento"];
    $tipoPedido = $movimentacao["tipo_pedido"];

    $sql = "select id from produtos WHERE cod_operacao = :cod_operacao";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cod_operacao', $codOperacao, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() == 0) {

        print('cod_operacao: ' . $codOperacao . "\xA");

        $paramsConsultaMovimentacao = [
            'tipo_operacao' => $tipoOperacao,
            'cod_operacao' => $codOperacao,
            'ujuros' => 'false',
            '$format' => 'json',
            '$dateformat' => 'iso',
        ];
    
        $bodyConsultaMovimentacao = CallAPI('GET', 'movimentacao/consulta', $paramsConsultaMovimentacao);
        $jsonConsultaMovimentacao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaMovimentacao), true);
    
        if (isset($jsonConsultaMovimentacao['value'][0]['produtos'])) {

            $valorComissaoTotal = 0;

            foreach($jsonConsultaMovimentacao['value'][0]['produtos'] as $jsonProduto) {

                // produtos

                $paramsConsultaProduto = [
                    'produto' => $jsonProduto['produto'],
                    '$format' => 'json',
                ];
        
                $bodyConsultaProdutoCodigo = CallAPI('GET', 'produtos/consultacodigo', $paramsConsultaProduto);
                $jsonConsultaProdutoCodigo = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaProdutoCodigo), true);
                
                $codProduto = '';
        
                if(isset($jsonConsultaProdutoCodigo['value']))
                    $codProduto = $jsonConsultaProdutoCodigo['value'][0]['cod_produto'];
                
                $descricao1 = '';
                $divisao = 0;

                $bodyConsultaProduto = CallAPI('GET', 'produtos/consulta', $paramsConsultaProduto);
                $jsonConsultaProduto = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaProduto), true);
                
                if(isset($jsonConsultaProduto['value'])) {
                    $descricao1 = $jsonConsultaProduto['value'][0]['descricao1'];
                    $divisao = $jsonConsultaProduto['value'][0]['divisao'];
                }

                // fim produtos

                // divisao

                $codDivisao = '';
                $descricaoDivisao = '';

                if(!empty($divisao)) {

                    $paramsConsultaDivisao = [
                        'divisao' => $divisao,
                        '$format' => 'json',
                    ];
            
                    $bodyConsultaDivisao = CallAPI('GET', 'divisoes/consulta', $paramsConsultaDivisao);
                    $jsonConsultaDivisao = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $bodyConsultaDivisao), true);
                    
                    if(isset($jsonConsultaDivisao['value'])) {
    
                        // print_r($jsonConsultaDivisao['value']);
    
                        $codDivisao = $jsonConsultaDivisao['value'][0]['cod_divisao'];
                        $descricaoDivisao = $jsonConsultaDivisao['value'][0]['descricao'];
                    }
    
                    if(is_null($codDivisao))
                        $codDivisao = '';

                }

                // fim divisao

                // calculo comissao

                $tabela = 214;

                if($clienteEstado == null)
                    $clienteEstado = 'SP';
        
                if($tabela == 104)
                    $tabela = 187;
                
                $percentualCalculo = 0;

                $sql = "select percentual_comissao from percentual_comissao where cod_divisao = :cod_divisao and tabela = :tabela";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cod_divisao', $codDivisao, PDO::PARAM_STR);
                $stmt->bindParam(':tabela', $tabela, PDO::PARAM_STR);
                $stmt->execute();
                $configPercentualComissao = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($stmt->rowCount() > 0)
                    $percentualCalculo = $configPercentualComissao['percentual_comissao'];                  

                if($tabela == 187 && $clienteEstado != 'SP' && $jsonProduto['desconto'] < 5)
                    $percentualCalculo = 3;

                if($tabela == 214 && $jsonProduto['desconto'] > 5)
                    $percentualCalculo = ($percentualCalculo / 2);

                if ($tipoPedido == 'ZC PEDIDO ESPECIAL' || $evento = 213)
                    $percentualCalculo = $comissaoR;
                    
                $produtoPreco = $jsonProduto['preco_aplicado'] == 0 ? $jsonProduto['preco'] : $jsonProduto['preco_aplicado'];
                $valorComissaoProduto = floor(($produtoPreco * $jsonProduto['quantidade']) * $percentualCalculo) / 100;

                if($tabela == 214 && $jsonProduto['desconto'] > 5)
                    $valorComissaoProduto = ($valorComissaoProduto / 2);

                $valorComissaoTotal += $valorComissaoProduto;

                // fim calculo comissao

                $data = [
                    'cod_operacao' => $codOperacao,
                    'produto' => $jsonProduto['produto'],
                    'cod_produto' => $codProduto,
                    'descricao1' => $descricao1,
                    'divisao' => $divisao == null ? 0 : $divisao,
                    'cod_divisao' => $codDivisao == null ? '' : $codDivisao,
                    'descricao_divisao' => $descricaoDivisao == null ? '' : $descricaoDivisao,
                    'cor' => $jsonProduto['cor'],
                    'estampa' => $jsonProduto['estampa'],
                    'tamanho' => $jsonProduto['tamanho'],
                    'quantidade' => $jsonProduto['quantidade'],
                    'preco' => $jsonProduto['preco'],
                    'ipi' => $jsonProduto['ipi'] == null ? 0 : $jsonProduto['ipi'],
                    'pedido' => $jsonProduto['pedido'] == null ? 0 : $jsonProduto['pedido'],
                    'unidade' => $jsonProduto['unidade'] == null ? '' : $jsonProduto['unidade'],
                    'nota' => $jsonProduto['nota'] == null ? 0 : $jsonProduto['nota'],
                    'preco_aplicado' => $jsonProduto['preco_aplicado'] == null ? 0 : $jsonProduto['preco_aplicado'],
                    'desconto' => $jsonProduto['desconto'],
                    'preco_bruto' => $jsonProduto['preco_bruto'],
                    'valor_comissao' => $valorComissaoProduto,
                    'percentual_comissao' => $percentualCalculo,
                ];

                // print_r($data);

                $sql = "insert into produtos (cod_operacao,
                                            produto,
                                            cod_produto,
                                            descricao1,
                                            divisao,
                                            cod_divisao,
                                            descricao_divisao,
                                            cor,
                                            estampa,
                                            tamanho,
                                            quantidade,
                                            preco,
                                            ipi,
                                            pedido,
                                            unidade,
                                            nota,
                                            preco_aplicado,
                                            desconto,
                                            preco_bruto,
                                            valor_comissao,
                                            percentual_comissao) values (:cod_operacao,
                                                                        :produto,
                                                                        :cod_produto,
                                                                        :descricao1,
                                                                        :divisao,
                                                                        :cod_divisao,
                                                                        :descricao_divisao,
                                                                        :cor,
                                                                        :estampa,
                                                                        :tamanho,
                                                                        :quantidade,
                                                                        :preco,
                                                                        :ipi,
                                                                        :pedido,
                                                                        :unidade,
                                                                        :nota,
                                                                        :preco_aplicado,
                                                                        :desconto,
                                                                        :preco_bruto,
                                                                        :valor_comissao,
                                                                        :percentual_comissao)";

                $stmt = $pdo->prepare($sql);
                $stmt->execute($data);
        
            }

        }   

    }

}

$pdo = null;

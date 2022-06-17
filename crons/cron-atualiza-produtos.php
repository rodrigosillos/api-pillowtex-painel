<?php

// include('call-api.php');
include('connection-db.php');

$sql = "select cod_operacao, tipo_operacao, cliente_estado, tabela, comissao_r, evento, tipo_pedido from movimentacao where representante_cod in ('0055', '0054', '0008', '0001') and data_emissao between '2022-05-01' and '2022-05-31'";
// $sql = "select cod_operacao, tipo_operacao, cliente_estado, tabela, comissao_r, evento, tipo_pedido from movimentacao where cod_operacao = 83564";

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

    

    $sql = "select id, desconto, preco_aplicado, preco, quantidade, cod_divisao from produtos where cod_operacao = ".$codOperacao; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produtos = $stmt->fetchAll();
    
    foreach ($produtos as $produto) {        

        $produtoID = $produto["id"];
        $codDivisao = $produto["cod_divisao"];
        $desconto = $produto["desconto"];
        $quantidade = $produto["quantidade"];
        $preco_aplicado = $produto["preco_aplicado"];
        $preco = $produto["preco"];

        // print($codDivisao);

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

        if($tabela == 187 && $clienteEstado != 'SP' && $desconto < 5)
            $percentualCalculo = 3;

        if($tabela == 214 && $desconto > 5)
            $percentualCalculo = ($percentualCalculo / 2);

        if ($tipoPedido == 'ZC PEDIDO ESPECIAL' || $evento = 213)
            $percentualCalculo = $comissaoR;
            
        $produtoPreco = $preco_aplicado == 0 ? $preco : $preco_aplicado;
        $valorComissaoProduto = floor(($produtoPreco * $quantidade) * $percentualCalculo) / 100;

        if($tabela == 214 && $desconto > 5)
            $valorComissaoProduto = ($valorComissaoProduto / 2);

        $valorComissaoTotal += $valorComissaoProduto;

        // fim calculo comissao

        $data = [
            'id' => $produtoID,
            'valor_comissao' => $valorComissaoProduto,
            'percentual_comissao' => $percentualCalculo,
        ];

        print_r($data);
    
        $sql = "update produtos set valor_comissao = :valor_comissao,
                                    percentual_comissao = :percentual_comissao
                                where id = :id";
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }
        
}

$pdo = null;

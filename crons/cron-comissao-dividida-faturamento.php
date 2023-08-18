<?php

include('call-api.php');
include('connection-db.php');

// $sql = "select m.cod_operacao, m.tipo_operacao, m.cliente_estado, m.tabela, m.tipo_pedido, m.data_emissao, m.comissao_r, m.representante, m.representante_cliente from movimentacao m where m.notas is null and m.representante_cod = '0054' and m.data_emissao between '2022-05-01' and '2022-05-20";
$sql = "select m.cod_operacao, m.tipo_operacao, m.cliente_estado, m.tabela, m.tipo_pedido, m.data_emissao, m.comissao_r, m.representante, m.representante_cliente, m.evento from movimentacao m where m.data_emissao between '2023-08-01' and '2023-08-31'";
// $sql = "select m.cod_operacao, m.tipo_operacao, m.cliente_estado, m.tabela, m.tipo_pedido, m.data_emissao, m.comissao_r, m.representante, m.representante_cliente, m.evento from movimentacao m where m.cod_operacao = 87832";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$invoices = $stmt->fetchAll();

// $lastMonth = date("m", strtotime("first day of previous month"));

foreach ($invoices as $invoice) {

    $operationCode = $invoice['cod_operacao'];
    $operationType = $invoice['tipo_operacao'];
    $clientAddress = $invoice['cliente_estado'];
    $tableId = $invoice['tabela'];
    $invoiceType = $invoice['tipo_pedido'];
    $issueDate = $invoice['data_emissao'];
    $comissaoR = $invoice['comissao_r'];
    $representante = $invoice['representante'];
    $representanteCliente = $invoice['representante_cliente'];
    $evento = $invoice['evento'];

    $issueDate = date_create($issueDate);

    $commissionAmountTotal = 0;

    $sql = "select cod_divisao, quantidade, preco, preco_aplicado, preco_bruto, desconto, descricao1, cod_produto from produtos where cod_operacao = :cod_operacao";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cod_operacao', $operationCode, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll();
    
    foreach ($products as $product) {
        
        $divisionCode = $product['cod_divisao'];
        $productName = $product['descricao1'];
        $productCode = $product['cod_produto'];
        $quantity = $product['quantidade'];
        $price = $product['preco'];
        $priceApplied = $product['preco_aplicado'];
        $discount = $product['desconto'];
        
        if($clientAddress == null)
            $clientAddress = 'SP';
    
        $tableCode = 214;
    
        if($tableId == 104)
            $tableCode = 187;
    
        $sql = "select percentual_comissao from percentual_comissao where cod_divisao = :cod_divisao and tabela = :tabela";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cod_divisao', $divisionCode, PDO::PARAM_STR);
        $stmt->bindParam(':tabela', $tableCode, PDO::PARAM_STR);
        $stmt->execute();
        $resultSettings = $stmt->fetch(\PDO::FETCH_ASSOC);
 
        $commissionPercentage = 0;

        if ($stmt->rowCount() > 0)
            $commissionPercentage = $resultSettings['percentual_comissao'];
    
        if($tableCode == 187 && $clientAddress != 'SP' && $discount < 5)
            $commissionPercentage = 3;

        if ($invoiceType == 'ZC PEDIDO ESPECIAL' || $invoiceType == 'ZC FEIRA ESPECIAL' || $invoiceType == 'ZC PET FEIRA ESPECIAL' || $evento == 213) {
            $commissionPercentage = $comissaoR;
            print($invoiceType . ' - ' .  $evento . "\xA");
        }
        
        $priceProduct = $priceApplied == 0 ? $price : $priceApplied;

        $commissionAmount = ($priceProduct * $quantity) * $commissionPercentage / 100;
    
        if($tableCode == 214 and $discount > 5 or $tableId == 20706 and $discount > 5)
            $commissionAmount = ($commissionAmount / 2);
    
        $commissionAmountTotal += $commissionAmount;
    }

    

    $percentualFaturamento = 50;
    $valorFaturamento = 0;

    if ($invoiceType == 'ANTECIPADO' || $invoiceType == 'ANTECIPADO ZC')
        $percentualFaturamento = 80;

    $valorFaturamento = ($percentualFaturamento / 100) * $commissionAmountTotal;

    $data = [
        'valor_comissao' => $commissionAmountTotal,
        'valor_faturamento' => $valorFaturamento,
        'cod_operacao' => $operationCode,
    ];
    
    $sql = "update movimentacao set 
                                valor_comissao = :valor_comissao,
                                valor_faturamento = :valor_faturamento
            where cod_operacao = :cod_operacao";

    // divisao de comissao

    if ($invoiceType == 'ZC FEIRA' || $invoiceType == 'ZC FUTURO') {

        if ($representante <> $representanteCliente) {

            $valorComissaoDividida = ($commissionAmountTotal / 2);
            $valorFaturamentoDividido = ($valorFaturamento / 2);

            $data = [
                'valor_comissao' => $commissionAmountTotal,
                'valor_comissao_representante' => ($valorComissaoDividida / 2),
                'valor_comissao_representante_cliente' => ($valorComissaoDividida / 2),
                'valor_faturamento' => $valorFaturamento,
                'valor_faturamento_representante' => $valorFaturamentoDividido,
                'valor_faturamento_representante_cliente' => $valorFaturamentoDividido,
                'cod_operacao' => $operationCode,
            ];
            
            $sql = "update movimentacao set 
                                        valor_comissao = :valor_comissao,
                                        valor_comissao_representante = :valor_comissao_representante,
                                        valor_comissao_representante_cliente = :valor_comissao_representante_cliente,
                                        valor_faturamento = :valor_faturamento,
                                        valor_faturamento_representante = :valor_faturamento_representante,
                                        valor_faturamento_representante_cliente = :valor_faturamento_representante_cliente
                    where cod_operacao = :cod_operacao";

        }
    }

    print_r($data);

    // fim divisao comissao

    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

$pdo = null;

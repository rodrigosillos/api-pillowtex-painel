<?php

include('call-api.php');
include('connection-db.php');

// $sql = "select cod_operacao, tipo_operacao, cliente_estado, tabela, tipo_pedido, data_emissao, comissao_r, representante, representante_cliente from movimentacao where data_emissao between '2022-04-01' and '2022-04-30'";
$sql = "select cod_operacao, tipo_operacao, cliente_estado, tabela, tipo_pedido, data_emissao, comissao_r, representante, representante_cliente from movimentacao where romaneio in ('102259','105395','111461','102264','105375','113364','100080','99507','99929','105504','112688','99165','102782','105391','112424','99082','99063','99985','98590','98584','98916','99069','104784','104229','102255','104699','99753','104753','105400','112681','99050','111667','101127','98651','101024','112992','112661','112036','101386','113389','111840','105406','99520','98580','112674','111610','99057','99120','105828','105092','112869','100087','105832')";

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

    $issueDate = date_create($issueDate);

    $commissionAmountTotal = 0;

    $sql = "select cod_divisao, quantidade, preco, preco_aplicado, preco_bruto, desconto, descricao1, cod_produto from produtos where cod_operacao = :cod_operacao";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cod_operacao', $operationCode, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll();

    // $sql = "select division_code, quantity, price, price_applied, price_gross, discount, product_name, product_code from invoices_product where operation_code = :operation_code";
    // $stmt = $pdo->prepare($sql);
    // $stmt->bindParam(':operation_code', $operationCode, PDO::PARAM_STR);
    // $stmt->execute();
    // $products = $stmt->fetchAll();
    
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

        // $sql = "select percentage from commission_settings where product_division = :product_division and price_list = :price_list";
        // $stmt = $pdo->prepare($sql);
        // $stmt->bindParam(':product_division', $divisionCode, PDO::PARAM_STR);
        // $stmt->bindParam(':price_list', $tableCode, PDO::PARAM_STR);
        // $stmt->execute();
        // $resultSettings = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        $commissionPercentage = 0;

        if ($stmt->rowCount() > 0)
            $commissionPercentage = $resultSettings['percentual_comissao'];
    
        if($tableCode == 187 && $clientAddress != 'SP' && $discount < 5)
            $commissionPercentage = 3;

        if ($invoiceType == 'ZC PEDIDO ESPECIAL')
            $commissionPercentage = $comissaoR;
        
        $priceProduct = $priceApplied == 0 ? $price : $priceApplied;

        $commissionAmount = ($priceProduct * $quantity) * $commissionPercentage / 100;
    
        if($tableCode == 214 && $discount > 5)
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

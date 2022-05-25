<?php

include('call-api.php');
include('connection-db.php');

$sql = "
select m.romaneio, m.cod_operacao, m.tipo_pedido, m.notas
from movimentacao m 
where m.notas = '' and m.representante_cod in ('0054', '0055') and m.data_emissao between '2022-05-01' and '2022-05-20'
or m.notas is null and m.representante_cod in ('0054', '0055') and m.data_emissao between '2022-05-01' and '2022-05-20'
";

// $sql = "select m.cod_operacao from movimentacao m where m.notas is null and m.tipo_pedido is null and m.representante_cod = '0054' and m.data_emissao between '2022-05-01' and '2022-05-20'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$movimentacoes = $stmt->fetchAll();

foreach ($movimentacoes as $movimentacaoSemNF) {

    $sql = "select n_documento from titulos_receber where origem = :cod_operacao limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cod_operacao', $movimentacaoSemNF['cod_operacao'], PDO::PARAM_INT);
    $stmt->execute();
    $tituloR = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {

        $numeroNota = explode('/', $tituloR['n_documento']);
        // print($numeroNota[0] . "\xA");

        $sql = "select comissao_r, tabela, tipo_pedido, valor_comissao, valor_faturamento from movimentacao where notas like '%" . $numeroNota[0] . "%'";
        $stmt = $pdo->prepare($sql);
        // $stmt->bindParam(':notas', $numeroNota[0], PDO::PARAM_STR);
        $stmt->execute();
        $movimentacaoNF = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {

            $data = [
                'comissao_r' => $movimentacaoNF['comissao_r'],
                'tabela' => $movimentacaoNF['tabela'],
                'valor_comissao' => $movimentacaoNF['valor_comissao'],
                'valor_faturamento' => $movimentacaoNF['valor_faturamento'],
                'cod_operacao' => $movimentacaoSemNF['cod_operacao'],
            ];

            // print_r('--- atualizando movimento sem nota: ' . $movimentacaoSemNF['cod_operacao'] . "\xA");
            print_r($data);

            $sql = "update movimentacao SET comissao_r = :comissao_r,
                                            tabela = :tabela,
                                            valor_comissao = :valor_comissao,
                                            valor_faturamento = :valor_faturamento
                                            where cod_operacao = :cod_operacao limit 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);

        } else {

            print_r('--- não achou movimento sem nota: ' . $numeroNota[0] . "\xA");

        }

    }

}

$pdo = null;

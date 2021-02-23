<?php

include('call-api.php');

$dataProduct = [
    '$format' => 'json',
];

$responseProduct = CallAPI('GET', 'produtos/consulta', $dataProduct);
$resultProduct = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseProduct), true);

$pdo = new PDO('mysql:host=db;dbname=pillowtex', 'root', 'qcLkozSAB3L4rp2TTUN7rJVlJa9C1CTb9hcdSLhcuiA=');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach ($resultProduct['value'] as $valueProduct) {

    $data = [
        'product_id' => $valueProduct['produto'],
        'name' => $valueProduct['descricao1'],
        'category_id' => $valueProduct['divisao'],
    ];

    $sql  = "INSERT INTO products (product_id, name, category_id) VALUES (:product_id, :name, :category_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

$pdo = null;

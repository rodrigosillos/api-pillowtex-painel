<?php

include('call-api.php');

$dataClient = [
    'dataci' => '2021-01-01',
    'datacf' => '2021-02-28',
    '$format' => 'json',
    '$dateformat' => 'iso',
];

$responseClient = CallAPI('GET', 'clientes/procura', $dataClient);
$resultClient = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseClient), true);

$pdo = new PDO('mysql:host=db;dbname=pillowtex', 'root', 'qcLkozSAB3L4rp2TTUN7rJVlJa9C1CTb9hcdSLhcuiA=');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach ($resultClient['value'] as $valueClient) {

    $data = [
        'client_id' => $valueClient['cliente'],
        'client_code' => $valueClient['codigo'],
        'name' => $valueClient['nome'],
        'email' => $valueClient['e_mail'],
        'type' => $valueClient['pf_pj'],
        'cnpj' => $valueClient['cnpj'],
        'address' => $valueClient['logradouro'],
        'city' => $valueClient['cidade'],
        'neighborhood' => $valueClient['bairro'],
        'state' => $valueClient['estado'],
    ];

    $sql  = "INSERT INTO clients (
                                client_id,
                                client_code, 
                                name, 
                                email,
                                type,
                                cnpj, 
                                address, 
                                city,
                                neighborhood, 
                                state) VALUES (
                                            :client_id,
                                            :client_code,
                                            :name,
                                            :email,
                                            :type,
                                            :cnpj,
                                            :address,
                                            :city,
                                            :neighborhood,
                                            :state)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

$pdo = null;

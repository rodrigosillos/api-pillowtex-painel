<?php

include('call-api.php');
include('connection-db.php');

//$countItem = 0;

$dataAgent = [
    '$format' => 'json',
];

$responseAgent = CallAPI('GET', 'representantes/busca', $dataAgent);
$resultAgent = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseAgent), true);

foreach ($resultAgent['value'] as $valueAgent) {

    if (!is_null($valueAgent['e_mail']) || !empty($valueAgent['e_mail']) || $valueAgent['e_mail'] != "") {

        $data = [
            'representante' => $valueAgent['representante'],
            'email' => $valueAgent['e_mail'],
        ];

        print($valueAgent['e_mail'] . ' - ' . $valueAgent['representante'] . "\xA");
        
        $sql = "update users SET agent_id2 = :representante where email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }

}

$pdo = null;

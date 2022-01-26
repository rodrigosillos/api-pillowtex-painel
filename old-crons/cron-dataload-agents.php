<?php

include('../call-api.php');
include('../connection-db.php');

$dataAgent = [
    '$format' => 'json',
];

$responseAgent = CallAPI('GET', 'representantes/busca', $dataAgent);
$resultAgent = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseAgent), true);

foreach ($resultAgent['value'] as $valueAgent) {

    if (!is_null($valueAgent['e_mail']) || !empty($valueAgent['e_mail']) || $valueAgent['e_mail'] != "") {

        $sql = "SELECT email FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $valueAgent['e_mail'], PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {

            print('cadastrando representante: ' . $valueAgent['e_mail'] . "\xA");

            $address_city = $valueAgent['cidade'];
            $address_state = $valueAgent['estado'];

            if(empty($valueAgent['cidade']))
                $address_city = 'São Paulo';

            if(empty($valueAgent['estado']))
                $address_state = 'SP';
                
            $data = [
                'name' => $valueAgent['nome'],
                'email' => $valueAgent['e_mail'],
                'email_verified_at' => null,
                'password' => '$2y$10$dNPoXhOEEy1eP4.UJeP8z.jvV01Vip59pJaVMpYVuhfi3qGj2q1Fi',
                'remember_token' => null,
                'user_profile_id' => 3,
                'agent_id' => $valueAgent['representante'],
                'agent_id2' => $valueAgent['representante'],
                'agent_code' => $valueAgent['codigo'],
                'address_city' => $address_city,
                'address_state' => $address_state,
            ];

            $sql  = "INSERT INTO users (
                                        name,
                                        email, 
                                        email_verified_at, 
                                        password,
                                        remember_token,
                                        user_profile_id, 
                                        agent_id, 
                                        agent_id2, 
                                        agent_code,
                                        address_city,
                                        address_state) VALUES (
                                                    :name,
                                                    :email,
                                                    :email_verified_at,
                                                    :password,
                                                    :remember_token,
                                                    :user_profile_id,
                                                    :agent_id,
                                                    :agent_id2,
                                                    :agent_code,
                                                    :address_city,
                                                    :address_state)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }
    }

}

$pdo = null;

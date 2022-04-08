<?php

include('call-api.php');
include('connection-db.php');

//$countItem = 0;

// $sql = "select agent_id from invoices i where operation_type = 'S' and hidden = 0 and issue_date between '2021-12-01' and '2021-12-30' group by agent_id";
$sql = "select agent_id2 from users where user_profile_id = 3 and regiao is null";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$representantes = $stmt->fetchAll();

foreach ($representantes as $representante__) {

    $representante_id = $representante__["agent_id2"];

    $consultaRepresentante = [
        'representante' => $representante_id,
        '$format' => 'json',
    ];
    
    $responseconsultaRepresentante = CallAPI('GET', 'representantes/consulta', $consultaRepresentante);
    $resultconsultaRepresentante = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $responseconsultaRepresentante), true);

    if($resultconsultaRepresentante['odata.count'] > 0 ) {

        $representanteRegiao = $resultconsultaRepresentante['value'][0]['regiao'];

        $data = [
            'regiao' => $representanteRegiao,
            'representante_id' => $representante_id,
        ];

        print_r($data);
        
        $sql = "update users SET regiao = :regiao where agent_id2 = :representante_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
    
        // $sql = "update invoices SET representante_regiao = :regiao where agent_id = :representante_id";
        // $stmt = $pdo->prepare($sql);
        // // $stmt->execute($data);
        
    }

}

$pdo = null;

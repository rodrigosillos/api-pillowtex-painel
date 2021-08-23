<?php

//include('call-api.php');
include('connection-db.php');

$dataAgent = [
    '$format' => 'json',
];

// database table division
$settings = [
    [
        'division' => '001',
        'table' => '214',
        'percentage' => 8,
    ],
    [
        'division' => '001',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '002',
        'table' => '214',
        'percentage' => 8,
    ],
    [
        'division' => '002',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '003',
        'table' => '214',
        'percentage' => 7.04,
    ],
    [
        'division' => '003',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '004',
        'table' => '214',
        'percentage' => 7.04,
    ],
    [
        'division' => '004',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '005',
        'table' => '214',
        'percentage' => 0,
    ],
    [
        'division' => '005',
        'table' => '187',
        'percentage' => 0,
    ],
    [
        'division' => '007',
        'table' => '214',
        'percentage' => 7,
    ],
    [
        'division' => '007',
        'table' => '187',
        'percentage' => 7,
    ],
    [
        'division' => '008',
        'table' => '214',
        'percentage' => 4,
    ],
    [
        'division' => '008',
        'table' => '187',
        'percentage' => 4,
    ],
    [
        'division' => '009',
        'table' => '214',
        'percentage' => 6,
    ],
    [
        'division' => '009',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '010',
        'table' => '214',
        'percentage' => 4,
    ],
    [
        'division' => '010',
        'table' => '187',
        'percentage' => 4,
    ],
    [
        'division' => '011',
        'table' => '214',
        'percentage' => 4,
    ],
    [
        'division' => '011',
        'table' => '187',
        'percentage' => 4,
    ],
    [
        'division' => '012',
        'table' => '214',
        'percentage' => 6,
    ],
    [
        'division' => '012',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '013',
        'table' => '214',
        'percentage' => 4,
    ],
    [
        'division' => '013',
        'table' => '187',
        'percentage' => 4,
    ],
    [
        'division' => '014',
        'table' => '214',
        'percentage' => 6,
    ],
    [
        'division' => '014',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '017',
        'table' => '214',
        'percentage' => 4,
    ],
    [
        'division' => '017',
        'table' => '187',
        'percentage' => 4,
    ],
    [
        'division' => '020',
        'table' => '214',
        'percentage' => 6,
    ],
    [
        'division' => '020',
        'table' => '187',
        'percentage' => 6,
    ],
    [
        'division' => '021',
        'table' => '214',
        'percentage' => 8,
    ],
    [
        'division' => '021',
        'table' => '187',
        'percentage' => 8,
    ],
    [
        'division' => '022',
        'table' => '214',
        'percentage' => 7,
    ],
    [
        'division' => '022',
        'table' => '187',
        'percentage' => 7,
    ],
    [
        'division' => 'L01',
        'table' => '214',
        'percentage' => 0,
    ],
    [
        'division' => 'L01',
        'table' => '187',
        'percentage' => 0,
    ],
    [
        'division' => 'indefinido',
        'table' => '214',
        'percentage' => 0,
    ],
    [
        'division' => 'indefinido',
        'table' => '187',
        'percentage' => 0,
    ],
];

foreach($settings as $setting) {

    $data = [
        'product_division' => $setting['division'],
        'price_list' => $setting['table'],
        'percentage' => $setting['percentage'],
    ];

    $sql = "INSERT INTO commission_settings (
                                            product_division,
                                            price_list, 
                                            percentage) VALUES (
                                                                :product_division,
                                                                :price_list,
                                                                :percentage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

$pdo = null;

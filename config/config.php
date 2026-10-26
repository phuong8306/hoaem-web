<?php
return [
    'db' => [
        'host' => 'db',
        'port' => 3306,
        'name' => 'hoavaem',
        'user' => 'hoaem',
        'pass' => 'hoaem123',
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'name'  => 'Hoa & Em',
        'url'   => 'http://localhost:8080',
        'debug' => true,
        'timezone' => 'Asia/Ho_Chi_Minh',
    ],
    'upload' => [
        'path'      => __DIR__ . '/../public/uploads',
        'url'       => '/uploads',
        'max_size'  => 5 * 1024 * 1024,
        'allowed'   => ['jpg', 'jpeg', 'png', 'webp'],
    ],
    'session' => [
        'name'     => 'HOAEM_SESSION',
        'lifetime' => 86400,
    ],
];
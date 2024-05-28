<?php 

return [
    'app' => [
        'name' => 'Framwork Narihy',
        'version' => '0.0.1',
        'environment' => 'development',
        'debug' => true,
        'url' => 'http://localhost:8000',
    ],
    'database' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'narihy',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '' 
    ],
    'mail' => [
        'driver' => 'stmp',
        'host' => '127.0.0.1',
        'port' => 1025,
        'username' => null,
        'password' => null,
        'encryption' => null,
        'from' => [
            'address' => 'hello@example.com',
            'name' => 'Example'
        ],
    ],
];
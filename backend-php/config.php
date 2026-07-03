<?php
$config = [
    'db' => [
        'host'    => 'localhost',
        'port'    => '3306',
        'name'    => 'crud_angular_mysql',
        'user'    => 'root',
        'pass'    => 'root',
        'charset' => 'utf8mb4',
    ],
    'cors_origins' => ['http://localhost:4200'],
];

$local = __DIR__ . '/config.local.php';
if (is_file($local)) {
    $override = require $local;
    if (is_array($override)) {
        $config = array_replace_recursive($config, $override);
    }
}

return $config;
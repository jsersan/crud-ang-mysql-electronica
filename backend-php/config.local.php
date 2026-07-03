<?php
// =============================================================================
//  PLANTILLA de config.local.php  (Arsys / producción)
// -----------------------------------------------------------------------------
//  1. Copia este fichero a  backend-php/config.local.php
//  2. Rellena la contraseña real de MySQL de Arsys.
//  3. NO lo subas a Git: config.local.php está en .gitignore.
//     Devuelve SOLO lo que quieras sobreescribir de config.php.
//
//  Los valores host/user/name son los que ya usaba tu backend Node en su .env.
// =============================================================================

return [
    'db' => [
        'host' => 'lldn292.servidoresdns.net',
        'port'    => '3306',
        'name'    => 'qaot591',
        'user'    => 'qaot591',
        'pass'    => 'Electronica2026#',
        'charset' => 'utf8mb4',
    ],
    'cors_origins' => ['http://txemaserrano.com', 'https://txemaserrano.com'],
];
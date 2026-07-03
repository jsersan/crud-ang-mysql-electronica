<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Content-Type: text/plain; charset=utf-8');

echo "PHP version: " . PHP_VERSION . "\n";
echo "pdo_mysql cargado: " . (extension_loaded('pdo_mysql') ? 'si' : 'NO') . "\n\n";

echo "1) Cargando config.php...\n";
$cfg = require __DIR__ . '/config.php';
echo "   OK  host=" . $cfg['db']['host'] . "  name=" . $cfg['db']['name'] . "  user=" . $cfg['db']['user'] . "\n\n";

echo "2) Cargando helpers.php, db.php, productos.php...\n";
require __DIR__ . '/helpers.php';
require __DIR__ . '/db.php';
require __DIR__ . '/productos.php';
echo "   OK (sin errores de sintaxis en esos ficheros)\n\n";

echo "3) Conectando a MySQL y contando filas...\n";
DB::init($cfg);
try {
    $pdo = DB::pdo();
    echo "   Conexion OK\n";
    $n = $pdo->query('SELECT COUNT(*) FROM productos')->fetchColumn();
    echo "   Filas en 'productos': " . $n . "\n";
} catch (Throwable $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
}
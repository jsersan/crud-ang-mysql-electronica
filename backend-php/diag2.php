<?php
// Captura errores fatales aunque Arsys tenga display_errors desactivado.
error_reporting(E_ALL);
ini_set('display_errors', '1');

register_shutdown_function(function () {
    $e = error_get_last();
    if ($e && in_array($e['type'], array(E_ERROR, E_PARSE, E_COMPILE_ERROR, E_CORE_ERROR, 4), true)) {
        echo "\n\n*** ERROR FATAL CAPTURADO ***\n";
        echo "Mensaje: " . $e['message'] . "\n";
        echo "Fichero: " . $e['file'] . "\n";
        echo "Linea:   " . $e['line'] . "\n";
    }
});

header('Content-Type: text/plain; charset=utf-8');
echo "PHP: " . PHP_VERSION . "\n\n";

echo "1) require config.php ...\n";
$cfg = require __DIR__ . '/config.php';
echo "   OK  (host=" . $cfg['db']['host'] . " name=" . $cfg['db']['name'] . " user=" . $cfg['db']['user'] . ")\n\n";

echo "2) require helpers/db/productos ...\n";
require __DIR__ . '/helpers.php';
require __DIR__ . '/db.php';
require __DIR__ . '/productos.php';
echo "   OK (sin errores de sintaxis)\n\n";

echo "3) conectar a MySQL ...\n";
DB::init($cfg);
$pdo = DB::pdo();
echo "   conexion OK\n";
$n = $pdo->query('SELECT COUNT(*) FROM productos')->fetchColumn();
echo "   filas en 'productos': " . $n . "\n";

<?php
// db_config.php
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_USER', 'postgres');
define('DB_PASS', '123456');
define('DB_NAME', 'muelle_pesquero');

try {
    $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";user=" . DB_USER . ";password=" . DB_PASS;
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>

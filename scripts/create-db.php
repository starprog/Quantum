<?php
// PHP fallback to create the database using .env values or command-line overrides.
// Run: php scripts/create-db.php

$envFile = __DIR__ . '/../.env';
$env = [];
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (!strpos($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $env[trim($k)] = trim($v);
    }
}

$dbHost = $env['DB_HOST'] ?? '127.0.0.1';
$dbPort = $env['DB_PORT'] ?? '3306';
$dbUser = $env['DB_USERNAME'] ?? $env['DB_USER'] ?? 'root';
$dbPass = $env['DB_PASSWORD'] ?? '';
$dbName = $env['DB_DATABASE'] ?? 'quantum';

// Allow overrides from CLI args
foreach ($argv as $arg) {
    if (strpos($arg, '--db=') === 0) $dbName = substr($arg, 5);
    if (strpos($arg, '--user=') === 0) $dbUser = substr($arg, 7);
    if (strpos($arg, '--pass=') === 0) $dbPass = substr($arg, 7);
    if (strpos($arg, '--host=') === 0) $dbHost = substr($arg, 7);
    if (strpos($arg, '--port=') === 0) $dbPort = substr($arg, 7);
}

echo "Creating database '$dbName' on $dbHost:$dbPort as $dbUser" . PHP_EOL;
try {
    $dsn = "mysql:host=$dbHost;port=$dbPort;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($sql);
    echo "Database '$dbName' created or already exists." . PHP_EOL;
    exit(0);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
?>

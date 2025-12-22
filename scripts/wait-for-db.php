<?php
// scripts/wait-for-db.php
$max = 60; // retry sampai ~60 detik
$tries = 0;
$host = getenv('DB_HOST') ?: getenv('MYSQLHOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: getenv('MYSQLPORT') ?: 3306;
$db   = getenv('DB_DATABASE') ?: getenv('MYSQLDATABASE') ?: '';
$user = getenv('DB_USERNAME') ?: getenv('MYSQLUSER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: getenv('MYSQLPASSWORD') ?: '';

fwrite(STDOUT, "Waiting for MySQL at {$host}:{$port} (db={$db}) ...\n");
while ($tries < $max) {
    try {
        $dsn = "mysql:host={$host};port={$port};dbname={$db}";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 3,
        ]);
        fwrite(STDOUT, "DB is reachable\n");
        exit(0);
    } catch (Exception $e) {
        $tries++;
        fwrite(STDOUT, "Waiting for DB ({$tries}/{$max})...\n");
        sleep(1);
    }
}
fwrite(STDERR, "DB not reachable after {$max} tries\n");
exit(1);
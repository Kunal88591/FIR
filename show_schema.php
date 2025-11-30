<?php
require_once __DIR__ . '/includes/db.php';
$pdo = getPDO();
$cols = $pdo->query("PRAGMA table_info('firs')")->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: text/plain');
foreach ($cols as $c) { echo $c['name'] . PHP_EOL; }
?>
<?php
// Database helper for SQLite using PDO
function getPDO(): PDO
{
    $dbFile = __DIR__ . '/../data/database.sqlite';
    if (!file_exists(dirname($dbFile))) {
        mkdir(dirname($dbFile), 0755, true);
    }

    $dsn = 'sqlite:' . $dbFile;
    $pdo = new PDO($dsn);
    // Throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Use associative arrays by default
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Enable foreign keys in SQLite
    $pdo->exec('PRAGMA foreign_keys = ON;');
    return $pdo;
}
?>
<?php
// MySQL Database Configuration for FIR System
function getPDO(): PDO
{
    $host = 'localhost';
    $dbname = 'fir_system';
    $username = 'root';
    $password = ''; // Default XAMPP password is empty
    
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage() . "<br>Make sure MySQL is running in XAMPP!");
    }
}
?>

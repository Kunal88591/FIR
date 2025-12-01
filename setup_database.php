<?php
// MySQL Database Initialization Script
// Run this after installing XAMPP and creating the database

require_once __DIR__ . '/includes/db_mysql.php';

echo "🚀 Starting MySQL Database Initialization...\n\n";

try {
    $pdo = getPDO();
    echo "✅ Connected to MySQL successfully!\n";
    
    // Read SQL file
    $sqlFile = __DIR__ . '/sql/init_mysql.sql';
    
    if (!file_exists($sqlFile)) {
        die("❌ Error: SQL file not found at $sqlFile\n");
    }
    
    $sql = file_get_contents($sqlFile);
    echo "📄 SQL file loaded successfully!\n";
    
    // Remove comments and split by semicolon
    $sql = preg_replace('/--.*$/m', '', $sql); // Remove single-line comments
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql); // Remove multi-line comments
    
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    echo "📊 Executing " . count($statements) . " SQL statements...\n\n";
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $statement) {
        if (empty($statement)) continue;
        
        try {
            $pdo->exec($statement);
            $successCount++;
            
            // Show progress for major operations
            if (stripos($statement, 'CREATE TABLE') !== false) {
                preg_match('/CREATE TABLE.*?`?(\w+)`?\s/i', $statement, $matches);
                $tableName = $matches[1] ?? 'unknown';
                echo "  ✓ Created table: $tableName\n";
            } elseif (stripos($statement, 'INSERT INTO') !== false) {
                preg_match('/INSERT INTO\s+`?(\w+)`?/i', $statement, $matches);
                $tableName = $matches[1] ?? 'unknown';
                echo "  + Inserted data into: $tableName\n";
            }
        } catch (PDOException $e) {
            $errorCount++;
            // Only show critical errors
            if (stripos($e->getMessage(), 'already exists') === false) {
                echo "  ⚠ Warning: " . substr($e->getMessage(), 0, 100) . "...\n";
            }
        }
    }
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "🎉 Database Initialization Complete!\n";
    echo str_repeat("=", 50) . "\n\n";
    
    echo "📊 Statistics:\n";
    echo "   ✅ Successful operations: $successCount\n";
    if ($errorCount > 0) {
        echo "   ⚠ Warnings: $errorCount\n";
    }
    
    echo "\n📋 Database Tables Created:\n";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        echo "   • $table ($count rows)\n";
    }
    
    echo "\n🌐 Access Points:\n";
    echo "   📊 phpMyAdmin: http://localhost/phpmyadmin\n";
    echo "   🏠 Your Project: http://localhost/fir (after copying to C:\\xampp\\htdocs\\fir)\n";
    echo "   🗄️ Database: fir_system\n";
    echo "   👤 Admin Login: admin / admin123\n";
    
    echo "\n✨ Your FIR System is ready for your college project!\n";
    
} catch (PDOException $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "\n💡 Troubleshooting:\n";
    echo "   1. Make sure XAMPP is running\n";
    echo "   2. Make sure MySQL service is started (green in XAMPP Control Panel)\n";
    echo "   3. Create database 'fir_system' in phpMyAdmin first\n";
    echo "   4. Check MySQL is running on port 3306\n";
}
?>

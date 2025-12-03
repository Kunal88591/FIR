<?php
// Database Configuration for FIR System (supports MySQL and SQLite)
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/logger.php';

function getPDO(): PDO
{
    static $pdo = null;
    
    if ($pdo !== null) {
        return $pdo;
    }
    
    $dbType = Config::get('DB_TYPE', 'sqlite'); // Default to SQLite for portability
    
    try {
        if ($dbType === 'sqlite') {
            // SQLite configuration
            $dbPath = __DIR__ . '/../database/fir_system.db';
            $dbDir = dirname($dbPath);
            
            // Create database directory if it doesn't exist
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0755, true);
            }
            
            $dsn = "sqlite:$dbPath";
            $pdo = new PDO($dsn);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Enable foreign keys in SQLite
            $pdo->exec('PRAGMA foreign_keys = ON');
            
            // Initialize database if it's empty
            initializeSQLiteDatabase($pdo, $dbPath);
            
            Logger::debug('SQLite database connection established');
        } else {
            // MySQL configuration
            $config = Config::database();
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            
            $pdo = new PDO($dsn, $config['username'], $config['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            Logger::debug('MySQL database connection established');
        }
        
        return $pdo;
    } catch (PDOException $e) {
        Logger::critical('Database connection failed', ['error' => $e->getMessage(), 'type' => $dbType]);
        if (Config::isDebug()) {
            die("Database connection failed: " . $e->getMessage() . "<br>Database type: $dbType");
        } else {
            die("Database connection failed. Please contact system administrator.");
        }
    }
}

function initializeSQLiteDatabase(PDO $pdo, string $dbPath): void
{
    // Check if database is already initialized
    $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='admins'")->fetchAll();
    
    if (empty($tables)) {
        Logger::info('Initializing SQLite database');
        
        $sqlFile = __DIR__ . '/../sql/init_sqlite.sql';
        if (file_exists($sqlFile)) {
            $sql = file_get_contents($sqlFile);
            $pdo->exec($sql);
            Logger::info('SQLite database initialized successfully');
        } else {
            Logger::error('SQLite initialization file not found', ['path' => $sqlFile]);
        }
    }
}
?>

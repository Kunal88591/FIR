<?php
/**
 * Logger Class
 * Handles application logging with different severity levels
 */

class Logger
{
    const DEBUG = 'DEBUG';
    const INFO = 'INFO';
    const WARNING = 'WARNING';
    const ERROR = 'ERROR';
    const CRITICAL = 'CRITICAL';

    private static $logFile;
    private static $logLevel;

    /**
     * Initialize logger
     */
    public static function init(): void
    {
        require_once __DIR__ . '/config.php';
        self::$logFile = __DIR__ . '/../' . Config::get('LOG_FILE', 'logs/app.log');
        self::$logLevel = strtoupper(Config::get('LOG_LEVEL', 'INFO'));
        
        // Create logs directory if it doesn't exist
        $logDir = dirname(self::$logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
    }

    /**
     * Log a message
     * @param string $level Log level
     * @param string $message Log message
     * @param array $context Additional context
     */
    private static function log(string $level, string $message, array $context = []): void
    {
        if (!self::$logFile) {
            self::init();
        }

        // Check if we should log this level
        $levels = [self::DEBUG => 0, self::INFO => 1, self::WARNING => 2, self::ERROR => 3, self::CRITICAL => 4];
        if ($levels[$level] < $levels[self::$logLevel]) {
            return;
        }

        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context) : '';
        $logEntry = "[$timestamp] $level: $message$contextStr" . PHP_EOL;

        // Write to log file
        file_put_contents(self::$logFile, $logEntry, FILE_APPEND | LOCK_EX);

        // If in debug mode, also output to error log
        if (Config::isDebug()) {
            error_log($logEntry);
        }
    }

    public static function debug(string $message, array $context = []): void
    {
        self::log(self::DEBUG, $message, $context);
    }

    public static function info(string $message, array $context = []): void
    {
        self::log(self::INFO, $message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::log(self::WARNING, $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::log(self::ERROR, $message, $context);
    }

    public static function critical(string $message, array $context = []): void
    {
        self::log(self::CRITICAL, $message, $context);
    }
}

// Initialize logger
Logger::init();

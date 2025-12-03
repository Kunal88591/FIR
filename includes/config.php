<?php
/**
 * Configuration Manager
 * Loads environment variables and provides configuration access
 */

class Config
{
    private static $config = [];
    private static $loaded = false;

    /**
     * Load environment variables from .env file
     */
    public static function load(): void
    {
        if (self::$loaded) {
            return;
        }

        $envFile = __DIR__ . '/../.env';
        if (!file_exists($envFile)) {
            throw new Exception('.env file not found. Please copy .env.example to .env');
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove quotes if present
                if (preg_match('/^(["\'])(.*)\\1$/', $value, $matches)) {
                    $value = $matches[2];
                }
                
                self::$config[$key] = $value;
                
                // Also set as environment variable
                if (!getenv($key)) {
                    putenv("$key=$value");
                }
            }
        }

        self::$loaded = true;
    }

    /**
     * Get configuration value
     * @param string $key Configuration key
     * @param mixed $default Default value if key not found
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        if (!self::$loaded) {
            self::load();
        }

        return self::$config[$key] ?? $default;
    }

    /**
     * Get database configuration
     * @return array
     */
    public static function database(): array
    {
        return [
            'host' => self::get('DB_HOST', 'localhost'),
            'dbname' => self::get('DB_NAME', 'fir_system'),
            'username' => self::get('DB_USER', 'root'),
            'password' => self::get('DB_PASSWORD', ''),
            'charset' => 'utf8mb4'
        ];
    }

    /**
     * Check if app is in debug mode
     * @return bool
     */
    public static function isDebug(): bool
    {
        return self::get('APP_DEBUG', 'false') === 'true';
    }

    /**
     * Get app environment
     * @return string
     */
    public static function environment(): string
    {
        return self::get('APP_ENV', 'production');
    }

    /**
     * Check if app is in production
     * @return bool
     */
    public static function isProduction(): bool
    {
        return self::environment() === 'production';
    }
}

// Auto-load configuration
Config::load();

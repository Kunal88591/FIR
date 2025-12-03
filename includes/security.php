<?php
/**
 * Security Helper Functions
 * CSRF protection, input validation, and security utilities
 */

require_once __DIR__ . '/config.php';

class Security
{
    /**
     * Generate CSRF token
     * @return string
     */
    public static function generateCsrfToken(): string
    {
        if (!isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_time'])) {
            self::regenerateCsrfToken();
        }

        // Check if token is expired
        $expiry = Config::get('CSRF_TOKEN_EXPIRY', 3600);
        if (time() - $_SESSION['csrf_token_time'] > $expiry) {
            self::regenerateCsrfToken();
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Regenerate CSRF token
     */
    public static function regenerateCsrfToken(): void
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
    }

    /**
     * Verify CSRF token
     * @param string $token Token to verify
     * @return bool
     */
    public static function verifyCsrfToken(string $token): bool
    {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Get CSRF token input field
     * @return string
     */
    public static function csrfField(): string
    {
        $token = self::generateCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }

    /**
     * Validate CSRF token from POST request
     * @throws Exception if token is invalid
     */
    public static function validateCsrfToken(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!self::verifyCsrfToken($token)) {
            Logger::warning('CSRF token validation failed', [
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'uri' => $_SERVER['REQUEST_URI'] ?? 'unknown'
            ]);
            throw new Exception('Invalid CSRF token. Please refresh the page and try again.');
        }
    }

    /**
     * Sanitize input string
     * @param string $input
     * @return string
     */
    public static function sanitizeString(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate email address
     * @param string $email
     * @return bool
     */
    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate phone number (basic)
     * @param string $phone
     * @return bool
     */
    public static function validatePhone(string $phone): bool
    {
        return preg_match('/^[0-9\+\-\(\)\s]{10,20}$/', $phone);
    }

    /**
     * Rate limiting check
     * @param string $key Unique key for rate limit (e.g., 'login_' . $ip)
     * @param int $maxAttempts Maximum attempts allowed
     * @param int $timeWindow Time window in seconds
     * @return bool True if allowed, false if rate limited
     */
    public static function checkRateLimit(string $key, int $maxAttempts = 5, int $timeWindow = 300): bool
    {
        if (!isset($_SESSION['rate_limit'])) {
            $_SESSION['rate_limit'] = [];
        }

        $now = time();
        $limitKey = 'rl_' . $key;

        // Clean up old entries
        if (isset($_SESSION['rate_limit'][$limitKey])) {
            $_SESSION['rate_limit'][$limitKey] = array_filter(
                $_SESSION['rate_limit'][$limitKey],
                function($timestamp) use ($now, $timeWindow) {
                    return ($now - $timestamp) < $timeWindow;
                }
            );
        } else {
            $_SESSION['rate_limit'][$limitKey] = [];
        }

        // Check if rate limit exceeded
        if (count($_SESSION['rate_limit'][$limitKey]) >= $maxAttempts) {
            Logger::warning('Rate limit exceeded', ['key' => $key, 'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']);
            return false;
        }

        // Add current attempt
        $_SESSION['rate_limit'][$limitKey][] = $now;
        return true;
    }

    /**
     * Reset rate limit for a key
     * @param string $key
     */
    public static function resetRateLimit(string $key): void
    {
        $limitKey = 'rl_' . $key;
        if (isset($_SESSION['rate_limit'][$limitKey])) {
            unset($_SESSION['rate_limit'][$limitKey]);
        }
    }

    /**
     * Secure session configuration
     */
    public static function configureSession(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        ini_set('session.cookie_httponly', Config::get('SESSION_HTTPONLY', 'true') === 'true' ? 1 : 0);
        ini_set('session.cookie_secure', Config::get('SESSION_SECURE', 'false') === 'true' ? 1 : 0);
        ini_set('session.use_strict_mode', 1);
        ini_set('session.cookie_samesite', 'Lax'); // Changed from Strict to Lax for better compatibility
        ini_set('session.gc_maxlifetime', Config::get('SESSION_LIFETIME', 7200));

        session_start();

        // Regenerate session ID periodically to prevent session fixation
        // But preserve CSRF token during regeneration
        if (!isset($_SESSION['last_regeneration'])) {
            $_SESSION['last_regeneration'] = time();
        } elseif (time() - $_SESSION['last_regeneration'] > 1800) { // 30 minutes
            $csrfToken = $_SESSION['csrf_token'] ?? null;
            $csrfTime = $_SESSION['csrf_token_time'] ?? null;
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
            // Restore CSRF token after regeneration
            if ($csrfToken) {
                $_SESSION['csrf_token'] = $csrfToken;
                $_SESSION['csrf_token_time'] = $csrfTime;
            }
        }
    }
}

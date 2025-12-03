<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/db.php';

// Configure secure session
Security::configureSession();

function isAdminLoggedIn(): bool
{
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdmin(): void
{
    if (!isAdminLoggedIn()) {
        Logger::warning('Unauthorized admin access attempt', [
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'uri' => $_SERVER['REQUEST_URI'] ?? 'unknown'
        ]);
        header('Location: /admin/login.php');
        exit;
    }
}

function adminLogin(string $username, string $password): bool
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :u LIMIT 1');
    $stmt->execute([':u' => $username]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password_hash'])) {
        // Regenerate session ID on login to prevent session fixation
        session_regenerate_id(true);
        
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['last_regeneration'] = time();
        
        Logger::info('Admin login successful', ['username' => $username, 'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']);
        
        // Reset rate limit on successful login
        Security::resetRateLimit('login_' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
        
        return true;
    }
    
    Logger::warning('Failed admin login attempt', ['username' => $username, 'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']);
    return false;
}

function adminLogout(): void
{
    $username = $_SESSION['admin_username'] ?? 'unknown';
    Logger::info('Admin logout', ['username' => $username]);
    
    session_unset();
    session_destroy();
    session_start();
    session_regenerate_id(true);
}
?>
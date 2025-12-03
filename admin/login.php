<?php
require_once __DIR__ . '/../includes/auth.php';
$title = 'Admin Login';

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Rate limiting check
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        if (!Security::checkRateLimit('login_' . $ip, 5, 300)) {
            $error = 'Too many login attempts. Please try again in 5 minutes.';
        } else {
            // CSRF validation
            Security::validateCsrfToken();
            
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (adminLogin($username, $password)) {
                header('Location: /admin/index.php');
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        }
    } catch (Exception $e) {
        Logger::error('Login error', ['error' => $e->getMessage()]);
        $error = $e->getMessage();
    }
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-section">
                <h2>Admin Login</h2>
                <?php if ($error): ?>
                        <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form method="POST">
                        <?php echo Security::csrfField(); ?>
                        <div class="mb-2"><label>Username</label><input class="form-control" type="text" name="username" required></div>
                        <div class="mb-2"><label>Password</label><input class="form-control" type="password" name="password" required></div>
                        <div class="d-grid"><button class="btn btn-primary" type="submit">Login</button></div>
                </form>
            </div>
        </div>
        <div class="text-center muted"><a href="/">Back to Home</a></div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
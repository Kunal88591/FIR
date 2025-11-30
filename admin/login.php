<?php
require_once __DIR__ . '/../includes/auth.php';
$title = 'Admin Login';

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (adminLogin($username, $password)) {
        header('Location: /admin/index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
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
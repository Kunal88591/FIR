<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';
$title = 'Admin - Criminals';
$pdo = getPDO();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_criminal'])) {
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0) ?: null;
    $gender = trim($_POST['gender'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $crime_history = trim($_POST['crime_history'] ?? '');
    if ($name === '') $errors[] = 'Criminal name is required.';
    if (empty($errors)) {
        $ins = $pdo->prepare('INSERT INTO criminals (name, age, gender, address, crime_history) VALUES (:n, :age, :g, :a, :ch)');
        $ins->execute([':n' => $name, ':age' => $age, ':g' => $gender, ':a' => $address, ':ch' => $crime_history]);
        header('Location: /admin/criminals.php');
        exit;
    }
}

$criminals = $pdo->query('SELECT * FROM criminals ORDER BY name ASC')->fetchAll();
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<div class="card">
    <div class="card-section d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Criminals</h1>
        <div>
            <a class="btn btn-outline" href="/admin/index.php">Back</a>
            <a class="btn btn-outline" href="/admin/logout.php">Logout</a>
        </div>
    </div>
    <div class="card-section">

    <?php if (!empty($errors)): ?>
        <div class="error"><?php echo htmlspecialchars(implode('; ', $errors)); ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-2 align-items-center mb-3">
        <div class="col-md-4"><input class="form-control" type="text" name="name" placeholder="Name" required></div>
        <div class="col-md-2"><input class="form-control" type="number" name="age" placeholder="Age"></div>
        <div class="col-md-2"><input class="form-control" type="text" name="gender" placeholder="Gender"></div>
        <div class="col-md-3"><input class="form-control" type="text" name="address" placeholder="Address"></div>
        <div class="col-md-1 d-grid"><button class="btn btn-primary" type="submit" name="create_criminal">Create</button></div>
    </form>

    <h2>All Criminals</h2>
</div>
  <h2>All Criminals</h2>
    <?php if (count($criminals) === 0): ?>
        <div class="alert alert-secondary">No criminals recorded.</div>
    <?php else: ?>
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr><th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($criminals as $c): ?>
                <tr>
                    <td><?php echo $c['id']; ?></td>
                    <td><?php echo htmlspecialchars($c['name']); ?></td>
                    <td><?php echo htmlspecialchars($c['age']); ?></td>
                    <td><?php echo htmlspecialchars($c['gender']); ?></td>
                    <td>
                        <form method="POST" action="/admin/actions.php" style="display:inline">
                            <input type="hidden" name="resource" value="criminal">
                            <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                            <button class="btn btn-sm btn-outline" type="submit" name="action" value="delete" onclick="return confirm('Delete this criminal?');">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    <?php endif; ?>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</div>
</body>
</html>

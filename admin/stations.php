<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';
$title = 'Admin - Police Stations';
$pdo = getPDO();

// Handle add station POST
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_station'])) {
    $name = trim($_POST['station_name'] ?? '');
    $contact = trim($_POST['contact_num'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    if ($name === '') $errors[] = 'Station name is required.';
    if (empty($errors)) {
        $ins = $pdo->prepare('INSERT INTO police_stations (station_name, contact_num, address, city) VALUES (:n, :c, :a, :city)');
        $ins->execute([':n' => $name, ':c' => $contact, ':a' => $address, ':city' => $city]);
        header('Location: /admin/stations.php');
        exit;
    }
}

$stations = $pdo->query('SELECT * FROM police_stations ORDER BY station_name ASC')->fetchAll();
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<div class="card">
    <div class="card-section d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Police Stations</h1>
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
        <div class="col-md-4"><input class="form-control" type="text" name="station_name" placeholder="Station Name" required></div>
        <div class="col-md-2"><input class="form-control" type="text" name="contact_num" placeholder="Contact"></div>
        <div class="col-md-3"><input class="form-control" type="text" name="address" placeholder="Address"></div>
        <div class="col-md-2"><input class="form-control" type="text" name="city" placeholder="City"></div>
        <div class="col-md-1 d-grid"><button class="btn btn-primary" type="submit" name="create_station">Create</button></div>
    </form>

    <h2>All Stations</h2>
    <?php if (count($stations) === 0): ?>
        <div class="alert alert-secondary">No stations defined.</div>
    <?php else: ?>
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr><th>ID</th><th>Name</th><th>Contact</th><th>City</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($stations as $s): ?>
                <tr>
                    <td><?php echo $s['id']; ?></td>
                    <td><?php echo htmlspecialchars($s['station_name']); ?></td>
                    <td><?php echo htmlspecialchars($s['contact_num']); ?></td>
                    <td><?php echo htmlspecialchars($s['city']); ?></td>
                    <td>
                        <form method="POST" action="/admin/actions.php" style="display:inline">
                            <input type="hidden" name="resource" value="station">
                            <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                            <button class="btn btn-sm btn-outline" type="submit" name="action" value="delete" onclick="return confirm('Delete this station?');">Delete</button>
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

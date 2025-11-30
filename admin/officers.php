<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
$title = 'Admin - Officers';
require_once __DIR__ . '/../includes/db.php';
$pdo = getPDO();
$stations = $pdo->query('SELECT id, station_name FROM police_stations ORDER BY station_name ASC')->fetchAll();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_officer'])) {
    $name = trim($_POST['name'] ?? '');
    $rank = trim($_POST['rank'] ?? '');
    $contact = trim($_POST['contact_num'] ?? '');
    if ($name === '') $errors[] = 'Officer name is required.';
    if (empty($errors)) {
        $station_id = intval($_POST['station_id'] ?? 0) ?: null;
        $ins = $pdo->prepare('INSERT INTO officers (name, rank, contact_num, station_id) VALUES (:n, :r, :c, :s)');
        $ins->execute([':n' => $name, ':r' => $rank, ':c' => $contact, ':s' => $station_id]);
        header('Location: /admin/officers.php');
        exit;
    }
}

$officers = $pdo->query('SELECT * FROM officers ORDER BY name ASC')->fetchAll();
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<div class="card">
    <div class="card-section d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Officers</h1>
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
        <div class="col-md-4"><input class="form-control" type="text" name="name" placeholder="Officer Name" required></div>
        <div class="col-md-2"><input class="form-control" type="text" name="rank" placeholder="Rank"></div>
        <div class="col-md-2"><input class="form-control" type="text" name="contact_num" placeholder="Contact"></div>
        <div class="col-md-3">
            <select class="form-select" name="station_id">
                <option value="">-- Select Station --</option>
                <?php foreach ($stations as $st): ?>
                    <option value="<?php echo $st['id']; ?>"><?php echo htmlspecialchars($st['station_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-1 d-grid"><button class="btn btn-primary" type="submit" name="create_officer">Create</button></div>
    </form>

    <h2>All Officers</h2>
    <?php if (count($officers) === 0): ?>
        <div class="alert alert-secondary">No officers defined.</div>
    <?php else: ?>
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr><th>ID</th><th>Name</th><th>Rank</th><th>Contact</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($officers as $o): ?>
                <tr>
                    <td><?php echo $o['id']; ?></td>
                    <td><?php echo htmlspecialchars($o['name']); ?></td>
                    <td><?php echo htmlspecialchars($o['rank']); ?></td>
                    <td><?php echo htmlspecialchars($o['contact_num']); ?></td>
                    <td>
                        <form method="POST" action="/admin/actions.php" style="display:inline">
                            <input type="hidden" name="resource" value="officer">
                            <input type="hidden" name="id" value="<?php echo $o['id']; ?>">
                            <button class="btn btn-sm btn-outline" type="submit" name="action" value="delete" onclick="return confirm('Delete this officer?');">Delete</button>
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
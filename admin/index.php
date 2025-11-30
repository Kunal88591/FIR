<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';
$title = 'Admin Dashboard';

$pdo = getPDO();
$counts = [];
$counts['firs'] = $pdo->query('SELECT COUNT(*) FROM firs')->fetchColumn();
$counts['stations'] = $pdo->query('SELECT COUNT(*) FROM police_stations')->fetchColumn();
$counts['officers'] = $pdo->query('SELECT COUNT(*) FROM officers')->fetchColumn();
$counts['criminals'] = $pdo->query('SELECT COUNT(*) FROM criminals')->fetchColumn();
$stmt = $pdo->query('SELECT f.*, c.name as complainant_name, ps.station_name as station_name FROM firs f LEFT JOIN complainants c ON f.complainant_id = c.id LEFT JOIN police_stations ps ON f.station_id = ps.id ORDER BY f.created_at DESC');
$firs = $stmt->fetchAll();
$officers = $pdo->query('SELECT id, name FROM officers ORDER BY name ASC')->fetchAll();
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
?>

<div class="card">
    <div class="card-section d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-0">Admin Dashboard</h1>
            <small class="muted">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'admin'); ?></small>
        </div>
        <div>
            <a href="/admin/stations.php" class="btn btn-outline">Stations</a>
            <a href="/admin/officers.php" class="btn btn-outline">Officers</a>
            <a href="/admin/criminals.php" class="btn btn-outline">Criminals</a>
            <a href="/admin/evidence.php" class="btn btn-outline">Evidence</a>
            <a href="/" class="btn btn-outline">Public</a>
        </div>
    </div>
        <div class="card-section">
            <div class="row mb-3">
                <div class="col-md-3"><div class="card card-compact p-2 text-center"><div class="fw-bold"><?php echo intval($counts['firs']); ?></div><small class="muted">Total FIRs</small></div></div>
                <div class="col-md-3"><div class="card card-compact p-2 text-center"><div class="fw-bold"><?php echo intval($counts['stations']); ?></div><small class="muted">Stations</small></div></div>
                <div class="col-md-3"><div class="card card-compact p-2 text-center"><div class="fw-bold"><?php echo intval($counts['officers']); ?></div><small class="muted">Officers</small></div></div>
                <div class="col-md-3"><div class="card card-compact p-2 text-center"><div class="fw-bold"><?php echo intval($counts['criminals']); ?></div><small class="muted">Criminals</small></div></div>
            </div>

        <?php if (count($firs) == 0): ?>
            <div class="alert alert-secondary">No FIRs found.</div>
        <?php else: ?>
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Complainant</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Place</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($firs as $f): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($f['id']); ?></td>
                        <td><?php echo htmlspecialchars($f['complainant_name']); ?></td>
                        <td><?php echo htmlspecialchars($f['title']); ?></td>
                        <td><?php echo htmlspecialchars($f['date_of_incident']); ?></td>
                        <td><?php echo htmlspecialchars($f['incident_place']); ?></td>
                        <td><div class="pill" data-status="<?php echo htmlspecialchars($f['status']); ?>"><?php echo htmlspecialchars($f['status']); ?></div></td>
                        <td class="table-actions">
                            <a class="btn btn-sm btn-outline" href="/view_fir.php?id=<?php echo $f['id']; ?>">View</a>
                            <a class="btn btn-sm btn-outline" href="/admin/edit_fir.php?id=<?php echo $f['id']; ?>">Edit</a>
                            <form style="display:inline" method="POST" action="/admin/actions.php">
                                <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
                                <input class="form-select form-select-sm" style="display:inline; width: auto;" name="status">
                                    <option value="Submitted" <?php echo ($f['status'] === 'Submitted') ? 'selected' : ''; ?>>Submitted</option>
                                    <option value="Under Investigation" <?php echo ($f['status'] === 'Under Investigation') ? 'selected' : ''; ?>>Under Investigation</option>
                                    <option value="Closed" <?php echo ($f['status'] === 'Closed') ? 'selected' : ''; ?>>Closed</option>
                                </input>
                                <button class="btn btn-sm btn-primary" type="submit" name="action" value="update">Update</button>
                                <button class="btn btn-sm btn-outline" type="submit" name="action" value="delete" onclick="return confirm('Delete this FIR?');">Delete</button>
                            </form>
                            <form style="display:inline" method="POST" action="/admin/actions.php">
                                <input type="hidden" name="resource" value="fir">
                                <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
                                <select name="officer_id">
                                    <option value="">-- Assign officer --</option>
                                    <?php foreach ($officers as $o): ?>
                                        <option value="<?php echo $o['id']; ?>"><?php echo htmlspecialchars($o['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="btn btn-sm btn-outline" type="submit" name="action" value="assign_officer">Assign</button>
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
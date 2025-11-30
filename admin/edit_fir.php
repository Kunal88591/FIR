<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
$title = 'Edit FIR';
require_once __DIR__ . '/../includes/db.php';
$pdo = getPDO();
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: /admin/index.php'); exit; }
$stmt = $pdo->prepare('SELECT * FROM firs WHERE id = :id LIMIT 1');
$stmt->execute([':id' => $id]);
$fir = $stmt->fetch();
if (!$fir) { header('Location: /admin/index.php'); exit; }
$stations = $pdo->query('SELECT id, station_name FROM police_stations ORDER BY station_name ASC')->fetchAll();
require_once __DIR__ . '/../includes/header.php';
?>
<div class="card">
  <div class="card-section">
    <h2>Edit FIR #<?php echo htmlspecialchars($fir['id']); ?></h2>
  </div>
  <div class="card-section">
    <form method="POST" action="/admin/actions.php">
        <input type="hidden" name="resource" value="fir">
        <input type="hidden" name="id" value="<?php echo $fir['id']; ?>">
        <div class="row">
            <div class="col-md-6 mb-2"><label>Title</label><input class="form-control" type="text" name="title" value="<?php echo htmlspecialchars($fir['title']); ?>"></div>
            <div class="col-md-6 mb-2"><label>Crime Type</label><input class="form-control" type="text" name="crime_type" value="<?php echo htmlspecialchars($fir['crime_type'] ?? ''); ?>"></div>
            <div class="col-md-4 mb-2"><label>Date of Incident</label><input class="form-control" type="date" name="date_of_incident" value="<?php echo htmlspecialchars($fir['date_of_incident']); ?>"></div>
            <div class="col-md-8 mb-2"><label>Place of Incident</label><input class="form-control" type="text" name="incident_place" value="<?php echo htmlspecialchars($fir['incident_place']); ?>"></div>
            <div class="col-md-6 mb-2"><label>Station</label><select class="form-select" name="station_id">
                <option value="">(none)</option>
                <?php foreach ($stations as $s): ?>
                    <option value="<?php echo $s['id']; ?>" <?php echo ($fir['station_id'] == $s['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($s['station_name']); ?></option>
                <?php endforeach; ?>
            </select></div>
            <div class="col-md-6 mb-2"><label>Status</label><select class="form-select" name="status">
                <option value="Submitted" <?php echo ($fir['status'] === 'Submitted') ? 'selected' : ''; ?>>Submitted</option>
                <option value="Under Investigation" <?php echo ($fir['status'] === 'Under Investigation') ? 'selected' : ''; ?>>Under Investigation</option>
                <option value="Closed" <?php echo ($fir['status'] === 'Closed') ? 'selected' : ''; ?>>Closed</option>
            </select></div>
            <div class="col-12 mb-2"><label>Description</label><textarea class="form-control" name="description" rows="6"><?php echo htmlspecialchars($fir['description']); ?></textarea></div>
        </div>
        <div class="d-grid mt-2"><button class="btn btn-primary" type="submit" name="action" value="update_fir">Save</button></div>
    </form>
    <p><a href="/admin/index.php">Back</a></p>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

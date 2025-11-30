<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';
$title = 'Admin - FIR Details';
$pdo = getPDO();

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: /admin/index.php'); exit; }

// Load FIR
$stmt = $pdo->prepare('SELECT f.*, c.name as complainant_name, c.contact as complainant_contact, c.email as complainant_email, c.address as complainant_address, ps.station_name as station_name FROM firs f LEFT JOIN complainants c ON f.complainant_id = c.id LEFT JOIN police_stations ps ON f.station_id = ps.id WHERE f.id = :id LIMIT 1');
$stmt->execute([':id' => $id]);
$fir = $stmt->fetch();
if (!$fir) { header('Location: /admin/index.php'); exit; }

// Load related
$criminals = $pdo->prepare('SELECT cr.* FROM criminals cr JOIN fir_criminals fc ON fc.criminal_id = cr.id WHERE fc.fir_id = :fid');
$criminals->execute([':fid' => $id]);
$criminals = $criminals->fetchAll();

$evidence = $pdo->prepare('SELECT * FROM evidence WHERE fir_id = :fid');
$evidence->execute([':fid' => $id]);
$evidence = $evidence->fetchAll();

$officers = $pdo->query('SELECT id, name FROM officers ORDER BY name ASC')->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>
<div class="card">
    <div class="card-section d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-0">Admin - FIR #<?php echo htmlspecialchars($fir['id']); ?></h1>
            <small class="muted"><?php echo htmlspecialchars($fir['title'] ?? ''); ?></small>
        </div>
        <div>
            <a class="btn btn-outline" href="/admin/index.php">Back to Dashboard</a>
        </div>
    </div>
    <div class="card-section">
        <h5>Complainant</h5>
        <p><strong><?php echo htmlspecialchars($fir['complainant_name'] ?? ''); ?></strong></p>
        <p class="muted"><strong>Contact:</strong> <?php echo htmlspecialchars($fir['complainant_contact'] ?? ''); ?></p>
        <h5 class="mt-3">Description</h5>
        <pre class="description"><?php echo htmlspecialchars($fir['description']); ?></pre>

    <hr/>
    <h5>Status</h5>
    <form method="POST" action="/admin/actions.php" class="row g-2 align-items-center">
        <input type="hidden" name="resource" value="fir">
        <input type="hidden" name="id" value="<?php echo $fir['id']; ?>">
        <div class="col-auto">
          <select class="form-select" name="status">
            <option value="Submitted" <?php echo ($fir['status'] === 'Submitted' ? 'selected' : ''); ?>>Submitted</option>
            <option value="Under Investigation" <?php echo ($fir['status'] === 'Under Investigation' ? 'selected' : ''); ?>>Under Investigation</option>
            <option value="Closed" <?php echo ($fir['status'] === 'Closed' ? 'selected' : ''); ?>>Closed</option>
          </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="submit" name="action" value="update">Update</button>
        </div>
    </form>

    <hr/>
    <h5>Assign Officer</h5>
    <form method="POST" action="/admin/actions.php" class="row g-2 align-items-center">
        <input type="hidden" name="resource" value="fir">
        <input type="hidden" name="id" value="<?php echo $fir['id']; ?>">
        <div class="col-9">
            <select class="form-select" name="officer_id">
            <option value="">-- Select --</option>
            <?php foreach ($officers as $o): ?>
                <option value="<?php echo $o['id']; ?>"><?php echo htmlspecialchars($o['name']); ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="col-3">
            <button class="btn btn-primary" type="submit" name="action" value="assign_officer">Assign</button>
        </div>
    </form>

    <hr/>
    <h5>Evidence</h5>
    <?php if (count($evidence) === 0): ?>
        <div class="muted">No evidence recorded.</div>
    <?php else: ?>
    <ul>
        <?php foreach ($evidence as $ev): ?>
            <li><?php echo htmlspecialchars($ev['description']) . ' (' . htmlspecialchars($ev['type'] ?? '') . ')'; ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form method="POST" action="/admin/actions.php" class="row g-2 align-items-center">
        <input type="hidden" name="resource" value="evidence">
        <input type="hidden" name="fir_id" value="<?php echo $fir['id']; ?>">
        <div class="col-md-3"><input class="form-control" type="text" name="type" placeholder="Type"></div>
        <div class="col-md-7"><input class="form-control" type="text" name="description" placeholder="Description"></div>
        <div class="col-md-2 d-grid"><button class="btn btn-outline" type="submit" name="action" value="create">Add</button></div>
    </form>

    <hr/>
    <h5>Accused / Criminals</h5>
    <?php if (count($criminals) === 0): ?>
        <div class="muted">No accused recorded.</div>
    <?php else: ?>
    <ul class="list-unstyled">
    <?php foreach ($criminals as $c): ?>
        <li><?php echo htmlspecialchars($c['name']); ?></li>
    <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form method="POST" action="/admin/actions.php" class="row g-2 align-items-center">
        <input type="hidden" name="resource" value="criminal">
        <input type="hidden" name="fir_id" value="<?php echo $fir['id']; ?>">
        <div class="col-md-9"><input class="form-control" type="text" name="name" placeholder="Name"></div>
        <div class="col-md-3 d-grid"><button class="btn btn-primary" type="submit" name="action" value="create">Add Criminal</button></div>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

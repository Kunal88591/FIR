<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/pagination.php';
$title = 'All FIRs';
$pdo = getPDO();
$q = trim($_GET['q'] ?? '');
$status = trim($_GET['status'] ?? '');
$station = trim($_GET['station'] ?? '');

$sql = "SELECT f.id, c.name AS complainant_name, f.title, f.crime_type, f.date_of_incident, f.incident_place, f.status, f.created_at, ps.station_name FROM firs f LEFT JOIN complainants c ON f.complainant_id = c.id LEFT JOIN police_stations ps ON f.station_id = ps.id";
$where = [];
$params = [];
if ($q !== '') {
    $where[] = '(c.name LIKE :q OR f.title LIKE :q OR f.description LIKE :q OR f.crime_type LIKE :q)';
    $params[':q'] = '%' . $q . '%';
}
if ($status !== '') {
    $where[] = 'f.status = :status';
    $params[':status'] = $status;
}
if ($station !== '') {
    $where[] = 'f.station_id = :station';
    $params[':station'] = $station;
}
if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

// Count total items for pagination
$countSql = "SELECT COUNT(*) FROM firs f LEFT JOIN complainants c ON f.complainant_id = c.id LEFT JOIN police_stations ps ON f.station_id = ps.id";
if (!empty($where)) {
    $countSql .= ' WHERE ' . implode(' AND ', $where);
}
$stmtCount = $pdo->prepare($countSql);
$stmtCount->execute($params);
$totalItems = $stmtCount->fetchColumn();

// Calculate pagination
$pagination = Pagination::calculate($totalItems, $_GET['page'] ?? 1, 20);

$sql .= ' ORDER BY f.created_at DESC LIMIT ' . $pagination['items_per_page'] . ' OFFSET ' . $pagination['offset'];
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$firs = $stmt->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>

<div class="card">
    <div class="card-section" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-0">📋 All FIRs</h1>
                <p class="muted" style="margin-top: 0.5rem; margin-bottom: 0;">Browse and filter filed reports</p>
            </div>
            <a href="/report.php" class="btn btn-primary">📝 Report New FIR</a>
        </div>
    </div>
    <div class="card-section">
        <form method="GET" class="row g-2 align-items-center mb-3">
            <div class="col-md-5"><input type="text" class="form-control" name="q" placeholder="Search by complainant, title, crime" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"></div>
            <div class="col-md-3"><select class="form-select" name="status">
                <option value="">All Statuses</option>
                <option value="Submitted" <?php echo (($_GET['status'] ?? '') === 'Submitted') ? 'selected' : ''; ?>>Submitted</option>
                <option value="Under Investigation" <?php echo (($_GET['status'] ?? '') === 'Under Investigation') ? 'selected' : ''; ?>>Under Investigation</option>
                <option value="Closed" <?php echo (($_GET['status'] ?? '') === 'Closed') ? 'selected' : ''; ?>>Closed</option>
</select></div>
            <div class="col-md-3">
              <select class="form-select" name="station">
                <option value="">All Stations</option>
                <?php $sts = $pdo->query('SELECT id, station_name FROM police_stations ORDER BY station_name ASC')->fetchAll(); foreach ($sts as $st): ?>
                    <option value="<?php echo $st['id']; ?>" <?php echo (($_GET['station'] ?? '') == $st['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($st['station_name']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-1 d-grid"><button class="btn btn-primary" type="submit">Filter</button></div>
        </form>
        <?php if (count($firs) == 0): ?>
            <div class="alert alert-secondary">No FIRs reported yet.</div>
        <?php else: ?>
            <div class="mb-3 text-muted">
                Showing <?php echo $pagination['offset'] + 1; ?>-<?php echo min($pagination['offset'] + $pagination['items_per_page'], $totalItems); ?> of <?php echo $totalItems; ?> FIRs
            </div>
            <div class="list-group">
            <?php foreach ($firs as $f): ?>
              <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="/view_fir.php?id=<?php echo $f['id']; ?>">
                <div>
                  <div class="fw-bold">#<?php echo htmlspecialchars($f['id']); ?> — <?php echo htmlspecialchars($f['title']); ?></div>
                  <div class="muted small"><?php echo htmlspecialchars($f['complainant_name']); ?> • <?php echo htmlspecialchars($f['incident_place']); ?> • <?php echo htmlspecialchars($f['date_of_incident']); ?></div>
                </div>
                <div class="text-end">
                  <div class="pill" data-status="<?php echo htmlspecialchars($f['status']); ?>"><?php echo htmlspecialchars($f['status']); ?></div>
                </div>
              </a>
            <?php endforeach; ?>
            </div>
            <div class="mt-3">
                <?php echo Pagination::render($pagination, '/list_firs.php', ['q' => $q, 'status' => $status, 'station' => $station]); ?>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
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
$crime_type = trim($_GET['crime_type'] ?? '');
if ($crime_type !== '') {
    $where[] = 'f.crime_type = :crime_type';
    $params[':crime_type'] = $crime_type;
}
$from_date = trim($_GET['from_date'] ?? '');
if ($from_date !== '') {
    $where[] = 'f.date_of_incident >= :from_date';
    $params[':from_date'] = $from_date;
}
$to_date = trim($_GET['to_date'] ?? '');
if ($to_date !== '') {
    $where[] = 'f.date_of_incident <= :to_date';
    $params[':to_date'] = $to_date;
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
            <div style="display: flex; gap: 0.5rem;">
                <button onclick="exportToCSV()" class="btn btn-outline" title="Export to CSV">📊 Export CSV</button>
                <a href="/report.php" class="btn btn-primary">📝 Report New FIR</a>
            </div>
        </div>
    </div>
    <div class="card-section">
        <form method="GET" id="filterForm" class="row g-2 align-items-end mb-3">
            <div class="col-md-3"><input type="text" class="form-control" name="q" placeholder="Search by complainant, title, crime" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"></div>
            <div class="col-md-2">
                <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Crime Type</label>
                <select class="form-select" name="crime_type">
                    <option value="">All Types</option>
                    <?php 
                    $crimeTypes = ['Theft', 'Assault', 'Robbery', 'Fraud', 'Kidnapping', 'Murder', 'Burglary', 'Cyber Crime', 'Drug Trafficking', 'Domestic Violence'];
                    foreach ($crimeTypes as $ct) {
                        $selected = (($_GET['crime_type'] ?? '') === $ct) ? 'selected' : '';
                        echo "<option value='$ct' $selected>$ct</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Status</label>
                <select class="form-select" name="status">
                    <option value="">All Statuses</option>
                    <option value="Submitted" <?php echo (($_GET['status'] ?? '') === 'Submitted') ? 'selected' : ''; ?>>Submitted</option>
                    <option value="Under Investigation" <?php echo (($_GET['status'] ?? '') === 'Under Investigation') ? 'selected' : ''; ?>>Under Investigation</option>
                    <option value="Closed" <?php echo (($_GET['status'] ?? '') === 'Closed') ? 'selected' : ''; ?>>Closed</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">From Date</label>
                <input type="date" class="form-control" name="from_date" value="<?php echo htmlspecialchars($_GET['from_date'] ?? ''); ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">To Date</label>
                <input type="date" class="form-control" name="to_date" value="<?php echo htmlspecialchars($_GET['to_date'] ?? ''); ?>">
            </div>
            <div class="col-md-1 d-grid"><button class="btn btn-primary" type="submit">Filter</button></div>
        </form>
        <script>
        function exportToCSV() {
            const form = document.getElementById('filterForm');
            const params = new URLSearchParams(new FormData(form)).toString();
            window.location.href = 'export_csv.php?' + params;
        }
        </script>
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
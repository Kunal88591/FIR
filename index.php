<?php
/* Landing page using shared header/footer */
$title = 'FIR System';
require_once __DIR__ . '/includes/db.php';
$pdo = getPDO();
$counts = [];
$counts['firs'] = $pdo->query('SELECT COUNT(*) FROM firs')->fetchColumn();
$counts['stations'] = $pdo->query('SELECT COUNT(*) FROM police_stations')->fetchColumn();
$counts['officers'] = $pdo->query('SELECT COUNT(*) FROM officers')->fetchColumn();
$counts['criminals'] = $pdo->query('SELECT COUNT(*) FROM criminals')->fetchColumn();
$counts['evidence'] = $pdo->query('SELECT COUNT(*) FROM evidence')->fetchColumn();
require_once __DIR__ . '/includes/header.php';
?>
<div class="hero card">
    <div class="card-section">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1 class="mb-1">FIR (First Information Report) System</h1>
                <p class="muted">Submit and manage FIRs. This is a lightweight demo application for reporting & tracking incidents.</p>
                <a class="btn btn-primary" href="/report.php">Report an FIR</a>
                <a class="btn btn-outline" href="/list_firs.php">View FIRs</a>
            </div>
            <div class="row mt-3">
                <div class="col-sm-6 col-md-3 mb-2"><div class="card card-compact p-2 text-center"><div class="fw-bold"><?php echo intval($counts['firs']); ?></div><small class="muted">Total FIRs</small></div></div>
                <div class="col-sm-6 col-md-3 mb-2"><div class="card card-compact p-2 text-center"><div class="fw-bold"><?php echo intval($counts['stations']); ?></div><small class="muted">Stations</small></div></div>
                <div class="col-sm-6 col-md-3 mb-2"><div class="card card-compact p-2 text-center"><div class="fw-bold"><?php echo intval($counts['officers']); ?></div><small class="muted">Officers</small></div></div>
                <div class="col-sm-6 col-md-3 mb-2"><div class="card card-compact p-2 text-center"><div class="fw-bold"><?php echo intval($counts['criminals']); ?></div><small class="muted">Suspects</small></div></div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
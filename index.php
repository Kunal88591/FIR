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
<div class="hero">
    <div class="d-flex justify-content-between align-items-start">
        <div style="flex: 1; position: relative; z-index: 1;">
            <h1 class="mb-1">FIR (First Information Report) System</h1>
            <p class="muted" style="font-size: 1.125rem; margin-bottom: 2rem;">Submit and manage FIRs. This is a lightweight demo application for reporting & tracking incidents.</p>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a class="btn btn-primary btn-lg"href="/report.php">📝 Report an FIR</a>
                <a class="btn btn-outline btn-lg" href="/list_firs.php">📋 View FIRs</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-3 mb-2">
        <div class="card-compact text-center" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%); border: 2px solid rgba(59, 130, 246, 0.2);">
            <div style="font-size: 2.5rem; font-weight: 800; color: #3b82f6; margin-bottom: 0.5rem;"><?php echo intval($counts['firs']); ?></div>
            <small class="muted" style="text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">Total FIRs</small>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 mb-2">
        <div class="card-compact text-center" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(167, 139, 250, 0.1) 100%); border: 2px solid rgba(139, 92, 246, 0.2);">
            <div style="font-size: 2.5rem; font-weight: 800; color: #8b5cf6; margin-bottom: 0.5rem;"><?php echo intval($counts['stations']); ?></div>
            <small class="muted" style="text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">Stations</small>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 mb-2">
        <div class="card-compact text-center" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(74, 222, 128, 0.1) 100%); border: 2px solid rgba(34, 197, 94, 0.2);">
            <div style="font-size: 2.5rem; font-weight: 800; color: #22c55e; margin-bottom: 0.5rem;"><?php echo intval($counts['officers']); ?></div>
            <small class="muted" style="text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">Officers</small>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 mb-2">
        <div class="card-compact text-center" style="background: linear-gradient(135deg, rgba(249, 115, 22, 0.1) 0%, rgba(251, 146, 60, 0.1) 100%); border: 2px solid rgba(249, 115, 22, 0.2);">
            <div style="font-size: 2.5rem; font-weight: 800; color: #f97316; margin-bottom: 0.5rem;"><?php echo intval($counts['criminals']); ?></div>
            <small class="muted" style="text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">Suspects</small>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
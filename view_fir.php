<?php
$requireAdmin = false;
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';
$requireAdmin = isAdminLoggedIn();

$title = 'FIR Details';
$pdo = getPDO();
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: /list_firs.php');
    exit;
}

$sql = "SELECT f.*, c.name as complainant_name, c.contact_num as complainant_contact, c.email as complainant_email, c.address as complainant_address, ps.station_name as station_name FROM firs f LEFT JOIN complainants c ON f.complainant_id = c.id LEFT JOIN police_stations ps ON f.station_id = ps.id WHERE f.id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$fir = $stmt->fetch();

if (!$fir) {
    header('Location: /list_firs.php');
    exit;
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="card">
    <div class="card-section d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-0">FIR #<?php echo htmlspecialchars($fir['id']); ?></h1>
            <small class="muted"><?php echo htmlspecialchars($fir['title'] ?? ''); ?></small>
        </div>
        <?php if (!empty($_GET['notice']) && $_GET['notice'] === 'created'): ?>
            <div class="alert alert-success" style="margin-bottom: 0; padding: 0.5rem 1rem;">✅ FIR Submitted Successfully</div>
        <?php endif; ?>
    </div>
    
    <div class="card-section">
        <div class="row">
            <div class="col-md-8">
                <h5>Incident Details</h5>
                <p class="muted"><strong>Station:</strong> <?php echo htmlspecialchars($fir['station_name'] ?? 'Not recorded'); ?></p>
                <p class="muted"><strong>Complainant:</strong> <?php echo htmlspecialchars($fir['complainant_name'] ?? 'Anonymous'); ?></p>
                
                <h5 class="mt-3">Description</h5>
                <pre class="description" style="white-space: pre-wrap; background: #f8fafc; padding: 1rem; border-radius: 0.5rem;"><?php echo htmlspecialchars($fir['description']); ?></pre>
            </div>
            <div class="col-md-4">
                <div class="card card-compact mb-3">
                    <div><strong>Date of Incident:</strong></div>
                    <div class="muted"><?php echo htmlspecialchars($fir['date_of_incident'] ?? $fir['incident_date'] ?? 'N/A'); ?></div>
                </div>
                <div class="card card-compact mb-3">
                    <div><strong>Place:</strong></div>
                    <div class="muted"><?php echo htmlspecialchars($fir['incident_place'] ?? 'N/A'); ?></div>
                </div>
                <div class="card card-compact mb-3">
                    <div><strong>Status:</strong></div>
                    <div class="pill" data-status="<?php echo htmlspecialchars($fir['status']); ?>"><?php echo htmlspecialchars($fir['status']); ?></div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Accused / Suspects</h5>
                <?php
                $crStmt = $pdo->prepare('SELECT cr.* FROM criminals cr JOIN fir_criminals fc ON fc.criminal_id = cr.id WHERE fc.fir_id = :fid');
                $crStmt->execute([':fid' => $id]);
                $criminals = $crStmt->fetchAll();
                if (count($criminals) === 0) {
                    echo '<div class="muted">None declared.</div>';
                } else {
                    echo '<ul class="list-unstyled">';
                    foreach ($criminals as $c) {
                        echo '<li>• ' . htmlspecialchars($c['name']) . '</li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
            <div class="col-md-6">
                <h5>Evidence</h5>
                <?php
                $ev = $pdo->prepare('SELECT * FROM evidence WHERE fir_id = :fid');
                $ev->execute([':fid' => $id]);
                $evidence = $ev->fetchAll();
                if (count($evidence) === 0) {
                    echo '<div class="muted">No evidence recorded.</div>';
                } else {
                    echo '<ul>';
                    foreach ($evidence as $e) {
                        echo '<li>' . htmlspecialchars($e['description']);
                        if ($requireAdmin) {
                            echo ' <form style="display:inline" method="POST" action="/admin/actions.php">'
                                . '<input type="hidden" name="resource" value="evidence">'
                                . '<input type="hidden" name="id" value="' . $e['id'] . '">'
                                . '<button type="submit" name="action" value="delete" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete evidence?\');">Delete</button>'
                                . '</form>';
                        }
                        echo '</li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </div>

        <div class="mt-4">
            <h5>Assigned Officers</h5>
            <?php
            $oStmt = $pdo->prepare('SELECT o.* FROM officers o JOIN fir_officers fo ON fo.officer_id = o.id WHERE fo.fir_id = :fid');
            $oStmt->execute([':fid' => $id]);
            $officers = $oStmt->fetchAll();
            if (count($officers) === 0) {
                echo '<div class="muted">No officers assigned.</div>';
            } else {
                echo '<ul class="list-unstyled">';
                foreach ($officers as $o) {
                    echo '<li>👮 ' . htmlspecialchars($o['name'] . ' (' . ($o['rank'] ?? '') . ')');
                    if ($requireAdmin) {
                        echo ' <form style="display:inline" method="POST" action="/admin/actions.php">'
                            . '<input type="hidden" name="resource" value="fir">'
                            . '<input type="hidden" name="id" value="' . $id . '">'
                            . '<input type="hidden" name="officer_id" value="' . $o['id'] . '">'
                            . '<button type="submit" name="action" value="unassign_officer" class="btn btn-sm btn-danger">Remove</button>'
                            . '</form>';
                    }
                    echo '</li>';
                }
                echo '</ul>';
            }
            ?>
        </div>

        <?php if ($requireAdmin): ?>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h5>Assign Officer</h5>
                    <form method="POST" action="/admin/actions.php" class="d-flex gap-2">
                        <input type="hidden" name="resource" value="fir">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <select name="officer_id" class="form-select">
                            <option value="">-- Select officer --</option>
                            <?php
                            $allOff = $pdo->query('SELECT id, name FROM officers ORDER BY name ASC')->fetchAll();
                            foreach ($allOff as $ao) {
                                echo '<option value="' . $ao['id'] . '">' . htmlspecialchars($ao['name']) . '</option>';
                            }
                            ?>
                        </select>
                        <button type="submit" name="action" value="assign_officer" class="btn btn-primary">Assign</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h5>Add Evidence</h5>
                    <form method="POST" action="/admin/actions.php" class="d-flex gap-2">
                        <input type="hidden" name="resource" value="fir">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="text" name="description" class="form-control" placeholder="Description" required>
                        <button type="submit" name="action" value="add_evidence" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
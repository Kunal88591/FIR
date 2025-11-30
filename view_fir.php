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

$compCols = $pdo->query("PRAGMA table_info('complainants')")->fetchAll(PDO::FETCH_ASSOC);
$compNames = array_map(fn($c) => $c['name'], $compCols);
$contactField = in_array('contact_num', $compNames) ? 'c.contact_num' : (in_array('contact', $compNames) ? 'c.contact' : 'NULL');
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
            <div class="card-section"><div class="alert alert-success">Your FIR was submitted successfully. Thank you.</div></div>
        <?php endif; ?>
        <div class="text-end">
            <a class="btn btn-outline" href="/list_firs.php">Back</a>
            <?php if ($requireAdmin): ?>
                <a class="btn btn-primary" href="/admin/edit_fir.php?id=<?php echo $fir['id']; ?>">Edit</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-section row">
        <div class="col-md-8">
            <h5>Complainant</h5>
            <p><strong><?php echo htmlspecialchars($fir['complainant_name'] ?? ''); ?></strong></p>
            <p class="muted"><strong>Contact:</strong> <?php echo htmlspecialchars($fir['complainant_contact'] ?? ''); ?></p>
            <p class="muted"><strong>Station:</strong> <?php echo htmlspecialchars($fir['station_name'] ?? 'Not recorded'); ?></p>
            <h5 class="mt-3">Description</h5>
            <pre class="description"><?php echo htmlspecialchars($fir['description']); ?></pre>
        </div>
        <div class="col-md-4">
            <div class="card card-compact mb-3">
                <div><strong>Date of Incident:</strong></div>
                <div class="muted"><?php echo htmlspecialchars($fir['date_of_incident'] ?? $fir['incident_date'] ?? ''); ?></div>
            </div>
            <div class="card card-compact mb-3">
                <div><strong>Place:</strong></div>
                <div class="muted"><?php echo htmlspecialchars($fir['incident_place'] ?? ''); ?></div>
            </div>
            <div class="card card-compact mb-3">
                <div><strong>Status:</strong></div>
                <div class="pill" data-status="<?php echo htmlspecialchars($fir['status']); ?>"><?php echo htmlspecialchars($fir['status']); ?></div>
            </div>
        </div>
    </div>

    <div class="card-section">
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
                echo '<li>' . htmlspecialchars($c['name']) . '</li>';
            }
            echo '</ul>';
        }
      ?>

      <h5 class="mt-3">Evidence</h5>
        <?php
            $ev = $pdo->prepare('SELECT * FROM evidence WHERE fir_id = :fid');
            $ev->execute([':fid' => $id]);
            $evidence = $ev->fetchAll();
            if (count($evidence) === 0) {
                echo '<div class="muted">No evidence recorded.</div>';
            } else {
                echo '<ul>';
                foreach ($evidence as $e) {
                    echo '<li>' . htmlspecialchars($e['description']) . ' <small>(' . htmlspecialchars($e['type'] ?? '') . ')</small>';
                    if ($requireAdmin) {
                        echo ' <form style="display:inline" method="POST" action="/admin/actions.php">'
                            . '<input type="hidden" name="resource" value="evidence">'
                            . '<input type="hidden" name="id" value="' . $e['id'] . '">'
                            . '<button type="submit" name="action" value="delete" onclick="return confirm(\'Delete evidence?\');">Delete</button>'
                            . '</form>';
                    }
                    echo '</li>';
                }
                echo '</ul>';
            }
        ?>

            <h5 class="mt-3">Assigned Officers</h5>
        <?php
            $oStmt = $pdo->prepare('SELECT o.* FROM officers o JOIN fir_officers fo ON fo.officer_id = o.id WHERE fo.fir_id = :fid');
            $oStmt->execute([':fid' => $id]);
            $officers = $oStmt->fetchAll();
            if (count($officers) === 0) {
                echo '<div class="muted">No officers assigned.</div>';
            } else {
                echo '<ul class="list-unstyled">';
                        foreach ($officers as $o) {
                            echo '<li>' . htmlspecialchars($o['name'] . ' (' . ($o['rank'] ?? '') . ')');
                            if ($requireAdmin) {
                                echo ' <form style="display:inline" method="POST" action="/admin/actions.php">'
                                    . '<input type="hidden" name="resource" value="fir">'
                                    . '<input type="hidden" name="id" value="' . $id . '">'
                                    . '<input type="hidden" name="officer_id" value="' . $o['id'] . '">'
                                    . '<button type="submit" name="action" value="unassign_officer">Remove</button>'
                                    . '</form>';
                            }
                            echo '</li>';
                        }
                echo '</ul>';
            }
        ?>

        <?php if ($requireAdmin): ?>
            <h4>Assign an officer</h4>
            <form method="POST" action="/admin/actions.php" style="margin-bottom: 1rem;">
                <input type="hidden" name="resource" value="fir">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <select name="officer_id">
                    <option value="">-- Select officer --</option>
                    <?php
                        $allOff = $pdo->query('SELECT id, name FROM officers ORDER BY name ASC')->fetchAll();
                        foreach ($allOff as $ao) {
                            echo '<option value="' . $ao['id'] . '">' . htmlspecialchars($ao['name']) . '</option>';
                        }
                    ?>
                </select>
                <button type="submit" name="action" value="assign_officer">Assign</button>
            </form>

            <h4>Add Evidence</h4>
            <form method="POST" action="/admin/actions.php">
                <input type="hidden" name="resource" value="fir">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label>Type</label>
                <input type="text" name="type">
                <label>Description</label>
                <input type="text" name="description" required>
                <label>Collected On</label>
                <input type="date" name="collected_on">
                <button type="submit" name="action" value="add_evidence">Add Evidence</button>
            </form>
        <?php endif; ?>

        </div>
        <?php if ($requireAdmin): ?>
            <div class="card-section">
                <h5>Admin Actions</h5>
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST" action="/admin/actions.php" class="mb-2">
                            <input type="hidden" name="resource" value="fir">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="mb-2"><label>Assign Officer</label>
                                <select class="form-select" name="officer_id">
                                        <option value="">-- Select officer --</option>
                                        <?php $allOff = $pdo->query('SELECT id, name FROM officers ORDER BY name ASC')->fetchAll(); foreach ($allOff as $ao): ?>
                                                <option value="<?php echo $ao['id']; ?>"><?php echo htmlspecialchars($ao['name']); ?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit" name="action" value="assign_officer">Assign</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="POST" action="/admin/actions.php">
                            <input type="hidden" name="resource" value="fir">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="mb-2"><label>Evidence Type</label><input class="form-control" type="text" name="type"></div>
                            <div class="mb-2"><label>Description</label><input class="form-control" type="text" name="description" required></div>
                            <div class="mb-2"><label>Collected On</label><input class="form-control" type="date" name="collected_on"></div>
                            <button class="btn btn-outline" type="submit" name="action" value="add_evidence">Add Evidence</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
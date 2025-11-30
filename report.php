<?php
require_once __DIR__ . '/includes/db.php';
$title = 'Report an FIR';
$pdo = getPDO();
$stationsStmt = $pdo->query('SELECT id, station_name FROM police_stations ORDER BY station_name ASC');
$stations = $stationsStmt->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>

<div class="card">
    <div class="card-section">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-0">Report an FIR</h1>
            <a href="/list_firs.php" class="btn btn-outline">View FIRs</a>
        </div>
    </div>
    <div class="card-section">
        <?php if (!empty($_GET['error'])): ?>
                <div class="error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <form id="firForm" action="/submit_fir.php" method="POST">
            <div class="row">
                <div class="col-md-7">
                    <h5>Complainant Details</h5>
                    <div class="mb-2"><label>Complainant Name</label><input class="form-control" type="text" name="complainant_name" required></div>
                    <div class="mb-2"><label>Contact (Phone)</label><input class="form-control" type="text" name="complainant_contact"></div>
                    <div class="mb-2"><label>Email</label><input class="form-control" type="text" name="complainant_email"></div>
                    <div class="mb-2"><label>Address</label><input class="form-control" type="text" name="complainant_address"></div>

                    <h5 class="mt-3">FIR Details</h5>
                    <div class="mb-2"><label>Title (Short)</label><input class="form-control" type="text" name="title" placeholder="Short summary" required></div>
                    <div class="mb-2"><label>Crime Type</label><input class="form-control" type="text" name="crime_type"></div>
                    <div class="mb-2"><label>Date of Incident</label><input class="form-control" type="date" name="incident_date"></div>
                    <div class="mb-2"><label>Place of Incident</label><input class="form-control" type="text" name="incident_place"></div>
                    <div class="mb-2"><label>Description</label><textarea class="form-control" name="description" rows="6" required></textarea></div>

                    <div class="mb-2"><label>Accused Names (comma-separated)</label><input class="form-control" type="text" name="accused_names" placeholder="Name1, Name2"></div>
                    <div class="mb-2"><label>Evidence Descriptions (semicolon-separated)</label><input class="form-control" type="text" name="evidence_descriptions" placeholder="Phone call logs; CCTV clip"></div>
                </div>
                <div class="col-md-5">
                    <div class="card card-compact mb-3">
                        <h6 class="mb-2">Police Station</h6>
                        <select class="form-select" name="station_id">
                            <option value="">-- Select a station (optional) --</option>
                            <?php foreach ($stations as $s): ?>
                                    <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['station_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="muted">Select the station responsible for this FIR.</small>
                    </div>
                    <div class="card card-compact">
                        <h6>Submit</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit">Submit FIR</button>
                            <a href="/" class="btn btn-outline">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
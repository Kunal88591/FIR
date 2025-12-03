<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

if (!isset($_GET['id'])) {
    die('FIR ID required');
}

$pdo = getPDO();
$id = intval($_GET['id']);

$stmt = $pdo->prepare('
    SELECT f.*, c.name as complainant_name, c.contact_num, c.email, c.address as complainant_address,
           s.name as station_name, s.address as station_address
    FROM firs f
    LEFT JOIN complainants c ON f.complainant_id = c.id
    LEFT JOIN police_stations s ON f.station_id = s.id
    WHERE f.id = ?
');
$stmt->execute([$id]);
$fir = $stmt->fetch();

if (!$fir) {
    die('FIR not found');
}

// Get officers
$officers = $pdo->prepare('
    SELECT o.name, o.badge_number, o.rank
    FROM fir_officers fo
    JOIN officers o ON fo.officer_id = o.id
    WHERE fo.fir_id = ?
');
$officers->execute([$id]);
$officerList = $officers->fetchAll();

// Get criminals
$criminals = $pdo->prepare('
    SELECT c.name, c.alias, c.description
    FROM fir_criminals fc
    JOIN criminals c ON fc.criminal_id = c.id
    WHERE fc.fir_id = ?
');
$criminals->execute([$id]);
$criminalList = $criminals->fetchAll();

// Get evidence
$evidence = $pdo->prepare('SELECT * FROM evidence WHERE fir_id = ?');
$evidence->execute([$id]);
$evidenceList = $evidence->fetchAll();

// Set headers for PDF download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="FIR_' . $id . '.pdf"');

// Simple PDF generation using HTML to PDF approach
// For production, use a proper library like TCPDF or DomPDF
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>FIR #<?php echo $id; ?></title>
    <style>
        @page { margin: 2cm; }
        body { font-family: Arial, sans-serif; font-size: 12pt; line-height: 1.6; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 24pt; }
        .section { margin-bottom: 20px; }
        .section-title { font-weight: bold; font-size: 14pt; border-bottom: 2px solid #333; margin-bottom: 10px; padding-bottom: 5px; }
        .field { margin-bottom: 10px; }
        .field-label { font-weight: bold; display: inline-block; width: 200px; }
        .field-value { display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .footer { margin-top: 50px; text-align: center; font-size: 10pt; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FIRST INFORMATION REPORT (FIR)</h1>
        <p><strong>FIR No:</strong> <?php echo htmlspecialchars($id); ?></p>
        <p><strong>Generated:</strong> <?php echo date('d-M-Y H:i:s'); ?></p>
    </div>

    <div class="section">
        <div class="section-title">FIR Details</div>
        <div class="field">
            <span class="field-label">Title:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['title']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Crime Type:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['crime_type']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Status:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['status']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Date of Incident:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['date_of_incident']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Incident Place:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['incident_place']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Registered:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['created_at']); ?></span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Description</div>
        <p><?php echo nl2br(htmlspecialchars($fir['description'])); ?></p>
    </div>

    <div class="section">
        <div class="section-title">Complainant Information</div>
        <div class="field">
            <span class="field-label">Name:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['complainant_name']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Contact:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['contact_num']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Email:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['email']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Address:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['complainant_address']); ?></span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Police Station</div>
        <div class="field">
            <span class="field-label">Station Name:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['station_name']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Address:</span>
            <span class="field-value"><?php echo htmlspecialchars($fir['station_address']); ?></span>
        </div>
    </div>

    <?php if (count($officerList) > 0): ?>
    <div class="section">
        <div class="section-title">Assigned Officers</div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Badge Number</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($officerList as $officer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($officer['name']); ?></td>
                    <td><?php echo htmlspecialchars($officer['badge_number']); ?></td>
                    <td><?php echo htmlspecialchars($officer['rank']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <?php if (count($criminalList) > 0): ?>
    <div class="section">
        <div class="section-title">Linked Suspects/Criminals</div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Alias</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($criminalList as $criminal): ?>
                <tr>
                    <td><?php echo htmlspecialchars($criminal['name']); ?></td>
                    <td><?php echo htmlspecialchars($criminal['alias']); ?></td>
                    <td><?php echo htmlspecialchars($criminal['description']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <?php if (count($evidenceList) > 0): ?>
    <div class="section">
        <div class="section-title">Evidence</div>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>File Path</th>
                    <th>Added</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evidenceList as $ev): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ev['description']); ?></td>
                    <td><?php echo htmlspecialchars($ev['file_path']); ?></td>
                    <td><?php echo htmlspecialchars($ev['created_at']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="footer">
        <p>This is a computer-generated document from the FIR Management System.</p>
        <p>For official use only. Unauthorized access or distribution is prohibited.</p>
    </div>
</body>
</html>

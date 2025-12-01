<?php
require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /report.php');
    exit;
}

// Server-side validation and normalized inputs
$complainant_name = trim($_POST['complainant_name'] ?? '');
$contact = trim($_POST['complainant_contact'] ?? '');
$email = trim($_POST['complainant_email'] ?? '');
$address = trim($_POST['complainant_address'] ?? '');
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$incident_date = $_POST['incident_date'] ?? null;
$incident_place = trim($_POST['incident_place'] ?? '');
$station_type = null; // placeholder
$crime_type = trim($_POST['crime_type'] ?? '');
$accused_names = trim($_POST['accused_names'] ?? '');
$evidence_descriptions = trim($_POST['evidence_descriptions'] ?? '');

$errors = [];
if ($complainant_name === '') {
    $errors[] = 'Complainant name is required.';
}
if ($title === '') {
    $errors[] = 'Title is required.';
}
if ($description === '') {
    $errors[] = 'Description is required.';
}

if (!empty($errors)) {
    $q = urlencode(implode('; ', $errors));
    header('Location: /report.php?error=' . $q);
    exit;
}

$pdo = getPDO();
try {
    $pdo->beginTransaction();
    // Create complainant (simple approach)
    $complainant_id = null;
    if ($complainant_name !== '') {
        $stmt = $pdo->prepare('INSERT INTO complainants (name, contact_num, email, address) VALUES (:n, :c, :e, :a)');
        $stmt->execute([':n' => $complainant_name, ':c' => $contact, ':e' => $email, ':a' => $address]);
        $complainant_id = $pdo->lastInsertId();
    }

    // Insert new FIR
    $station_id = intval($_POST['station_id'] ?? 0) ?: null;
    $ins = $pdo->prepare('INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place) VALUES (:comp, :psid, :t, :ct, :d, :doi, :ip)');
    $ins->execute([
        ':comp' => $complainant_id,
        ':psid' => $station_id,
        ':t' => $title,
        ':ct' => $crime_type,
        ':d' => $description,
        ':doi' => $incident_date,
        ':ip' => $incident_place
    ]);
    $fir_id = $pdo->lastInsertId();

    // Insert criminals and link
    if ($accused_names !== '') {
        $accused = array_filter(array_map('trim', explode(',', $accused_names)));
        foreach ($accused as $name) {
            if ($name === '') continue;
            // Search for existing criminal by name
            $sel = $pdo->prepare('SELECT id FROM criminals WHERE name = :n LIMIT 1');
            $sel->execute([':n' => $name]);
            $row = $sel->fetch();
            if ($row) {
                $criminal_id = $row['id'];
            } else {
                $ci = $pdo->prepare('INSERT INTO criminals (name) VALUES (:n)');
                $ci->execute([':n' => $name]);
                $criminal_id = $pdo->lastInsertId();
            }
            // Link - FIXED FOR MYSQL
            $link = $pdo->prepare('INSERT IGNORE INTO fir_criminals (fir_id, criminal_id) VALUES (:f, :c)');
            $link->execute([':f' => $fir_id, ':c' => $criminal_id]);
        }
    }

    // Evidence
    if ($evidence_descriptions !== '') {
        $evs = array_filter(array_map('trim', explode(';', $evidence_descriptions)));
        foreach ($evs as $evDesc) {
            if ($evDesc === '') continue;
            $eci = $pdo->prepare('INSERT INTO evidence (fir_id, type, description, collected_on) VALUES (:fir, :type, :desc, :collected)');
            // we don't have a type or collected date from the user, leave type null and collected_on null
            $eci->execute([':fir' => $fir_id, ':type' => null, ':desc' => $evDesc, ':collected' => null]);
        }
    }

    $pdo->commit();
    header('Location: /view_fir.php?id=' . $fir_id . '&notice=created');
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    error_log('DB error: ' . $e->getMessage());
    $q = urlencode('Internal error. Please try again later.');
    header('Location: /report.php?error=' . $q);
    exit;
}
?>
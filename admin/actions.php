<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/index.php');
    exit;
}

$action = $_POST['action'] ?? '';
$id = intval($_POST['id'] ?? 0);
$resource = $_POST['resource'] ?? 'fir';
$pdo = getPDO();

// Manage resource-specific actions
if ($resource === 'fir') {
    if ($action === 'update' && $id > 0) {
        $status = $_POST['status'] ?? 'Submitted';
        $stmt = $pdo->prepare('UPDATE firs SET status = :s WHERE id = :id');
        $stmt->execute([':s' => $status, ':id' => $id]);
        header('Location: /admin/index.php');
        exit;
    }
    if ($action === 'assign_officer' && $id > 0) {
        $officer_id = intval($_POST['officer_id'] ?? 0);
        if ($officer_id > 0) {
            $stmt = $pdo->prepare('INSERT OR IGNORE INTO fir_officers (fir_id, officer_id) VALUES (:f, :o)');
            $stmt->execute([':f' => $id, ':o' => $officer_id]);
        }
        header('Location: /admin/index.php');
        exit;
    }
    if ($action === 'unassign_officer' && $id > 0) {
        $officer_id = intval($_POST['officer_id'] ?? 0);
        if ($officer_id > 0) {
            $stmt = $pdo->prepare('DELETE FROM fir_officers WHERE fir_id = :f AND officer_id = :o');
            $stmt->execute([':f' => $id, ':o' => $officer_id]);
        }
        header('Location: /view_fir.php?id=' . $id);
        exit;
    }
    if ($action === 'add_evidence' && $id > 0) {
        $type = trim($_POST['type'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $collected_on = trim($_POST['collected_on'] ?? '') ?: null;
        if ($desc !== '') {
            $stmt = $pdo->prepare('INSERT INTO evidence (fir_id, type, description, collected_on) VALUES (:f, :t, :d, :c)');
            $stmt->execute([':f' => $id, ':t' => $type, ':d' => $desc, ':c' => $collected_on]);
        }
        header('Location: /view_fir.php?id=' . $id);
        exit;
    }
    if ($action === 'delete' && $id > 0) {
        $stmt = $pdo->prepare('DELETE FROM firs WHERE id = :id');
        $stmt->execute([':id' => $id]);
        header('Location: /admin/index.php');
        exit;
    }
    if ($action === 'update_fir' && $id > 0) {
        $title = trim($_POST['title'] ?? '');
        $crime_type = trim($_POST['crime_type'] ?? '');
        $date_of_incident = trim($_POST['date_of_incident'] ?? '');
        $incident_place = trim($_POST['incident_place'] ?? '');
        $station_id = intval($_POST['station_id'] ?? 0) ?: null;
        $status = trim($_POST['status'] ?? 'Submitted');
        $description = trim($_POST['description'] ?? '');
        $stmt = $pdo->prepare('UPDATE firs SET title = :t, crime_type = :ct, date_of_incident = :doi, incident_place = :ip, station_id = :sid, status = :s, description = :d WHERE id = :id');
        $stmt->execute([':t' => $title, ':ct' => $crime_type, ':doi' => $date_of_incident, ':ip' => $incident_place, ':sid' => $station_id, ':s' => $status, ':d' => $description, ':id' => $id]);
        header('Location: /admin/index.php');
        exit;
    }
}

if ($resource === 'station') {
    if ($action === 'delete' && $id > 0) {
        $stmt = $pdo->prepare('DELETE FROM police_stations WHERE id = :id');
        $stmt->execute([':id' => $id]);
        header('Location: /admin/stations.php');
        exit;
    }
}

if ($resource === 'officer') {
    if ($action === 'delete' && $id > 0) {
        $stmt = $pdo->prepare('DELETE FROM officers WHERE id = :id');
        $stmt->execute([':id' => $id]);
        header('Location: /admin/officers.php');
        exit;
    }
}

if ($resource === 'criminal') {
    if ($action === 'delete' && $id > 0) {
        $stmt = $pdo->prepare('DELETE FROM criminals WHERE id = :id');
        $stmt->execute([':id' => $id]);
        header('Location: /admin/criminals.php');
        exit;
    }
}

if ($resource === 'evidence') {
    if ($action === 'delete' && $id > 0) {
        $stmt = $pdo->prepare('DELETE FROM evidence WHERE id = :id');
        $stmt->execute([':id' => $id]);
        header('Location: /admin/index.php');
        exit;
    }
}

// Create evidence or criminal if requested
if ($resource === 'evidence' && $action === 'create') {
    $fir_id = intval($_POST['fir_id'] ?? 0);
    $type = trim($_POST['type'] ?? null);
    $desc = trim($_POST['description'] ?? null);
    if ($fir_id > 0 && $desc !== null && $desc !== '') {
        $stmt = $pdo->prepare('INSERT INTO evidence (fir_id, type, description, collected_on) VALUES (:f, :t, :d, :c)');
        $stmt->execute([':f' => $fir_id, ':t' => $type, ':d' => $desc, ':c' => null]);
    }
    header('Location: /admin/view_fir.php?id=' . $fir_id);
    exit;
}

if ($resource === 'criminal' && $action === 'create') {
    $fir_id = intval($_POST['fir_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        // Create criminal if doesn't exist
        $sel = $pdo->prepare('SELECT id FROM criminals WHERE name = :n LIMIT 1');
        $sel->execute([':n' => $name]);
        $row = $sel->fetch();
        if ($row) {
            $criminal_id = $row['id'];
        } else {
            $ins = $pdo->prepare('INSERT INTO criminals (name) VALUES (:n)');
            $ins->execute([':n' => $name]);
            $criminal_id = $pdo->lastInsertId();
        }
        if ($fir_id > 0) {
            $link = $pdo->prepare('INSERT OR IGNORE INTO fir_criminals (fir_id, criminal_id) VALUES (:f, :c)');
            $link->execute([':f' => $fir_id, ':c' => $criminal_id]);
        }
    }
    header('Location: /admin/view_fir.php?id=' . $fir_id);
    exit;
}

// Default redirect
header('Location: /admin/index.php');
exit;
?>
<?php
require_once __DIR__ . '/includes/db.php';

$pdo = getPDO();

// Run SQL schema
$sql = file_get_contents(__DIR__ . '/sql/init.sql');
$pdo->exec($sql);

// Enable foreign keys enforcement
$pdo->exec('PRAGMA foreign_keys = ON');

// Migration: If the `firs` table exists but lacks the new columns, add them and migrate complainant_name into complainants.
$cols = $pdo->query("PRAGMA table_info('firs')")->fetchAll(PDO::FETCH_ASSOC);
$colNames = array_map(fn($c) => $c['name'], $cols);

if (!in_array('complainant_id', $colNames)) {
    // Add new columns
    try {
    $pdo->exec("ALTER TABLE firs ADD COLUMN complainant_id INTEGER;");
    // Add station_id column (use standard name)
    $pdo->exec("ALTER TABLE firs ADD COLUMN station_id INTEGER;");
        $pdo->exec("ALTER TABLE firs ADD COLUMN title TEXT;");
        $pdo->exec("ALTER TABLE firs ADD COLUMN date_of_incident TEXT;");
    } catch (Exception $e) {
        // ignore if column exists concurrently
    }

    // Ensure complainants table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS complainants (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        contact_num TEXT,
        email TEXT,
        address TEXT
    );");

    // Migrate existing complainant_name -> complainants
    // detect legacy 'contact' column and migrate accordingly
    $fCols = $pdo->query("PRAGMA table_info('firs')")->fetchAll(PDO::FETCH_ASSOC);
    $fColNames = array_map(fn($c) => $c['name'], $fCols);
    $contactField = in_array('contact', $fColNames) ? 'contact' : (in_array('contact_num', $fColNames) ? 'contact_num' : 'NULL');
    $stmt = $pdo->query("SELECT id, complainant_name, " . $contactField . " as contact FROM firs WHERE complainant_name IS NOT NULL AND complainant_name != ''");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $inserted = 0;
    foreach ($rows as $r) {
        $name = $r['complainant_name'];
        $contact = $r['contact'];
        // Create complainant record
        $ins = $pdo->prepare('INSERT INTO complainants (name, contact_num) VALUES (:n, :c)');
        $ins->execute([':n' => $name, ':c' => $contact]);
        $cid = $pdo->lastInsertId();
        // Update firs row
        $upd = $pdo->prepare('UPDATE firs SET complainant_id = :cid WHERE id = :id');
        $upd->execute([':cid' => $cid, ':id' => $r['id']]);
        $inserted++;
    }
    if ($inserted > 0) {
        echo "Migrated $inserted complainant(s) into `complainants` table.\n";
    }
}

// Ensure station_id column exists, adding it if missing
$cols = $pdo->query("PRAGMA table_info('firs')")->fetchAll(PDO::FETCH_ASSOC);
$colNames = array_map(fn($c) => $c['name'], $cols);
if (!in_array('station_id', $colNames)) {
    try {
        $pdo->exec("ALTER TABLE firs ADD COLUMN station_id INTEGER;");
    } catch (Exception $e) {
        // ignore if already added concurrently
    }
}

// Add crime_type column if missing
$cols = $pdo->query("PRAGMA table_info('firs')")->fetchAll(PDO::FETCH_ASSOC);
$colNames = array_map(fn($c) => $c['name'], $cols);
if (!in_array('crime_type', $colNames)) {
    try {
        $pdo->exec("ALTER TABLE firs ADD COLUMN crime_type TEXT;");
    } catch (Exception $e) {
        // ignore
    }
}

// Insert default admin (username: admin, password: admin123) if not exists
$username = getenv('FIR_ADMIN_USER') ?: 'admin';
$password = getenv('FIR_ADMIN_PASS') ?: 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('SELECT COUNT(*) FROM admins WHERE username = :u');
$stmt->execute([':u' => $username]);
$count = $stmt->fetchColumn();
if ($count == 0) {
    $ins = $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (:u, :p)');
    $ins->execute([':u' => $username, ':p' => $hash]);
    echo "Default admin '$username' created with password '$password'.\n";
} else {
    echo "Admin '$username' already exists.\n";
}

echo "Database initialized successfully.\n";
?>
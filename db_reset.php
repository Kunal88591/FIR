<?php
// Development helper: remove database file and reinitialize
require_once __DIR__ . '/includes/db.php';

$dbFile = __DIR__ . '/data/database.sqlite';
if (file_exists($dbFile)) {
    unlink($dbFile);
}
echo "Deleted DB file if existed.\n";
echo "Re-initializing database...\n";
passthru('php ' . __DIR__ . '/db_init.php');
echo "Done.\n";
?>

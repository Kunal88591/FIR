<?php
require_once __DIR__ . '/includes/db.php';

// CSV export is public - no authentication required for viewing FIR data
$pdo = getPDO();

// Get filters from query string
$where = ['1=1'];
$params = [];

if (!empty($_GET['q'])) {
    $where[] = '(c.name LIKE :q OR f.title LIKE :q OR f.description LIKE :q OR f.crime_type LIKE :q)';
    $params[':q'] = '%' . $_GET['q'] . '%';
}

if (!empty($_GET['crime_type'])) {
    $where[] = 'f.crime_type = :crime_type';
    $params[':crime_type'] = $_GET['crime_type'];
}

if (!empty($_GET['status'])) {
    $where[] = 'f.status = :status';
    $params[':status'] = $_GET['status'];
}

if (!empty($_GET['from_date'])) {
    $where[] = 'f.date_of_incident >= :from_date';
    $params[':from_date'] = $_GET['from_date'];
}

if (!empty($_GET['to_date'])) {
    $where[] = 'f.date_of_incident <= :to_date';
    $params[':to_date'] = $_GET['to_date'];
}

$sql = '
    SELECT f.id, f.title, f.crime_type, f.description, f.date_of_incident, 
           f.incident_place, f.status, f.created_at,
           c.name as complainant_name, c.contact_num, c.email,
           s.station_name
    FROM firs f
    LEFT JOIN complainants c ON f.complainant_id = c.id
    LEFT JOIN police_stations s ON f.station_id = s.id
    WHERE ' . implode(' AND ', $where) . '
    ORDER BY f.created_at DESC
';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$firs = $stmt->fetchAll();

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="firs_export_' . date('Y-m-d_H-i-s') . '.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Write UTF-8 BOM for Excel compatibility
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Write header row
fputcsv($output, [
    'FIR ID',
    'Title',
    'Crime Type',
    'Status',
    'Date of Incident',
    'Incident Place',
    'Description',
    'Complainant Name',
    'Contact Number',
    'Email',
    'Station Name',
    'Registered At'
]);

// Write data rows
foreach ($firs as $fir) {
    fputcsv($output, [
        $fir['id'],
        $fir['title'],
        $fir['crime_type'],
        $fir['status'],
        $fir['date_of_incident'],
        $fir['incident_place'],
        $fir['description'],
        $fir['complainant_name'],
        $fir['contact_num'],
        $fir['email'],
        $fir['station_name'],
        $fir['created_at']
    ]);
}

fclose($output);
exit;

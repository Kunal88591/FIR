<?php
// Shared page header and navigation
require_once __DIR__ . '/auth.php';
// Allow pages to set $title before including this file.
if (!isset($title)) $title = 'FIR System';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/print.css" media="print">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
        <a class="navbar-brand" href="/">FIR System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link <?php echo ($title === 'FIR System') ? 'active' : ''; ?>" href="/">Home</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($title === 'Report an FIR') ? 'active' : ''; ?>" href="/report.php">Report</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($title === 'All FIRs') ? 'active' : ''; ?>" href="/list_firs.php">FIRs</a></li>
          </ul>
          <form class="d-flex" role="search" method="GET" action="/list_firs.php">
              <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Search FIRs" aria-label="Search">
              <button class="btn btn-sm btn-outline-light" type="submit">Search</button>
          </form>
          <ul class="navbar-nav ms-auto">
            <?php if (function_exists('isAdminLoggedIn') && isAdminLoggedIn()): ?>
                <li class="nav-item"><a class="nav-link" href="/admin/index.php">Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/logout.php">Logout</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="/admin/login.php">Admin</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
    <main class="container py-4">

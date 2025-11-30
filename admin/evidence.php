<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';
$title = 'Admin - Evidence';
$pdo = getPDO();

$ev = $pdo->query('SELECT e.*, f.title as fir_title FROM evidence e LEFT JOIN firs f ON e.fir_id = f.id ORDER BY e.id DESC');
$evidence = $ev->fetchAll();
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<div class="card">
    <div class="card-section d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Evidence</h1>
        <div>
            <a class="btn btn-outline" href="/admin/index.php">Back</a>
            <a class="btn btn-outline" href="/admin/logout.php">Logout</a>
        </div>
    </div>
    <div class="card-section">

    <?php if (count($evidence) === 0): ?>
        <div class="alert alert-secondary">No evidence entries yet.</div>
    <?php else: ?>
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr><th>ID</th><th>FIR</th><th>Type</th><th>Description</th><th>Collected On</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($evidence as $e): ?>
                <tr>
                    <td><?php echo $e['id']; ?></td>
                    <td><?php echo htmlspecialchars($e['fir_title']); ?></td>
                    <td><?php echo htmlspecialchars($e['type']); ?></td>
                    <td><?php echo htmlspecialchars($e['description']); ?></td>
                    <td><?php echo htmlspecialchars($e['collected_on']); ?></td>
                    <td>
                        <form method="POST" action="/admin/actions.php" style="display:inline">
                            <input type="hidden" name="resource" value="evidence">
                            <input type="hidden" name="id" value="<?php echo $e['id']; ?>">
                            <button class="btn btn-sm btn-outline" type="submit" name="action" value="delete" onclick="return confirm('Delete this evidence record?');">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    <?php endif; ?>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</div>
</body>
</html>

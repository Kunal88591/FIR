<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';
$title = 'Admin Dashboard';

$pdo = getPDO();

// Get statistics
$stats = [];
$stats['total_firs'] = $pdo->query('SELECT COUNT(*) FROM firs')->fetchColumn();
$stats['submitted'] = $pdo->query('SELECT COUNT(*) FROM firs WHERE status = "Submitted"')->fetchColumn();
$stats['investigating'] = $pdo->query('SELECT COUNT(*) FROM firs WHERE status = "Under Investigation"')->fetchColumn();
$stats['closed'] = $pdo->query('SELECT COUNT(*) FROM firs WHERE status = "Closed"')->fetchColumn();
$stats['stations'] = $pdo->query('SELECT COUNT(*) FROM police_stations')->fetchColumn();
$stats['officers'] = $pdo->query('SELECT COUNT(*) FROM officers')->fetchColumn();
$stats['criminals'] = $pdo->query('SELECT COUNT(*) FROM criminals')->fetchColumn();
$stats['evidence'] = $pdo->query('SELECT COUNT(*) FROM evidence')->fetchColumn();

// Crime type distribution
$crimeTypes = $pdo->query('SELECT crime_type, COUNT(*) as count FROM firs GROUP BY crime_type ORDER BY count DESC')->fetchAll();

// Monthly trend (last 6 months)
$monthlyData = $pdo->query("
    SELECT strftime('%Y-%m', date_of_incident) as month, COUNT(*) as count 
    FROM firs 
    WHERE date_of_incident >= date('now', '-6 months')
    GROUP BY month 
    ORDER BY month ASC
")->fetchAll();

// Recent FIRs
$recentFirs = $pdo->query('
    SELECT f.id, f.title, f.status, f.created_at, c.name as complainant_name
    FROM firs f
    LEFT JOIN complainants c ON f.complainant_id = c.id
    ORDER BY f.created_at DESC
    LIMIT 10
')->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap');

.dashboard-wrapper {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 2rem;
}

.dashboard-header {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.dashboard-title {
    font-family: 'Poppins', sans-serif;
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
    letter-spacing: -0.02em;
}

.dashboard-subtitle {
    font-size: 1rem;
    color: #64748b;
    font-weight: 500;
    margin-top: 0.5rem;
}

.nav-pills {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: 1.5rem;
}

.nav-pill {
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 12px;
    color: #667eea;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-pill:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--stat-color-1), var(--stat-color-2));
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.stat-value {
    font-family: 'Poppins', sans-serif;
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.75rem;
    background: linear-gradient(135deg, var(--stat-color-1), var(--stat-color-2));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 0.95rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.stat-card.primary { --stat-color-1: #667eea; --stat-color-2: #764ba2; }
.stat-card.success { --stat-color-1: #10b981; --stat-color-2: #059669; }
.stat-card.warning { --stat-color-1: #f59e0b; --stat-color-2: #d97706; }
.stat-card.purple { --stat-color-1: #8b5cf6; --stat-color-2: #7c3aed; }

.charts-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.chart-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.chart-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.5rem;
}

.chart-container {
    height: 340px;
    position: relative;
}

@media (max-width: 768px) {
    .dashboard-wrapper { padding: 1rem; }
    .dashboard-title { font-size: 1.75rem; }
    .charts-section { grid-template-columns: 1fr; }
}
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-header">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 2rem;">
            <div>
                <h1 class="dashboard-title">Command Center</h1>
                <p class="dashboard-subtitle">Real-time incident monitoring and analytics</p>
            </div>
            <div class="nav-pills">
                <a href="/admin/stations.php" class="nav-pill">Stations</a>
                <a href="/admin/officers.php" class="nav-pill">Officers</a>
                <a href="/admin/criminals.php" class="nav-pill">Criminals</a>
                <a href="/admin/evidence.php" class="nav-pill">Evidence</a>
                <a href="/" class="nav-pill">Public Portal</a>
                <a href="/admin/logout.php" class="nav-pill" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%); border-color: rgba(239, 68, 68, 0.3); color: #ef4444;">Sign Out</a>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-value"><?php echo number_format($stats['total_firs']); ?></div>
            <div class="stat-label">Total Reports</div>
        </div>
        <div class="stat-card success">
            <div class="stat-value"><?php echo number_format($stats['investigating']); ?></div>
            <div class="stat-label">Active Cases</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-value"><?php echo number_format($stats['submitted']); ?></div>
            <div class="stat-label">Pending Review</div>
        </div>
        <div class="stat-card purple">
            <div class="stat-value"><?php echo number_format($stats['closed']); ?></div>
            <div class="stat-label">Resolved</div>
        </div>
    </div>

    <div class="charts-section">
        <div class="chart-card">
            <h3 class="chart-title">Status Overview</h3>
            <div class="chart-container">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <h3 class="chart-title">Crime Categories</h3>
            <div class="chart-container">
                <canvas id="crimeChart"></canvas>
            </div>
        </div>
    </div>

    <div class="chart-card" style="margin-bottom: 2rem;">
        <h3 class="chart-title">Activity Trend</h3>
        <div class="chart-container">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <div class="chart-card">
        <h3 class="chart-title">Recent Activity</h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Report ID</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Incident</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Complainant</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Date</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentFirs as $fir): ?>
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                            <td style="padding: 1rem; font-weight: 600; color: #667eea;">#<?php echo $fir['id']; ?></td>
                            <td style="padding: 1rem; color: #1e293b; font-weight: 500;"><?php echo htmlspecialchars(substr($fir['title'], 0, 50)); ?><?php echo strlen($fir['title']) > 50 ? '...' : ''; ?></td>
                            <td style="padding: 1rem; color: #64748b;"><?php echo htmlspecialchars($fir['complainant_name']); ?></td>
                            <td style="padding: 1rem;">
                                <span style="padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; 
                                    <?php 
                                    if ($fir['status'] == 'Closed') echo 'background: #dcfce7; color: #166534;';
                                    elseif ($fir['status'] == 'Under Investigation') echo 'background: #dbeafe; color: #1e40af;';
                                    else echo 'background: #fef3c7; color: #92400e;';
                                    ?>">
                                    <?php echo $fir['status']; ?>
                                </span>
                            </td>
                            <td style="padding: 1rem; color: #64748b; font-size: 0.9rem;"><?php echo date('M d, Y', strtotime($fir['created_at'])); ?></td>
                            <td style="padding: 1rem;">
                                <a href="/view_fir.php?id=<?php echo $fir['id']; ?>" style="padding: 0.5rem 1.25rem; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: inline-block; transition: all 0.3s;">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
window.addEventListener('load', function() {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js not loaded');
        return;
    }

    Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, sans-serif";
    Chart.defaults.font.size = 13;
    Chart.defaults.color = '#64748b';

    // Status Distribution Doughnut Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending Review', 'Active Cases', 'Resolved'],
            datasets: [{
                data: [<?php echo $stats['submitted']; ?>, <?php echo $stats['investigating']; ?>, <?php echo $stats['closed']; ?>],
                backgroundColor: [
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(139, 92, 246, 0.8)'
                ],
                borderColor: '#fff',
                borderWidth: 4,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: { size: 13, weight: '600' },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Crime Type Bar Chart
    new Chart(document.getElementById('crimeChart'), {
        type: 'bar',
        data: {
            labels: [<?php echo implode(',', array_map(function($ct) { return '"' . addslashes($ct['crime_type']) . '"'; }, array_slice($crimeTypes, 0, 8))); ?>],
            datasets: [{
                label: 'Cases',
                data: [<?php echo implode(',', array_map(function($ct) { return $ct['count']; }, array_slice($crimeTypes, 0, 8))); ?>],
                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { font: { size: 12 } }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 11 },
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });

    // Monthly Trend Line Chart
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: [<?php echo implode(',', array_map(function($m) { return '"' . ($m['month'] ?? 'N/A') . '"'; }, $monthlyData)); ?>],
            datasets: [{
                label: 'Reports Filed',
                data: [<?php echo implode(',', array_map(function($m) { return $m['count']; }, $monthlyData)); ?>],
                borderColor: 'rgba(102, 126, 234, 1)',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { font: { size: 12 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                }
            }
        }
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

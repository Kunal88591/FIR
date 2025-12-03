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

// Station-wise distribution
$stationStats = $pdo->query('
    SELECT ps.station_name, COUNT(f.id) as fir_count
    FROM police_stations ps
    LEFT JOIN firs f ON ps.id = f.station_id
    GROUP BY ps.id
    ORDER BY fir_count DESC
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
</script>ew Chart(crimeCtx, {
            type: 'bar',
            data: {
                labels: [<?php echo implode(',', array_map(function($ct) { return '"' . addslashes($ct['crime_type']) . '"'; }, array_slice($crimeTypes, 0, 10))); ?>],
                datasets: [{
                    label: 'Number of FIRs',
                    data: [<?php echo implode(',', array_map(function($ct) { return $ct['count']; }, array_slice($crimeTypes, 0, 10))); ?>],
                    backgroundColor: [
                        '#3b82f6', '#8b5cf6', '#22c55e', '#f97316', '#ec4899',
                        '#06b6d4', '#f59e0b', '#10b981', '#6366f1', '#ef4444'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'FIRs: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: {
                            font: { size: 12 }
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 11 },
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
        console.log('✓ Crime type chart created');
    }

    // Monthly Trend Line Chart
    const trendCanvas = document.getElementById('trendChart');
    if (trendCanvas) {
        console.log('Creating monthly trend chart...');
        const trendCtx = trendCanvas.getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: [<?php echo implode(',', array_map(function($m) { return '"' . ($m['month'] ?? 'N/A') . '"'; }, $monthlyData)); ?>],
                datasets: [{
                    label: 'FIRs Registered',
                    data: [<?php echo implode(',', array_map(function($m) { return $m['count']; }, $monthlyData)); ?>],
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.2)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#8b5cf6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        display: true,
                        labels: {
                            font: { size: 13 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'FIRs: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: {
                            font: { size: 12 }
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 12 }
                        }
                    }
                }
            }
        });
        console.log('✓ Monthly trend chart created');
    }
    
    console.log('✅ All charts initialized successfully!');
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<?php
/* Landing page using shared header/footer */
$title = 'FIR System';
require_once __DIR__ . '/includes/db.php';
$pdo = getPDO();
$counts = [];
$counts['firs'] = $pdo->query('SELECT COUNT(*) FROM firs')->fetchColumn();
$counts['stations'] = $pdo->query('SELECT COUNT(*) FROM police_stations')->fetchColumn();
$counts['officers'] = $pdo->query('SELECT COUNT(*) FROM officers')->fetchColumn();
$counts['criminals'] = $pdo->query('SELECT COUNT(*) FROM criminals')->fetchColumn();
$counts['evidence'] = $pdo->query('SELECT COUNT(*) FROM evidence')->fetchColumn();
require_once __DIR__ . '/includes/header.php';
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Poppins:wght@600;700;800;900&display=swap');

.homepage-wrapper {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 50%, #4c1d95 100%);
    min-height: 100vh;
    position: relative;
    overflow: hidden;
}

.homepage-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="60" height="60" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="60" fill="none"/><circle cx="30" cy="30" r="1.5" fill="rgba(255,255,255,0.1)"/></svg>');
    opacity: 0.4;
}

.hero-section {
    position: relative;
    z-index: 1;
    padding: 6rem 0;
    text-align: center;
}

.hero-badge {
    display: inline-block;
    padding: 0.5rem 1.5rem;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    color: white;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.hero-title {
    font-family: 'Poppins', sans-serif;
    font-size: 4rem;
    font-weight: 900;
    color: white;
    margin-bottom: 1.5rem;
    line-height: 1.1;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.hero-subtitle {
    font-size: 1.35rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 3rem;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.cta-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 5rem;
}

.cta-button {
    padding: 1.25rem 3rem;
    font-size: 1.1rem;
    font-weight: 700;
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.cta-primary {
    background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
    color: white;
    border: none;
}

.cta-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(245, 158, 11, 0.4);
    color: white;
}

.cta-secondary {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.cta-secondary:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-3px);
    color: white;
}

.stats-container {
    position: relative;
    z-index: 1;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem 4rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 2.5rem;
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
    height: 5px;
    background: var(--gradient);
}

.stat-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
}

.stat-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 1.5rem;
    background: var(--gradient);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.stat-number {
    font-family: 'Poppins', sans-serif;
    font-size: 3.5rem;
    font-weight: 900;
    line-height: 1;
    margin-bottom: 0.75rem;
    background: var(--gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 1rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.features-section {
    background: white;
    padding: 5rem 0;
    position: relative;
    z-index: 1;
}

.features-title {
    font-family: 'Poppins', sans-serif;
    font-size: 2.5rem;
    font-weight: 800;
    text-align: center;
    margin-bottom: 3rem;
    color: #1e293b;
}

.features-grid {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.feature-card {
    padding: 2rem;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(168, 85, 247, 0.05) 100%);
    border: 2px solid rgba(99, 102, 241, 0.1);
    transition: all 0.3s;
}

.feature-card:hover {
    transform: translateY(-5px);
    border-color: rgba(99, 102, 241, 0.3);
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.15);
}

.feature-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.feature-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.feature-description {
    color: #64748b;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .hero-title { font-size: 2.5rem; }
    .hero-subtitle { font-size: 1.1rem; }
    .cta-buttons { flex-direction: column; align-items: stretch; }
    .cta-button { justify-content: center; }
}
</style>

<div class="homepage-wrapper">
    <div class="hero-section">
        <div class="container">
            <div class="hero-badge">🚓 Law Enforcement Technology</div>
            <h1 class="hero-title">Incident Reporting<br>Made Simple</h1>
            <p class="hero-subtitle">Modern, secure, and efficient First Information Report management system designed for law enforcement agencies to streamline case handling and investigation workflows.</p>
            
            <div class="cta-buttons">
                <a href="/report.php" class="cta-button cta-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    File New Report
                </a>
                <a href="/list_firs.php" class="cta-button cta-secondary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                    Browse Cases
                </a>
            </div>
        </div>
    </div>

    <div class="stats-container">
        <div class="stats-grid">
            <div class="stat-card" style="--gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <div class="stat-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div class="stat-number"><?php echo number_format($counts['firs']); ?></div>
                <div class="stat-label">Total Reports</div>
            </div>

            <div class="stat-card" style="--gradient: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <div class="stat-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <div class="stat-number"><?php echo number_format($counts['stations']); ?></div>
                <div class="stat-label">Police Stations</div>
            </div>

            <div class="stat-card" style="--gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="stat-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="stat-number"><?php echo number_format($counts['officers']); ?></div>
                <div class="stat-label">Active Officers</div>
            </div>

            <div class="stat-card" style="--gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="stat-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 8v4l3 3"/>
                    </svg>
                </div>
                <div class="stat-number"><?php echo number_format($counts['criminals']); ?></div>
                <div class="stat-label">Recorded Suspects</div>
            </div>
        </div>
    </div>
</div>

<div class="features-section">
    <h2 class="features-title">Why Choose Our Platform</h2>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🔒</div>
            <h3 class="feature-title">Enterprise Security</h3>
            <p class="feature-description">Military-grade encryption, CSRF protection, and secure session management ensure your data stays protected.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">⚡</div>
            <h3 class="feature-title">Lightning Fast</h3>
            <p class="feature-description">Optimized SQLite database and efficient caching deliver instant response times for all operations.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3 class="feature-title">Real-time Analytics</h3>
            <p class="feature-description">Visual dashboards with live charts and statistics help track crime patterns and case progress.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📱</div>
            <h3 class="feature-title">Mobile Friendly</h3>
            <p class="feature-description">Responsive design works seamlessly across all devices - desktop, tablet, and smartphone.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔍</div>
            <h3 class="feature-title">Advanced Search</h3>
            <p class="feature-description">Powerful filtering and search capabilities make finding specific cases quick and effortless.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📄</div>
            <h3 class="feature-title">Export Reports</h3>
            <p class="feature-description">Generate PDF and CSV exports for offline analysis, reporting, and record-keeping.</p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
// FIR System - Enhanced JavaScript

// ============================================
// Toast Notifications (Feature 5)
// ============================================
let notyf;
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Notyf
    notyf = new Notyf({
        duration: 4000,
        position: { x: 'right', y: 'top' },
        types: [
            {
                type: 'success',
                background: '#22c55e',
                icon: { className: 'notyf__icon--success', tagName: 'i' }
            },
            {
                type: 'error',
                background: '#ef4444',
                icon: { className: 'notyf__icon--error', tagName: 'i' }
            }
        ]
    });

    // Replace alert messages with toasts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const text = alert.textContent.trim();
        if (alert.classList.contains('alert-success')) {
            notyf.success(text);
            alert.style.display = 'none';
        } else if (alert.classList.contains('alert-danger') || alert.classList.contains('error')) {
            notyf.error(text);
            alert.style.display = 'none';
        }
    });

    // Initialize all features
    initDarkMode();
    initFileUpload();
    initKeyboardShortcuts();
    initBackToTop();
    initLoadingStates();
    initImagePreview();
    
    // Original FIR form validation
    const form = document.getElementById('firForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            const name = form['complainant_name'] ? form['complainant_name'].value.trim() : '';
            const desc = form['description'] ? form['description'].value.trim() : '';
            if (!name || !desc) {
                e.preventDefault();
                notyf.error('Please fill in required fields!');
                return false;
            }
        });
    }

    // Handle forms marked with 'needs-confirm'
    document.querySelectorAll('form[data-confirm]').forEach((frm) => {
        frm.addEventListener('submit', (e) => {
            const message = frm.dataset.confirm || 'Are you sure?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
});

// ============================================
// Dark Mode Toggle (Feature 5)
// ============================================
function initDarkMode() {
    const darkMode = localStorage.getItem('darkMode') === 'true';
    if (darkMode) {
        document.body.classList.add('dark-mode');
    }

    const nav = document.querySelector('.navbar .container');
    if (nav) {
        const toggle = document.createElement('button');
        toggle.innerHTML = darkMode ? '☀️' : '🌙';
        toggle.className = 'btn btn-sm btn-outline-light ms-2';
        toggle.title = 'Toggle Dark Mode (Ctrl+D)';
        toggle.style.cssText = 'font-size: 1.2rem; padding: 0.25rem 0.75rem;';
        toggle.onclick = toggleDarkMode;
        nav.appendChild(toggle);
    }
}

function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const isDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDark);
    event.target.innerHTML = isDark ? '☀️' : '🌙';
    if (notyf) notyf.success(isDark ? 'Dark mode enabled' : 'Light mode enabled');
}

// ============================================
// File Upload Enhancement (Feature 3)
// ============================================
function initFileUpload() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files.length > 0) {
                let fileInfo = `${files.length} file(s) selected`;
                let allValid = true;
                
                Array.from(files).forEach((file) => {
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
                    if (!allowedTypes.includes(file.type)) {
                        if (notyf) notyf.error(`Invalid file type: ${file.name}`);
                        allValid = false;
                    }
                    
                    if (file.size > 5242880) {
                        if (notyf) notyf.error(`File too large: ${file.name} (max 5MB)`);
                        allValid = false;
                    }
                });
                
                if (!allValid) {
                    input.value = '';
                    return;
                }
                
                const parent = input.parentElement;
                const info = document.createElement('small');
                info.className = 'text-muted mt-1 d-block';
                info.textContent = fileInfo;
                const existing = parent.querySelector('small.text-muted');
                if (existing) existing.remove();
                parent.appendChild(info);
            }
        });
    });
}

// ============================================
// Image Preview (Feature 3)
// ============================================
function initImagePreview() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let preview = input.parentElement.querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.className = 'image-preview mt-2';
                        input.parentElement.appendChild(preview);
                    }
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #e5e7eb;">`;
                };
                reader.readAsDataURL(file);
            }
        });
    });
}

// ============================================
// Keyboard Shortcuts (Feature 5)
// ============================================
function initKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('input[name="q"]');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }

        if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
            e.preventDefault();
            toggleDarkMode();
        }

        if (e.key === 'Escape') {
            const searchInput = document.querySelector('input[name="q"]');
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                searchInput.blur();
            }
        }
    });
}

// ============================================
// Back to Top Button (Feature 5)
// ============================================
function initBackToTop() {
    const btn = document.createElement('button');
    btn.innerHTML = '↑';
    btn.className = 'back-to-top';
    btn.title = 'Back to top';
    btn.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });
    document.body.appendChild(btn);

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            btn.classList.add('show');
        } else {
            btn.classList.remove('show');
        }
    });
}

// ============================================
// Loading States (Feature 5)
// ============================================
function initLoadingStates() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.classList.contains('no-loading')) {
                submitBtn.disabled = true;
                submitBtn.dataset.originalText = submitBtn.textContent;
                submitBtn.innerHTML = '<span class="spinner"></span> Processing...';
                
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = submitBtn.dataset.originalText;
                }, 5000);
            }
        });
    });
}

console.log('FIR System Enhanced JS Loaded ✓');

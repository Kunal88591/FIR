// Simple client-side validation and helper functions
window.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('firForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            const name = form['complainant_name'].value.trim();
            const desc = form['description'].value.trim();
            if (!name || !desc) {
                e.preventDefault();
                alert('Please fill in required fields: Complainant name and description.');
                return false;
            }
            // Confirm dialog removed for smoother experience
            // if (!confirm('Submit FIR? Please ensure details are correct.')) {
            //    e.preventDefault();
            //    return false;
            // }
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

    // Auto dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert, .error').forEach((el) => {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 600);
        });
    }, 5000);
});

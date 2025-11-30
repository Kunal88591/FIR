# FIR (First Information Report) - PHP / HTML / CSS / JS + SQLite

This repository contains a minimal FIR (First Information Report) system implemented using PHP, HTML, CSS, JS and an SQLite database.

Features:
- Submit FIRs via a web form (complainant details, title, description, accused(s), evidence)
- View a list of FIRs with search & filters (by status, station, query)
- View FIR details with connected data (complainant, assigned officers, evidence)
- Admin area: change status, assign/unassign officers, add/delete evidence, manage stations/officers/criminals
- Admin: edit FIR details (title, crime type, date/place, station, status)

This is intended as a starter project and demo. For production use, add proper authentication, CSRF protection, input sanitization, and HTTPS.

## Quick setup (local)

1. Ensure you have PHP installed (PHP 7.4+ recommended). You can check with `php -v`.
2. Start a local PHP server in the project root:

```bash
php -S localhost:8000
```

3. Initialize the database (creates SQLite DB and default admin):

```bash
php db_init.php
```

4. Open http://localhost:8000 in your browser.

Development helper:
- Reset & reinitialize DB: `php db_reset.php` (deletes `data/database.sqlite` and runs `db_init.php`).

Advanced features you could add:
- File uploads for evidence with server-side validation and storage
- Stronger admin authentication & CSRF protection
- Pagination and more sophisticated search (date range, crime_type)
- Exporting FIRs (CSV/JSON)

Admin credentials (default):
- Username: `admin`
- Password: `admin123`

## Notes
- You can switch to MySQL by adjusting `includes/db.php` and schema if you need multi-user or networked access.
- This demo uses simple session-based admin authentication; adjust for stronger policies if using in production.

## Project structure

- `index.php` — landing
- `report.php` — submit FIR form
- `submit_fir.php` — handler to insert FIRs
- `list_firs.php` — list public FIRs
- `view_fir.php` — view single FIR
- `admin/` — admin login and dashboard
- `includes/` — DB and auth helpers
- `sql/init.sql` — schema
- `db_init.php` — creates DB and seeds admin
- `assets/` — CSS and JS

Happy hacking! Please ask if you'd like enhancements: search, filtering, user accounts, email notifications, file uploads, or stricter access control.
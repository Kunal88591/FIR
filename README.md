# 🚓 FIR Management System

> A modern, secure First Information Report (FIR) management system built with PHP and SQLite. Digitize police station record-keeping with enterprise-grade security features.

![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-blue)
![Database](https://img.shields.io/badge/Database-SQLite-green)
![License](https://img.shields.io/badge/License-MIT-yellow)
![Status](https://img.shields.io/badge/Status-Production%20Ready-success)

---

## ✨ Features

### 🔐 Security First
- **CSRF Protection** - All forms secured against cross-site request forgery
- **Rate Limiting** - Login attempts limited (5 per 5 minutes)
- **Secure Sessions** - HttpOnly, SameSite cookies with auto-regeneration
- **Input Validation** - Comprehensive server-side validation
- **SQL Injection Prevention** - PDO prepared statements throughout
- **XSS Protection** - Output escaping on all user data
- **Password Hashing** - Bcrypt algorithm with cost factor 12
- **Audit Logging** - Complete activity tracking system

### 👥 User Features
- 📝 **Submit FIR** - Online complaint registration with detailed information
- 🔍 **Search & Filter** - Find FIRs by ID, crime type, status, or date range
- 👁️ **View Details** - Complete FIR information with evidence tracking
- 📄 **Pagination** - Smooth navigation through large datasets (20 items/page)
- 📱 **Responsive Design** - Works perfectly on desktop, tablet, and mobile

### 🎛️ Admin Dashboard
- 📊 **Statistics Overview** - Real-time counts of FIRs, stations, officers
- ✏️ **FIR Management** - Edit, update, and close investigations
- 👮 **Officer Management** - Add, edit, assign officers to cases
- 🏢 **Station Management** - Manage police station records
- 👤 **Criminal Database** - Track suspects and link to FIRs
- 📦 **Evidence Tracking** - Document and manage case evidence
- 🔄 **Status Updates** - Track cases from submission to closure

### 🛠️ Technical Features
- ⚡ **Zero Dependencies** - Pure PHP with built-in SQLite
- 🗄️ **Auto-Initialization** - Database creates itself on first run
- 📝 **Environment Config** - Secure `.env` based configuration
- 📊 **Rich Logging** - Multi-level logging (debug, info, warning, error, critical)
- 🔧 **Easy Configuration** - Simple setup via environment variables
- 🌐 **Cross-Platform** - Works on Windows, Linux, macOS

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.0 or higher
- SQLite3 extension (included in most PHP installations)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/kunal885911/FIR.git
   cd FIR
   ```

2. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env if needed (defaults work out of the box)
   ```

3. **Start the server**
   ```bash
   php -S localhost:8000
   ```

4. **Open in browser**
   ```
   http://localhost:8000
   ```

**That's it!** 🎉 The database is created automatically with sample data.

---

## 🔑 Default Credentials

### Admin Access
```
URL:      http://localhost:8000/admin/login.php
Username: admin
Password: admin123
```

> ⚠️ **Important:** Change the default password in production!

---

## 📂 Project Structure

```
FIR/
├── admin/              # Admin panel (login, dashboard, management)
│   ├── index.php       # Admin dashboard with statistics
│   ├── login.php       # Secure admin login
│   ├── actions.php     # Officer/criminal assignment logic
│   ├── edit_fir.php    # FIR editing interface
│   └── ...
├── assets/             # Frontend resources
│   ├── css/            # Stylesheets
│   └── js/             # JavaScript files
├── database/           # SQLite database file (auto-created)
│   └── fir_system.db   # Main database (1000+ records)
├── includes/           # Core application logic
│   ├── db.php          # Database connection & initialization
│   ├── config.php      # Configuration manager
│   ├── security.php    # CSRF, rate limiting, session management
│   ├── logger.php      # Application logging system
│   ├── pagination.php  # Pagination helper
│   ├── validator.php   # Input validation utilities
│   ├── header.php      # Common header template
│   └── footer.php      # Common footer template
├── logs/               # Application logs (auto-created)
│   └── app.log         # Main log file
├── sql/                # Database schema
│   └── init_sqlite.sql # SQLite initialization script
├── uploads/            # User uploaded files (evidence, documents)
├── .env                # Environment configuration (DO NOT commit)
├── .env.example        # Environment template
├── index.php           # Public homepage
├── list_firs.php       # Browse all FIRs with filters
├── view_fir.php        # View single FIR details
├── report.php          # Submit new FIR form
└── submit_fir.php      # FIR submission handler
```

---

## ⚙️ Configuration

Edit `.env` to customize your installation:

```env
# Database Type (sqlite only)
DB_TYPE=sqlite

# Application Settings
APP_ENV=production        # development or production
APP_DEBUG=false           # true shows detailed errors
APP_URL=http://localhost:8000

# Session Configuration
SESSION_LIFETIME=7200     # 2 hours
SESSION_SECURE=false      # set true for HTTPS
SESSION_HTTPONLY=true

# Security
CSRF_TOKEN_EXPIRY=3600    # 1 hour

# File Upload
MAX_FILE_SIZE=5242880     # 5MB in bytes
ALLOWED_EXTENSIONS=pdf,jpg,jpeg,png,doc,docx

# Logging
LOG_LEVEL=info            # debug, info, warning, error, critical
LOG_FILE=logs/app.log
```

---

## 📊 Database Schema

The system uses 9 core tables:

| Table | Purpose | Key Fields |
|-------|---------|------------|
| `admins` | Admin users | username, password_hash |
| `police_stations` | Station records | name, address, phone |
| `officers` | Police officers | name, badge_number, rank, station_id |
| `complainants` | Complainant info | name, contact, address |
| `firs` | FIR records | title, crime_type, description, status |
| `criminals` | Criminal database | name, alias, description |
| `fir_criminals` | Link criminals to FIRs | fir_id, criminal_id |
| `evidence` | Case evidence | fir_id, description, file_path |
| `fir_officers` | Assign officers to cases | fir_id, officer_id |

---

## 🔒 Security Best Practices

### For Production Deployment

1. **Change Default Credentials**
   ```bash
   # Update admin password in database or via admin panel
   ```

2. **Use HTTPS**
   ```env
   SESSION_SECURE=true
   APP_URL=https://yourdomain.com
   ```

3. **Disable Debug Mode**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   LOG_LEVEL=warning
   ```

4. **Set Proper Permissions**
   ```bash
   chmod 600 .env                    # Protect environment file
   chmod 755 database/               # Database directory
   chmod 644 database/fir_system.db  # Database file
   chmod 755 logs/ uploads/          # Writable directories
   ```

5. **Regular Backups**
   ```bash
   # Backup database regularly
   cp database/fir_system.db backups/fir_system_$(date +%Y%m%d).db
   ```

---

## 🧪 Testing

### Included Test Data
The system comes pre-loaded with:
- **1000 FIRs** - Realistic crime reports across multiple types
- **1200 Complainants** - Diverse complainant records
- **595 Criminals** - Sample criminal database entries
- **1238 Evidence Items** - Associated case evidence
- **5 Officers** - Police officers assigned to cases
- **3 Police Stations** - Station records

### Manual Testing

1. **Public Portal**
   - Visit `http://localhost:8000`
   - Browse FIRs in `list_firs.php`
   - Submit test FIR via `report.php`
   - Search and filter functionality

2. **Admin Panel**
   - Login at `/admin/login.php`
   - View dashboard statistics
   - Edit FIRs, assign officers
   - Manage stations, officers, criminals
   - Test rate limiting (6+ wrong passwords)

---

## 🐛 Troubleshooting

### Database Issues
```bash
# Reset database (WARNING: Deletes all data)
rm database/fir_system.db
# Restart server - database recreates automatically
```

### Permission Errors
```bash
chmod -R 755 database/ logs/ uploads/
```

### Session Problems
```bash
# Clear session files
rm -rf /tmp/sess_*  # Linux/Mac
# On Windows, clear C:\Windows\Temp\
```

---

## 📈 Performance Tips

- **For large datasets (10,000+ FIRs)**: Consider MySQL instead of SQLite
- **Optimize searches**: Use indexes on frequently queried columns
- **Enable caching**: Add PHP OPcache in production
- **Compress assets**: Minify CSS/JS files
- **Use CDN**: Host Bootstrap from CDN instead of locally

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**Kunal MEENA**
- GitHub: [@Kunal88591](https://github.com/Kunal88591)

---

## 🙏 Acknowledgments

- Bootstrap 5 for responsive UI framework
- PHP community for excellent documentation
- SQLite for lightweight, embedded database

---

## 📞 Support

If you encounter any issues or have questions:

1. Check the [Troubleshooting](#-troubleshooting) section
2. Review closed issues on GitHub
3. Open a new issue with detailed information

---

## 🗺️ Roadmap

Future enhancements planned:
- [ ] REST API for mobile applications
- [ ] Email notifications for FIR status updates
- [ ] Advanced analytics and reporting
- [ ] Multi-language support
- [ ] Document scanning with OCR
- [ ] Real-time notifications using WebSockets

---

**⭐ Star this repository if you find it helpful!**

4. **Logging:**
   - Check `logs/app.log` for logged events

---

## 🐛 Troubleshooting

**Problem:** Database connection failed
- ✅ Make sure WAMP/MySQL is running
- ✅ Check `.env` file has correct credentials
- ✅ Verify `fir_system` database exists

**Problem:** CSRF token error
- ✅ Clear your browser cookies
- ✅ Refresh the page to get a new token

**Problem:** Rate limit exceeded
- ✅ Wait 5 minutes or clear browser session

---

## 📝 Logs

Application logs are stored in `logs/app.log`. They include:
- Login/logout events
- FIR submissions and updates
- Security warnings
- Errors and exceptions

---

## 🔐 Production Deployment

Before deploying to production:

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Set `SESSION_SECURE=true` if using HTTPS
4. Use strong database password
5. Change default admin password
6. Set appropriate file permissions
7. Enable HTTPS
8. Configure regular database backups

---

## 📚 Additional Documentation

- [IMPROVEMENTS.md](IMPROVEMENTS.md) - Detailed list of all improvements
- [.env.example](.env.example) - Environment configuration template

---

## 🤝 Contributing

This is a college project. Feel free to fork and enhance!

---

## 📄 License

Educational project for learning purposes.



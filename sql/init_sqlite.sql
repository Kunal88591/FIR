-- FIR System SQLite Database Schema
-- SQLite version of the database

-- Table: police_stations
CREATE TABLE IF NOT EXISTS police_stations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    station_name TEXT NOT NULL,
    address TEXT,
    contact TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table: officers
CREATE TABLE IF NOT EXISTS officers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    rank TEXT,
    badge_number TEXT,
    station_id INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (station_id) REFERENCES police_stations(id) ON DELETE SET NULL
);

-- Table: complainants
CREATE TABLE IF NOT EXISTS complainants (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    contact_num TEXT,
    email TEXT,
    address TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table: firs (First Information Reports)
CREATE TABLE IF NOT EXISTS firs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    complainant_id INTEGER,
    station_id INTEGER,
    title TEXT NOT NULL,
    crime_type TEXT,
    description TEXT NOT NULL,
    date_of_incident DATE,
    incident_place TEXT,
    status TEXT DEFAULT 'Submitted',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (complainant_id) REFERENCES complainants(id) ON DELETE SET NULL,
    FOREIGN KEY (station_id) REFERENCES police_stations(id) ON DELETE SET NULL
);

-- Table: criminals (suspects/accused)
CREATE TABLE IF NOT EXISTS criminals (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    known_aliases TEXT,
    address TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table: fir_criminals (many-to-many relationship)
CREATE TABLE IF NOT EXISTS fir_criminals (
    fir_id INTEGER NOT NULL,
    criminal_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (fir_id, criminal_id),
    FOREIGN KEY (fir_id) REFERENCES firs(id) ON DELETE CASCADE,
    FOREIGN KEY (criminal_id) REFERENCES criminals(id) ON DELETE CASCADE
);

-- Table: evidence
CREATE TABLE IF NOT EXISTS evidence (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    fir_id INTEGER NOT NULL,
    type TEXT,
    description TEXT,
    collected_on DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fir_id) REFERENCES firs(id) ON DELETE CASCADE
);

-- Table: fir_officers (case assignments)
CREATE TABLE IF NOT EXISTS fir_officers (
    fir_id INTEGER NOT NULL,
    officer_id INTEGER NOT NULL,
    assigned_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (fir_id, officer_id),
    FOREIGN KEY (fir_id) REFERENCES firs(id) ON DELETE CASCADE,
    FOREIGN KEY (officer_id) REFERENCES officers(id) ON DELETE CASCADE
);

-- Table: admins
CREATE TABLE IF NOT EXISTS admins (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_firs_status ON firs(status);
CREATE INDEX IF NOT EXISTS idx_firs_date ON firs(date_of_incident);
CREATE INDEX IF NOT EXISTS idx_firs_created ON firs(created_at);
CREATE INDEX IF NOT EXISTS idx_officers_station ON officers(station_id);
CREATE INDEX IF NOT EXISTS idx_evidence_fir ON evidence(fir_id);

-- Insert sample data
-- Insert police stations
INSERT INTO police_stations (station_name, address, contact) VALUES
('Central Police Station', '123 Main Street, City Center', '555-0101'),
('North Police Station', '456 North Avenue, North District', '555-0102'),
('South Police Station', '789 South Boulevard, South District', '555-0103');

-- Insert default admin (username: admin, password: admin123)
INSERT INTO admins (username, password_hash) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert sample officers
INSERT INTO officers (name, rank, badge_number, station_id) VALUES
('John Smith', 'Inspector', 'B-1001', 1),
('Sarah Johnson', 'Constable', 'B-1002', 1),
('Mike Davis', 'Sub-Inspector', 'B-1003', 2),
('Emily Wilson', 'Constable', 'B-1004', 2),
('David Brown', 'Inspector', 'B-1005', 3);

-- Insert sample criminals
INSERT INTO criminals (name, known_aliases, address) VALUES
('Unknown Suspect', 'N/A', 'Unknown'),
('John Doe', 'Johnny', 'Unknown Address');

-- FIR System schema (SQLite)
PRAGMA foreign_keys = ON;

-- Table: admins
CREATE TABLE IF NOT EXISTS admins (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL
);

-- Table: police_stations
CREATE TABLE IF NOT EXISTS police_stations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    station_name TEXT NOT NULL,
    contact_num TEXT,
    address TEXT,
    city TEXT
);

-- Table: officers
CREATE TABLE IF NOT EXISTS officers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    rank TEXT,
    contact_num TEXT,
    station_id INTEGER,
    FOREIGN KEY (station_id) REFERENCES police_stations(id) ON DELETE SET NULL
);

-- Table: complainants
CREATE TABLE IF NOT EXISTS complainants (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT,
    contact_num TEXT,
    address TEXT
);

-- Table: criminals
CREATE TABLE IF NOT EXISTS criminals (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    age INTEGER,
    gender TEXT,
    address TEXT,
    crime_history TEXT
);

-- FIR main table
CREATE TABLE IF NOT EXISTS firs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    complainant_id INTEGER,
    station_id INTEGER,
    title TEXT,
    crime_type TEXT,
    description TEXT NOT NULL,
    status TEXT NOT NULL DEFAULT 'Submitted',
    date_of_incident TEXT,
    incident_place TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (complainant_id) REFERENCES complainants(id) ON DELETE SET NULL,
    FOREIGN KEY (station_id) REFERENCES police_stations(id) ON DELETE SET NULL
);

-- Junction: fir_criminals (N:M)
CREATE TABLE IF NOT EXISTS fir_criminals (
    fir_id INTEGER NOT NULL,
    criminal_id INTEGER NOT NULL,
    PRIMARY KEY (fir_id, criminal_id),
    FOREIGN KEY (fir_id) REFERENCES firs(id) ON DELETE CASCADE,
    FOREIGN KEY (criminal_id) REFERENCES criminals(id) ON DELETE CASCADE
);

-- Evidence table (each piece of evidence belongs to an FIR)
CREATE TABLE IF NOT EXISTS evidence (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    fir_id INTEGER NOT NULL,
    type TEXT,
    description TEXT,
    collected_on TEXT,
    FOREIGN KEY (fir_id) REFERENCES firs(id) ON DELETE CASCADE
);

-- Junction: fir_officers (to assign officers to FIRs - N:M)
CREATE TABLE IF NOT EXISTS fir_officers (
    fir_id INTEGER NOT NULL,
    officer_id INTEGER NOT NULL,
    PRIMARY KEY (fir_id, officer_id),
    FOREIGN KEY (fir_id) REFERENCES firs(id) ON DELETE CASCADE,
    FOREIGN KEY (officer_id) REFERENCES officers(id) ON DELETE CASCADE
);

-- Seed a sample police station and officer
INSERT OR IGNORE INTO police_stations (id, station_name, contact_num, address, city) VALUES (1, 'Central Police Station', '123-456-7890', '123 Main St', 'Capital City');
INSERT OR IGNORE INTO officers (id, name, rank, contact_num) VALUES (1, 'Officer John Doe', 'Inspector', '987-654-3210');

-- Basic seed for admins will be handled by db_init.php

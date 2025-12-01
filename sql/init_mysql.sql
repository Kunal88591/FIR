-- FIR System MySQL Database Schema
-- Created for College Database Project

-- Create database (run this first in phpMyAdmin or MySQL command line)
-- CREATE DATABASE IF NOT EXISTS fir_system CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- USE fir_system;

-- Table: police_stations
CREATE TABLE IF NOT EXISTS police_stations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    station_name VARCHAR(255) NOT NULL,
    address TEXT,
    contact VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Police station information';

-- Table: officers
CREATE TABLE IF NOT EXISTS officers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    rank VARCHAR(100),
    badge_number VARCHAR(50),
    station_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (station_id) REFERENCES police_stations(id) ON DELETE SET NULL,
    INDEX idx_station (station_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Police officers';

-- Table: complainants
CREATE TABLE IF NOT EXISTS complainants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_num VARCHAR(50),
    email VARCHAR(255),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='People who file FIRs';

-- Table: firs (First Information Reports)
CREATE TABLE IF NOT EXISTS firs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    complainant_id INT,
    station_id INT,
    title VARCHAR(255) NOT NULL,
    crime_type VARCHAR(100),
    description TEXT NOT NULL,
    date_of_incident DATE,
    incident_place TEXT,
    status VARCHAR(50) DEFAULT 'Submitted',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (complainant_id) REFERENCES complainants(id) ON DELETE SET NULL,
    FOREIGN KEY (station_id) REFERENCES police_stations(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_date (date_of_incident),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='First Information Reports';

-- Table: criminals (suspects/accused)
CREATE TABLE IF NOT EXISTS criminals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    known_aliases TEXT,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Criminal suspects/accused persons';

-- Table: fir_criminals (many-to-many relationship)
CREATE TABLE IF NOT EXISTS fir_criminals (
    fir_id INT NOT NULL,
    criminal_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (fir_id, criminal_id),
    FOREIGN KEY (fir_id) REFERENCES firs(id) ON DELETE CASCADE,
    FOREIGN KEY (criminal_id) REFERENCES criminals(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Link FIRs to criminals';

-- Table: evidence
CREATE TABLE IF NOT EXISTS evidence (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fir_id INT NOT NULL,
    type VARCHAR(100),
    description TEXT,
    collected_on DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fir_id) REFERENCES firs(id) ON DELETE CASCADE,
    INDEX idx_fir (fir_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Evidence items';

-- Table: fir_officers (case assignments)
CREATE TABLE IF NOT EXISTS fir_officers (
    fir_id INT NOT NULL,
    officer_id INT NOT NULL,
    assigned_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (fir_id, officer_id),
    FOREIGN KEY (fir_id) REFERENCES firs(id) ON DELETE CASCADE,
    FOREIGN KEY (officer_id) REFERENCES officers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Officer assignments to FIRs';

-- Table: admins
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Admin users';

-- Insert sample police stations
INSERT INTO police_stations (station_name, address, contact) VALUES
('Central Police Station', '123 Main Street, Downtown', '555-0101'),
('North Division', '456 North Avenue', '555-0102'),
('South Division', '789 South Boulevard', '555-0103'),
('East Precinct', '321 East Road', '555-0104'),
('West Precinct', '654 West Street', '555-0105');

-- Insert sample officers
INSERT INTO officers (name, rank, badge_number, station_id) VALUES
('John Smith', 'Inspector', 'B-1001', 1),
('Sarah Johnson', 'Constable', 'B-1002', 1),
('Mike Davis', 'Sub-Inspector', 'B-1003', 2),
('Emily Wilson', 'Constable', 'B-1004', 2),
('Robert Brown', 'Inspector', 'B-1005', 3),
('Lisa Anderson', 'Head Constable', 'B-1006', 3);

-- Insert default admin (username: admin, password: admin123)
-- Password hash for 'admin123'
INSERT INTO admins (username, password_hash) VALUES
('admin', '$2y$10$tX1XiBMnKiiYJJzf.c52nuU8UUKtmi2Dc4MOGFxMi/OxSfjLtqh1EW');

-- Insert sample complainants
INSERT INTO complainants (name, contact_num, email, address) VALUES
('Rajesh Kumar', '9876543210', 'rajesh@example.com', '12 Gandhi Nagar'),
('Priya Sharma', '9765432109', 'priya@example.com', '45 Nehru Road'),
('Amit Patel', '9654321098', 'amit@example.com', '78 Park Street');

-- Insert sample FIRs
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status) VALUES
(1, 1, 'Theft of Mobile Phone', 'Theft', 'My mobile phone was stolen from my pocket while I was shopping in the market.', '2024-11-28', 'Central Market', 'Under Investigation'),
(2, 2, 'House Burglary', 'Burglary', 'Unknown persons broke into my house and stole jewelry and cash.', '2024-11-29', '45 Nehru Road', 'Submitted'),
(3, 1, 'Vehicle Accident', 'Accident', 'My car was hit by a speeding vehicle that fled the scene.', '2024-11-30', 'Main Highway', 'Under Investigation');

-- Insert sample criminals
INSERT INTO criminals (name, known_aliases, address) VALUES
('Unknown Suspect 1', NULL, 'Unknown'),
('Ram Singh', 'Ramu', '23 Old City'),
('Unknown Suspect 2', NULL, 'Unknown');

-- Link FIRs to criminals
INSERT INTO fir_criminals (fir_id, criminal_id) VALUES
(1, 1),
(2, 2),
(3, 3);

-- Insert sample evidence
INSERT INTO evidence (fir_id, type, description, collected_on) VALUES
(1, 'CCTV Footage', 'Market CCTV showing suspect', '2024-11-28'),
(2, 'Fingerprints', 'Fingerprints found on window', '2024-11-29'),
(3, 'Witness Statement', 'Statement from nearby shopkeeper', '2024-11-30');

-- Assign officers to FIRs
INSERT INTO fir_officers (fir_id, officer_id) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 1);

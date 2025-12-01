-- Generated Dummy Data for FIR System
-- Generated on: 2025-12-01 03:05:45.409201
-- Uses INSERT ... SELECT to ensure referential integrity

SET FOREIGN_KEY_CHECKS=0;

-- Complainants
INSERT INTO complainants (name, contact_num, email, address) VALUES
('Aarav Mehta', '7789817458', 'aarav.mehta@example.com', '821, Market Street, Jaipur'),
('Muhammad Ali', '7110383952', 'muhammad.ali@example.com', '509, Park Avenue, Surat'),
('Myra Singh', '8251229740', 'myra.singh@example.com', '479, Park Avenue, Delhi'),
('Reyansh Sharma', '9222881093', 'reyansh.sharma@example.com', '783, Ring Road, Delhi'),
('Riya Kumar', '8885776821', 'riya.kumar@example.com', '480, Nehru Path, Kolkata'),
('Sana Das', '8043522883', 'sana.das@example.com', '17, Main Street, Jaipur'),
('Saanvi Gupta', '9459468714', 'saanvi.gupta@example.com', '283, Nehru Path, Mumbai'),
('Riya Yadav', '8286696204', 'riya.yadav@example.com', '960, Gandhi Marg, Hyderabad'),
('Aarav Nair', '7861503466', 'aarav.nair@example.com', '773, Park Avenue, Bangalore'),
('Arjun Sharma', '8993228509', 'arjun.sharma@example.com', '480, MG Road, Bangalore'),
('Ishaan Mehta', '8558366632', 'ishaan.mehta@example.com', '439, Gandhi Marg, Pune'),
('Aarav Chopra', '7053655545', 'aarav.chopra@example.com', '729, MG Road, Bangalore'),
('Pari Gupta', '9333178388', 'pari.gupta@example.com', '841, Main Street, Kolkata'),
('Vihaan Patel', '8505737668', 'vihaan.patel@example.com', '773, Ring Road, Ahmedabad'),
('Vihaan Nair', '9627056685', 'vihaan.nair@example.com', '492, Nehru Path, Ahmedabad'),
('Pari Yadav', '7645434586', 'pari.yadav@example.com', '702, Main Street, Jaipur'),
('Krishna Gupta', '7333831934', 'krishna.gupta@example.com', '63, Nehru Path, Ahmedabad'),
('Rohan Das', '9055898174', 'rohan.das@example.com', '745, Main Street, Pune'),
('Diya Joshi', '8815555956', 'diya.joshi@example.com', '184, Park Avenue, Delhi'),
('Pari Yadav', '8990728168', 'pari.yadav@example.com', '698, MG Road, Surat'),
('Aadhya Chopra', '8776162718', 'aadhya.chopra@example.com', '38, Main Street, Pune'),
('Sana Chopra', '7074183572', 'sana.chopra@example.com', '297, Market Street, Kolkata'),
('Saanvi Nair', '8197376719', 'saanvi.nair@example.com', '669, Station Road, Jaipur'),
('Ananya Kumar', '8713917977', 'ananya.kumar@example.com', '577, Park Avenue, Surat'),
('Arjun Mehta', '7412804250', 'arjun.mehta@example.com', '392, Station Road, Pune'),
('Saanvi Chopra', '8923272805', 'saanvi.chopra@example.com', '251, Market Street, Pune'),
('Aditya Gupta', '7539576896', 'aditya.gupta@example.com', '889, Park Avenue, Kolkata'),
('Reyansh Ali', '8451558610', 'reyansh.ali@example.com', '612, Ring Road, Bangalore'),
('Aarav Khan', '8647649486', 'aarav.khan@example.com', '344, Main Street, Jaipur'),
('Pari Mehta', '8993360979', 'pari.mehta@example.com', '856, Market Street, Bangalore'),
('Aadhya Yadav', '9842914717', 'aadhya.yadav@example.com', '211, Park Avenue, Kolkata'),
('Arjun Chopra', '7404865534', 'arjun.chopra@example.com', '546, Gandhi Marg, Mumbai'),
('Sai Mishra', '7628441045', 'sai.mishra@example.com', '337, Park Avenue, Bangalore'),
('Reyansh Nair', '7842824011', 'reyansh.nair@example.com', '950, MG Road, Delhi'),
('Diya Gupta', '9440309377', 'diya.gupta@example.com', '402, Park Avenue, Ahmedabad'),
('Arjun Mehta', '7810739693', 'arjun.mehta@example.com', '813, Main Street, Mumbai'),
('Rohan Joshi', '7954890919', 'rohan.joshi@example.com', '50, Gandhi Marg, Surat'),
('Fatima Yadav', '9974114369', 'fatima.yadav@example.com', '607, Station Road, Chennai'),
('Vihaan Gupta', '9210239647', 'vihaan.gupta@example.com', '91, Station Road, Pune'),
('Ananya Sharma', '9386688696', 'ananya.sharma@example.com', '394, MG Road, Surat'),
('Aadhya Khan', '7933818998', 'aadhya.khan@example.com', '65, Main Street, Bangalore'),
('Ananya Ali', '7517923276', 'ananya.ali@example.com', '313, Station Road, Hyderabad'),
('Myra Chopra', '8924604677', 'myra.chopra@example.com', '588, Market Street, Chennai'),
('Pari Nair', '8474492992', 'pari.nair@example.com', '136, Main Street, Jaipur'),
('Muhammad Das', '8128224227', 'muhammad.das@example.com', '112, Park Avenue, Bangalore'),
('Sai Sharma', '9679640332', 'sai.sharma@example.com', '460, Main Street, Bangalore'),
('Ananya Mishra', '8320760036', 'ananya.mishra@example.com', '824, Station Road, Ahmedabad'),
('Reyansh Das', '8250618316', 'reyansh.das@example.com', '402, Gandhi Marg, Pune'),
('Arjun Joshi', '8548421233', 'arjun.joshi@example.com', '662, Station Road, Pune'),
('Diya Gupta', '7930346372', 'diya.gupta@example.com', '769, Gandhi Marg, Jaipur');

-- Criminals
INSERT INTO criminals (name, known_aliases, address) VALUES
('Muhammad Nair', NULL, '381, Market Street, Delhi'),
('Ishaan Yadav', 'Bhai', '560, Main Street, Delhi'),
('Zara Patel', 'Tiger', '835, Park Avenue, Mumbai'),
('Diya Gupta', 'Bhai', '596, Station Road, Hyderabad'),
('Ananya Mehta', NULL, '826, MG Road, Chennai'),
('Rohan Mehta', 'Tiger', '704, Ring Road, Mumbai'),
('Aditya Mishra', NULL, '460, Park Avenue, Mumbai'),
('Riya Chopra', NULL, '660, MG Road, Surat'),
('Sai Sharma', 'Rocky', '538, Market Street, Surat'),
('Fatima Reddy', NULL, '929, Park Avenue, Kolkata'),
('Aadhya Yadav', NULL, '70, Gandhi Marg, Chennai'),
('Vihaan Nair', NULL, '510, Market Street, Mumbai'),
('Ishaan Reddy', NULL, '290, Gandhi Marg, Mumbai'),
('Rohan Sharma', 'Rocky', '707, Nehru Path, Kolkata'),
('Sana Yadav', 'King', '669, Market Street, Surat'),
('Aditya Patel', 'King', '459, Nehru Path, Pune'),
('Muhammad Gupta', 'Don', '174, MG Road, Pune'),
('Rohan Mehta', 'Tiger', '147, Park Avenue, Mumbai'),
('Vihaan Reddy', NULL, '337, Market Street, Surat'),
('Ishaan Sharma', 'Bhai', '290, Gandhi Marg, Delhi'),
('Myra Ali', 'Rocky', '209, Market Street, Ahmedabad'),
('Arjun Patel', 'King', '352, Park Avenue, Chennai'),
('Ananya Reddy', 'Tiger', '543, Nehru Path, Bangalore'),
('Diya Das', NULL, '452, Station Road, Hyderabad'),
('Sai Joshi', NULL, '645, Ring Road, Bangalore'),
('Muhammad Sharma', 'Bhai', '707, Station Road, Chennai'),
('Vihaan Joshi', 'Rocky', '894, MG Road, Kolkata'),
('Sana Khan', NULL, '149, Park Avenue, Hyderabad'),
('Sana Yadav', NULL, '410, MG Road, Chennai'),
('Vihaan Ali', NULL, '847, Station Road, Bangalore'),
('Myra Mishra', NULL, '391, Main Street, Hyderabad'),
('Fatima Khan', NULL, '732, Market Street, Jaipur'),
('Riya Chopra', 'Rocky', '288, Ring Road, Chennai'),
('Diya Gupta', 'Bhai', '131, Ring Road, Mumbai'),
('Rohan Yadav', 'Don', '440, MG Road, Delhi'),
('Saanvi Mehta', 'King', '532, Park Avenue, Ahmedabad'),
('Muhammad Yadav', NULL, '633, Gandhi Marg, Jaipur'),
('Ananya Chopra', NULL, '439, Gandhi Marg, Pune'),
('Ananya Kumar', 'Rocky', '112, Nehru Path, Kolkata'),
('Sana Gupta', 'King', '464, Nehru Path, Hyderabad'),
('Riya Chopra', NULL, '409, Station Road, Chennai'),
('Aarav Kumar', 'Bhai', '709, Station Road, Hyderabad'),
('Ishaan Patel', NULL, '800, Station Road, Mumbai'),
('Aadhya Khan', NULL, '750, MG Road, Pune'),
('Myra Singh', NULL, '606, Park Avenue, Hyderabad'),
('Krishna Chopra', 'Tiger', '647, Gandhi Marg, Surat'),
('Aarav Joshi', NULL, '391, Station Road, Chennai'),
('Riya Joshi', 'Rocky', '587, Station Road, Hyderabad'),
('Riya Khan', NULL, '615, Park Avenue, Jaipur'),
('Fatima Kumar', NULL, '579, Main Street, Ahmedabad');

-- FIRs
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Cybercrime incident', 'Cybercrime', 'Detailed report regarding Cybercrime that occurred at the mentioned location. Investigation required.', '2024-05-26', 'Nehru Path, Mumbai', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Fraud incident', 'Fraud', 'Detailed report regarding Fraud that occurred at the mentioned location. Investigation required.', '2024-04-06', 'Nehru Path, Mumbai', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Theft incident', 'Theft', 'Detailed report regarding Theft that occurred at the mentioned location. Investigation required.', '2024-07-30', 'Station Road, Hyderabad', 'Rejected'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Harassment incident', 'Harassment', 'Detailed report regarding Harassment that occurred at the mentioned location. Investigation required.', '2024-03-07', 'MG Road, Bangalore', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Vandalism incident', 'Vandalism', 'Detailed report regarding Vandalism that occurred at the mentioned location. Investigation required.', '2024-02-23', 'Nehru Path, Delhi', 'Action Taken'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Harassment incident', 'Harassment', 'Detailed report regarding Harassment that occurred at the mentioned location. Investigation required.', '2023-04-07', 'Main Street, Kolkata', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Domestic Violence incident', 'Domestic Violence', 'Detailed report regarding Domestic Violence that occurred at the mentioned location. Investigation required.', '2024-05-08', 'Main Street, Bangalore', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Burglary incident', 'Burglary', 'Detailed report regarding Burglary that occurred at the mentioned location. Investigation required.', '2023-10-03', 'Station Road, Chennai', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Cybercrime incident', 'Cybercrime', 'Detailed report regarding Cybercrime that occurred at the mentioned location. Investigation required.', '2024-11-17', 'Market Street, Pune', 'Submitted'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Vandalism incident', 'Vandalism', 'Detailed report regarding Vandalism that occurred at the mentioned location. Investigation required.', '2024-12-24', 'Market Street, Hyderabad', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Kidnapping incident', 'Kidnapping', 'Detailed report regarding Kidnapping that occurred at the mentioned location. Investigation required.', '2024-06-25', 'Market Street, Bangalore', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Domestic Violence incident', 'Domestic Violence', 'Detailed report regarding Domestic Violence that occurred at the mentioned location. Investigation required.', '2024-11-02', 'Nehru Path, Delhi', 'Submitted'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Vandalism incident', 'Vandalism', 'Detailed report regarding Vandalism that occurred at the mentioned location. Investigation required.', '2023-05-19', 'Station Road, Chennai', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Cybercrime incident', 'Cybercrime', 'Detailed report regarding Cybercrime that occurred at the mentioned location. Investigation required.', '2024-09-08', 'Nehru Path, Pune', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Domestic Violence incident', 'Domestic Violence', 'Detailed report regarding Domestic Violence that occurred at the mentioned location. Investigation required.', '2023-06-29', 'Main Street, Jaipur', 'Submitted'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Domestic Violence incident', 'Domestic Violence', 'Detailed report regarding Domestic Violence that occurred at the mentioned location. Investigation required.', '2024-09-19', 'Station Road, Hyderabad', 'Action Taken'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Kidnapping incident', 'Kidnapping', 'Detailed report regarding Kidnapping that occurred at the mentioned location. Investigation required.', '2023-07-21', 'Main Street, Chennai', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Traffic Violation incident', 'Traffic Violation', 'Detailed report regarding Traffic Violation that occurred at the mentioned location. Investigation required.', '2023-06-01', 'Nehru Path, Bangalore', 'Action Taken'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Harassment incident', 'Harassment', 'Detailed report regarding Harassment that occurred at the mentioned location. Investigation required.', '2024-11-17', 'Ring Road, Jaipur', 'Action Taken'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Domestic Violence incident', 'Domestic Violence', 'Detailed report regarding Domestic Violence that occurred at the mentioned location. Investigation required.', '2024-02-20', 'Main Street, Bangalore', 'Action Taken'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Domestic Violence incident', 'Domestic Violence', 'Detailed report regarding Domestic Violence that occurred at the mentioned location. Investigation required.', '2024-07-11', 'MG Road, Kolkata', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Vandalism incident', 'Vandalism', 'Detailed report regarding Vandalism that occurred at the mentioned location. Investigation required.', '2024-04-01', 'Market Street, Jaipur', 'Rejected'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Theft incident', 'Theft', 'Detailed report regarding Theft that occurred at the mentioned location. Investigation required.', '2023-12-06', 'MG Road, Delhi', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Domestic Violence incident', 'Domestic Violence', 'Detailed report regarding Domestic Violence that occurred at the mentioned location. Investigation required.', '2023-05-02', 'Station Road, Ahmedabad', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Kidnapping incident', 'Kidnapping', 'Detailed report regarding Kidnapping that occurred at the mentioned location. Investigation required.', '2023-08-16', 'Station Road, Kolkata', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Assault incident', 'Assault', 'Detailed report regarding Assault that occurred at the mentioned location. Investigation required.', '2023-12-27', 'Main Street, Delhi', 'Action Taken'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Assault incident', 'Assault', 'Detailed report regarding Assault that occurred at the mentioned location. Investigation required.', '2024-05-18', 'Park Avenue, Kolkata', 'Rejected'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Kidnapping incident', 'Kidnapping', 'Detailed report regarding Kidnapping that occurred at the mentioned location. Investigation required.', '2024-08-11', 'Nehru Path, Hyderabad', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Kidnapping incident', 'Kidnapping', 'Detailed report regarding Kidnapping that occurred at the mentioned location. Investigation required.', '2023-03-30', 'Market Street, Pune', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Vandalism incident', 'Vandalism', 'Detailed report regarding Vandalism that occurred at the mentioned location. Investigation required.', '2023-10-22', 'Park Avenue, Ahmedabad', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Assault incident', 'Assault', 'Detailed report regarding Assault that occurred at the mentioned location. Investigation required.', '2023-11-07', 'Market Street, Pune', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Burglary incident', 'Burglary', 'Detailed report regarding Burglary that occurred at the mentioned location. Investigation required.', '2023-04-26', 'Park Avenue, Ahmedabad', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Kidnapping incident', 'Kidnapping', 'Detailed report regarding Kidnapping that occurred at the mentioned location. Investigation required.', '2023-04-06', 'Park Avenue, Hyderabad', 'Rejected'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Kidnapping incident', 'Kidnapping', 'Detailed report regarding Kidnapping that occurred at the mentioned location. Investigation required.', '2023-02-14', 'Nehru Path, Delhi', 'Submitted'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Cybercrime incident', 'Cybercrime', 'Detailed report regarding Cybercrime that occurred at the mentioned location. Investigation required.', '2023-10-19', 'Gandhi Marg, Delhi', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Theft incident', 'Theft', 'Detailed report regarding Theft that occurred at the mentioned location. Investigation required.', '2024-07-18', 'MG Road, Bangalore', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Fraud incident', 'Fraud', 'Detailed report regarding Fraud that occurred at the mentioned location. Investigation required.', '2023-04-19', 'Main Street, Jaipur', 'Submitted'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Burglary incident', 'Burglary', 'Detailed report regarding Burglary that occurred at the mentioned location. Investigation required.', '2024-02-26', 'Nehru Path, Surat', 'Rejected'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Vandalism incident', 'Vandalism', 'Detailed report regarding Vandalism that occurred at the mentioned location. Investigation required.', '2024-05-15', 'MG Road, Surat', 'Rejected'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Domestic Violence incident', 'Domestic Violence', 'Detailed report regarding Domestic Violence that occurred at the mentioned location. Investigation required.', '2024-11-15', 'MG Road, Delhi', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Traffic Violation incident', 'Traffic Violation', 'Detailed report regarding Traffic Violation that occurred at the mentioned location. Investigation required.', '2024-10-06', 'Market Street, Delhi', 'Action Taken'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Theft incident', 'Theft', 'Detailed report regarding Theft that occurred at the mentioned location. Investigation required.', '2024-08-22', 'MG Road, Bangalore', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Vandalism incident', 'Vandalism', 'Detailed report regarding Vandalism that occurred at the mentioned location. Investigation required.', '2023-02-05', 'MG Road, Jaipur', 'Rejected'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Harassment incident', 'Harassment', 'Detailed report regarding Harassment that occurred at the mentioned location. Investigation required.', '2024-03-20', 'Market Street, Kolkata', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Assault incident', 'Assault', 'Detailed report regarding Assault that occurred at the mentioned location. Investigation required.', '2024-02-02', 'Nehru Path, Kolkata', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Assault incident', 'Assault', 'Detailed report regarding Assault that occurred at the mentioned location. Investigation required.', '2023-10-24', 'Main Street, Jaipur', 'Under Investigation'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Traffic Violation incident', 'Traffic Violation', 'Detailed report regarding Traffic Violation that occurred at the mentioned location. Investigation required.', '2024-12-27', 'MG Road, Hyderabad', 'Closed'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Theft incident', 'Theft', 'Detailed report regarding Theft that occurred at the mentioned location. Investigation required.', '2023-11-01', 'Gandhi Marg, Chennai', 'Rejected'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Cybercrime incident', 'Cybercrime', 'Detailed report regarding Cybercrime that occurred at the mentioned location. Investigation required.', '2023-05-09', 'Gandhi Marg, Surat', 'Rejected'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;
INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, 'Reported Vandalism incident', 'Vandalism', 'Detailed report regarding Vandalism that occurred at the mentioned location. Investigation required.', '2024-12-21', 'MG Road, Chennai', 'Rejected'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;

-- FIR Criminal Links
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;

-- Evidence
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Document', 'Collected Document from the scene.', '2023-09-27'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Weapon', 'Collected Weapon from the scene.', '2024-08-19'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Audio Recording', 'Collected Audio Recording from the scene.', '2023-10-02'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Witness Statement', 'Collected Witness Statement from the scene.', '2023-11-09'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Photograph', 'Collected Photograph from the scene.', '2023-04-13'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Document', 'Collected Document from the scene.', '2024-03-19'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Audio Recording', 'Collected Audio Recording from the scene.', '2023-05-02'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Photograph', 'Collected Photograph from the scene.', '2024-09-26'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Fingerprints', 'Collected Fingerprints from the scene.', '2024-12-21'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Photograph', 'Collected Photograph from the scene.', '2023-01-15'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Document', 'Collected Document from the scene.', '2024-02-19'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'DNA Sample', 'Collected DNA Sample from the scene.', '2024-05-28'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Document', 'Collected Document from the scene.', '2024-02-18'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'CCTV Footage', 'Collected CCTV Footage from the scene.', '2023-02-11'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Audio Recording', 'Collected Audio Recording from the scene.', '2024-03-16'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'DNA Sample', 'Collected DNA Sample from the scene.', '2024-06-11'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'CCTV Footage', 'Collected CCTV Footage from the scene.', '2024-09-19'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Audio Recording', 'Collected Audio Recording from the scene.', '2023-11-21'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Photograph', 'Collected Photograph from the scene.', '2024-11-23'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Witness Statement', 'Collected Witness Statement from the scene.', '2024-02-24'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Witness Statement', 'Collected Witness Statement from the scene.', '2024-08-11'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Photograph', 'Collected Photograph from the scene.', '2023-04-17'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Photograph', 'Collected Photograph from the scene.', '2024-03-03'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Weapon', 'Collected Weapon from the scene.', '2024-05-16'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'DNA Sample', 'Collected DNA Sample from the scene.', '2024-10-19'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Fingerprints', 'Collected Fingerprints from the scene.', '2023-10-01'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'CCTV Footage', 'Collected CCTV Footage from the scene.', '2024-08-05'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Document', 'Collected Document from the scene.', '2023-12-02'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Audio Recording', 'Collected Audio Recording from the scene.', '2024-01-01'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'CCTV Footage', 'Collected CCTV Footage from the scene.', '2024-10-21'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Witness Statement', 'Collected Witness Statement from the scene.', '2023-07-01'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Fingerprints', 'Collected Fingerprints from the scene.', '2023-04-03'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Witness Statement', 'Collected Witness Statement from the scene.', '2024-06-13'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Document', 'Collected Document from the scene.', '2023-10-06'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Audio Recording', 'Collected Audio Recording from the scene.', '2023-08-27'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Fingerprints', 'Collected Fingerprints from the scene.', '2023-09-26'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'CCTV Footage', 'Collected CCTV Footage from the scene.', '2024-12-09'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'DNA Sample', 'Collected DNA Sample from the scene.', '2024-10-22'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Document', 'Collected Document from the scene.', '2023-04-10'
FROM firs
ORDER BY RAND()
LIMIT 1;
INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, 'Document', 'Collected Document from the scene.', '2023-05-07'
FROM firs
ORDER BY RAND()
LIMIT 1;

-- Officer Assignments
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;
INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;

SET FOREIGN_KEY_CHECKS=1;
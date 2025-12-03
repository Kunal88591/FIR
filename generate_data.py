import random
import datetime

def generate_sql():
    # Data pools
    first_names = ["Aarav", "Vihaan", "Aditya", "Sai", "Arjun", "Reyansh", "Muhammad", "Rohan", "Krishna", "Ishaan", "Diya", "Saanvi", "Ananya", "Aadhya", "Pari", "Fatima", "Zara", "Myra", "Riya", "Sana"]
    last_names = ["Patel", "Sharma", "Singh", "Kumar", "Gupta", "Khan", "Ali", "Reddy", "Nair", "Mishra", "Joshi", "Yadav", "Das", "Chopra", "Mehta"]
    cities = ["Mumbai", "Delhi", "Bangalore", "Hyderabad", "Ahmedabad", "Chennai", "Kolkata", "Surat", "Pune", "Jaipur"]
    streets = ["MG Road", "Station Road", "Main Street", "Park Avenue", "Gandhi Marg", "Nehru Path", "Ring Road", "Market Street"]
    crime_types = ["Theft", "Burglary", "Assault", "Fraud", "Cybercrime", "Vandalism", "Harassment", "Domestic Violence", "Traffic Violation", "Kidnapping"]
    statuses = ["Submitted", "Under Investigation", "Action Taken", "Closed", "Rejected"]
    evidence_types = ["CCTV Footage", "Witness Statement", "Fingerprints", "DNA Sample", "Weapon", "Document", "Photograph", "Audio Recording"]

    # Helper to get random date
    def random_date(start_year=2023, end_year=2024):
        start = datetime.date(start_year, 1, 1)
        end = datetime.date(end_year, 12, 31)
        return start + datetime.timedelta(days=random.randint(0, (end - start).days))

    sql_statements = []
    sql_statements.append("-- Generated Dummy Data for FIR System")
    sql_statements.append("-- Generated on: " + str(datetime.datetime.now()))
    sql_statements.append("-- Uses INSERT ... SELECT to ensure referential integrity")
    sql_statements.append("")
    
    # Disable FK checks temporarily to avoid issues during bulk insert if order is slightly off, 
    # though we are trying to be safe with SELECTs.
    sql_statements.append("SET FOREIGN_KEY_CHECKS=0;") 
    sql_statements.append("")

    # 1. Generate Complainants (50)
    sql_statements.append("-- Complainants")
    sql_statements.append("INSERT INTO complainants (name, contact_num, email, address) VALUES")
    complainant_values = []
    for i in range(50):
        name = f"{random.choice(first_names)} {random.choice(last_names)}"
        contact = f"{random.randint(7000000000, 9999999999)}"
        email = f"{name.lower().replace(' ', '.')}@example.com"
        address = f"{random.randint(1, 999)}, {random.choice(streets)}, {random.choice(cities)}"
        complainant_values.append(f"('{name}', '{contact}', '{email}', '{address}')")
    sql_statements.append(",\n".join(complainant_values) + ";")
    sql_statements.append("")

    # 2. Generate Criminals (50)
    sql_statements.append("-- Criminals")
    sql_statements.append("INSERT INTO criminals (name, known_aliases, address) VALUES")
    criminal_values = []
    for i in range(50):
        name = f"{random.choice(first_names)} {random.choice(last_names)}"
        alias = random.choice([None, f"'{random.choice(['Rocky', 'Tiger', 'Don', 'Bhai', 'King'])}'"])
        address = f"{random.randint(1, 999)}, {random.choice(streets)}, {random.choice(cities)}"
        alias_val = "NULL" if alias is None else alias
        criminal_values.append(f"('{name}', {alias_val}, '{address}')")
    sql_statements.append(",\n".join(criminal_values) + ";")
    sql_statements.append("")

    # 3. Generate FIRs (50)
    # Use INSERT INTO ... SELECT to pick a random complainant and station
    sql_statements.append("-- FIRs")
    for i in range(50):
        crime = random.choice(crime_types)
        title = f"Reported {crime} incident"
        desc = f"Detailed report regarding {crime} that occurred at the mentioned location. Investigation required."
        date = random_date()
        place = f"{random.choice(streets)}, {random.choice(cities)}"
        status = random.choice(statuses)
        
        # We select 1 random complainant and 1 random station
        sql = f"""INSERT INTO firs (complainant_id, station_id, title, crime_type, description, date_of_incident, incident_place, status)
SELECT c.id, s.id, '{title}', '{crime}', '{desc}', '{date}', '{place}', '{status}'
FROM complainants c
JOIN police_stations s
ORDER BY RAND()
LIMIT 1;"""
        sql_statements.append(sql)
    sql_statements.append("")

    # 4. Link FIRs to Criminals (Randomly)
    sql_statements.append("-- FIR Criminal Links")
    # We want to insert ~40 links. 
    # We use IGNORE to skip duplicates if we accidentally pick the same pair.
    for i in range(40):
        sql = """INSERT IGNORE INTO fir_criminals (fir_id, criminal_id)
SELECT f.id, c.id
FROM firs f
JOIN criminals c
ORDER BY RAND()
LIMIT 1;"""
        sql_statements.append(sql)
    sql_statements.append("")

    # 5. Evidence
    sql_statements.append("-- Evidence")
    for i in range(40):
        etype = random.choice(evidence_types)
        desc = f"Collected {etype} from the scene."
        date = random_date()
        sql = f"""INSERT INTO evidence (fir_id, type, description, collected_on)
SELECT id, '{etype}', '{desc}', '{date}'
FROM firs
ORDER BY RAND()
LIMIT 1;"""
        sql_statements.append(sql)
    sql_statements.append("")
    
    # 6. Assign Officers
    sql_statements.append("-- Officer Assignments")
    for i in range(50):
        sql = """INSERT IGNORE INTO fir_officers (fir_id, officer_id)
SELECT f.id, o.id
FROM firs f
JOIN officers o
ORDER BY RAND()
LIMIT 1;"""
        sql_statements.append(sql)

    sql_statements.append("")
    sql_statements.append("SET FOREIGN_KEY_CHECKS=1;")
    
    return "\n".join(sql_statements)

if __name__ == "__main__":
    sql_content = generate_sql()
    with open("sql/dummy_data.sql", "w") as f:
        f.write(sql_content)
    print("Dummy data generated in sql/dummy_data.sql")

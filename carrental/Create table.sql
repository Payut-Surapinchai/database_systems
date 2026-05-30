-- CREATE Table Statements
-- Run this SQL code in the SQL tab before opening the index.php file

-- Create a Customer Table
CREATE TABLE Customer(
    id INT PRIMARY KEY,
    first_name VARCHAR(30),
    last_name VARCHAR(40),
    phone VARCHAR(15)
);

-- Create a Car Table
CREATE TABLE Car(
    Vid INT PRIMARY KEY,
    model VARCHAR(20),
    year INT,
    make VARCHAR(30),
    daily_rate DECIMAL(12,2),  -- 12 total numerical places with 2 decimal places
    weekly_rate DECIMAL(12,2),
    avail_start_date DATE,
    avail_end_date DATE
);

-- Create a Van Table
CREATE TABLE Van(
    Vid INT PRIMARY KEY,
    FOREIGN KEY (Vid) REFERENCES Car(Vid)
);

-- Create a Truck Table
CREATE TABLE Truck(
    Vid INT PRIMARY KEY,
    FOREIGN KEY (Vid) REFERENCES Car(Vid)
);
 
-- Create an SUV Table
CREATE TABLE SUV(
    Vid INT PRIMARY KEY,
    FOREIGN KEY (Vid) REFERENCES Car(Vid)
);

-- Create a Large Table
CREATE TABLE Large(
    Vid INT PRIMARY KEY,
    FOREIGN KEY (Vid) REFERENCES Car(Vid)
);

-- Create a Med Table
CREATE TABLE Med(
    Vid INT PRIMARY KEY,
    FOREIGN KEY (Vid) REFERENCES Car(Vid)
);

-- Create a Compact Table
CREATE TABLE Compact(
    Vid INT PRIMARY KEY,
    FOREIGN KEY (Vid) REFERENCES Car(Vid)
);

-- Create a Rental Table
CREATE TABLE Rental(
    id INT PRIMARY KEY,
    status VARCHAR(15),
    start_date DATE
);

-- Create a Rent Table
CREATE TABLE Rent(
    cust_id INT,
    Vid INT,
    Rid INT,
    PRIMARY KEY (cust_id, Vid, Rid),  -- Composite Primary Key
    FOREIGN KEY (cust_id) REFERENCES Customer(id),
    FOREIGN KEY (Vid) REFERENCES Car(Vid),
    FOREIGN KEY (Rid) REFERENCES Rental(id)
);

-- Create a Daily Table
CREATE TABLE Daily(
    Rid INT PRIMARY KEY,
    no_of_days INT,
    FOREIGN KEY (Rid) REFERENCES Rental(id)
);

-- Create a Weekly Table
CREATE TABLE Weekly(
    Rid INT PRIMARY KEY,
    no_of_weeks INT,
    FOREIGN KEY (Rid) REFERENCES Rental(id)
);

-- INSERT Values into Customer, Car (and their subtypes), Rental, Rent, Daily, and Weekly tables

-- In this section, apart from the Customer table, I used Claude AI to help me generate values and link values to their
-- respective tables. To be more specific, Claude helped me generated Car values, linked them to their respective subtypes, and
-- added them into Rent, Daily, and Weekly tables.

-- Insert Values into the Customer table (generated them myself)
INSERT INTO Customer (id, first_name, last_name, phone) 
VALUES
(1, "Doug", "Mincher", "790-555-5323"),
(2, "Kim", "Hun-nee", "999-345-2526"),
(3, "Plaku", "Bunach", "700-350-2000"),
(4, "Pluto", "Nicha", "600-298-3094"),
(5, "Fluke", "Luker", "200-355-6293"),
(6, "Yane", "Maou", "203-384-9485"),
(7, "June", "Tanker", "530-745-3928"),
(8, "Carol", "Miner", "928-203-2394"),
(9, "Cheux", "Pollo", "205-473-3502"),
(10, "Lily", "Monger", "393-979-8526");

-- Insert Values into the Car table 
INSERT INTO Car (Vid, model, year, make, daily_rate, weekly_rate, avail_start_date, avail_end_date) 
VALUES

-- Vans subtype
(1, 'Sienna', 2020, 'Toyota', 50.00, 300.00, '2024-01-01', '2024-12-31'),
(2, 'Odyssey', 2021, 'Honda', 55.00, 330.00, '2024-01-01', '2024-12-31'),
(3, 'Pacifica', 2022, 'Chrysler', 48.00, 288.00, '2024-01-01', '2024-12-31'),
(4, 'Transit', 2021, 'Ford', 60.00, 360.00, '2024-01-01', '2024-12-31'),
(5, 'Metris', 2020, 'Mercedes', 65.00, 390.00, '2024-01-01', '2024-12-31'),

-- Trucks subtype
(6, 'F-150', 2021, 'Ford', 75.00, 450.00, '2024-01-01', '2024-12-31'),
(7, 'Silverado', 2022, 'Chevrolet', 80.00, 480.00, '2024-01-01', '2024-12-31'),
(8, 'Tundra', 2023, 'Toyota', 78.00, 468.00, '2024-01-01', '2024-12-31'),
(9, '1500', 2021, 'RAM', 72.00, 432.00, '2024-01-01', '2024-12-31'),
(10, 'Sierra', 2022, 'GMC', 76.00, 456.00, '2024-01-01', '2024-12-31'),

-- SUVs subtype
(11, 'Tahoe', 2023, 'Chevrolet', 90.00, 540.00, '2024-01-01', '2024-12-31'),
(12, 'Explorer', 2022, 'Ford', 85.00, 510.00, '2024-01-01', '2024-12-31'),
(13, '4Runner', 2021, 'Toyota', 88.00, 528.00, '2024-01-01', '2024-12-31'),
(14, 'Grand Cherokee', 2023, 'Jeep', 92.00, 552.00, '2024-01-01', '2024-12-31'),
(15, 'Pilot', 2022, 'Honda', 83.00, 498.00, '2024-01-01', '2024-12-31'),

-- Large subtype 
(16, 'Avalon', 2021, 'Toyota', 65.00, 390.00, '2024-01-01', '2024-12-31'),
(17, 'Impala', 2020, 'Chevrolet', 60.00, 360.00, '2024-01-01', '2024-12-31'),
(18, 'Taurus', 2021, 'Ford', 62.00, 372.00, '2024-01-01', '2024-12-31'),
(19, '300', 2022, 'Chrysler', 68.00, 408.00, '2024-01-01', '2024-12-31'),
(20, 'Maxima', 2021, 'Nissan', 63.00, 378.00, '2024-01-01', '2024-12-31'),

-- Mid subtype
(21, 'Camry', 2022, 'Toyota', 55.00, 330.00, '2024-01-01', '2024-12-31'),
(22, 'Accord', 2021, 'Honda', 53.00, 318.00, '2024-01-01', '2024-12-31'),
(23, 'Fusion', 2020, 'Ford', 50.00, 300.00, '2024-01-01', '2024-12-31'),
(24, 'Altima', 2022, 'Nissan', 52.00, 312.00, '2024-01-01', '2024-12-31'),
(25, 'Sonata', 2021, 'Hyundai', 51.00, 306.00, '2024-01-01', '2024-12-31'),

-- Compact subtype 
(26, 'Corolla', 2022, 'Toyota', 40.00, 240.00, '2024-01-01', '2024-12-31'),
(27, 'Civic', 2021, 'Honda', 38.00, 228.00, '2024-01-01', '2024-12-31'),
(28, 'Focus', 2020, 'Ford', 35.00, 210.00, '2024-01-01', '2024-12-31'),
(29, 'Sentra', 2021, 'Nissan', 36.00, 216.00, '2024-01-01', '2024-12-31'),
(30, 'Elantra', 2022, 'Hyundai', 37.00, 222.00, '2024-01-01', '2024-12-31');

-- Put the values from the Car table into their respective subtypes 
INSERT INTO Van VALUES (1), (2), (3), (4), (5);
INSERT INTO Truck VALUES (6), (7), (8), (9), (10);
INSERT INTO SUV VALUES (11), (12), (13), (14), (15);
INSERT INTO Large VALUES (16), (17), (18), (19), (20);
INSERT INTO Med VALUES (21), (22), (23), (24), (25);
INSERT INTO Compact VALUES (26), (27), (28), (29), (30);

-- Add values into rental table 
INSERT INTO Rental (id, status, start_date) VALUES
(1, 'active',    '2024-11-01'),
(2, 'active',    '2024-11-05'),
(3, 'scheduled', '2024-12-01'),
(4, 'scheduled', '2024-12-10'),
(5, 'active',    '2024-11-10');

-- Link customers and car to a rental ID
INSERT INTO Rent (cust_id, Vid, Rid) VALUES
(1, 6,  1),   -- Doug rented Truck F-150
(2, 11, 2),   -- Kim rented SUV Tahoe
(3, 26, 3),   -- Plaku rented Compact Corolla
(4, 1,  4),   -- Pluto rented Van Sienna
(5, 21, 5);   -- Fluke rented Mid Camry

-- Add Daily rental details (3 rentals are daily)
INSERT INTO Daily (Rid, no_of_days) VALUES
(1, 5),    
(2, 3),
(5, 7); 

-- Add Weekly rental details (2 rentals are weekly)
INSERT INTO Weekly (Rid, no_of_weeks) VALUES
(3, 2),  
(4, 1); 
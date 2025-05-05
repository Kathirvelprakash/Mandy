CREATE DATABASE IF NOT EXISTS service_booking_db;

USE service_booking_db;

CREATE TABLE IF NOT EXISTS vehicles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  tire_info VARCHAR(255) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  service_name VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  email VARCHAR(150),
  phone VARCHAR(15),
  comments TEXT,
  services TEXT,
  vehicle TEXT,
  appointment_date DATE,
  appointment_time TIME,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO vehicles (name, tire_info) VALUES 
  ('2005 Audi TT Quattro Base', '18\" option'),
  ('2019 Mercedes-Benz CLS450 4Matic', '245/40R19 98 H');

INSERT INTO services (service_name) VALUES
  ('Check Engine Light'),
  ('Starting & Charging Systems'),
  ('Heating & Cooling Systems'),
  ('Electrical Systems'),
  ('Basic Battery Install'),
  ('Air Conditioning Systems'),
  ('Muffler and Exhaust Repair Shop');
CREATE DATABASE IF NOT EXISTS laundry_shop;
USE laundry_shop;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','staff') NOT NULL DEFAULT 'staff',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(100) NOT NULL,
  contact_number VARCHAR(20),
  address TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  service_name VARCHAR(100) NOT NULL,
  price_per_kg DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(100) NOT NULL,
  category VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  icon VARCHAR(20) DEFAULT '🧺',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  service_id INT NOT NULL,
  weight DECIMAL(10,2) NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  status ENUM('Pending','Washing','Drying','Ready','Claimed') DEFAULT 'Pending',
  order_date DATE NOT NULL,
  pickup_date DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
);

CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  amount_paid DECIMAL(10,2) NOT NULL,
  payment_status ENUM('Paid','Unpaid') DEFAULT 'Unpaid',
  payment_date DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- Plain-text admin password, no hashing.
INSERT INTO users (name, username, password, role) VALUES
('Administrator', 'admin', 'admin123', 'admin');

INSERT INTO services (service_name, price_per_kg) VALUES
('Wash Only', 50.00),
('Wash and Dry', 80.00),
('Wash, Dry and Fold', 100.00),
('Dry Clean', 150.00),
('Ironing', 60.00),
('Comforter Wash', 180.00),
('Shoe Cleaning', 120.00);

INSERT INTO products (product_name, category, price, stock, icon) VALUES
('Premium Laundry Detergent', 'Detergent', 180.00, 25, '🧴'),
('Fabric Conditioner', 'Fabric Care', 150.00, 30, '🌸'),
('Color Safe Bleach', 'Cleaning Supply', 120.00, 18, '✨'),
('Stain Remover Spray', 'Cleaning Supply', 95.00, 20, '🧽'),
('Laundry Basket', 'Laundry Equipment', 220.00, 12, '🧺'),
('Garment Hanger Set', 'Laundry Equipment', 85.00, 40, '👕'),
('Plastic Laundry Bag', 'Packaging', 8.00, 500, '🛍️'),
('Dryer Sheet Pack', 'Fabric Care', 110.00, 22, '⚡'),
('Shoe Cleaning Kit', 'Cleaning Supply', 250.00, 10, '👟'),
('Comforter Storage Bag', 'Packaging', 65.00, 35, '🛏️');

INSERT INTO customers (customer_name, contact_number, address) VALUES
('Juan Dela Cruz', '09123456789', 'Cebu City'),
('Maria Santos', '09987654321', 'Mandaue City');

INSERT INTO orders (customer_id, service_id, weight, total_amount, status, order_date, pickup_date) VALUES
(1, 1, 5.00, 250.00, 'Pending', CURDATE(), CURDATE()),
(2, 3, 3.00, 300.00, 'Ready', CURDATE(), CURDATE());

INSERT INTO payments (order_id, amount_paid, payment_status, payment_date) VALUES
(1, 250.00, 'Paid', CURDATE());

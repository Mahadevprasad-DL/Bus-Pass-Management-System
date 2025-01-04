CREATE DATABASE bus_management;

USE bus_management;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE bus_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
);

-- Create a separate table for pass types
CREATE TABLE bus_pass_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bus_category_id INT,
    pass_type ENUM('Monthly', 'Weekly', 'Yearly') NOT NULL,
    FOREIGN KEY (bus_category_id) REFERENCES bus_categories(id) ON DELETE CASCADE
);

-- Insert sample data into bus_categories table
INSERT INTO bus_categories (category_name)
VALUES
    ('AC BUS'),
    ('Non AC BUS'),
    ('Volvo BUS'),
    ('Delux BUS'),
    ('KSRTC BUS'),
    ('City BUS');

-- Insert sample pass types for each category
INSERT INTO bus_pass_types (bus_category_id, pass_type)
VALUES
    (1, 'Monthly'),
    (1, 'Weekly'),
    (1, 'Yearly'),
    (2, 'Monthly'),
    (2, 'Weekly'),
    (2, 'Yearly'),
    (3, 'Monthly'),
    (3, 'Weekly'),
    (3, 'Yearly'),
    (4, 'Monthly'),
    (4, 'Weekly'),
    (4, 'Yearly'),
    (5, 'Monthly'),
    (5, 'Weekly'),
    (5, 'Yearly'),
    (6, 'Monthly'),
    (6, 'Weekly'),
    (6, 'Yearly');

    CREATE TABLE bus_pass_applications (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     full_name VARCHAR(100) NOT NULL,
    ->     contact_number VARCHAR(15) NOT NULL,
    ->     email VARCHAR(100) NOT NULL,
    ->     identity_type VARCHAR(50) NOT NULL,
    ->     identity_number VARCHAR(50) NOT NULL,
    ->     source VARCHAR(100) NOT NULL,
    ->     destination VARCHAR(100) NOT NULL,
    ->     pass_type VARCHAR(50) NOT NULL,
    ->     start_date DATE NOT NULL,
    ->     end_date DATE NOT NULL,
    ->     cost DECIMAL(10, 2) NOT NULL
    -> );

ALTER TABLE bus_pass_applications ADD COLUMN profile_image VARCHAR(255);

ALTER TABLE bus_pass_applications ADD COLUMN category_name VARCHAR(255);

ALTER TABLE bus_pass_applications ADD status VARCHAR(50) NULL;


CREATE TABLE complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    place VARCHAR(100) NOT NULL,
    complaint TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE users
CHANGE COLUMN username full_name VARCHAR(100) NOT NULL;

SELECT * FROM users WHERE full_name = 'YourFullName';


CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    username VARCHAR(50) NOT NULL,
    source VARCHAR(50) NOT NULL,
    destination VARCHAR(50) NOT NULL,
    time_date DATETIME NOT NULL,
    num_seats INT NOT NULL,
    price FLOAT NOT NULL,
    phone VARCHAR(15) NOT NULL,
    bus_number VARCHAR(15) NOT NULL
);

ALTER TABLE bus_pass_applications
ADD COLUMN passnum VARCHAR(50) NOT NULL AFTER id;

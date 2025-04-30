CREATE DATABASE IF NOT EXISTS qless;
USE qless;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'driver') NOT NULL
);

CREATE TABLE slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slot_time TIME NOT NULL,
    is_booked BOOLEAN DEFAULT FALSE
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    slot_id INT NOT NULL,
    container_type VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (slot_id) REFERENCES slots(id) ON DELETE CASCADE
);

INSERT INTO slots (slot_time) VALUES
('08:00:00'), ('08:30:00'), ('09:00:00'), ('09:30:00'),
('10:00:00'), ('10:30:00'), ('11:00:00'), ('11:30:00'),
('13:00:00'), ('13:30:00'), ('14:00:00'), ('14:30:00');

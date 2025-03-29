-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS todolist;

-- Use the database
USE todolist;

-- Create images table if it doesn't exist
CREATE TABLE IF NOT EXISTS images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_name VARCHAR(255) NOT NULL,
    upload_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
); 
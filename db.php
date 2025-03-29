<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todolist";

// Check if mysqli extension is loaded
if (!extension_loaded('mysqli')) {
    die('MySQLi extension is not loaded. Please enable it in php.ini');
}

try {
    // First connect without database selected
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if (!$conn->query($sql)) {
        throw new Exception("Error creating database: " . $conn->error);
    }

    // Close the connection
    $conn->close();

    // Now connect with the database selected
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set charset to utf8mb4
    $conn->set_charset("utf8mb4");

    // Create images table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        image_name VARCHAR(255) NOT NULL,
        upload_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating table: " . $conn->error);
    }

    // Check if upload_date column exists, if not add it
    $result = $conn->query("SHOW COLUMNS FROM images LIKE 'upload_date'");
    if ($result->num_rows == 0) {
        $sql = "ALTER TABLE images ADD COLUMN upload_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP";
        if (!$conn->query($sql)) {
            throw new Exception("Error adding upload_date column: " . $conn->error);
        }
    }

} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}
?>

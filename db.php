<?php
// Check if mysqli extension is loaded
if (!extension_loaded('mysqli')) {
    die('mysqli extension is not loaded. Please enable it in php.ini');
}

$servername = "localhost"; // or your server IP
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "couple_images"; // your database name

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set charset to utf8mb4
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>

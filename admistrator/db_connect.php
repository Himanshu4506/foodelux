<?php
$host     = "localhost";         // Server name
$username = "root";              // Default XAMPP username
$password = "";                  // Default XAMPP password (blank)
$database = "foodeluxe";      // Apna actual database name

$conn = new mysqli($host, $username, $password, $database);

// Connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

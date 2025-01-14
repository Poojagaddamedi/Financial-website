<?php
// db.php - To connect to the MySQL database
$host = "localhost";  // MySQL server
$user = "root";       // Your database username (default for XAMPP is 'root')
$pass = "";           // Your database password (default for XAMPP is empty)
$dbname = "financial_analysis";  // Name of your database (replace with actual name)

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

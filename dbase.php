
<?php
// db.php - To connect to the MySQL database
$host = "localhost";  // MySQL server
$user = "root";       // Your database username
$pass = "";           // Default password is empty
$dbname = "financial_analysis";  // Your actual database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>



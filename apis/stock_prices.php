<?php
// Ensure no output before headers
ob_clean(); // Clean output buffer to avoid any unwanted HTML output

// Enable error reporting for debugging (remove this in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set Content-Type header to application/json for JSON response
header('Content-Type: application/json');

// Include database connection file
include("../dbase.php");

// Get company_id and date from the request (sanitize inputs)
$company_id = isset($_GET['company_id']) ? intval($_GET['company_id']) : 0;
$date = isset($_GET['date']) ? $_GET['date'] : '';  // Expect format: YYYY-MM-DD

// Validate inputs
if ($company_id <= 0 || empty($date)) {
    // Return error as JSON if invalid company_id or date
    echo json_encode(["error" => "Invalid company_id or date provided."]);
    exit; // Exit after sending the error to prevent further output
}

// Query to fetch stock prices for the specified company and date
$sql = "SELECT * FROM stock_prices WHERE company_id = $company_id AND DATE(date) = '$date'";
$result = $conn->query($sql);

// Check if the query was successful and data is found
if ($result && $result->num_rows > 0) {
    $data = [];
    // Fetch all results and store them in the array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    // Return the data as JSON
    echo json_encode($data);
    exit; // Exit after sending the JSON response to prevent further output
} else {
    // Return error if no data is found
    echo json_encode(["error" => "Stock data not found for this company and date"]);
    exit; // Exit after sending the error
}

// Close the database connection
$conn->close();
?>

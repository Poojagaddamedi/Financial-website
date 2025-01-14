<?php
// Ensure no output before headers
ob_clean(); // Clean output buffer to avoid any unwanted HTML output

// Enable error reporting for debugging (remove this in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set Content-Type header to application/json for JSON response
header('Content-Type: application/json');

// Include the database connection file
include("../dbase.php");

// Get company_id and year from the request (use default 0 if not set)
$company_id = isset($_GET['company_id']) ? intval($_GET['company_id']) : 0;
$year = isset($_GET['year']) ? intval($_GET['year']) : 0;

// Validate the inputs
if ($company_id <= 0 || $year <= 0) {
    // Return error as JSON if invalid company_id or year
    echo json_encode(["error" => "Invalid company_id or year provided."]);
    exit; // Exit after sending the error to prevent further output
}

// Query to fetch cash flow data
$sql = "SELECT operating_cash_flow, investing_cash_flow, financing_cash_flow 
        FROM cash_flow 
        WHERE company_id = $company_id AND year = $year";
$result = $conn->query($sql);

// Check if the query was successful and data is found
if ($result && $result->num_rows > 0) {
    // Fetch the data
    $data = $result->fetch_assoc();
    // Return the data as JSON
    echo json_encode($data);
    exit; // Exit after sending the JSON response to prevent further output
} else {
    // Return error if no data is found
    echo json_encode(["error" => "Data not found for this company and year"]);
    exit; // Exit after sending the error
}

// Close the database connection
$conn->close();
?>

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

// Get company_id and document_type from the request (sanitize inputs)
$company_id = isset($_GET['company_id']) ? intval($_GET['company_id']) : 0;
$document_type = isset($_GET['document_type']) ? trim($_GET['document_type']) : '';

// Validate inputs
if ($company_id <= 0 || empty($document_type)) {
    // Return error as JSON if invalid company_id or document_type
    echo json_encode(["error" => "Invalid company_id or document_type provided."]);
    exit; // Exit after sending the error to prevent further output
}

// Ensure that the document_type is properly escaped
$document_type = $conn->real_escape_string($document_type);

// Query to fetch documents
$sql = "SELECT * FROM documents WHERE company_id = $company_id AND LOWER(document_type) = LOWER('$document_type')";
$result = $conn->query($sql);

// Check if the query was successful and data is found
if ($result && $result->num_rows > 0) {
    $data = [];
    // Fetch all results and store them in an array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;  // Push each row into the array
    }
    // Return the data as JSON
    echo json_encode($data);
    exit; // Exit after sending the JSON response to prevent further output
} else {
    // Return error if no data is found
    echo json_encode(["error" => "Document not found for this company"]);
    exit; // Exit after sending the error
}

// Close the database connection
$conn->close();
?>

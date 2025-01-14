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

// Get company_id and media_type from the request (sanitize inputs)
$company_id = isset($_GET['company_id']) ? intval($_GET['company_id']) : 0;
$media_type = isset($_GET['media_type']) ? trim($_GET['media_type']) : '';

// Validate inputs
if ($company_id <= 0 || empty($media_type)) {
    // Return error as JSON if invalid company_id or media_type
    echo json_encode(["error" => "Invalid company_id or media_type provided."]);
    exit; // Exit after sending the error to prevent further output
}

// Ensure that the media_type is properly escaped
$media_type = $conn->real_escape_string($media_type);

// Query to fetch media files
$sql = "SELECT media_name, media_url, upload_date 
        FROM media 
        WHERE company_id = $company_id 
        AND LOWER(media_type) = LOWER('$media_type')";
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
    echo json_encode(["error" => "Media not found for this company and media type"]);
    exit; // Exit after sending the error
}

// Close the database connection
$conn->close();
?>

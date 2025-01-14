<?php
// Include database connection file
include("../dbase.php");

// Get company_id and year from the request
$company_id = isset($_GET['company_id']) ? intval($_GET['company_id']) : 0;
$year = isset($_GET['year']) ? intval($_GET['year']) : 0;

// Validate inputs
if ($company_id <= 0 || $year <= 0) {
    echo json_encode(["error" => "Invalid company_id or year provided."]);
    exit;
}

// Query to fetch balance sheet data
$sql = "SELECT assets, liabilities, equity FROM balance_sheet WHERE company_id = $company_id AND year = $year";
$result = $conn->query($sql);

// Check if data is found
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);  // Return data as JSON
} else {
    echo json_encode(["error" => "Data not found for this company and year"]);
}
?>

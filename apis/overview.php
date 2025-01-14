<!--?php
// Disable error reporting in production
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

try {
    // Clear output buffer
    if (ob_get_length()) {
        ob_end_clean();
    }

    // Set Content-Type to application/json
    header('Content-Type: application/json');

    // Include database connection
    include("../dbase.php");

    // Validate and sanitize input
    $company_id = filter_input(INPUT_GET, 'company_id', FILTER_VALIDATE_INT);
    if (!$company_id) {
        echo json_encode(["error" => "Invalid Company ID"]);
        exit;
    }

    // Fetch company data
    $sql = "SELECT * FROM overview WHERE company_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Return JSON response
    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["error" => "Company not found"]);
    }

    // End the script cleanly
    exit;
} catch (Exception $e) {
    // Handle errors gracefully
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
    exit;
}
?-->
<?php
// Disable error reporting in production
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

try {
    // Clear output buffers
    while (ob_get_level()) {
        ob_end_clean();
    }

    // Set Content-Type to application/json
    header('Content-Type: application/json');

    // Include database connection
    include("../dbase.php");

    // Validate and sanitize input
    $company_id = filter_input(INPUT_GET, 'company_id', FILTER_VALIDATE_INT);
    if (!$company_id) {
        echo json_encode(["error" => "Invalid Company ID"]);
        exit;
    }

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM overview WHERE company_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["error" => "Database Error"]);
        exit;
    }
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Return JSON response
    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["error" => "Company not found"]);
    }

    // End the script cleanly
    exit;
} catch (Exception $e) {
    // Handle errors gracefully
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
    exit;
}
?>

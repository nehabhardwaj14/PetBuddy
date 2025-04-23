<?php
include 'db_connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Safety check
    if (!isset($_POST['request_id']) || !isset($_POST['status'])) {
        echo json_encode([
            "success" => false,
            "message" => "Missing request_id or status"
        ]);
        exit;
    }

    $request_id = intval($_POST['request_id']);
    $status = trim($_POST['status']);

    // Validate input
    if (empty($status) || $request_id <= 0 || !in_array($status, ['Approved', 'Rejected'])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid request_id or status. Status must be either 'Approved' or 'Rejected'."
        ]);
        exit;
    }

    // Update the adoption request status in the database
    $sql = "UPDATE adoption_requests SET status = ?, request_date = NOW() WHERE request_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "SQL Prepare Failed: " . $conn->error
        ]);
        exit;
    }

    // Bind the parameters
    $stmt->bind_param("si", $status, $request_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if any row was affected (meaning status was updated)
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                "success" => true,
                "message" => "Status updated successfully to " . $status
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "No matching request_id found or status already set."
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Execute Failed: " . $stmt->error
        ]);
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method. Use POST."
    ]);
}
?>

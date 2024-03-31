<?php
// Include your database connection file (e.g., db_con.php)
include 'db_con.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if joinEvent_id is set in the POST data
    if (isset($_POST['joinEvent_id'])) {
        $joinEventId = $_POST['joinEvent_id'];
        // Assuming you have sanitized the input and prevented SQL injection

        // Update the status in the joinEvent table
        $updateSql = "UPDATE joinevent SET status = 1 WHERE joinEvent_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("i", $joinEventId);
        $stmt->execute();

        // Check if update was successful
        if ($stmt->affected_rows > 0) {
            // Insert record into attendees table
            $insertSql = "INSERT INTO attendees (user_id, event_id) SELECT user_id, event_id FROM joinevent WHERE joinEvent_id = ?";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("i", $joinEventId);
            $insertStmt->execute();

            // Check if insert was successful
            if ($insertStmt->affected_rows > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to insert record into attendees table']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update status in joinevent table']);
        }
    } else {
        echo json_encode(['error' => 'joinEvent_id not provided']);
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>

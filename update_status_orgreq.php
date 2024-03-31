<?php
// Include your database connection file here
include 'db_con.php'; // Adjust the path if necessary

// Handle POST request to update request status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive request_id and new_status in the POST request
    $request_id = $_POST['user_id'];
    $new_status = $_POST['new_status'];


    // Prepare and execute the SQL query to update the status of the request
    $stmt = $conn->prepare("UPDATE requests SET approved = ? WHERE user_id = ?");
    $stmt->bind_param("ii", $new_status, $request_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Update successful
        echo json_encode(['success' => true]);
    } else {
        // Update failed
        echo json_encode(['success' => false, 'message' => 'Failed to update request status']);
    }

    // Close statement
    $stmt->close();
} else {
    // Handle invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

<?php
// Include your database connection file here
include 'db_con.php'; // Adjust the path if necessary

// Handle POST request to add new request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive user_id, dateTime, and approved status in the POST request
    $user_id = $_POST['user_id'];
    $approved = $_POST['approved'];

    $dateTime = date('Y-m-d H:i:s');

    // Prepare and execute the SQL query to insert a new record
    $stmt = $conn->prepare("INSERT INTO requests (user_id, dateTime, approved) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $dateTime, $approved);
    $stmt->execute();

    // Check if the record was successfully inserted
    if ($stmt->affected_rows > 0) {
        // Record inserted successfully
        echo json_encode(['success' => true]);
    } else {
        // Failed to insert record
        echo json_encode(['success' => false, 'message' => 'Failed to add request']);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

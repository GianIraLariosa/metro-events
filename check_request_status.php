<?php
// Include your database connection file here
include 'db_con.php'; // Adjust the path if necessary

// Handle POST request to check request status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive user_id in the POST request
    $user_id = $_POST['user_id'];

    // Prepare and execute the SQL query to fetch the status of the request for the user_id
    $stmt = $conn->prepare("SELECT approved FROM requests WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the status from the first (and only) row
        $row = $result->fetch_assoc();
        $status = $row['approved'];
        $requestSent = true;
    } else {
        // No request found for the user_id
        $status = null;
        $requestSent = false;
    }

    // Return the status as JSON
    header('Content-Type: application/json');
    echo json_encode(['requestSent' => $requestSent, 'status' => $status]);
} else {
    // Handle invalid request method
    echo json_encode(['error' => 'Invalid request method']);
}
?>

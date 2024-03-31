<?php
include 'db_con.php';

// Check if user_id exists in the requests table
function checkUser($user_id) {
    include 'db_con.php';

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT * FROM requests WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        return true; // User ID exists in the table
    } else {
        return false; // User ID does not exist in the table
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

// Handle POST request to check user ID
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive user_id in the POST request
    $user_id = $_POST['user_id'];

    // Check if user ID exists
    $userExists = checkUser($user_id);

    // Return the result as JSON
    header('Content-Type: application/json');
    echo json_encode(['userExists' => $userExists]);
}
?>

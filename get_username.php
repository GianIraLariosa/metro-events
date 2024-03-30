<?php
include 'db_con.php';

// Check if user_id parameter is provided in the request
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Perform a SELECT query to fetch user name based on user_id
    $query = "SELECT user_name FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id); // Assuming user_id is an integer
    $stmt->execute();
    $stmt->bind_result($user_name);
    $stmt->fetch();

    if($user_name !== null) {
        // Return user name as JSON response
        echo json_encode(array('user_name' => $user_name));
    } else {
        // User not found
        http_response_code(404);
        echo json_encode(array('message' => 'User not found.'));
    }
} else {
    // Invalid request, user_id parameter not provided
    http_response_code(400);
    echo json_encode(array('message' => 'Invalid request. User ID parameter is missing.'));
}
?>

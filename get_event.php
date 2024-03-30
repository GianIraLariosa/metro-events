<?php
include 'db_con.php';

// Check if user_id parameter is provided in the request
if(isset($_GET['event_id'])) {
    $user_id = $_GET['event_id'];

    // Perform a SELECT query to fetch all data based on user_id
    $query = "SELECT * FROM event WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id); // Assuming user_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        // Fetch all data associated with the user_id
        $user_data = $result->fetch_assoc();

        // Return user data as JSON response
        echo json_encode($user_data);
    } else {
        // User not found
        http_response_code(404);
        echo json_encode(array('message' => 'Event not found.'));
    }
} else {
    // Invalid request, user_id parameter not provided
    http_response_code(400);
    echo json_encode(array('message' => 'Invalid request. User ID parameter is missing.'));
}
?>

<?php
include 'db_con.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID from the POST data and sanitize it
    $userid = isset($_POST['userid']) ? intval($_POST['userid']) : 0;

    if ($userid <= 0) {
        // Invalid user ID provided
        http_response_code(400); // Bad Request
        echo json_encode(array('success' => false, 'message' => 'Invalid user ID.'));
        exit;
    }

    // Check if the user exists
    $stmt = $pdo->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // User does not exist
        http_response_code(404); // Not Found
        echo json_encode(array('success' => false, 'message' => 'User not found.'));
        exit;
    }

    // Perform any necessary validation or authentication here

    // Simulate processing the request
    // In a real application, you would likely insert this request into a database
    $success = true; // Assume success

    // Prepare the response
    $response = array();

    if ($success) {
        $response['success'] = true;
        $response['message'] = "Request to become an organizer has been submitted successfully.";
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to submit request to become an organizer.";
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If the request method is not POST, return an error
    http_response_code(405); // Method Not Allowed
    echo "Method Not Allowed";
}
?>

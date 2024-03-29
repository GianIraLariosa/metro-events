<?php
include 'db_con.php'; // Include your database connection file

// Initialize response array
$response = array();

// Check if event_id parameter is provided
if(isset($_GET['event_id'])) {
    // Sanitize the input to prevent SQL injection
    $event_id = intval($_GET['event_id']);

    // Prepare and execute SQL query to retrieve comments for the given event ID
    $stmt = $pdo->prepare("SELECT comments FROM comments WHERE event_id = ?");
    $stmt->execute([$event_id]);

    // Fetch comments from the database
    $comments = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Check if comments were fetched successfully
    if ($comments !== false) {
        // Prepare the response
        $response = [
            'success' => true,
            'comments' => $comments
        ];
    } else {
        // If comments fetching failed, set error message
        $response = [
            'success' => false,
            'message' => 'Failed to fetch comments for the event.'
        ];
    }
} else {
    // If event_id parameter is not provided, send an error response
    $response = [
        'success' => false,
        'message' => 'Event ID parameter is missing.'
    ];
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection if necessary
$pdo = null;
?>

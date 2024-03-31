<?php
include 'db_con.php';

// Check if event_id is sent via POST
if(isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // SQL query to retrieve attendees' usernames for the given event ID
    $sql = "SELECT u.user_name 
            FROM attendees a 
            INNER JOIN user u ON a.user_id = u.user_id 
            WHERE a.event_id = $event_id";

    $result = $conn->query($sql);

    $userList = array();

    if ($result->num_rows > 0) {
        // Fetch data and store in array
        while ($row = $result->fetch_assoc()) {
            $userList[] = $row;
        }
    }

    // Close connection
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($userList);
} else {
    // Invalid request, event_id not provided
    echo "Invalid request: event_id not provided";
}
?>

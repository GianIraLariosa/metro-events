<?php

include 'db_con.php'; // Include your database connection file

// Check if userid, eventid, organizer_id, and dateTime are provided in the request
if(isset($_POST['user_id']) && isset($_POST['eventid']) && isset($_POST['organizer_id'])) {
    $userid = $_POST['user_id'];
    $eventid = $_POST['eventid'];
    $orgid = $_POST['organizer_id'];
    $dateTime = date('Y-m-d H:i:s'); // Get the current timestamp in the format 'YYYY-MM-DD HH:MM:SS'
    
    // Check if the user is already joined to the event
    $check_query = "SELECT * FROM joinevent WHERE user_id = $userid AND event_id = $eventid";
    $check_result = $conn->query($check_query);
    
    if($check_result->num_rows == 0) {
        // If the user is not already joined, insert into the join_events table with dateTime
        $insert_query = "INSERT INTO joinevent (user_id, event_id, organizer_id, status, dateTime) VALUES ('$userid', '$eventid', '$orgid', '0', '$dateTime')";
        if ($conn->query($insert_query) === TRUE) {
            echo json_encode(array("success" => true, "message" => "User joined event successfully."));
        } else {
            echo json_encode(array("success" => false, "message" => "Failed to join event. Please try again later."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "User is already joined to the event."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Userid, eventid, organizer_id, and dateTime are required."));
}

$conn->close();


?>

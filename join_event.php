<?php

include 'db_con.php'; // Include your database connection file

// Check if userid and eventid are provided in the request
if(isset($_POST['user_id']) && isset($_POST['eventid'])) {
    $userid = $_POST['user_id'];
    $eventid = $_POST['eventid'];

    // Check if the user is already joined to the event
    $check_query = "SELECT * FROM joinevent WHERE user_id = $userid AND event_id = $eventid";
    $check_result = $conn->query($check_query);
    
    if($check_result->num_rows == 0) {
        // If the user is not already joined, insert into the join_events table
        $insert_query = "INSERT INTO joinevent (user_id, event_id, status) VALUES ('$userid', '$eventid', '0')";
        if ($conn->query($insert_query) === TRUE) {
            echo json_encode(array("success" => true, "message" => "User joined event successfully."));
        } else {
            echo json_encode(array("success" => false, "message" => "Failed to join event. Please try again later."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "User is already joined to the event."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Userid and eventid are required."));
}

$conn->close();

?>

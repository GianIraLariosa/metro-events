<?php
include 'db_con.php';

// Check if user_id and event_id are provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id']) && isset($_GET['event_id'])) {
    $user_id = $_GET['user_id'];
    $event_id = $_GET['event_id'];

    // Validate user_id and event_id (ensure they exist in their respective tables)
    $sql_check_user = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result_check_user = $conn->query($sql_check_user);

    $sql_check_event = "SELECT * FROM event WHERE event_id = '$event_id'";
    $result_check_event = $conn->query($sql_check_event);

    if ($result_check_user->num_rows > 0 && $result_check_event->num_rows > 0) {
        // User and event exist, proceed with inserting into attendees table
        $sql_insert_attendee = "INSERT INTO attendees (users_id, event_id) VALUES ('$user_id', '$event_id')";
        if ($conn->query($sql_insert_attendee) === TRUE) {
            echo "New record created successfully in attendees table";
        } else {
            echo "Error creating record in attendees table: " . $conn->error;
        }
    } else {
        echo "User with ID $user_id or event with ID $event_id does not exist";
    }

    $conn->close();
} else {
    echo "user_id or event_id not provided";
}
?>

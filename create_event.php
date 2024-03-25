<?php
include 'db_con.php';

// Check if event_name, organizer_id, and event_description are provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['event_name']) && isset($_GET['organizer_id']) && isset($_GET['event_description'])) {
    $event_name = $_GET['event_name'];
    $organizer_id = $_GET['organizer_id'];
    $event_description = $_GET['event_description'];

    // Validate organizer_id (ensure it exists in the users table)
    $sql_check_organizer = "SELECT * FROM organizer WHERE organizer_id = '$organizer_id'";
    $result_check_organizer = $conn->query($sql_check_organizer);

    if ($result_check_organizer->num_rows > 0) {
        // Organizer exists, proceed with inserting into events table
        $sql_insert_event = "INSERT INTO event (event_name, organizer, event_description) VALUES ('$event_name', '$organizer_id', '$event_description')";
        if ($conn->query($sql_insert_event) === TRUE) {
            echo "New event created successfully";
        } else {
            echo "Error creating event: " . $conn->error;
        }
    } else {
        echo "Organizer with ID $organizer_id does not exist";
    }

    $conn->close();
} else {
    echo "event_name, organizer_id, or event_description not provided";
}
?>

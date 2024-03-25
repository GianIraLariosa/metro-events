<?php
include 'db_con.php';

// Check if POST data is provided
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check for event_name parameter
    if (!empty($_POST['event_name'])) {
        $event_name = $_POST['event_name'];
    } else {
        die("Error: event_name not provided");
    }

    // Check for organizer_id parameter
    if (!empty($_POST['organizer'])) {
        $organizer_id = $_POST['organizer'];
    } else {
        die("Error: organizer_id not provided");
    }

    // Check for event_description parameter
    if (!empty($_POST['event_description'])) {
        $event_description = $_POST['event_description'];
    } else {
        die("Error: event_description not provided");
    }

    // Check for event_datetime parameter
    if (!empty($_POST['event_datetime'])) {
        $event_datetime = $_POST['event_datetime'];
    } else {
        die("Error: event_datetime not provided");
    }

    // Proceed with inserting into events table
    // Validate organizer_id (ensure it exists in the users table)
    $sql_check_organizer = "SELECT * FROM organizer WHERE organizer_id = '$organizer_id'";
    $result_check_organizer = $conn->query($sql_check_organizer);

    if ($result_check_organizer->num_rows > 0) {
        // Organizer exists, proceed with inserting into events table
        $sql_insert_event = "INSERT INTO event (event_name, organizer, event_description, event_datetime) VALUES ('$event_name', '$organizer_id', '$event_description', '$event_datetime')";
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
    echo "No POST data received";
}
?>

<?php
include 'db_con.php'; // Include your database connection file

// Check if organizer_id and event_id are provided in the POST request
if(isset($_POST['organizer_id']) && isset($_POST['event_id'])) {
    // Get organizer_id and event_id from POST request
    $org_id = $_POST['organizer_id'];
    $event_id = $_POST['event_id'];

    // Prepare SQL statement with placeholders for organizer_id and event_id parameters
    $sql = "SELECT * FROM joinevent WHERE organizer_id = ? AND event_id = ?";

    // Prepare the SQL statement and bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $org_id, $event_id); // Assuming organizer_id and event_id are integers, use "i" for integer parameter

    // Execute the prepared statement
    $stmt->execute();

    // Get the result set from the executed statement
    $result = $stmt->get_result();

    $events = [];

    // Fetch events and add them to the $events array
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    // Close the prepared statement
    $stmt->close();

    // Close database connection
    $conn->close();

    // Return JSON response containing events
    header('Content-Type: application/json');
    echo json_encode($events);
} else {
    // Return error message if organizer_id or event_id is not provided
    echo json_encode(array("success" => false, "message" => "Organizer_id and Event_id are required."));
}
?>

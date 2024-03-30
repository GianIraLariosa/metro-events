<?php
include 'db_con.php'; // Include your database connection file

// Fetch upvotes count for each event
$query = "SELECT event_id, COUNT(*) as upvotes FROM upvotes GROUP BY event_id";
$result = mysqli_query($conn, $query);

$response = array();

if (!$result) {
    echo json_encode(array("success" => false, "message" => "Failed to fetch upvotes."));
} else {
    $upvotes = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $upvotes[$row['event_id']] = $row['upvotes'];
    }

    // Fetch events from the database
    $sql = "SELECT * FROM event WHERE status = 1";
    $eventsResult = mysqli_query($conn, $sql);

    if ($eventsResult && mysqli_num_rows($eventsResult) > 0) {
        // Output data of each row
        while ($row = mysqli_fetch_assoc($eventsResult)) {
            $eventId = $row["event_id"];
            $event = array(
                "id" => $eventId,
                "name" => $row["event_name"],
                "description" => $row["event_description"],
                "date" => $row["event_datetime"],
                "upvotes" => isset($upvotes[$eventId]) ? $upvotes[$eventId] : 0 // Assign upvotes count if available, otherwise 0
            );
            $response[] = $event;
        }
        echo json_encode(array("success" => true, "events" => $response));
    } else {
        echo json_encode(array("success" => false, "message" => "No events found."));
    }
}

// Close the database connection if necessary
mysqli_close($conn);
?>

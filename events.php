<?php
include 'db_con.php'; // Include your database connection file

// Fetch events from the database
$sql = "SELECT * FROM event where status = 1";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $event = array(
            "id" => $row["event_id"],
            "name" => $row["event_name"],
            "description" => $row["event_description"],
            "date" => $row["event_datetime"],
        );
        $response[] = $event;
    }
    echo json_encode(array("success" => true, "events" => $response));
} else {
    echo json_encode(array("success" => false, "message" => "No events found."));
}

$conn->close();
?>

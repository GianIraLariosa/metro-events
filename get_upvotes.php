<?php
include 'db_con.php'; // Include your database connection file

// Check if the event_id is provided via GET or POST request
if (isset($_REQUEST["event_id"])) {
    // Retrieve the event_id from the request
    $eventId = $_REQUEST["event_id"];

    // Prepare the SQL statement to get the upvotes count for the specific event_id
    $query = "SELECT COUNT(*) AS upvotes FROM upvotes WHERE event_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind the event_id parameter
    mysqli_stmt_bind_param($stmt, "i", $eventId);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result variables
    mysqli_stmt_bind_result($stmt, $upvotes);

    // Fetch the result
    mysqli_stmt_fetch($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Output the upvotes count
    echo json_encode(array("success" => true, "upvotes" => $upvotes));
} else {
    // If event_id is not provided
    echo json_encode(array("success" => false, "message" => "Event ID not provided."));
}

// Close the database connection
mysqli_close($conn);
?>

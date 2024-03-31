<?php
// Include the conn.php file to establish the database connection
include 'db_con.php';
// Assuming database connection is established

if (isset($_POST['eventid']) && isset($_POST['reason'])) {
    $eventId = $_POST['eventid'];
    $reason = $_POST['reason'];
    
    // Perform cancellation operation, for example:
    $query = "UPDATE event SET status = 0, cancel_reason = '$reason' WHERE event_id = $eventId";
    
    if (mysqli_query($conn, $query)) {
        echo "Event cancelled successfully";
    } else {
        echo "Error cancelling event: " . mysqli_error($conn);
    }
} else {
    echo "Event ID or reason not provided";
}
?>
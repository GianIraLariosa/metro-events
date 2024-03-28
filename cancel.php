<?php
// Include the conn.php file to establish the database connection
include 'db_con.php';
// Assuming database connection is established

if (isset($_POST['eventid'])) {
    $eventId = $_POST['eventid'];
    
    // Perform cancellation operation, for example:
    $query = "UPDATE event SET status = 0 WHERE event_id = $eventId";
    
    if (mysqli_query($conn, $query)) {
        echo "Event cancelled successfully";
    } else {
        echo "Error cancelling event: " . mysqli_error($conn);
    }
} else {
    echo "Event ID not provided";
}
?>

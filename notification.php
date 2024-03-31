<?php
// Include the db_con.php file to establish the database connection
include 'db_con.php';

// Assuming database connection is established

if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    
    // Query to fetch event name and cancel reason based on user_id
    $query = "SELECT event.event_name, event.cancel_reason FROM event 
              JOIN joinevent ON event.event_id = joinevent.event_id
              WHERE joinevent.user_id = $userId AND event.status = 0";
    
    // Execute the query
    $result = mysqli_query($conn, $query);
    
    // Check if the query was successful
    if ($result) {
        $events = array(); // Array to store events
        
        // Fetch data from the result set
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row; // Add each event to the events array
        }
        
        // Encode the events array into JSON format and echo it
        echo json_encode($events);
    } else {
        // If the query fails, echo an error message
        echo "Error fetching events: " . mysqli_error($conn);
    }
} else {
    // If user_id is not provided, echo an error message
    echo "User ID not provided";
}
?>

<?php
// Include your database connection file
include 'db_con.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required parameters are set
    if (isset($_POST['user_id']) && isset($_POST['eventid']) && isset($_POST['comment'])) {
        $user_id = $_POST['user_id'];
        $event_id = $_POST['eventid'];
        $comment = $_POST['comment'];

        // Insert the comment into the database
        $query = "INSERT INTO comments (user_id, event_id, comments) VALUES ('$user_id', '$event_id', '$comment')";
        if (mysqli_query($conn, $query)) {
            echo "Comment recorded successfully";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Missing parameters";
    }
} else {
    echo "Invalid request method";
}
?>

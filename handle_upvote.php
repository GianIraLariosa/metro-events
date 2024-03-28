<?php
include 'db_con.php'; // Include your database connection file

// Check if the user_id and eventid are received via POST request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_id"]) && isset($_POST["eventid"])) {
    // Include the database connection file
    
    // Retrieve user_id and eventid from POST data
    $userId = $_POST["user_id"];
    $eventId = $_POST["eventid"];

    // Prepare a SQL statement to check if the user has already upvoted this event
    $sql_check = "SELECT * FROM upvotes WHERE user_id = ? AND event_id = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        // Bind the parameters
        $stmt_check->bind_param("ii", $userId, $eventId);

        // Execute the statement
        $stmt_check->execute();

        // Store the result
        $result = $stmt_check->get_result();

        // If the user has already upvoted this event, exit with a message
        if ($result->num_rows > 0) {
            echo "You have already upvoted this event.";
            exit(); // Stop further execution
        }

        // Close the statement
        $stmt_check->close();
    } else {
        // Error occurred while preparing the statement
        echo "Error: " . $conn->error;
        exit(); // Stop further execution
    }

    // Prepare a SQL statement to insert userId and eventId into the 'upvotes' table
    $sql = "INSERT INTO upvotes (user_id, event_id) VALUES (?, ?)";

    // Use prepared statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("ii", $userId, $eventId);

        // Execute the statement
        if ($stmt->execute()) {

            // Get the count of occurrences of the eventid in the upvotes table
            $sql_count = "SELECT COUNT(*) AS upvote_count FROM upvotes WHERE event_id = ?";
            if ($stmt_count = $conn->prepare($sql_count)) {
                // Bind the parameter
                $stmt_count->bind_param("i", $eventId);

                // Execute the statement
                $stmt_count->execute();

                // Store the result
                $result_count = $stmt_count->get_result();

                // Fetch the row
                $row = $result_count->fetch_assoc();

                // Output the upvote count
                echo $row["upvote_count"];
            } else {
                // Error occurred while preparing the statement
                echo "Error: " . $conn->error;
            }

            // Close the statement
            $stmt_count->close();
        } else {
            // Error occurred while executing the statement
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error occurred while preparing the statement
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If user_id and eventid are not received or request method is not POST
    echo "Invalid request";
}
?>

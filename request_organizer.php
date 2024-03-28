<?php
// Include your database connection file
require_once 'db_con.php';

// Assuming db_conn.php defines $conn as your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user_id and event_id are provided in the POST request
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        // Get user ID and event ID from the POST request
        $user_id = $_POST['user_id'];

        // Check if the user has already requested this event
        $check_sql = "SELECT * FROM requests WHERE user_id = ?;
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ss", $user_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "Error: User has already requested this event";
        } else {
            // Get current date and time
            $dateTime = date('Y-m-d H:i:s');

            // Prepare and execute SQL statement to insert the request
            $sql = "INSERT INTO requests (dateTime, user_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sss", $dateTime, $user_id);
                if ($stmt->execute()) {
                    echo "Successfull";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error: Unable to prepare SQL statement";
            }
        }
        $check_stmt->close();
    } else {
        echo "Error: user_id or event_id is missing or empty in the POST request";
    }
} else {
    echo "Invalid request method";
}
$conn->close();
?>

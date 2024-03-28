<?php
include 'db_con.php';

// Check if user_id is provided in the POST data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Validate user_id (ensure it exists in the user table)
    $sql_check_user = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result_check_user = $conn->query($sql_check_user);

    if ($result_check_user->num_rows > 0) {
        // User exists, proceed with inserting into admin table
        $sql_insert_admin = "INSERT INTO organizer (user_id) VALUES ('$user_id')";
        $sql_change_approve_status = "UPDATE requests SET approved = 1 WHERE user_id = '$user_id'";
        if ($conn->query($sql_insert_admin) === TRUE) {
            $conn->query($sql_change_approve_status);
            echo "New record created successfully in organizer table";
        } else {
            echo "Error creating record in admin table: " . $conn->error;
        }
    } else {
        echo "User with ID $user_id does not exist";
    }

    $conn->close();
} else {
    echo "user_id not provided";
}
?>

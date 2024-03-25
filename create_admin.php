<?php
include 'db_con.php';

// Check if user_id is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Validate user_id (ensure it exists in the user table)
    $sql_check_user = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result_check_user = $conn->query($sql_check_user);

    if ($result_check_user->num_rows > 0) {
        // User exists, proceed with inserting into admin table
        $sql_insert_admin = "INSERT INTO admin (user_id) VALUES ('$user_id')";
        if ($conn->query($sql_insert_admin) === TRUE) {
            echo "New record created successfully in admin table";
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

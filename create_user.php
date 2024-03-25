<?php
include 'db_con.php';

// Check if action and other necessary parameters are passed in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'create_update') {
        $username = $_GET['name'];
        $password = $_GET['password'];
        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];

        // Insert or update data in the database
        $sql = "INSERT INTO user (user_name, user_password, first_name, last_name) VALUES ('$username', '$password', '$firstname', '$lastname')";
        if ($conn->query($sql) === TRUE) {
            echo "Record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    // Add code for other CRUD operations (Read, Update, Delete) here
}
?>

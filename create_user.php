<?php
// Include the conn.php file to establish the database connection
include 'db_con.php';

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO user (user_name, user_password, first_name, last_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $firstName, $lastName);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "New record added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

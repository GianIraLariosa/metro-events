<?php
include 'db_con.php'; // Include your database connection file

// Check if user_id is provided as GET parameter
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Perform authentication query
    $sql = "SELECT * FROM user WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful, get user data
        $user = $result->fetch_assoc();

        // Check if user is an admin
        $admin_check_sql = "SELECT * FROM admin WHERE user_id = $user_id";
        $admin_result = $conn->query($admin_check_sql);
        $is_admin = $admin_result->num_rows > 0;

        // Check if user is an organizer
        $organizer_check_sql = "SELECT * FROM organizer WHERE user_id = $user_id";
        $organizer_result = $conn->query($organizer_check_sql);
        $is_organizer = $organizer_result->num_rows > 0;
        $organizer_id = $organizer_result->fetch_assoc();

        // Construct response based on user role
        if ($is_admin) {
            $response = array('message' => 'admin', 'user' => $user);
        } elseif ($is_organizer) {
            $response = array('message' => 'organizer', 'user' => $organizer_id);
        } else {
            $response = array('message' => 'user', 'user' => $user);
        }

        echo json_encode($response);
    } else {
        $response = array('error' => 'Invalid user ID');
        echo json_encode($response);
    }

    $conn->close();
} else {
    $response = array('error' => 'User ID not provided');
    echo json_encode($response);
}
?>

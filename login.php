<?php
include 'db_con.php'; // Include your database connection file

// Check if username and password are provided as GET parameters
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username']) && isset($_GET['password'])) {
    $username = $_GET['username'];
    $password = $_GET['password'];

    // Perform authentication query
    $sql = "SELECT * FROM user WHERE user_name = '$username' AND user_password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful, get user data
        $user = $result->fetch_assoc();

        // Check if user is an admin
        $user_id = $user['user_id'];
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
            $response = array('message' => 'organizer', 'user' => $organizer_id['organizer_id']);
        } else {
            $response = array('message' => 'user', 'user' => $user);
        }

        echo json_encode($response);
    } else {
        $response = array('error' => 'Invalid username or password');
        echo json_encode($response);
    }

    $conn->close();
} else {
    $response = array('error' => 'Username or password not provided');
    echo json_encode($response);
}
?>

<?php
include 'db_con.php';

// Check if the table name is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['table'])) {
    $table = $_GET['table'];
    
    // Check if the organizer ID is provided in the URL
    if (isset($_GET['organizer_id'])) {
        $organizer_id = $_GET['organizer_id'];
        // Retrieve data from the specified table for the specific organizer
        $sql_data = "SELECT * FROM $table WHERE organizer = '$organizer_id' AND status = 1";
    } else {
        // Retrieve all data from the specified table
        $sql_data = "SELECT * FROM $table AND status = 1";
    }

    $result_data = $conn->query($sql_data);

    if ($result_data->num_rows > 0) {
        // Fetch data from the table
        $data = [];
        while ($row = $result_data->fetch_assoc()) {
            $data[] = $row;
        }

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        // Return empty array if no data available for the organizer
        echo json_encode([]);
    }

    $conn->close();
} else {
    echo "Table name not provided.";
}
?>

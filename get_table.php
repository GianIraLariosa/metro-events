<?php
include 'db_con.php';

// Check if the table name and organizer ID are provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['table']) && isset($_GET['organizer_id'])) {
    $table = $_GET['table'];
    $organizer_id = $_GET['organizer_id'];

    // Retrieve data from the specified table for the specific organizer
    $sql_data = "SELECT * FROM $table WHERE organizer = '$organizer_id'";
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
    echo "Table name or organizer ID not provided.";
}
?>

<?php
include 'db_con.php';

// Check if table name, primary key name, and primary key value are provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['table']) && isset($_GET['pk_name']) && isset($_GET['pk_value'])) {
    $table = $_GET['table'];
    $pk_name = $_GET['pk_name'];
    $pk_value = $_GET['pk_value'];

    // Sanitize primary key value (example using mysqli_real_escape_string, consider using prepared statements)
    $pk_value = mysqli_real_escape_string($conn, $pk_value);

    // Check if the provided table name and primary key name are valid
    $sql_columns = "SHOW COLUMNS FROM $table";
    $result_columns = $conn->query($sql_columns);

    if ($result_columns->num_rows > 0) {
        $valid_pk_name = false;
        while ($row = $result_columns->fetch_assoc()) {
            if ($row['Field'] === $pk_name) {
                $valid_pk_name = true;
                break;
            }
        }

        if ($valid_pk_name) {
            // Delete record from the specified table
            $sql_delete = "DELETE FROM $table WHERE $pk_name = '$pk_value'";
            if ($conn->query($sql_delete) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        } else {
            echo "Invalid primary key name.";
        }
    } else {
        echo "Table not found or has no columns.";
    }

    $conn->close();
} else {
    echo "Table name, primary key name, or primary key value not provided.";
}
?>

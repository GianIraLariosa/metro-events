<?php
include 'db_con.php';

// Check if table name, primary key name, primary key value, and new values are provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['table']) && isset($_GET['pk_name']) && isset($_GET['pk_value']) && isset($_GET['new_values'])) {
    $table = $_GET['table'];
    $pk_name = $_GET['pk_name'];
    $pk_value = $_GET['pk_value'];
    $new_values = $_GET['new_values'];

    // Sanitize primary key value (example using mysqli_real_escape_string, consider using prepared statements)
    $pk_value = mysqli_real_escape_string($conn, $pk_value);

    // Split new values into column-value pairs
    $pairs = explode(",", $new_values);
    $set_values = [];
    foreach ($pairs as $pair) {
        $pair_parts = explode("=", $pair);
        $column = trim($pair_parts[0]);
        $value = trim($pair_parts[1]);
        // Escape single quotes in the value
        $value = mysqli_real_escape_string($conn, $value);
        $set_values[] = "$column = '$value'";
    }
    $set_clause = implode(", ", $set_values);

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
            // Update record in the specified table
            $sql_update = "UPDATE $table SET $set_clause WHERE $pk_name = '$pk_value'";
            if ($conn->query($sql_update) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Invalid primary key name.";
        }
    } else {
        echo "Table not found or has no columns.";
    }

    $conn->close();
} else {
    echo "Table name, primary key name, primary key value, or new values not provided.";
}
?>

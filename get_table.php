<?php
include 'db_con.php';

// Check if the table name is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['table'])) {
    $table = $_GET['table'];

    // Retrieve column names from the specified table
    $sql_columns = "SHOW COLUMNS FROM $table";
    $result_columns = $conn->query($sql_columns);

    if ($result_columns->num_rows > 0) {
        // Get column names
        $columns = [];
        while ($row = $result_columns->fetch_assoc()) {
            $columns[] = $row['Field'];
        }

        // Retrieve data from the specified table
        $sql_data = "SELECT * FROM $table";
        $result_data = $conn->query($sql_data);

        if ($result_data->num_rows > 0) {
            echo "<h2>Data from Table: $table</h2>";
            echo "<table border='1'>";
            echo "<tr>";
            foreach ($columns as $column) {
                echo "<th>$column</th>";
            }
            echo "</tr>";

            while ($row = $result_data->fetch_assoc()) {
                echo "<tr>";
                foreach ($columns as $column) {
                    echo "<td>" . $row[$column] . "</td>";
                }
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No data available in the table.";
        }
    } else {
        echo "Table not found or has no columns.";
    }

    $conn->close();
} else {
    echo "Table name not provided.";
}
?>

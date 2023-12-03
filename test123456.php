<?php
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$tableRows = ''; // Variable to store HTML table rows

// Retrieve distinct ERP numbers from the database
$sql_erp_numbers = "SELECT DISTINCT erp FROM calculated_data";
$result_erp_numbers = $conn->query($sql_erp_numbers);
$erp_numbers = [];
while ($row_erp = $result_erp_numbers->fetch_assoc()) {
    $erp_numbers[] = $row_erp['erp'];
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input for selected ERP numbers
    $user_selected_erps = isset($_POST["selected_erps"]) ? $_POST["selected_erps"] : [];

    // If no ERP numbers are selected, display a message
    if (empty($user_selected_erps)) {
        echo "Please select at least one ERP number.";
    } else {
        // Prepare the SQL query with user input
        $sql = "SELECT * FROM calculated_data WHERE erp IN (";
        
        // Add placeholders for each selected ERP number
        $placeholders = implode(",", array_fill(0, count($user_selected_erps), "?"));
        $sql .= $placeholders . ")";
        
        $stmt = $conn->prepare($sql);

        // Bind parameters dynamically
        $bind_params = str_repeat("s", count($user_selected_erps));
        $stmt->bind_param($bind_params, ...$user_selected_erps);

        // Execute the query
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Display the results in an HTML table
        $tableRows = '<table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Plan ID</th>
                            <th>ERP</th>
                            <th>ICode</th>
                            <th>Description</th>
                            <th>Mold ID</th>
                            <th>Cavity ID</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Found Time</th>
                            <th>User Time</th>
                            <th>Tires per Mold</th>
                            <th>Time Difference (Minutes)</th>
                            <th>Found Time Difference (Minutes)</th>
                            <th>Time Taken</th>
                            <th>Min Time Difference (Minutes)</th>
                            <th>Time Difference (User to End - Minutes)</th>
                            <th>Time Difference (User to Found - Minutes)</th>
                            <th>Plan</th>
                        </tr>';

        while ($row = $result->fetch_assoc()) {
            $tableRows .= "<tr>";
            $tableRows .= "<td>{$row['id']}</td>";
            $tableRows .= "<td>{$row['date']}</td>";
            $tableRows .= "<td>{$row['plan_id']}</td>";
            $tableRows .= "<td>{$row['erp']}</td>";
            $tableRows .= "<td>{$row['icode']}</td>";
            $tableRows .= "<td>{$row['description']}</td>";
            $tableRows .= "<td>{$row['mold_id']}</td>";
            $tableRows .= "<td>{$row['cavity_id']}</td>";
            $tableRows .= "<td>{$row['start_date']}</td>";
            $tableRows .= "<td>{$row['end_date']}</td>";
            $tableRows .= "<td>{$row['found_time']}</td>";
            $tableRows .= "<td>{$row['user_time']}</td>";
            $tableRows .= "<td>{$row['tires_per_mold']}</td>";
            $tableRows .= "<td>{$row['time_difference_minutes']}</td>";
            $tableRows .= "<td>{$row['found_time_difference_minutes']}</td>";
            $tableRows .= "<td>{$row['time_taken']}</td>";
            $tableRows .= "<td>{$row['min_time_difference_minutes']}</td>";
            $tableRows .= "<td>{$row['time_difference_user_to_end_minutes']}</td>";
            $tableRows .= "<td>{$row['time_difference_user_to_found_minutes']}</td>";
            $tableRows .= "<td>{$row['plan']}</td>";
            $tableRows .= "</tr>";
        }

        $tableRows .= "</table>";

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP Data Retrieval</title>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Select ERP numbers:</label><br>
        <?php
        // Populate checkboxes for each ERP number
        foreach ($erp_numbers as $erp) {
            echo "<input type='checkbox' name='selected_erps[]' value='$erp'>$erp<br>";
        }
        ?>
        <br>
        <button type="submit">Retrieve Data</button>
    </form>

    <!-- Display the retrieved data in a table -->
    <?php echo $tableRows; ?>
</body>
</html>

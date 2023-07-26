<?php

// Replace these variables with your actual database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'task_management';

// Connect to the database
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// SQL query to fetch all data from the table ordered by erp and icode
$selectQuery = "SELECT
    plannew.erp,
    plannew.icode,
    plannew.description,
    plannew.tobe,
    plannew.press,
    plannew.press_name,
    plannew.mold_id,
    plannew.mold_name,
    plannew.cavity_id,
    plannew.cavity_name,
    plannew.cuing_group_id,
    plannew.cuing_group_name,
    DATE_FORMAT(plannew.start_date, '%Y-%m-%d %H:%i') AS start_datetime,
    plannew.end_date,
    tire.time_taken
FROM
    plannew
JOIN
    tire ON plannew.icode = tire.icode
ORDER BY erp, icode";

// Execute the select query
$result = mysqli_query($conn, $selectQuery);

if ($result) {
    // Prepare the SQL INSERT statement
    $insertQuery = "INSERT INTO production_schedule (erp, icode, description, tobe, press, press_name, mold_id, mold_name, cavity_id, cavity_name, cuing_group_id, cuing_group_name, start_datetime, end_date, time_taken, production_date, production_time, available_production_slots) VALUES ";

    $values = array();
    // Loop through the data and build the INSERT query
    while ($row = mysqli_fetch_assoc($result)) {
        $erp = $row['erp'];
        $icode = $row['icode'];
        $startDate = strtotime($row['start_datetime']);
        $endDate = strtotime($row['end_date']);
        $productionTime = $row['time_taken'];

        // Separate each date between start_date and end_date for each erp and icode
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $formattedDate = date('Y-m-d', $currentDate);
            $currentTime = date('H:i', $currentDate);

            // Calculate the amount of tire icode that can be made on this date and time slot
            $availableProductionSlots = floor((strtotime("tomorrow", $currentDate) - $currentDate) / ($productionTime * 60));

            // Add the data row to the values array
            $values[] = "('$erp', '$icode', '{$row['description']}', '{$row['tobe']}', '{$row['press']}', '{$row['press_name']}', '{$row['mold_id']}', '{$row['mold_name']}', '{$row['cavity_id']}', '{$row['cavity_name']}', '{$row['cuing_group_id']}', '{$row['cuing_group_name']}', '{$row['start_datetime']}', '{$row['end_date']}', {$row['time_taken']}, '$formattedDate', '$currentTime', $availableProductionSlots)";

            // Move to the next day
            $currentDate = strtotime('+1 day', $currentDate);
        }
    }

    // Combine the insertQuery and values into a single SQL statement
    $insertQuery .= implode(", ", $values);

    // Execute the INSERT query
    if (mysqli_query($conn, $insertQuery)) {
        echo "Data inserted successfully into the table.";
    } else {
        echo "Error inserting data: " . mysqli_error($conn);
    }
} else {
    echo "Error fetching data: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

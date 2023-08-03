<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>
    <style>
        /* CSS styles (unchanged) */
    </style>
</head>
<body>
    <h1>Task Management</h1>
    <?php
    // Replace with your MySQL database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "task_management";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Move the $dataByDates array initialization outside the if ($result->num_rows > 0) block
    $dataByDates = array();

    // SQL query to select data from the plannew table
    $sql = "SELECT * FROM plannew";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Loop through each row of the result
        while ($row = $result->fetch_assoc()) {
            // Get the start_date and end_date for the current row
            
            $endDate = strtotime($row['end_date']);

            // Get the start time from the start_date
            $endTime = date('H:i:s', $endDate);

            // Determine if it's the first date
            $isFirstDate = true;

            // Loop through each date between start_date and end_date (inclusive)
            for ($date = $endDate; $date <= $endDate; $date = strtotime('+1 day', $date)) {
                $currentDate = date('Y-m-d', $date);

               

                // Store the distribution information for this date in an array
                $distributionInfo = array(
                    'erp' => $row['erp'],
                    'plan_id' => $row['plan_id'],
                    'icode' => $row['icode'],
                    'mold_id' => $row['mold_id'],
                    'cavity_id' => $row['cavity_id'],
                    'end_date' => $currentDate . ' ' . $endTime, // Combining the date and time
                 
                );

                // Add the distribution information to the $dataByDates array using the current date as the key
                $dataByDates[$currentDate][] = $distributionInfo;

                // For subsequent dates, set isFirstDate to false
                $isFirstDate = false;
            }
        }

        // Now, the data is divided by dates in the $dataByDates array
        // You can access the data and distribution information for each date using the date as the key

        // Close the current database connection
        $conn->close();

        // Connect to the new database for table creation and data insertion
        $newConn = new mysqli($servername, $username, $password, $dbname);

        // Check if the connection was successful
        if ($newConn->connect_error) {
            die("Connection failed: " . $newConn->connect_error);
        }

        // Create the new table 'task_distribution' (if it doesn't exist)
        $createTableQuery = "CREATE TABLE IF NOT EXISTS task_distribution (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            erp VARCHAR(50),
            plan_id INT(11),
            icode VARCHAR(50),
            mold_id INT(11),
            cavity_id INT(11),
            end_date DATETIME
        
        )";

        if ($newConn->query($createTableQuery) === FALSE) {
            echo "Error creating table: " . $newConn->error;
            exit;
        }

        // Insert the data into the new table
        foreach ($dataByDates as $date => $data) {
            foreach ($data as $info) {
                // Insert the data into the new table
                $erp = $info['erp'];
                $plan_id = $info['plan_id'];
                $icode = $info['icode'];
                $mold_id = $info['mold_id'];
                $cavity_id = $info['cavity_id'];
                $end_date = $info['end_date'];
        

                $insertQuery = "INSERT INTO task_distribution (erp, plan_id, icode, mold_id, cavity_id, end_date)
                                VALUES ('$erp', '$plan_id', '$icode', '$mold_id', '$cavity_id', '$end_date')";

                if ($newConn->query($insertQuery) === FALSE) {
                    echo "Error inserting data: " . $newConn->error;
                }
            }
        }

        // Close the new database connection
        $newConn->close();
    } else {
        echo "No data found.";
        // Close the database connection
        $conn->close();
    }
    ?>
</body>
</html>

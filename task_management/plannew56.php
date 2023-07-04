<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "task_management");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the ERP ID from the form submission
    $erp = isset($_POST['erp']) ? $_POST['erp'] : '';

    // Validate the ERP ID (you can add your own validation logic here)
    if (empty($erp)) {
        die("Please enter a valid ERP ID");
    }

    // Sanitize the ERP ID to prevent SQL injection
    $erp = mysqli_real_escape_string($conn, $erp);

    // Generate Production Plan

    // Retrieve the tire IDs, quantities, press, mold, and time_taken for the ERP
    $sql = "SELECT s.icode, s.tobe, t.time_taken, s.press, s.mold , s.cavity
            FROM selected_data s
            INNER JOIN tire t ON s.icode = t.icode
            WHERE s.erp = '$erp'";
    $result = mysqli_query($conn, $sql);

    // Check if the ERP exists
    if (mysqli_num_rows($result) > 0) {
        // Split the tire IDs, quantities, press, mold, and time_taken
        $tires = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $icode = $row['icode'];
            $tobe = $row['tobe'];
            $press = $row['press'];
            $mold = $row['mold'];
            $cavity = $row['cavity'];
            $time_taken = $row['time_taken'];
            $tires[] = array('icode' => $icode, 'tobe' => $tobe, 'press' => $press, 'mold' => $mold,  'cavity' => $cavity,'time_taken' => $time_taken);
        }

        // Iterate over each tire in the ERP
        foreach ($tires as $tire) {
            $icode = $tire['icode'];
            $tobe = $tire['tobe'];
            $press = $tire['press'];
            $mold = $tire['mold'];
            $cavity = $tire['cavity'];


            // Retrieve the time taken for the tire type
            $time_taken = $tire['time_taken'];

            // Get the latest completion date for the specific press and mold combination
            $latest_end_date = null;
            $sql = "SELECT MAX(end_date) AS latest_end_date
                    FROM plannew
                    WHERE press = '$press' AND mold = '$mold'";
           $result = mysqli_query($conn, $sql);
           if (!$result) {
               die("Error: " . mysqli_error($conn));
           }
           
            $row = mysqli_fetch_assoc($result);
            if ($row['latest_end_date']) {
                $latest_end_date = $row['latest_end_date'];
            }

            $next_start_date = $latest_end_date ? date("Y-m-d H:i:s", strtotime("$latest_end_date + 1 minute")) : date("Y-m-d H:i:s");

            // Calculate the total time for all tires in the ERP
            $total_time = $time_taken * $tobe;

            // Calculate the start and end dates based on the total time
            $start_date = $next_start_date;
            $end_date = date("Y-m-d H:i:s", strtotime("$start_date + $total_time minutes"));

            // Update the next start date for the next tire
            $next_start_date = $end_date;

            // Insert the production plan into the database for the entire quantity
            $sql = "INSERT INTO plannew (erp, icode, press, mold, cavity ,start_date, end_date)
                    VALUES ('$erp', '$icode', '$press', '$mold', '$cavity', '$start_date', '$end_date')";
            mysqli_query($conn, $sql);

            // Get the ID of the inserted production plan
            $production_plan_id = mysqli_insert_id($conn);
        }

        echo "Production plan generated successfully!";
    } else {
        echo "No tires found for the provided ERP ID.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Production Plan Editor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            padding: 8px;
            width: 200px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            padding: 8px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        select {
            padding: 6px;
            width: 100%;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[name="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Colorful design */
        h2, button[type="submit"], button[name="submit"] {
            background-color: #2196F3;
        }

        th {
            background-color: #2196F3;
        }

        tr:nth-child(even) {
            background-color: #E3F2FD;
        }

        select[name^="press_"] {
            background-color: #BBDEFB;
            color: #000;
        }

        select[name^="mold_"] {
            background-color: #64B5F6;
            color: #fff;
        }

        select[name^="cavity_"] {
            background-color: #1976d1;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Production Plan Editor</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="erp">ERP ID:</label>
            <input type="text" id="erp" name="erp" required>
            <button type="submit">Generate Plan</button>
        </form>

        <?php
        // ... The existing PHP code for generating the table ...
        ?>
    </div>
</body>
</html>


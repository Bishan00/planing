

<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "task_management");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate Production Plan

    // Retrieve all tire IDs, quantities, press, mold, and time_taken from the database table
    $sql = "SELECT s.icode, p.tobe, s.mold_id, s.cavity_id, t.time_taken
            FROM process s
            INNER JOIN tire t ON s.icode = t.icode
            INNER JOIN tobeplan p ON s.icode = p.icode";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    
    // Check if any tires are available for production
    if (mysqli_num_rows($result) > 0) {
        // Initialize array to store the latest end date for each press
        $latest_end_dates = array();

        // Iterate over each tire in the database table
        while ($row = mysqli_fetch_assoc($result)) {
            $icode = $row['icode'];
            $tobe = $row['tobe'];
            $mold = $row['mold_id'];
            $cavity = $row['cavity_id'];
            $time_taken = $row['time_taken'];

            // Skip the tire if the 'tobe' value is 0
            if ($tobe == 0) {
                continue;
            }

            // Retrieve the latest end date for the current press
            $latest_end_date = isset($latest_end_dates[$mold]) ? $latest_end_dates[$mold] : null;

            // Calculate the start date based on the latest end date of the previous tire type or the current time
            $start_date = $latest_end_date ? date("Y-m-d H:i:s", strtotime("$latest_end_date + 1 minute")) : date("Y-m-d H:i:s");

            // Calculate the total time for all tires in the current iteration
            $total_time = $time_taken * $tobe;

            // Calculate the end date based on the total time
            $end_date = date("Y-m-d H:i:s", strtotime("$start_date + $total_time minutes"));

            // Update the next start date for the next tire type of the same press
            $latest_end_dates[$mold] = $end_date;

            // Insert the production plan into the database for the entire quantity
            $sql = "INSERT INTO plannew (icode, mold_id, cavity_id, start_date, end_date)
                    VALUES ('$icode', '$mold', '$cavity', '$start_date', '$end_date')";
            mysqli_query($conn, $sql);

            // Get the ID of the inserted production plan
            $production_plan_id = mysqli_insert_id($conn);

            // Update the availability date of mold
            $sql = "UPDATE mold SET availability_date = '$end_date' WHERE mold_id = '$mold'";
            mysqli_query($conn, $sql);

            // Update the availability date of cavity
            $sql = "UPDATE cavity SET availability_date = '$end_date' WHERE cavity_id = '$cavity'";
            mysqli_query($conn, $sql);
        }

        echo "Production plan generated successfully!";
    } else {
        echo "No tires found in the database.";
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

<!DOCTYPE html>
<html>
<head>
    <title>Production Plan Generator</title>
</head>
<body>
    <h1>Production Plan Generator</h1>

    <form method="POST" action="plannew56.php">
        <input type="submit" name="generate_plan" value="Generate Production Plan">
    </form>
</body>
</html>

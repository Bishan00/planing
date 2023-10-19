<!DOCTYPE html>
<html>
<head>
    <title>Inventory Input Form</title>
    <!-- Your CSS styles -->
</head>
<body>
    <h1>Enter Daily Production</h1>
    <form method="post">
        <label for="inputDate">Date:</label>
        <input type="date" id="inputDate" name="inputDate" required>

        <label for="shift">Shift:</label>
        <select name="shift" id="shift">
        <option value="DAY A">DAY A</option>
            <option value="DAY B">DAY B</option>
            <option value="DAY C">DAY C</option>

            <option value="NIGHT A">NIGHT A</option>
            <option value="NIGHT B">NIGHT B</option>
            <option value="NIGHT C">NIGHT C</option>
        </select>
      

        <!-- Submit button -->
        <input type="submit" name="submit" value="Submit">
    </form>


    <?php
    if (isset($_POST['submit'])) {
        // Get user input values
        $inputDate = $_POST['inputDate'];
        $shift = $_POST['shift'];

        // Establish a database connection
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

        // Loop through the table data and insert it into the database
        $table_data = json_decode($_GET['table_data'], true);


        
        foreach ($table_data as $result) {
            $icode = $result['icode'];
            $description = $result['description'];
            $mold_name = $result['mold_name'];
            $cavity_name = $result['cavity_name'];
            $found_start_time = $result['found_start_time'];
            $found_end_time = $result['found_end_time'];
            $tobe = round($result['tobe']);
            $time_given = $result['time_given'];

            // Insert data into the database table, setting date and shift
            $sql = "INSERT INTO shift_plan (Date, Shift, Icode, Description, MoldName, CavityName, StartTime, EndTime, Plan, TimeGiven)
                    VALUES ('$inputDate', '$shift', '$icode', '$description', '$mold_name', '$cavity_name', '$found_start_time', '$found_end_time', $tobe, '$time_given')";

            if ($conn->query($sql) === TRUE) {
                echo "Data inserted successfully.";
                
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Close the database connection
        $conn->close();
        header("Location: plan_edit2.php");
exit();
    }
    ?>
</body>
</html>









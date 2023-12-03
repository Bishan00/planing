<!DOCTYPE html>
<html>
<head>
    <title>Task Management - Process Data</title>
    <style>
        body {
            font-family: 'Cantarell';
            background-color: #F28018;
            transition: background-color 1s;
        }

        h1 {
            font-family: 'Cantarell Bold', sans-serif;
        }

        .custom-button {
            background-color: #000000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-family: 'Cantarell Bold', sans-serif;
            transition: background-color 1s, color 1s;
        }

        .custom-button:hover {
            background-color: #000000;
            color: #F28018;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #000000;
            color: #FFFFFF;
            transition: background-color 1s, color 1s;
        }

        table, th, td {
            border: 0.1px solid #6C6565;
            padding: 10px;
            text-align: left;
        }

        .select-box select {
            font-family: 'Open Sans', sans-serif;
            font-weight: normal;
        }

        .highlight {
            background-color: #F28018;
            color: #000000;
        }

        .highlight-mold {
        border: 2px solid #FFD700; /* Change the border color to your desired highlight color */
        background-color: #FFFFE0; /* Change the background color to your desired highlight color */
    }
    </style>
</head>

<body>
    <h1>Task Management - Process Data</h1>
    <a href="plannew56.php">
        <button class="custom-button">Generate Plan</button>
    </a>

    <?php
    // Establish a database connection
    $hostname = 'localhost';
    $username = 'planatir_task_management';
    $password = 'Bishan@1919';
    $database = 'planatir_task_management';

    $connection = mysqli_connect($hostname, $username, $password, $database);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }



    function getSumOfPositiveTobe($connection)
    {
        $sumQuery = "SELECT SUM(tobe) AS total_tobe FROM `tobeplan` WHERE tobe > 0";
        $result = mysqli_query($connection, $sumQuery);
        $row = mysqli_fetch_assoc($result);
        return $row['total_tobe'];
    }
    
    function displayProcessData($connection)
    {
        // Initialize a variable to store the total
        $totalTiresPerMold = 0;
          // Call the function to get the sum of positive values in tobe
    $sumOfPositiveTobe = getSumOfPositiveTobe($connection);


        // Updated SQL query to join the tobeplan table
        $selectQuery = "SELECT p.icode, p.tires_per_mold, p.mold_name, p.cavity_name, t.description, t.availability_date, p.is_completed,
                        tp.tobe -- Add the desired column from tobeplan table
                        FROM `process` p
                        LEFT JOIN `mold` m ON p.mold_name = m.mold_name
                        LEFT JOIN `tire` t ON p.icode = t.icode
                        LEFT JOIN `tobeplan` tp ON p.icode = tp.icode"; // Modify this line according to your database structure
        $result = mysqli_query($connection, $selectQuery);
    

   

        if (mysqli_num_rows($result) > 0) {
            
            echo "<table>
                    <tr>
                        <th>ICODE</th>
                        <th>Description</th> 
                        <th>Tires per Mold</th>
                        <th>Tobe </th> 
                        <th>Mold Name</th>
                        <th>Similer Cavity Name</th>
                        <th>All Cavity Name</th>
                        <th>Availability Date</th>
                        <th>Change Start Date</th>
                        <th>Completed</th>
                       
                    </tr>";

                    

      
       
   
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['icode']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['tires_per_mold']}</td>";
                        echo "<td>{$row['tobe']}</td>";
                // Display Mold Name
                echo "<td class='select-box'>";
                echo "<select name='mold_select[{$row['icode']}]' onchange='updateData(\"{$row['icode']}\", this.value, \"{$row['cavity_name']}\", true)' class='highlight-mold'>";
                echo "<option value=''>-- Select Mold Name --</option>";
                
                $moldNamesQuery = "SELECT mold_name, availability_date FROM mold WHERE mold_name IN (SELECT mold_name FROM production_plan WHERE icode = '{$row['icode']}')";
                $moldNamesResult = mysqli_query($connection, $moldNamesQuery);
                $molds = array();
                while ($moldRow = mysqli_fetch_assoc($moldNamesResult)) {
                    $selected = $moldRow['mold_name'] === $row['mold_name'] ? 'selected' : '';
                    echo "<option value='{$moldRow['mold_name']}' {$selected}>{$moldRow['mold_name']}</option>";
                }
                
                echo "</select>";
                
                echo "</td>";

                // Display Cavity Name
                echo "<td class='select-box'>";
                echo "<select name='cavity_select[{$row['icode']}]' onchange='updateData(\"{$row['icode']}\", \"{$row['mold_name']}\", this.value, false)'>";
                echo "<option value=''>-- Select Cavity Name --</option>";

                // Fetch the available cavities for the specific icode from the tire_cavity table
                $tireCavityQuery = "SELECT cavity_name, availability_date FROM cavity WHERE cavity_name IN (SELECT cavity_name FROM production_plan WHERE icode = '{$row['icode']}')";
                $tireCavityResult = mysqli_query($connection, $tireCavityQuery);
                $cavities = array();
                while ($tireCavityRow = mysqli_fetch_assoc($tireCavityResult)) {
                    $cavities[] = $tireCavityRow;
                }

                foreach ($cavities as $cavity) {
                    $selected = $cavity['cavity_name'] === $row['cavity_name'] ? 'selected' : '';
                    $cavityId = getCavityIdFromCavityName($connection, $cavity['cavity_name']);
                    $highlightClass = isCavityIdInPlanNewTable($connection, $cavityId) ? 'highlight' : '';
                    echo "<option value='{$cavity['cavity_name']}' {$selected} class='{$highlightClass}'>{$cavity['cavity_name']} (Availability Date: {$cavity['availability_date']})</option>";
                }

                echo "</select>";
                echo "</td>";

                // Display Cavity Name
                echo "<td class='select-box'>";
                echo "<select name='cavity_select[{$row['icode']}]' onchange='updateData(\"{$row['icode']}\", \"{$row['mold_name']}\", this.value, false)'>";
                echo "<option value=''>-- Select Cavity Name --</option>";

                // Fetch the available cavities for the specific icode from the tire_cavity table
                $tireCavityQuery = "SELECT cavity_name, availability_date FROM cavity";
                $tireCavityResult = mysqli_query($connection, $tireCavityQuery);
                $cavities = array();
                while ($tireCavityRow = mysqli_fetch_assoc($tireCavityResult)) {
                    $cavities[] = $tireCavityRow;
                }

                foreach ($cavities as $cavity) {
                    $selected = $cavity['cavity_name'] === $row['cavity_name'] ? 'selected' : '';
                    $cavityId = getCavityIdFromCavityName($connection, $cavity['cavity_name']);
                    $highlightClass = isCavityIdInPlanNewTable($connection, $cavityId) ? 'highlight' : '';
                    echo "<option value='{$cavity['cavity_name']}' {$selected} class='{$highlightClass}'>{$cavity['cavity_name']} (Availability Date: {$cavity['availability_date']})</option>";
                }

                echo "</select>";
                echo "</td>";

                // Display the highest availability date
                $highestAvailabilityDate = getHighestAvailabilityDate($connection, $row['icode']);
                echo "<td>{$highestAvailabilityDate}</td>";

                // Add a new column for changing the start date
                echo "<td class='date-input'>";
                echo "<input type='datetime-local' name='start_date[{$row['icode']}]'>";
                echo "<button onclick='updateStartDate(\"{$row['icode']}\")'>Update</button>";
                echo "</td>";

                // Add a checkbox for the tick mark
                $checked = $row['is_completed'] ? 'checked' : '';
                echo "<td><input type='checkbox' name='completed_checkbox[{$row['icode']}]' onchange='updateCompletion(\"{$row['icode']}\", this.checked)'" . $checked . "></td>";

                
                echo "</tr>";
                // Accumulate the tires_per_mold value to calculate the total
            $totalTiresPerMold += $row['tires_per_mold'];
            }
            echo "</table>";
        } else {
            echo "No records found.";
        }
        // Display the total above the table
    echo "<p>Total Tires per Mold: $totalTiresPerMold</p>";
      // Display the total above the table
     
      echo "<p>Total Tobe (Positive): $sumOfPositiveTobe</p>";
  
     

        mysqli_free_result($result);
    }

    function getCavityIdFromCavityName($connection, $cavityName)
    {
        $selectQuery = "SELECT cavity_id FROM `cavity` WHERE cavity_name = '$cavityName'";
        $result = mysqli_query($connection, $selectQuery);
        $row = mysqli_fetch_assoc($result);
        return $row['cavity_id'];
    }

    function isCavityIdInPlanNewTable($connection, $cavityId)
    {
        $selectQuery = "SELECT cavity_id FROM `plannew` WHERE cavity_id = $cavityId";
        $result = mysqli_query($connection, $selectQuery);
        return mysqli_num_rows($result) > 0;
    }

    function getHighestAvailabilityDate($connection, $icode)
    {
        $selectQuery = "SELECT MAX(availability_date) AS highest_date 
                        FROM (
                            SELECT availability_date FROM `mold` WHERE mold_name IN (
                                SELECT mold_name FROM `process` WHERE icode = '$icode'
                            )
                            UNION
                            SELECT availability_date FROM `cavity` WHERE cavity_name IN (
                                SELECT cavity_name FROM `process` WHERE icode = '$icode'
                            )
                            UNION
                            SELECT availability_date FROM `tire` WHERE icode = '$icode'
                        ) AS availability_dates";
        $result = mysqli_query($connection, $selectQuery);
        $row = mysqli_fetch_assoc($result);
        return $row['highest_date'];
    }

    displayProcessData($connection);

    mysqli_close($connection);
    ?>

    <script>


        function updateData(icode, moldName, cavity, isMold) {
            // AJAX request to update data on the server
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Refresh the page after successful update
                   //location.reload();
                }
            };

            // Prepare the data to be sent to the server
            const data = new FormData();
            data.append("icode", icode);
            data.append("moldName", moldName);
            data.append("cavity", cavity);
            data.append("isMold", isMold);

            // Send the AJAX request
            xhr.open("POST", "update_data.php", true);
            xhr.send(data);
        }
        function updateCompletion(icode, isChecked) {
    // AJAX request to update completion status on the server
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response if needed
        }
    };

    // Prepare the data to be sent to the server
    const data = new FormData();
    data.append("icode", icode);
    data.append("isChecked", isChecked);

    // Send the AJAX request
    xhr.open("POST", "update_completion.php", true);
    xhr.send(data);
}

        function updateStartDate(icode) {
            // Get the new start date entered by the user
            const newStartDate = document.querySelector(`input[name='start_date[${icode}]']`).value;

            // AJAX request to update start date in the tire database table
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response if needed
                    location.reload(); // Refresh the page after successful update
                }
            };

            // Prepare the data to be sent to the server
            const data = new FormData();
            data.append("icode", icode);
            data.append("newStartDate", newStartDate);

            // Send the AJAX request to update the start date
            xhr.open("POST", "update_start_date.php", true);
            xhr.send(data);
        }


        // Function to change colors to an "easy on the eyes" scheme
        function changeColors() {
            // Change background color to a light gray
            document.body.style.backgroundColor = "#EFEFEF";
            // Change button colors to a contrasting color scheme
            const buttons = document.querySelectorAll('.custom-button');
            buttons.forEach(button => {
                button.style.backgroundColor = "#F28018"; // A shade of blue
                button.style.color = "#FFFFFF";
            });
            // Change table colors to improve readability
            const tables = document.querySelectorAll('table');
            tables.forEach(table => {
                table.style.backgroundColor = "#FFFFFF";
                table.style.color = "#333333"; // Dark gray text
            });
        }

        // Schedule color change after 2 minutes
        setTimeout(changeColors,600); // 2 minutes in milliseconds (2 * 60 * 1000)
    </script>



</body>
</html>
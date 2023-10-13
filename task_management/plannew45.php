<!DOCTYPE html>
<html>
<head>
    <title>Task Management - Process Data</title>
    <style>
       

/* Styles for the button */
.custom-button {
  background-color: powderblue;
  color: white;
  border: none;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
}

/* Hover effect */
.custom-button:hover {
  background-color: skyblue;
}

/* Active (clicked) effect */
.custom-button:active {
  background-color: deepskyblue;
}
body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
  margin: 0;
  padding: 0;
}

.header {
  background-color: #333;
  color: #fff;
  padding: 20px;
  text-align: center;
}

.container {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}


.select-box select {
  
  padding: 12px;
  border: 2px solid #3498db;
  border-radius: 5px;
  background-color: #fff;
  
  text-indent: 1px;
  text-overflow: '';
  font-size: 16px;
  font-weight: bold;
  color: #555;
  cursor: pointer;
}



/* Styling for the update button */
.update-button {
  display: block;
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  background-color: #3498db;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.update-button:hover {
  background-color: #2184c3;
}

/* Styling for the table and table rows */
table {
  border-collapse: collapse;
  width: 100%;
  margin-top: 20px;
}

th, td {
  padding: 12px;
  text-align: left;
}

th {
  background-color: #3498db;
  color: #fff;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

/* Highlight class to show the selected cavity_id in red */
.highlight {
color: blue;
}


    </style>
</head>
<body>
    <h1>Task Management - Process Data</h1>
    <a href="plannew56.php">
        <button class="custom-button">Generate Plan</button>
    </a>

    <?php
    $hostname = 'localhost';
    $username = 'planatir_task_management';
    $password = 'Bishan@1919';
    $database = 'planatir_task_management';

    $connection = mysqli_connect($hostname, $username, $password, $database);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    function displayProcessData($connection)
    {
        $selectQuery = "SELECT p.icode, p.tires_per_mold, p.mold_name, p.cavity_name, t.description
                        FROM `process` p
                        LEFT JOIN `mold` m ON p.mold_name = m.mold_name
                        LEFT JOIN `tire` t ON p.icode = t.icode";
        $result = mysqli_query($connection, $selectQuery);

        if (mysqli_num_rows($result) > 0) {
            echo "<table>
                    <tr>
                        <th>ICODE</th>
                        <th>Description</th> 
                        <th>Tires per Mold</th>
                        <th>Mold Name</th>
                        
                        <th>Cavity Name</th>

                    </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['icode']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['tires_per_mold']}</td>";

                // Display select box for Mold Name
                echo "<td class='select-box'>";
                echo "<select name='mold_select[{$row['icode']}]' onchange='updateData(\"{$row['icode']}\", this.value, \"{$row['cavity_name']}\", true)'>";
                echo "<option value=''>-- Select Mold Name --</option>";

                // Fetch all mold names
                $moldNamesQuery = "SELECT mold_name FROM `mold`";
                $moldNamesResult = mysqli_query($connection, $moldNamesQuery);
                while ($moldRow = mysqli_fetch_assoc($moldNamesResult)) {
                    $selected = $moldRow['mold_name'] === $row['mold_name'] ? 'selected' : '';
                    echo "<option value='{$moldRow['mold_name']}' {$selected}>{$moldRow['mold_name']}</option>";
                }

                echo "</select>";
                echo "</td>";

                

                // Display select box for Cavity Name
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

                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No records found.";
        }

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
                    location.reload();
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
    </script>
</body>
</html>

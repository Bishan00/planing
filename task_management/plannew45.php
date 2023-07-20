<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function updateData(icode, moldId, press, cavityId, checked) {
            // Send an AJAX request to update the database with the selected mold and cavity IDs
            const url = "update_data.php";

            const data = {
                icode: icode,
                moldId: moldId,
                press: press,
                cavityId: cavityId,
                checked: checked ? 1 : 0
            };

            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                // The server-side script may send a response with updated data
                // You can handle the response here, if needed
                console.log(result);
            })
            .catch(error => {
                console.error("Error updating data: ", error);
            });
        }
    </script>
</head>
<body>
    <?php
    // Replace these variables with your database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "task_management";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch all data for each icode
    $sql = "SELECT 
                icode,
                mold_id,
                press_name,
                GROUP_CONCAT(DISTINCT cavity_id ORDER BY cavity_id) AS selected_cavities
            FROM 
                production_plan
            GROUP BY 
                icode, mold_id, press_name";

    $result = $conn->query($sql);

    // Fetch the selected mold and cavity IDs for each icode from the database
    $selectedMoldIds = array();
    $selectedCavityIds = array();

    $sqlSelect = "SELECT icode, mold_id, cavity_id FROM process";
    $resultSelect = $conn->query($sqlSelect);

    if ($resultSelect->num_rows > 0) {
        while ($rowSelect = $resultSelect->fetch_assoc()) {
            $icode = $rowSelect["icode"];
            $moldId = $rowSelect["mold_id"];
            $cavityId = $rowSelect["cavity_id"];

            if (!isset($selectedMoldIds[$icode])) {
                $selectedMoldIds[$icode] = array();
            }
            if (!isset($selectedCavityIds[$icode])) {
                $selectedCavityIds[$icode] = array();
            }

            $selectedMoldIds[$icode][] = $moldId;
            $selectedCavityIds[$icode][] = $cavityId;
        }
    }

    if ($result->num_rows > 0) {
        $icodeData = array();

        while ($row = $result->fetch_assoc()) {
            $icode = $row["icode"];
            $mold = $row["mold_id"];
            $press = $row["press_name"];
            $cavities = $row["selected_cavities"];

            if (!isset($icodeData[$icode])) {
                $icodeData[$icode] = array();
            }

            $icodeData[$icode][] = array("mold" => $mold, "press" => $press, "cavities" => $cavities);
        }

        foreach ($icodeData as $icode => $data) {
            echo "<h2>Icode: " . $icode . "</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Selected Mold ID</th><th>Selected Press</th><th>Selected Cavities IDs</th></tr>";

            foreach ($data as $row) {
                echo "<tr>";
                $moldCheckboxValue = $row["mold"];
                $moldChecked = isset($selectedMoldIds[$icode]) && in_array($moldCheckboxValue, $selectedMoldIds[$icode]) ? 'checked' : '';
                echo "<td><input type='checkbox' name='mold_checkbox[$icode][]' value='" . $moldCheckboxValue . "' onclick='updateData(\"$icode\", this.value, \"" . $row["press"] . "\", \"" . $row["cavities"] . "\", this.checked)' $moldChecked>" . $moldCheckboxValue . "</td>";
                echo "<td>" . $row["press"] . "</td>";

                // Split the cavities into an array
                $cavitiesArray = explode(",", $row["cavities"]);

                echo "<td>"; // Start the cell for cavities

                // Display checkboxes for cavities
                foreach ($cavitiesArray as $cavity) {
                    $cavityCheckboxValue = $cavity;
                    $cavityChecked = isset($selectedCavityIds[$icode]) && in_array($cavityCheckboxValue, $selectedCavityIds[$icode]) ? 'checked' : '';
                    echo '<input type="checkbox" name="cavity_checkbox[' . $icode . '][' . $moldCheckboxValue . '][' . $cavityCheckboxValue . ']" value="' . $cavityCheckboxValue . '" onclick="updateData(\'' . $icode . '\', \'' . $moldCheckboxValue . '\', \'' . $row["press"] . '\', \'' . $cavityCheckboxValue . '\', this.checked)" ' . $cavityChecked . '>' . $cavityCheckboxValue . '<br>';
                }

                echo "</td>"; // End the cell for cavities
                echo "</tr>";
            }

            echo "</table><br>";
        }
    } else {
        echo "No results found.";
    }

    // Close the connection
    $conn->close();
    ?>
</body>
</html>

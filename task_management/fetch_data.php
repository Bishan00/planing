
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        input[type=checkbox] {
            margin-right: 5px;
        }

        p {
            color: red;
        }
    </style>
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
            mold_name,
            press_name,
            GROUP_CONCAT(DISTINCT cavity_name ORDER BY cavity_name) AS selected_cavities
        FROM 
            production_plan
        GROUP BY 
            icode, mold_name, press_name";

$result = $conn->query($sql);

// Fetch the selected mold and cavity names for each icode from the database
$selectedMoldNames = array();
$selectedCavityNames = array();

$sqlSelect = "SELECT icode, mold_name, cavity_name FROM process";
$resultSelect = $conn->query($sqlSelect);

if ($resultSelect->num_rows > 0) {
    while ($rowSelect = $resultSelect->fetch_assoc()) {
        $icode = $rowSelect["icode"];
        $moldName = $rowSelect["mold_name"];
        $cavityName = $rowSelect["cavity_name"];

        if (!isset($selectedMoldNames[$icode])) {
            $selectedMoldNames[$icode] = array();
        }
        if (!isset($selectedCavityNames[$icode])) {
            $selectedCavityNames[$icode] = array();
        }

        $selectedMoldNames[$icode][] = $moldName;
        $selectedCavityNames[$icode][] = $cavityName;
    }
}

if ($result->num_rows > 0) {
    $icodeData = array();

    while ($row = $result->fetch_assoc()) {
        $icode = $row["icode"];
        $moldName = $row["mold_name"];
        $press = $row["press_name"];
        $cavities = $row["selected_cavities"];

        if (!isset($icodeData[$icode])) {
            $icodeData[$icode] = array();
        }

        $icodeData[$icode][] = array("moldName" => $moldName, "press" => $press, "cavities" => $cavities);
    }

    if (isset($_GET['icode'])) {
        $searchedIcode = $_GET['icode'];
        if (isset($icodeData[$searchedIcode])) {
            echo "<h2>Icode: " . $searchedIcode . "</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Selected Mold Name</th><th>Selected Press</th><th>Selected Cavities Names</th></tr>";

            foreach ($icodeData[$searchedIcode] as $row) {
                echo "<tr>";
                $moldNameCheckboxValue = $row["moldName"];
                $moldChecked = isset($selectedMoldNames[$searchedIcode]) && in_array($moldNameCheckboxValue, $selectedMoldNames[$searchedIcode]) ? 'checked' : '';
                echo "<td><input type='checkbox' name='mold_checkbox[$searchedIcode][]' value='" . $moldNameCheckboxValue . "' onclick='updateData(\"$searchedIcode\", \"" . $row["moldName"] . "\", \"" . $row["press"] . "\", \"" . $row["cavities"] . "\", this.checked)' $moldChecked>" . $moldNameCheckboxValue . "</td>";
                echo "<td>" . $row["press"] . "</td>";

                // Split the cavities into an array
                $cavitiesArray = explode(",", $row["cavities"]);

                echo "<td>"; // Start the cell for cavities

                // Display checkboxes for cavities
                foreach ($cavitiesArray as $cavity) {
                    $cavityNameCheckboxValue = $cavity;
                    $cavityChecked = isset($selectedCavityNames[$searchedIcode]) && in_array($cavityNameCheckboxValue, $selectedCavityNames[$searchedIcode]) ? 'checked' : '';
                    echo '<input type="checkbox" name="cavity_checkbox[' . $searchedIcode . '][' . $moldNameCheckboxValue . '][' . $cavityNameCheckboxValue . ']" value="' . $cavityNameCheckboxValue . '" onclick="updateData(\'' . $searchedIcode . '\', \'' . $row["moldName"] . '\', \'' . $row["press"] . '\', \'' . $cavityNameCheckboxValue . '\', this.checked)" ' . $cavityChecked . '>' . $cavityNameCheckboxValue . '<br>';
                }

                echo "</td>"; // End the cell for cavities

                echo "</tr>";
            }

            echo "</table><br>";
        } else {
            echo "<p>No results found for Icode: " . $searchedIcode . "</p>";
        }
    }
} else {
    echo "No results found.";
}

// Close the connection
$conn->close();
?>

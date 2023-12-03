<?php
// Replace these variables with your actual database connection details
$host = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database = "planatir_task_management";

// Collect the user-provided date from the form
$user_date = $_POST['start_date'];

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data based on the user-provided date (ignoring time)
$sql = "SELECT plannew.icode, plannew.mold_id, plannew.cavity_id, plannew.start_date, plannew.end_date, tire.description, mold.mold_name, cavity.cavity_name
        FROM plannew
        LEFT JOIN tire ON plannew.icode = tire.icode
        LEFT JOIN mold ON plannew.mold_id = mold.mold_id
        LEFT JOIN cavity ON plannew.cavity_id = cavity.cavity_id
        WHERE DATE(plannew.start_date) = '$user_date'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output the data in a table
    echo "<table border='1'>";
    echo "<tr><th>icode</th><th>Description</th><th>Mold Name</th><th>Cavity Name</th><th>Start Date</th><th>End Date</th><th>Removing Mold</th><th>Removing Tire Id</th><th>Description</th></tr>";

    while ($row = $result->fetch_assoc()) {
        

 // Check if there is data related to removing mold and tire
 $cavity_id = $row["cavity_id"];
 $cavityQuery = "SELECT mold.mold_name, plannew.icode FROM plannew
                 LEFT JOIN mold ON plannew.mold_id = mold.mold_id
                 WHERE plannew.cavity_id = '$cavity_id' AND DATE(plannew.end_date) = '$user_date'";
 $cavityResult = $conn->query($cavityQuery);

 if ($cavityResult->num_rows > 0) {
     $cavityRow = $cavityResult->fetch_assoc();
    
 } else {
     
 }


        // Check if "icode" and "Removing Tire Id" are the same
        if ($row["icode"] == $cavityRow["icode"]) {
            continue; // Skip the row
        }

        echo "<tr>";
        echo "<td>" . $row["icode"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo "<td>" . $row["mold_name"] . "</td>";
        echo "<td>" . $row["cavity_name"] . "</td>";
        echo "<td>" . $row["start_date"] . "</td>";
        echo "<td>" . $row["end_date"] . "</td>";

        // Check if there is data related to removing mold and tire
        $cavity_id = $row["cavity_id"];
        $cavityQuery = "SELECT mold.mold_name, plannew.icode FROM plannew
                        LEFT JOIN mold ON plannew.mold_id = mold.mold_id
                        WHERE plannew.cavity_id = '$cavity_id' AND DATE(plannew.end_date) = '$user_date'";
        $cavityResult = $conn->query($cavityQuery);

        if ($cavityResult->num_rows > 0) {
            $cavityRow = $cavityResult->fetch_assoc();
            echo "<td>" . $cavityRow["mold_name"] . "</td>";
            echo "<td>" . $cavityRow["icode"] . "</td>";
    
            // Fetch and display the description from the "tire" table based on "icode"
            $icode = $cavityRow["icode"];
            $tireDescriptionQuery = "SELECT description FROM tire WHERE icode = '$icode'";
            $tireDescriptionResult = $conn->query($tireDescriptionQuery);
    
            if ($tireDescriptionResult->num_rows > 0) {
                $tireDescriptionRow = $tireDescriptionResult->fetch_assoc();
                echo "<td>" . $tireDescriptionRow["description"] . "</td>";
            } else {
                echo "<td>No description found</td>";
            }
        } else {
            echo "<td>No data</td>";
            echo "<td>No data</td>";
            echo "<td>No description</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No data found in the plannew table.";
}

// Close the database connection
$conn->close();
?>

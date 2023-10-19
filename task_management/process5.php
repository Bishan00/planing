<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>
    <style>
        /* CSS styles here */
    </style>
</head>
<body>
<?php
$host = 'localhost';
$dbname = 'planatir_task_management';
$username = 'planatir_task_management';
$password = 'Bishan@1919';

try {
    // Connect to the database
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to get the tire counts and mold counts
    $query = "
    SELECT tp.icode, tp.tobe AS total_tires, COUNT(DISTINCT qp.mold_id) AS mold_count
    FROM tobeplan tp
    JOIN quick_plan qp ON tp.icode = qp.icode
    GROUP BY tp.icode
    ";

    // Prepare and execute the query
    $stmt = $db->prepare($query);
    $stmt->execute();

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        $icode = $row['icode'];
        $totalTires = $row['total_tires'];
        $moldCount = $row['mold_count'];

        // SQL query to get the count per mold_id for the given tires_per_mold
        $subQuery = "
        SELECT qp.mold_id, COUNT(*) AS count, qp.cavity_id
        FROM tobeplan tp
        JOIN quick_plan qp ON tp.icode = qp.icode
        WHERE tp.icode = :icode
        GROUP BY qp.mold_id
        ";

        // Prepare and execute the subquery
        $subStmt = $db->prepare($subQuery);
        $subStmt->bindValue(':icode', $icode);
        $subStmt->execute();

        // Fetch the subquery results
        $subResults = $subStmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate the updated tires_per_mold for each mold ID
        $updatedTiresPerMold = intval($totalTires / $moldCount);
        $updatedTiresPerMold = max(0, $updatedTiresPerMold);

        // Calculate the sum of the number of tires per mold for this icode
        $totalTiresPerMoldSum = $updatedTiresPerMold * $moldCount;

        if ($totalTires !== $totalTiresPerMoldSum) {
            // Calculate the difference and distribute among molds
            $difference = $totalTires - $totalTiresPerMoldSum;
            $differencePerMold = intval($difference / $moldCount);
            $remainingDifference = $difference % $moldCount;

            foreach ($subResults as $subRow) {
                $moldId = $subRow['mold_id'];
                $count = $subRow['count'];
                $cavityId = $subRow['cavity_id'];

                // Calculate the tires_per_mold for the current mold
                $updatedTiresPerMoldMold = $updatedTiresPerMold + $differencePerMold;

                // If there's a remaining difference, distribute it among the molds starting from the first one
                if ($remainingDifference > 0) {
                    $updatedTiresPerMoldMold += 1;
                    $remainingDifference--;
                }

                // Set the tires_per_mold to 0 if it has a negative transition
                $updatedTiresPerMoldMold = max(0, $updatedTiresPerMoldMold);

                // Fetch mold_name and cavity_name based on mold_id and cavity_id
                $moldId = $subRow['mold_id'];
                $cavityId = $subRow['cavity_id'];

                $moldQuery = "SELECT mold_name FROM mold WHERE mold_id = :mold_id";
                $moldStmt = $db->prepare($moldQuery);
                $moldStmt->bindValue(':mold_id', $moldId);
                $moldStmt->execute();
                $moldRow = $moldStmt->fetch(PDO::FETCH_ASSOC);
                $moldName = $moldRow['mold_name'];

                $cavityQuery = "SELECT cavity_name FROM cavity WHERE cavity_id = :cavity_id";
                $cavityStmt = $db->prepare($cavityQuery);
                $cavityStmt->bindValue(':cavity_id', $cavityId);
                $cavityStmt->execute();
                $cavityRow = $cavityStmt->fetch(PDO::FETCH_ASSOC);
                $cavityName = $cavityRow['cavity_name'];

                // Fetch press_name based on cavity_id from the production_plan database
                $pressQuery = "SELECT press_name FROM production_plan WHERE cavity_id = :cavity_id";
                $pressStmt = $db->prepare($pressQuery);
                $pressStmt->bindValue(':cavity_id', $cavityId);
                $pressStmt->execute();
                $pressRow = $pressStmt->fetch(PDO::FETCH_ASSOC);
                $pressName = $pressRow['press_name'];

                // Insert data into the "process" table, including mold_name, cavity_name, and press_name
                $insertQuery = "
                INSERT INTO process (icode, mold_id, cavity_id, tires_per_mold, mold_name, cavity_name, press_name)
                VALUES (:icode, :mold_id, :cavity_id, :tires_per_mold, :mold_name, :cavity_name, :press_name)
                ";

                $insertStmt = $db->prepare($insertQuery);
                $insertStmt->bindValue(':icode', $icode);
                $insertStmt->bindValue(':mold_id', $moldId);
                $insertStmt->bindValue(':cavity_id', $cavityId);
                $insertStmt->bindValue(':tires_per_mold', $updatedTiresPerMoldMold);
                $insertStmt->bindValue(':mold_name', $moldName);
                $insertStmt->bindValue(':cavity_name', $cavityName);
                $insertStmt->bindValue(':press_name', $pressName);
                $insertStmt->execute();
            }
        }
    }


} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update ERP numbers
$sqlUpdateERP = "
    UPDATE process p
    JOIN production_plan pp ON p.icode = pp.icode
    SET p.erp = pp.erp
";

if ($conn->query($sqlUpdateERP) === TRUE) {
    echo "ERP numbers updated successfully<br>";
} else {
    echo "Error updating ERP numbers: " . $conn->error . "<br>";
}

// SQL query to select rows from the 'process' table ordered by 'icode' and 'id'
$sqlSelect = "SELECT * FROM process ORDER BY icode, id";

$result = $conn->query($sqlSelect);

$current_icode = null; // Variable to keep track of the current 'icode' value
$counter = 0; // Counter for numbering rows within each group

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $icode = $row['icode'];

        // Check if 'icode' value has changed
        if ($icode != $current_icode) {
            // Display a header for the new group
            echo "<h2>Group $icode</h2>";
            $current_icode = $icode;

            // Reset the counter for the new group
            $counter = 0;
        }

        // Increment the counter and display it
        $counter++;
        echo "<p>{$counter}. {$row['mold_name']}</p>"; // Replace 'column_name' with your actual column names

        // Update the 'serial' column in the database
        $serial = $counter;
        $updateSql = "UPDATE process SET serial = $serial WHERE id = {$row['id']}";
        $conn->query($updateSql);
    }
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();

    //Redirect to another page after the data is inserted successfully
   header("Location: plannew45.php");
    exit(); // Make sure to add this exit() to stop further execution
?>
</body>
</html>



<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        input[type='text'] {
            width: 60px;
        }

        input[type='submit'] {
            margin-top: 10px;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
<?php
// Database connection settings
$host = 'localhost';
$dbname = 'task_management';
$username = 'root';
$password = '';

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

    // Start the form
    echo "<form method='post' action='update.php'>"; // Replace 'update.php' with the desired update script

    // Display the results in a table
    echo "<table>";
    echo "<tr><th>icode</th><th>Number of tobess</th><th>Mold ID</th><th>Cavity ID</th><th>Tires per Mold</th></tr>";

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

        // Check if the total number of tires per mold is not equal to the total tires for this icode
        if ($totalTires !== $totalTiresPerMoldSum) {
            $difference = $totalTires - $totalTiresPerMoldSum;

            // Calculate the difference per mold
            $differencePerMold = intval($difference / $moldCount);

            // Calculate the remaining difference that could not be evenly distributed among molds
            $remainingDifference = $difference % $moldCount;

            // Display the results
            echo "<tr>";
            echo "<td rowspan='" . count($subResults) . "'>$icode</td>";
            echo "<td rowspan='" . count($subResults) . "'>$totalTires</td>";

            $firstRow = true;

            foreach ($subResults as $subRow) {
                $moldId = $subRow['mold_id'];
                $count = $subRow['count'];
                $cavityId = $subRow['cavity_id'];

                if (!$firstRow) {
                    echo "<tr>";
                }

                echo "<td>$moldId</td>";
                echo "<td>$cavityId</td>";

                // Calculate the tires_per_mold for the current mold
                $updatedTiresPerMoldMold = $updatedTiresPerMold + $differencePerMold;

                // If there's a remaining difference, distribute it among the molds starting from the first one
                if ($remainingDifference > 0) {
                    $updatedTiresPerMoldMold += 1;
                    $remainingDifference--;
                }
          
                // Set the tires_per_mold to 0 if it has a negative transition
                $updatedTiresPerMoldMold = max(0, $updatedTiresPerMoldMold);

                echo "<td><input type='text' name='tires_per_mold[$icode][$moldId]' value='$updatedTiresPerMoldMold'></td>";

                echo "</tr>";
                $firstRow = false;

                // ... (remaining code)
            }
        }
    }

    echo "</table>";

    // Add the update button
    echo "<input type='submit' name='submit' value='Update'>";
    echo "</form>";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


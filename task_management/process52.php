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

    // Redirect to another page after the data is inserted successfully
    header("Location: updatepro.php");
    exit(); // Make sure to add this exit() to stop further execution

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
</body>
</html>

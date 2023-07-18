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

    // Display the results
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
        $updatedTiresPerMold = $totalTires / $moldCount;

        // Display the results
        echo "icode: $icode<br>";

        foreach ($subResults as $subRow) {
            $moldId = $subRow['mold_id'];
            $count = $subRow['count'];
            $cavityId = $subRow['cavity_id'];
            echo "mold_id: $moldId, cavity_id: $cavityId<br>";

            echo "tires_per_mold: <input type='text' name='tires_per_mold[$icode][$moldId]' value='$updatedTiresPerMold'><br>";
            echo "cavity_id: $cavityId <br>";
            echo "<input type='hidden' name='icode' value='$icode'>";
            
            // Insert the data into the 'process' table
            $insertQuery = "INSERT INTO process (icode, mold_id, cavity_id, tires_per_mold) VALUES (:icode, :moldId, :cavityId, :tiresPerMold)";
            $insertStmt = $db->prepare($insertQuery);
            $insertStmt->bindParam(':icode', $icode);
            $insertStmt->bindParam(':moldId', $moldId);
            $insertStmt->bindParam(':cavityId', $cavityId);
            $insertStmt->bindParam(':tiresPerMold', $updatedTiresPerMold);
            $insertStmt->execute();
        }

        echo "<br>";
    }

    // Add the update button
    echo "<input type='submit' name='submit' value='Update'>";
    echo "</form>";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

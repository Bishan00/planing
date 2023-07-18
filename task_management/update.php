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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the form is submitted
        
        // Retrieve the submitted form data
        $tiresPerMoldData = $_POST['tires_per_mold'];

        // Update the database table with the submitted data
        foreach ($tiresPerMoldData as $icode => $moldData) {
            foreach ($moldData as $moldId => $tiresPerMold) {
                // Update the 'process' table with the new tires_per_mold value
                $updateQuery = "UPDATE process SET tires_per_mold = :tiresPerMold WHERE icode = :icode AND mold_id = :moldId";
                $updateStmt = $db->prepare($updateQuery);
                $updateStmt->bindParam(':tiresPerMold', $tiresPerMold);
                $updateStmt->bindParam(':icode', $icode);
                $updateStmt->bindParam(':moldId', $moldId);
                $updateStmt->execute();
            }
        }

        echo "Data updated successfully.";
    } else {
        echo "Invalid request.";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

header("Location: plannew56.php");
exit();
?>

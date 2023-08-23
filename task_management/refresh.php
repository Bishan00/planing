<?php
// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get all distinct erp values from work_order table
    $erpQuery = "SELECT DISTINCT erp FROM worder";
    $erpStmt = $conn->prepare($erpQuery);
    $erpStmt->execute();
    $erpValues = $erpStmt->fetchAll(PDO::FETCH_COLUMN);

    // Update stock table for each erp value
    foreach ($erpValues as $erp) {
        $updateSql = "
            UPDATE stock t2
            INNER JOIN worder t1 ON t1.icode = t2.icode
            SET t2.cstock = CASE
                WHEN t1.new <= t2.cstock THEN t2.cstock - t1.new
                ELSE 0
            END
            WHERE t1.erp = :erp";

        $stmt = $conn->prepare($updateSql);
        $stmt->bindParam(':erp', $erp);
        $stmt->execute();
        
        echo "Update successful for ERP: $erp<br>";
    }

    echo "All updates completed!";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
header("Location: refresh3.php");
exit();
?>

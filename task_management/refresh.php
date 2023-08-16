<?php
ob_start(); // Start output buffering

include './includes/admin_header.php';
include './includes/data_base_save_update.php';
include 'includes/App_Code.php';
$AppCodeObj = new App_Code();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ... Previous code ...

// Get all ERPs from the worder table
$erpSql = "SELECT DISTINCT erp FROM worder";
$erpResult = $conn->query($erpSql);

if ($erpResult->num_rows > 0) {
    while ($erpRow = $erpResult->fetch_assoc()) {
        $erp = $erpRow['erp'];

        // Check if the work order already exists in tobeplan table
        $existingSql = "SELECT COUNT(*) as count FROM tobeplan1 WHERE erp = '$erp'";
        $existingResult = $conn->query($existingSql);
        $existingRow = $existingResult->fetch_assoc();
        $count = $existingRow['count'];

        if ($count > 0) {
            echo "Work order with ERP number $erp already exists.";
        } else {
            // Perform subtraction and insert result into result_table
            $sql = "INSERT INTO tobeplan (icode, tobe, erp, stockonhand)
                    SELECT t1.icode, t1.new - t2.cstock, t1.erp, t2.cstock
                    FROM worder t1
                    INNER JOIN stock t2 ON t1.icode = t2.icode
                    WHERE t1.erp = '$erp'";

            if ($conn->query($sql) === TRUE) {
                // Perform subtraction and update stock table
                $updateSql = "UPDATE stock t2
                              INNER JOIN worder t1 ON t1.icode = t2.icode
                              SET t2.cstock = CASE
                                  WHEN t1.new <= t2.cstock THEN t2.cstock - t1.new
                                  ELSE 0
                              END
                              WHERE t1.erp = '$erp'";

                if ($conn->query($updateSql) === TRUE) {
                    // Display a message or perform other actions for each ERP
                    echo "Processed ERP number: $erp<br>";
                    
                } else {
                    echo "Error updating stock for ERP $erp: " . $conn->error;
                }
            } else {
                echo "Error performing subtraction for ERP $erp: " . $conn->error;
            }
        }
    }
} else {
    echo "No ERPs found.";
}

// ... Rest of the code ...
header("Location: refresh3.php");
exit(); // Make sure to exit to prevent further execution
$conn->close();
ob_end_flush(); // Send output buffer and turn off output buffering

?>

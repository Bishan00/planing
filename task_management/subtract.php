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

if (isset($_POST['submit'])) {
    // Get the user-provided work order ID
    $erp = $_POST['erp'];

    // Check if the work order already exists in tobeplan table
    $existingSql = "SELECT COUNT(*) as count FROM tobeplan WHERE erp = '$erp'";
    $existingResult = $conn->query($existingSql);
    $existingRow = $existingResult->fetch_assoc();
    $count = $existingRow['count'];

    if ($count > 0) {
        echo "Work order with ERP number $erp already exists.";
    } else {
        // Perform subtraction and insert result into result_table
        $sql = "INSERT INTO tobeplan (icode, tobe, erp)
                SELECT t1.icode, t1.new - t2.cstock, t1.erp
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
                // Redirect to another page to display the relevant data
                header("Location: display.php?erp=$erp");
                exit;
            } else {
                echo "Error updating stock: " . $conn->error;
            }
        } else {
            echo "Error performing subtraction: " . $conn->error;
        }
    }
}

$conn->close();
ob_end_flush(); // Send output buffer and turn off output buffering
?>

<form method="POST" action="subtract.php">
    <label for="erp">Work Order ID:</label>
    <input type="text" name="erp" id="erp" required>
    <button type="submit" name="submit">Click Next</button>
</form>

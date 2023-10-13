<?php
// Replace with your actual database connection details
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = "";
$error_message = "";

// Check if a form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input for ERP number
    $erp_to_delete = $_POST["erp"];

    // Delete data from the `old_process` table based on the provided ERP number
    $sql_old_process = "DELETE FROM `old_process` WHERE `erp` = '$erp_to_delete'";

    // Delete data from the `wcopy` table based on the provided ERP number
    $sql_wcopy = "DELETE FROM `wcopy` WHERE `erp` = '$erp_to_delete'";

    // Perform both deletions in a transaction to ensure data consistency
    $conn->begin_transaction();

    if ($conn->query($sql_old_process) === TRUE && $conn->query($sql_wcopy) === TRUE) {
        $conn->commit();
        $success_message = "Data from both old_process and wcopy tables for ERP number $erp_to_delete deleted successfully.";
        header("Location: convertstockR.php");
        exit();
    } else {
        $conn->rollback();
        $error_message = "Error deleting data: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete ERP Data</title>
</head>
<body>
    <h2>Delete ERP Data</h2>
    <?php
    if (!empty($success_message)) {
        echo "<p style='color: green;'>$success_message</p>";
    }
    if (!empty($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        ERP Number: <input type="text" name="erp" required>
        <input type="submit" value="Delete">
    </form>
</body>
</html>







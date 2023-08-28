<?php
// Replace with your actual database connection details
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

$success_message = "";
$error_message = "";

// Check if a form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input for ERP number
    $erp_to_delete = $_POST["erp"];

    // Delete related data based on the provided ERP number
    $sql = "DELETE FROM `wcopy` WHERE `erp` = '$erp_to_delete'";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Related data for ERP number $erp_to_delete deleted successfully.";
        // Redirect to the next page after successful delete
        header("Location: convertstockR.php");
        exit();
    } else {
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

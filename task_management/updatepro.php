<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
    UPDATE process p
    JOIN old_process po ON p.icode = po.icode AND p.mold_id = po.mold_id
    SET p.cavity_name = po.cavity_name,
        p.cavity_id = po.cavity_id
";

if ($conn->query($sql) === TRUE) {
    echo "Records updated successfully";
} else {
    echo "Error updating records: " . $conn->error;
}

$conn->close();
header("Location: sleep3.php");
exit();
?>


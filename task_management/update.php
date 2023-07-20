<?php
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "task_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$icode = $_POST['icode'];
$mold = $_POST['mold'];
$press = $_POST['press'];
$cavity = $_POST['cavity'];
$isChecked = $_POST['isChecked'] ? 1 : 0;

// Update the "process" table with the new checkbox value
if (!empty($mold)) {
    $sql = "UPDATE process SET is_selected_mold = $isChecked WHERE icode = '$icode' AND mold_name = '$mold'";
    $conn->query($sql);
}

if (!empty($cavity)) {
    $sql = "UPDATE process SET is_selected_cavity = $isChecked WHERE icode = '$icode' AND mold_name = '$mold' AND cavity_name = '$cavity'";
    $conn->query($sql);
}

$conn->close();
?>

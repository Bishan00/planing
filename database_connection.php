<?php
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database = "planatir_task_management";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

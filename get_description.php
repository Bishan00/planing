<?php
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['icode']) && isset($_GET['id'])) {
    $icode = $_GET['icode'];
    $id = $_GET['id'];
    $sql = "SELECT description FROM tire WHERE icode = '$icode'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['description'];
    }
}

$conn->close();
?>

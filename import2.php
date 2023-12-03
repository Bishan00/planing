<?php
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "UPDATE worder
            JOIN work_order ON worder.erp = work_order.erp
            SET worder.date = work_order.datetime";
    
    $conn->exec($sql);
    
    echo "Dates updated successfully!";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
header("Location: convertstock.php");
exit();

?>

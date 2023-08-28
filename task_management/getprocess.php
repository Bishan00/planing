<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "INSERT INTO `old_process` (
    `icode`, `mold_id`, `tires_per_mold`, `cavity_id`,
    `mold_name`, `cavity_name`, `press_name`, `press_id`, `erp`
  )
  SELECT
    `p`.`icode`, `p`.`mold_id`, `p`.`tires_per_mold`, `p`.`cavity_id`,
    `p`.`mold_name`, `p`.`cavity_name`, `p`.`press_name`, `p`.`press_id`,
    (SELECT `pp`.`erp` FROM `production_plan` `pp` WHERE `pp`.`mold_id` = `p`.`mold_id` LIMIT 1)
  FROM `process` `p`";
  
if ($conn->query($query) === TRUE) {
    echo "Data copied successfully!";
} else {
    echo "Error copying data: " . $conn->error;
}

// Close the connection
$conn->close();
header("Location: deleteall.php");
exit();
?>

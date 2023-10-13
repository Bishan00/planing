<?php
// Replace with your own database credentials
$hostname = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database_name = "planatir_task_management";

// Create a database connection
$mysqli = new mysqli($hostname, $username, $password, $database_name);

// Check if the connection was successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Create the combined_data table if it doesn't exist
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS `combinedd_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `press` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mold` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)";

if ($mysqli->query($sqlCreateTable) === TRUE) {
    echo "Table combined_data created successfully<br>";
} else {
    echo "Error creating table: " . $mysqli->error . "<br>";
}

// Copy data from vertical_press_data to combined_data
$sqlCopyPressData = "INSERT INTO `combinedd_data` (`press`) SELECT `press` FROM `vertical_press_data`";
if ($mysqli->query($sqlCopyPressData) === TRUE) {
    echo "Data from vertical_press_data copied successfully<br>";
} else {
    echo "Error copying data: " . $mysqli->error . "<br>";
}

// Copy data from vertical_mold_data to combined_data
$sqlCopyMoldData = "UPDATE `combinedd_data`, `vertical_mold_data` SET `combinedd_data`.`mold` = `vertical_mold_data`.`mold` WHERE `combinedd_data`.`id` = `vertical_mold_data`.`id`";
if ($mysqli->query($sqlCopyMoldData) === TRUE) {
    echo "Data from vertical_mold_data copied successfully<br>";
} else {
    echo "Error copying data: " . $mysqli->error . "<br>";
}

// Close the database connection
$mysqli->close();
?>

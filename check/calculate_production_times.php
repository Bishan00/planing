<?php

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tire_production";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Query the database to get the total number of tires to produce
$total_tires_query = mysqli_query($conn, "SELECT SUM(quantity) as total_tires FROM tires");
$total_tires_row = mysqli_fetch_assoc($total_tires_query);
$total_tires = $total_tires_row['total_tires'];

// Calculate the production time for each tire type
$tire_types_query = mysqli_query($conn, "SELECT DISTINCT tire_type FROM tires");

while ($tire_type_row = mysqli_fetch_assoc($tire_types_query)) {
  $tire_type = $tire_type_row['tire_type'];
  
  // Query the database to get the total production rate for this tire type
  $total_production_rate_query = mysqli_query($conn, "SELECT SUM(production_rate) as total_production_rate FROM presses WHERE tire_type='$tire_type'");
  $total_production_rate_row = mysqli_fetch_assoc($total_production_rate_query);
  $total_production_rate = $total_production_rate_row['total_production_rate'];
  
  // Query the database to get the total number of molds for this tire type
  $total_molds_query = mysqli_query($conn, "SELECT COUNT(*) as total_molds FROM molds INNER JOIN presses ON molds.press_id=presses.id WHERE molds.tire_type='$tire_type' AND presses.tire_type='$tire_type'");
  $total_molds_row = mysqli_fetch_assoc($total_molds_query);
  $total_molds = $total_molds_row['total_molds'];
  
  // Calculate the time it takes to produce all the tires of this type
  $total_time = ceil($total_tires / ($total_production_rate * $total_molds));
  
  // Store the production time in the database
  mysqli_query($conn, "INSERT INTO production_times (tire_type, production_time) VALUES ('$tire_type', $total_time)");
}

// Close the database connection
mysqli_close($conn);

?>

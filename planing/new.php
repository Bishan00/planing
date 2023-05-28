<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newr";

// Create a connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === false) {
    die("Database creation failed: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create the work_order table
$sql = "CREATE TABLE IF NOT EXISTS work_order (
  work_order_id INT PRIMARY KEY,
  tire_id INT,
  quantity INT
)";
if ($conn->query($sql) === false) {
    die("Table creation failed: " . $conn->error);
}

// Create the tire table
$sql = "CREATE TABLE IF NOT EXISTS tire (
  tire_id INT PRIMARY KEY,
  time_taken FLOAT
)";
if ($conn->query($sql) === false) {
    die("Table creation failed: " . $conn->error);
}

// Create the mold table
$sql = "CREATE TABLE IF NOT EXISTS mold (
  mold_id INT PRIMARY KEY,
  tire_id INT
)";
if ($conn->query($sql) === false) {
    die("Table creation failed: " . $conn->error);
}

// Create the press table
$sql = "CREATE TABLE IF NOT EXISTS press (
  press_id INT PRIMARY KEY,
  mold_id INT
)";
if ($conn->query($sql) === false) {
    die("Table creation failed: " . $conn->error);
}

// Insert sample data into the work_order table
$sql = "INSERT INTO work_order (work_order_id, tire_id, quantity) VALUES
  (1, 1, 100),
  (2, 2, 200),
  (3, 3, 150)";
if ($conn->query($sql) === false) {
    die("Data insertion failed: " . $conn->error);
}

// Insert sample data into the tire table
$sql = "INSERT INTO tire (tire_id, time_taken) VALUES
  (1, 0.5),
  (2, 0.75),
  (3, 1.0)";
if ($conn->query($sql) === false) {
    die("Data insertion failed: " . $conn->error);
}

// Insert sample data into the mold table
$sql = "INSERT INTO mold (mold_id, tire_id) VALUES
  (1, 1),
  (2, 2),
  (3, 2),
  (4, 3)";
if ($conn->query($sql) === false) {
    die("Data insertion failed: " . $conn->error);
}

// Insert sample data into the press table
$sql = "INSERT INTO press (press_id, mold_id) VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4)";
if ($conn->query($sql) === false) {
    die("Data insertion failed: " . $conn->error);
}

// Close the database connection
$conn->close();
?>

<?php

// Define database connection parameters
$host = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Connect to database
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get the ID from the search box
$id = $_GET['id'];

// Query to retrieve data from the first table based on the ID
$sql = "SELECT * FROM table1 WHERE id = '$id'";

// Perform the query and store the result in a variable
$result = mysqli_query($conn, $sql);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {

  // Retrieve the row data
  $row = mysqli_fetch_assoc($result);

  // Get additional data from another table using a JOIN statement
  $sql2 = "SELECT * FROM table2 JOIN table1 ON table2.id = table1.id WHERE table2.id = '$id'";
  $result2 = mysqli_query($conn, $sql2);

  // Display the data from both tables
  echo "Data from Table 1:<br>";
  echo "ID: " . $row['id'] . "<br>";
  echo "Name: " . $row['name'] . "<br>";
  echo "<br>";
  echo "Data from Table 2:<br>";
  while ($row2 = mysqli_fetch_assoc($result2)) {
    echo "ID: " . $row2['id'] . "<br>";
    echo "Field 1: " . $row2['field1'] . "<br>";
    echo "Field 2: " . $row2['field2'] . "<br>";
    echo "<br>";
  }

} else {
  echo "No results found.";
}

// Close the database connection
mysqli_close($conn);

?>

<?php
// connect to MySQL database
$host = 'localhost';
$username = 'your_username';
$password = 'your_password';
$database = 'your_database';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
  die('Failed to connect to database: ' . mysqli_connect_error());
}

// retrieve data from a form and insert into first table
$name = $_POST['name'];
$email = $_POST['email'];
// add more fields as needed

$insert_query = "INSERT INTO first_table (name, email) VALUES ('$name', '$email')";
$insert_result = mysqli_query($conn, $insert_query);

if ($insert_result) {
  // if the insert was successful, retrieve data from second table
  $select_query = "SELECT * FROM second_table WHERE name = '$name'";
  $select_result = mysqli_query($conn, $select_query);

  // loop through the results and display the data
  while ($row = mysqli_fetch_assoc($select_result)) {
    echo "Name: " . $row['name'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    // add more fields as needed
  }
} else {
  // handle the case where the insert failed
  echo "Failed to insert data";
}

// close database connection
mysqli_close($conn);
?>

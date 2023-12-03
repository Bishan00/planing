<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: 'Cantarell', sans-serif;
      background: url('atire2.jpg') center/cover no-repeat; /* Set the background image */
      display: flex;
      justify-content: center; /* Center horizontally */
      align-items: center; /* Center vertically */
      height: 100vh;
      margin: 0; /* Remove default margin for full-page background */
    }
    .container {
      text-align: center;
    }
    .gradient-button {
  background: #F28018;
  color: #FFFFFF;
  font-family: 'Cantarell', sans-serif;
  font-weight: bold;
  font-size: 16px;
  border: none;
  cursor: pointer;
  border-radius: 60px;
  text-transform: uppercase;
  padding: 10px 20px;
  margin: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: background 0.3s, color 0.3s;
  width: 350px; /* Set the width of the buttons */
  height: 50px; /* Set the height of the buttons */
}

    .gradient-button:hover {
      background: #000000;
      color: #F28018;
    }
  </style>
</head>
<body>
  <div class="container">
    <form method="post" action="">
      <input type="submit" name="button1" value="Saleble Stock" class="gradient-button">
    </form>
    <form method="post" action="">
      <input type="submit" name="button2" value="Hold Stock" class="gradient-button">
    </form>


  </div>
</body>


</html>

<?php
// Your PHP code begins here

// Assuming you have established a connection to your MySQL database
$host = 'localhost'; // Your database host
$username = 'planatir_task_management'; // Your database username
$password = 'Bishan@1919'; // Your database password
$database = 'planatir_task_management'; // Your database name

// Create a connection to the database
$connection = mysqli_connect($host, $username, $password, $database);

// Function to execute MySQL queries
function executeQuery($query, $connection) {
    // Execute the query
    $result = mysqli_query($connection, $query);

    // Check for errors
    if (!$result) {
        die("Query execution failed: " . mysqli_error($connection));
    }

    // Return the result
    return $result;
}

// Check if a button is clicked and handle the click
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['button1'])) {
        // Redirect to the desired page when Button 1 is clicked
        header("Location: stock.php");
        exit();
    } elseif (isset($_POST['button2'])) {
        // Redirect to the desired page when Button 2 is clicked
        header("Location: stockb.php");
        exit();
    }
}



// Close the database connection (if necessary)
mysqli_close($connection);
?>

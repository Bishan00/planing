<style>
  .mismatched {
    background-color: yellow;
  }
</style>

<?php
// Establish a connection to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "task_management";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Compare and display mismatched data
if (isset($_POST['compare'])) {
    // Query the order table and data table to fetch the relevant data
   // Fetch the data from the order table
   $orderQuery = "SELECT * FROM worder";
   $orderResult = mysqli_query($conn, $orderQuery);

   if (!$orderResult) {
       die("Error executing order query: " . mysqli_error($conn));
   }

   // Fetch the data from the data table
   $dataQuery = "SELECT * FROM selectpress";
   $dataResult = mysqli_query($conn, $dataQuery);

   if (!$dataResult) {
       die("Error executing data query: " . mysqli_error($conn));
   }
    // Display the data in a table
    echo '<table>';
    echo '<tr>';
    echo '<th>Tire ID</th>';
    echo '<th>Tire Size</th>';
    echo '<th>Brand</th>';
    echo '<th>Fit</th>';
    echo '<th>Colour</th>';
    echo '<th>Rim</th>';
    echo '</tr>';


    while ($orderRow = mysqli_fetch_assoc($orderResult)) {
        $dataRow = mysqli_fetch_assoc($dataResult);

        // Compare each column and highlight mismatches
        $mismatch = false;
        if (
            $orderRow['t_size'] !== $dataRow['t_size'] ||
            $orderRow['brand'] !== $dataRow['brand'] ||
            $orderRow['fit'] !== $dataRow['fit'] ||
            $orderRow['col'] !== $dataRow['col'] ||
            $orderRow['rim'] !== $dataRow['rim'] 
            
        ) {
            $mismatch = true;
        }

        // Add table row with data
        echo '<tr' . ($mismatch ? ' class="mismatched"' : '') . '>';
        echo '<td>' . $orderRow['icode'] . '</td>';
        echo '<td>' . $orderRow['t_size'] . '</td>';
        echo '<td>' . $orderRow['brand'] . '</td>';
        echo '<td>' . $orderRow['fit'] . '</td>';
        echo '<td>' . $orderRow['col'] . '</td>';
        echo '<td>' . $orderRow['rim'] . '</td>';
     
        echo '</tr>';
    }

    echo '</table>';
} else {
    // ...
}
?>
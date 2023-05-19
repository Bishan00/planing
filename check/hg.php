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
$database = "tires";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Compare and display mismatched data
if (isset($_POST['compare'])) {
    // Query the order table and data table to fetch the relevant data
   // Fetch the data from the order table
   $orderQuery = "SELECT * FROM order_table";
   $orderResult = mysqli_query($conn, $orderQuery);

   if (!$orderResult) {
       die("Error executing order query: " . mysqli_error($conn));
   }

   // Fetch the data from the data table
   $dataQuery = "SELECT * FROM data_table";
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
    echo '<th>Colour</th>';
    echo '<th>Fit</th>';
    echo '<th>Ri</th>';

    echo '<th>Average Finish Tire weight - kgs</th>';
    echo '<th>Per Voloume/cbm</th>';
    echo '<th>Total Volume cbm</th>';

    echo '</tr>';


    while ($orderRow = mysqli_fetch_assoc($orderResult)) {
        $dataRow = mysqli_fetch_assoc($dataResult);

        // Compare each column and highlight mismatches
        $mismatch = false;
        if (
            $orderRow['Tire Size'] !== $dataRow['Tire Size'] ||
            $orderRow['Brand'] !== $dataRow['Brand'] ||
            $orderRow['Colour'] !== $dataRow['Color'] ||
            $orderRow['Fit'] !== $dataRow['Fit'] ||
            $orderRow['Rim'] !== $dataRow['Rim'] ||
         
            $orderRow['Average Finish Tire weight - kgs'] !== $dataRow['Average Finish Tire Weight - kgs'] ||
            $orderRow['Per Voloume/cbm'] !== $dataRow['Per Voloume/cbm'] ||
            $orderRow['Total Volume cbm'] !== $dataRow['Total Volume cbm'] 
            
        ) {
            $mismatch = true;
        }

        // Add table row with data
        echo '<tr' . ($mismatch ? ' class="mismatched"' : '') . '>';
        echo '<td>' . $orderRow['Tireid'] . '</td>';
        echo '<td>' . $orderRow['Tire Size'] . '</td>';
        echo '<td>' . $orderRow['Brand'] . '</td>';
        echo '<td>' . $orderRow['Colour'] . '</td>';
        echo '<td>' . $orderRow['Fit'] . '</td>';
        echo '<td>' . $orderRow['Rim'] . '</td>';
      
        echo '<td>' . $orderRow['Average Finish Tire weight - kgs'] . '</td>';
        echo '<td>' . $orderRow['Per Voloume/cbm'] . '</td>';
        echo '<td>' . $orderRow['Total Volume cbm'] . '</td>';
     
        echo '</tr>';
    }

    echo '</table>';
} else {
    // ...
}
?>
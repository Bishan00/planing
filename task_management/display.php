<?php
// display.php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
include 'includes/App_Code.php';
$AppCodeObj = new App_Code();

$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the ERP from the URL parameter
$erp = $_GET['erp'];

// Fetch data from tobeplan table for the specified ERP
$sql = "SELECT * FROM tobeplan WHERE erp = '$erp'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display the fetched data in a table
    echo "<table>";
    echo "<tr><th>ERP</th><th>ICODE</th><th>Description</th><th>Order Quantity</th><th>TOBE</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['erp'] . "</td>";
        echo "<td>" . $row['icode'] . "</td>";

          // Fetch description from the tire table based on icode
          $icode = $row['icode'];
          $description = "";
          $descriptionQuery = "SELECT description FROM tire WHERE icode = '$icode'";
          $descriptionResult = $conn->query($descriptionQuery);
          if ($descriptionResult->num_rows > 0) {
              $descriptionRow = $descriptionResult->fetch_assoc();
              $description = $descriptionRow['description'];
          }
  
          echo "<td>" . $description . "</td>";
        // Fetch new value from the worder table based on erp and icode
        $newQuery = "SELECT new FROM worder WHERE erp = '$erp' AND icode = '$icode'";
        $newResult = $conn->query($newQuery);
        if ($newResult->num_rows > 0) {
            $newRow = $newResult->fetch_assoc();
            $newValue = $newRow['new'];
        } else {
            $newValue = "N/A";
        }

        echo "<td>" . $newValue . "</td>";

        echo "<td>" . $row['tobe'] . "</td>";
       
        // Fetch new value from the worder table based on erp and icode
        $newQuery = "SELECT new FROM worder WHERE erp = '$erp' AND icode = '$icode'";
        $newResult = $conn->query($newQuery);
        if ($newResult->num_rows > 0) {
            $newRow = $newResult->fetch_assoc();
            $newValue = $newRow['new'];
        } else {
            $newValue = "N/A";
        }

        

      


        echo "</tr>";
    }
    echo "</table>";

    // Add a button to send the ERP number to another page
    echo "<form action='plannew34.php' method='get'>";
    echo "<input type='hidden' name='erp' value='" . $erp . "'>";
    echo "<button type='submit'>Generate Plan</button>";
    echo "</form>";
} else {
    echo "No data found for the provided ERP.";
}

$conn->close();
?>
 <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            padding: 8px;
            width: 200px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            padding: 8px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        select {
            padding: 6px;
            width: 100%;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[name="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Colorful design */
        h2, button[type="submit"], button[name="submit"] {
            background-color: #2196F3;
        }

        th {
            background-color: #2196F3;
        }

        tr:nth-child(even) {
            background-color: #E3F2FD;
        }

        select[name^="press_"] {
            background-color: #BBDEFB;
            color: #000;
        }

        select[name^="mold_"] {
            background-color: #64B5F6;
            color: #fff;
        }

        select[name^="cavity_"] {
            background-color: #1976D2;
            color: #fff;
        }
    </style>
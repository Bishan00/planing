<?php
// display.php

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

// Initialize variables to store the totals
$totalOrderQuantity = 0;
$totalTobePositive = 0;

if ($result->num_rows > 0) {
    // Create a table to store the data
    echo "<table style='border-collapse: collapse; width: 100%;'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th style='background-color: #F28018; color: #000000; font-family: \"Cantarell Regular\", sans-serif; padding: 10px;'>ERP</th>";
    echo "<th style='background-color: #F28018; color: #000000; font-family: \"Cantarell Regular\", sans-serif; padding: 10px;'>ICODE</th>";
    echo "<th style='background-color: #F28018; color: #000000; font-family: \"Cantarell Regular\", sans-serif; padding: 10px;'>Description</th>";
    echo "<th style='background-color: #F28018; color: #000000; font-family: \"Cantarell Regular\", sans-serif; padding: 10px;'>Order Quantity</th>";
    echo "<th style='background-color: #F28018; color: #000000; font-family: \"Cantarell Regular\", sans-serif; padding: 10px;'>TOBE</th>";
    echo "</tr>";
    echo "</thead>";

    while ($row = $result->fetch_assoc()) {
        // Fetch new value from the worder table based on erp and icode
        $newQuery = "SELECT new FROM worder WHERE erp = '$erp' AND icode = '{$row['icode']}'";
        $newResult = $conn->query($newQuery);
        if ($newResult->num_rows > 0) {
            $newRow = $newResult->fetch_assoc();
            $newValue = $newRow['new'];
        } else {
            $newValue = "N/A";
        }

        // Update the totals
        $totalOrderQuantity += (int)$newValue;
        $tobe = (int)$row['tobe'];
        if ($tobe > 0) {
            $totalTobePositive += $tobe;
        }

        echo "<tr>";
        echo "<td style='padding: 10px; border: 1px solid #F28018;'>" . $row['erp'] . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #F28018;'>" . $row['icode'] . "</td>";

        // Fetch description from the tire table based on icode
        $description = "";
        $descriptionQuery = "SELECT description FROM tire WHERE icode = '{$row['icode']}'";
        $descriptionResult = $conn->query($descriptionQuery);
        if ($descriptionResult->num_rows > 0) {
            $descriptionRow = $descriptionResult->fetch_assoc();
            $description = $descriptionRow['description'];
        }

        echo "<td style='padding: 10px; border: 1px solid #F28018;'>" . $description . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #F28018;'>" . $newValue . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #F28018;'>" . $row['tobe'] . "</td>";
        echo "</tr>";
    }

    // Display the totals in the table head
    echo "<tr>";
    echo "<th colspan='3' style='background-color: #F28018; color: #000000; font-family: \"Cantarell Bold\", sans-serif; padding: 10px;'>Total</th>";
    echo "<th style='background-color: #F28018; color: #000000; font-family: \"Cantarell Bold\", sans-serif; padding: 10px;'>$totalOrderQuantity</th>";
    echo "<th style='background-color: #F28018; color: #000000; font-family: \"Cantarell Bold\", sans-serif; padding: 10px;'>$totalTobePositive</th>";
    echo "</tr>";

    echo "</table>";

    // Add a button to send the ERP number to another page
    echo "<form action='plannew34.php' method='get'>";
    echo "<input type='hidden' name='erp' value='" . $erp . "'>";
    echo "<button type='submit' style='background-color: #F28018; color: #000000; font-family: \"Cantarell Bold\", sans-serif; padding: 10px; border: none; cursor: pointer;'>Generate Plan</button>";
    echo "</form>";
} else {
    echo "No data found for the provided ERP.";
}

$conn->close();
?>
<style>
    body {
        font-family: "Open Sans Regular", sans-serif;
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
        padding: 10px;
        font-size: 16px;
        background-color: #F28018;
        color: #000000;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

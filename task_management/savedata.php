<!DOCTYPE html>
<html>
<head>
    <title>Production Plan Editor</title>
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
            background-color: #1976d1;
            color: #fff;
        }
    </style>
<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Establish database connection
    $conn = mysqli_connect("localhost", "root", "", "task_management");

    // Retrieve the ERP ID from the form submission
    $erp = isset($_POST['erp']) ? $_POST['erp'] : '';

    // Validate the ERP ID (you can add your own validation logic here)
    if (empty($erp)) {
        die("Please enter a valid ERP ID");
    }

    // Sanitize the ERP ID to prevent SQL injection
    $erp = mysqli_real_escape_string($conn, $erp);

    // Retrieve the data from the production_plan table for the given ERP ID
    $sql = "SELECT DISTINCT icode, description FROM production_plan WHERE erp = '$erp'";
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($result) {
        // Check if there are any rows returned
        if (mysqli_num_rows($result) > 0) {
            echo "<h3>Production Plan for ERP: $erp</h3>";
            echo "<table>";
            echo "<tr>
            <th>ICode</th>
            <th>Description</th>
            <th>Press</th>
            
            <th>Mold</th>
         
            <th>Cavity</th>
          
            <th>Order Quantity</th>
            <th>To Be Produced</th>
          </tr>";

            // Iterate over each row in the result set
            while ($row = mysqli_fetch_assoc($result)) {
                $icode = $row['icode'];
               
                // Retrieve the selected press value
                $selectedPress = isset($_POST['press_' . $icode]) ? $_POST['press_' . $icode] : '';
              
                // Retrieve the selected mold value
                $selectedMold = isset($_POST['mold_' . $icode]) ? $_POST['mold_' . $icode] : '';

                // Retrieve the selected cavity value
                $selectedCavity = isset($_POST['cavity_' . $icode]) ? $_POST['cavity_' . $icode] : '';

                // Save the selected values to the database
                saveSelectedValues($conn, $erp, $icode, $selectedPress, $selectedMold, $selectedCavity);

                echo "<tr>";
                echo "<td>$icode</td>";
               
                echo "<td>$selectedPress</td>";
               
                echo "<td>$selectedMold</td>";
             
                echo "<td>$selectedCavity</td>";
               
                echo "</tr>";
            }

            header("Location: plannew56.php");
exit();
        } else {
            echo "No data found in the production plan for ERP: $erp";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request method";
}
// Function to save the selected values to the database
function saveSelectedValues($conn, $erp, $icode, $press, $mold, $cavity) {
    // Retrieve the number of tobes for the tire type
    $tobeQuantity = getTobeQuantity($conn, $icode);

    // Retrieve the description, mold name, press name, and cavity name for the tire type
 
    // Prepare the INSERT statement
    $sql = "INSERT INTO selected_data (erp, icode, press,mold,cavity, tobe) VALUES ('$erp', '$icode', '$press','$mold','$cavity', '$tobeQuantity' )";

    // Execute the INSERT statement
    if (mysqli_query($conn, $sql)) {
        // Data inserted successfully
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Function to retrieve the number of tobes for a given tire type
function getTobeQuantity($conn, $icode) {
    // Replace 'tobeplan' with the actual table name where the tobe quantity is stored
    $sql = "SELECT tobe FROM tobeplan WHERE icode = '$icode'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['tobe'];
    }

    return 0; // Return 0 if no tobe quantity is found
}


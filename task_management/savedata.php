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
                $description = $row['description'];

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
                echo "<td>$description</td>";
                echo "<td>$selectedPress</td>";
                echo "<td>$selectedMold</td>";
                echo "<td>$selectedCavity</td>";
                echo "</tr>";
            }

            echo "</table>";
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

    // Prepare the INSERT statement
    $sql = "INSERT INTO selected_data (erp, icode, press, mold, cavity, tobe) VALUES ('$erp', '$icode', '$press', '$mold', '$cavity', '$tobeQuantity')";

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

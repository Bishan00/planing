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

        .curing-group {
        font-size: 12px;
        color: #999999;
    }
    </style>

<?php
ob_start(); // Start output buffering

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

// ... Previous code ...

if (isset($_POST['submit'])) {
    // Get the user-provided work order ID
    $erp = $_POST['erp'];

    // Check if the work order already exists in tobeplan table
    $existingSql = "SELECT COUNT(*) as count FROM tobeplan1 WHERE erp = '$erp'";
    $existingResult = $conn->query($existingSql);
    $existingRow = $existingResult->fetch_assoc();
    $count = $existingRow['count'];

    if ($count > 0) {
        echo "Work order with ERP number $erp already exists.";
    } else {
        // Perform subtraction and insert result into result_table
        $sql = "INSERT INTO tobeplan (icode, tobe, erp, stockonhand)
                SELECT t1.icode, t1.new - t2.cstock, t1.erp, t2.cstock
                FROM worder t1
                INNER JOIN stock t2 ON t1.icode = t2.icode
                WHERE t1.erp = '$erp'";

        if ($conn->query($sql) === TRUE) {
            // Perform subtraction and update stock table
            $updateSql = "UPDATE stock t2
                          INNER JOIN worder t1 ON t1.icode = t2.icode
                          SET t2.cstock = CASE
                              WHEN t1.new <= t2.cstock THEN t2.cstock - t1.new
                              ELSE 0
                          END
                          WHERE t1.erp = '$erp'";

            if ($conn->query($updateSql) === TRUE) {
                // Redirect to another page to display the relevant data
                header("Location: display.php?erp=$erp");
                exit;
            } else {
                echo "Error updating stock: " . $conn->error;
            }
        } else {
            echo "Error performing subtraction: " . $conn->error;
        }
    }
}

// ... Rest of the code ...


$conn->close();
ob_end_flush(); // Send output buffer and turn off output buffering
?>

<form method="POST" action="subtract.php">
    <label for="erp">Work Order ID:</label>
    <input type="text" name="erp" id="erp" required>
    <button type="submit" name="submit">Click Next</button>
</form>

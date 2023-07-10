
<?php
include './includes/admin_header.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 20px;
            text-align: center;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Data</h1>

        <form method="post" action="">
            <input type="text" name="erp" placeholder="Enter ERP Number">
            <br>
            <input type="submit" name="delete" value="Delete Data">
        </form>

        <?php
        // Remaining PHP code goes here
        ?>
    </div>
</body>
</html>


    <?php
    
    // MySQL database credentials
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'task_management';

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the delete button is clicked and ERP number is provided
    if (isset($_POST['delete']) && !empty($_POST['erp'])) {
        // Sanitize the input to prevent SQL injection
        $erpNumber = $conn->real_escape_string($_POST['erp']);

        // SQL query to delete data with the specified ERP number from the table
        $sql = "DELETE FROM plannew WHERE erp = '$erpNumber'";

        if ($conn->query($sql) === TRUE) {
            echo "Data with ERP number $erpNumber deleted successfully.";
        } else {
            echo "Error deleting data: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>

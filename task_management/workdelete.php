<!DOCTYPE html>
<html>
<head>
    <title>Delete Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            padding: 5px;
            width: 200px;
        }

        button[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 20px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Delete Information</h2>

    <?php
    // Assuming you have already established a MySQL database connection

    $servername = "localhost"; // Replace with your MySQL server name
    $username = "planatir_task_management"; // Replace with your MySQL username
    $password = "Bishan@1919"; // Replace with your MySQL password
    $dbname = "planatir_task_management"; // Replace with your MySQL database name

    // Create a new PDO instance
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }


    // Check if the ERP number is provided
    if (isset($_POST['erp'])) {
        $erpNumber = $_POST['erp'];

        // Prepare the delete statements for both tables
        $stmt1 = $pdo->prepare("DELETE FROM worder WHERE erp = :erpNumber");
        $stmt2 = $pdo->prepare("DELETE FROM work_order WHERE erp = :erpNumber");

        // Bind the parameter for both statements
        $stmt1->bindParam(':erpNumber', $erpNumber);
        $stmt2->bindParam(':erpNumber', $erpNumber);

        // Execute the delete statements
        $deleteSuccessful = $stmt1->execute() && $stmt2->execute();

        if ($deleteSuccessful) {
            // Deletion successful
            echo '<div class="message success">Information deleted successfully.</div>';
            echo '<script>window.location.href = "dashboard.php";</script>';
            exit; // Exit to prevent further execution
        } else {
            // Deletion failed
            echo '<div class="message error">An error occurred while deleting the information.</div>';
        }
    }
    ?>

    <!-- HTML form to input the ERP number -->
    <form method="POST" action="">
        <label for="erp">Enter ERP Number:</label>
        <input type="text" name="erp" id="erp">
        <button type="submit">Delete</button>
    </form>
</body>
</html>

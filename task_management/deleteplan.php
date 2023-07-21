
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
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: darkblue;
        }

        .message {
            margin-top: 20px;
            text-align: center;
             color:red;
        }

        .error {
            color: red;
        }
    </style>
</head>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Data</title>
    <style>
        .container {
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Data</h1>

        <form method="post" action="">
            <input type="submit" name="delete" value="Delete Data">
        </form>

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

        // Check if the delete button is clicked
        if (isset($_POST['delete'])) {
            // Start the deletion transaction
            $conn->begin_transaction();

            try {
                // Delete all data from the plannew table
                $deletePlannewSql = "DELETE FROM plannew";
                $conn->query($deletePlannewSql);

                // Update the availability_date of all presses in the 'press' table
                $updatePressSql = "UPDATE press SET availability_date = NOW()";
                $conn->query($updatePressSql);

                // Update the availability_date of all molds in the 'mold' table
                $updateMoldSql = "UPDATE mold SET availability_date = NOW()";
                $conn->query($updateMoldSql);

                // Update the availability_date of all cavities in the 'cavity' table
                $updateCavitySql = "UPDATE cavity SET availability_date = NOW()";
                $conn->query($updateCavitySql);

                 // Delete all data from the stock table
        $deleteStockSql = "DELETE FROM stock";
        $conn->query($deleteStockSql);

        
                 // Delete all data from the stock table
                 $deleteStockSql = "DELETE FROM tobeplan1";
                 $conn->query($deleteStockSql);
         

                // Commit the transaction if all queries are successful
                $conn->commit();

                echo "All data in the 'plannew' table has been deleted successfully, and the availability dates in the 'press', 'mold', and 'cavity' tables have been updated.";
            } catch (Exception $e) {
                // Rollback the transaction if an error occurs
                $conn->rollback();

                echo "Error deleting data: " . $e->getMessage();
            }
        }
        ?>
    </div>
</body>
</html>

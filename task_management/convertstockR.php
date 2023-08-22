<!DOCTYPE html>
<html>
<head>
    <title>Copy Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        h1 {
            color: #333333;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Please press the Next button</h1>
        <form action="convertstock.php" method="post">
            <input type="submit" name="copy_data" value="Next">
        </form>
    </div>
</body>
</html>

<?php
// Establish a connection to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "task_management";

$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the "Copy Data" button is clicked
if (isset($_POST['copy_data'])) {
    // Copy data from "realstock" table to "stock" table
    $copyQuery = "INSERT INTO stock SELECT * FROM realstock";
    
    if ($conn->query($copyQuery) === TRUE) {
        echo "Data copied successfully.";

        header("Location: subtract.php");
    exit();
    } else {
        echo "Error copying data: " . $conn->error;
        header("Location: .php");
        exit();
    }
}

// Close the database connection
$conn->close();
?>

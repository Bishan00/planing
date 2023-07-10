<?php
// Assuming you have established a connection to your MySQL database

// Function to execute MySQL queries
function executeQuery($query) {
    // Add your database connection code here

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Check for errors
    if (!$result) {
        die("Query execution failed: " . mysqli_error($connection));
    }

    // Close the connection
    mysqli_close($connection);

    // Return the result
    return $result;
}

// Check if the button is clicked
if (isset($_POST['button1'])) {
    // Code to execute when Button 1 is clicked
    // Redirect to the desired page
    header("Location: planning.php");
    exit();
}

if (isset($_POST['button2'])) {
    // Code to execute when Button 2 is clicked
    // Redirect to the desired page
    header("Location: erprange.php");
    exit();
}

if (isset($_POST['button3'])) {
    // Code to execute when Button 3 is clicked
    // Redirect to the desired page
    header("Location: page3.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Button Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
        }

        form {
            display: inline-block;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Button Example</h1>
    <form method="post" action="">
        <input type="submit" name="button1" value="Work Order Range">
        <input type="submit" name="button2" value="Button 2">
        <input type="submit" name="button3" value="Button 3">
    </form>
</body>
</html>

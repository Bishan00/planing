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
    header("Location: indwork.php");
    exit();
}

if (isset($_POST['button4'])) {
    // Code to execute when Button 3 is clicked
    // Redirect to the desired page
    header("Location: rangeerp.php");
    exit();
}


if (isset($_POST['button5'])) {
    // Code to execute when Button 3 is clicked
    // Redirect to the desired page
    header("Location: check_indi.php");
    exit();
}

if (isset($_POST['button6'])) {
    // Code to execute when Button 3 is clicked
    // Redirect to the desired page
    header("Location: check_indi3.php");
    exit();
}
if (isset($_POST['button7'])) {
    // Code to execute when Button 3 is clicked
    // Redirect to the desired page
    header("Location: compound.php");
    exit();
}
if (isset($_POST['button8'])) {
    // Code to execute when Button 3 is clicked
    // Redirect to the desired page
    header("Location: compound2.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Summery Report</title>
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
            background-color: blue;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color:lightblue;
        }
    </style>
</head>
<body>
    <h1>Summery Report</h1>
    <form method="post" action="">
        <input type="submit" name="button1" value="All Plan">
        <input type="submit" name="button2" value="TO BE Produce All Work Orders">
        <input type="submit" name="button3" value="Individual Work orders">
        <input type="submit" name="button4" value="Work Order range"><br><br>
        <input type="submit" name="button5" value="Individual date">
        <input type="submit" name="button6" value="All date">
        <input type="submit" name="button7" value="Compound Plan">
        <input type="submit" name="button8" value="All Compound Plan">
    </form>
</body>
</html>

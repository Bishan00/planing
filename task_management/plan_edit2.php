<!DOCTYPE html>
<html>
<head>
    <title>Data Copy</title>
</head>
<body>

<form method="post" action="copy_data.php">
    <input type="submit" name="copy_data" value="Click To Next">
</form>
<?php
// Database connection settings
$hostname = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database = "planatir_task_management";

// Create a database connection
$connection = mysqli_connect($hostname, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if a form submission for updating a record has occurred
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $icode = $_POST['icode'];
    $description = $_POST['description'];
    $moldName = $_POST['moldName'];
    $cavityName = $_POST['cavityName'];
    $plan = $_POST['plan'];
    
    $updateQuery = "UPDATE shift_plan 
                    SET Icode='$icode', Description='$description', MoldName='$moldName', 
                    CavityName='$cavityName', Plan='$plan' 
                    WHERE ID='$id'";
    
    if (mysqli_query($connection, $updateQuery)) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}

// SQL query to retrieve data from the shift_plan table
$query = "SELECT * FROM shift_plan";

// Execute the query
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Display the data in an HTML table with editable fields for specific columns
echo "<table border='1'>
    <tr>
        <th>ID</th>
        <th>Icode</th>
        <th>Description</th>
        <th>MoldName</th>
        <th>CavityName</th>
        <th>StartTime</th>
        <th>EndTime</th>
        <th>Plan</th>
        <th>Actions</th>
    </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<form method='post' action=''>
    <tr>
        <td><input type='hidden' name='id' value='" . $row['ID'] . "'>" . $row['ID'] . "</td>
        <td><input type='text' name='icode' value='" . $row['Icode'] . "'></td>
        <td><input type='text' name='description' value='" . $row['Description'] . "'></td>
        <td><input type='text' name='moldName' value='" . $row['MoldName'] . "'></td>
        <td><input type='text' name='cavityName' value='" . $row['CavityName'] . "'></td>
        <td>" . $row['StartTime'] . "</td>
        <td>" . $row['EndTime'] . "</td>
        <td><input type='text' name='plan' value='" . $row['Plan'] . "'></td>
        <td><input type='submit' name='update' value='Update'></td>
    </tr>
    </form>";
}

echo "</table>";

// Close the database connection
mysqli_close($connection);
?>



</body>
</html>

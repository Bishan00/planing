<form method="POST" action="process_form.php">
    <label for="id">Enter ID:</label>
    <input type="text" name="pid" id="pid">
    <br>
    
    <label for="label1">Label 1:</label>
    <input type="text" name="type" id="type">
    <br>
    <label for="label2">Label 2:</label>
    <input type="text" name="colour" id="colour">
    <br>
    <input type="submit" value="Submit">
</form>


<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the ID from the form
    $pid = $_POST["pid"];


    // Query the database to fetch the corresponding data
    $query = "SELECT * FROM bom WHERE pid = '$pid'";
    $result = $conn->query($query);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the data from the result set
        $row = $result->fetch_assoc();

        // Extract the necessary information
        $Tsize = $row["Tsize"];
        $brand = $row["brand"];

        // Extract the data from the included labels
        $type = $_POST["type"];
        $colour = $_POST["colour"];
        // Add more labels as needed

        
        // Insert or update the data in the target table
        $insertQuery = "INSERT INTO daily_production (pid,Tsize, brand, type, colour) VALUES ('$pid','$Tsize', '$brand', '$type', '$colour')";
        // Or use an update query if needed
        // $updateQuery = "UPDATE target_table SET name = '$name', email = '$email', label1 = '$label1', label2 = '$label2' WHERE id = '$id'";



        if ($conn->query($insertQuery) === TRUE) {
            echo "Data inserted successfully.";

            echo "<h2>Inserted Data:</h2>";
        echo "<label>ID: </label><span>$pid</span><br>";
        echo "<label>Tire Size: </label><span>$Tsize</span><br>";
        echo "<label>Brand </label><span>$brand</span><br>";
        
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    } else {
        echo "No data found for the provided ID.";
    }
}
?>

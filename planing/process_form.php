<form method="POST" action="process_form.php">

<label for="label1">date</label>
    <input type="date" name="procution" id="type">
    <br><br>
    <label for="mySelect">shift:</label>
<select id="shift">
  <option value="option1">DAY A</option>
  <option value="option2">NIGHT A</option>
  <option value="option2">DAY B</option>
  <option value="option2">NIGHT B</option>
  <option value="option2">DAY C</option>
  <option value="option2">NIGHT C</option>

</select>
<br>
    <label for="id">Enter ID:</label>
    <input type="text" name="icode" id="icode">
    <br>
    <label for="label1">Production</label>
    <input type="text" name="production" id="type">
    <br>
    <label for="label2">REMARKS</label>
    <input type="text" name="remarks" id="colour">
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
    $icode = $_POST["icode"];


    // Query the database to fetch the corresponding data
    $query = "SELECT * FROM worder WHERE icode = '$icode'";
    $result = $conn->query($query);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the data from the result set
        $row = $result->fetch_assoc();

        // Extract the necessary information
        $Tsize = $row["t_size"];
        $brand = $row["brand"];
        $gweight = $row["gweight"];

        // Extract the data from the included labels
        $type = $_POST["date"];
        $type = $_POST["type"];
        $colour = $_POST["colour"];
        // Add more labels as needed

        
        // Insert or update the data in the target table
        $insertQuery = "INSERT INTO daily_production (shift,date,icode,t_size,brand,gweight,colour) VALUES ('$pid','$Tsize', '$brand', '$gweight', '$colour')";
        // Or use an update query if needed
        // $updateQuery = "UPDATE target_table SET name = '$name', email = '$email', label1 = '$label1', label2 = '$label2' WHERE id = '$id'";



        if ($conn->query($insertQuery) === TRUE) {
            echo "Data inserted successfully.";

            echo "<h2>Inserted Data:</h2>";
        echo "<label>ID: </label><span>$icode</span><br>";
        echo "<label>Tire Size: </label><span>$Tsize</span><br>";
        echo "<label>Brand </label><span>$brand</span><br>";
        echo "<label>gweigth </label><span>$gweight</span><br>";
        
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    } else {
        echo "No data found for the provided ID.";
    }
}
?>

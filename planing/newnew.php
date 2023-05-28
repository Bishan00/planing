<?php

// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bis";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check if a mold is available for production
function isMoldAvailable($conn, $moldId, $startDate, $endDate)
{
    $sql = "SELECT COUNT(*) AS count FROM production_plan WHERE mold_id = $moldId AND end_date >= '$startDate' AND start_date <= '$endDate'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count = $row['count'];

    return $count == 0;
}

// Function to check if a press is available for production
function isPressAvailable($conn, $pressId, $startDate, $endDate)
{
    $sql = "SELECT COUNT(*) AS count FROM production_plan WHERE press_id = $pressId AND end_date >= '$startDate' AND start_date <= '$endDate'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count = $row['count'];

    return $count == 0;
}

// Function to plan production for a work order
function planProduction($conn, $workOrderId, $startDate, $endDate, $priority)
{
    // Retrieve the tire types and quantities for the work order
    $sql = "SELECT tire_id, quantity FROM work_order WHERE work_order_id = $workOrderId";
    $result = $conn->query($sql);

    // Iterate over the tires in the work order
    while ($row = $result->fetch_assoc()) {
        $tireId = $row['tire_id'];
        $quantity = $row['quantity'];
  //get the time taken for tire production
 // Function to get the time taken for tire production
function getTimeTaken($conn, $tireId, $quantity)
{
    $sql = "SELECT time_taken FROM tire WHERE tire_id = $tireId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $timeTakenPerTire = $row['time_taken'];
        $timeTaken = $timeTakenPerTire * $quantity;
        return $timeTaken;
    }

    return 0; // Return 0 if tire ID is not found or there's an error
}


      
    // Get the molds available for the tire
    $sql = "SELECT mold_id FROM mold_tire_mapping WHERE tire_id = $tireId";
    $moldResult = $conn->query($sql);

    // Iterate over the molds
    while ($moldRow = $moldResult->fetch_assoc()) {
        $moldId = $moldRow['mold_id'];
        
            // Get the presses available for the mold
            $sql = "SELECT press_id FROM mold_press_mapping WHERE mold_id = $moldId";
            $pressResult = $conn->query($sql);

            // Iterate over the presses
            while ($pressRow = $pressResult->fetch_assoc()) {
                $pressId = $pressRow['press_id'];

                // Check if the mold and press are available for production
                if (isMoldAvailable($conn, $moldId, $startDate, $endDate) && isPressAvailable($conn, $pressId, $startDate, $endDate)) {
                    // Plan the production
                    $sql = "INSERT INTO production_plan (work_order_id, tire_id, mold_id, press_id, start_date, end_date, priority) 
                            VALUES ($workOrderId, $tireId, $moldId, $pressId, '$startDate', '$endDate', $priority)";
                    $conn->query($sql);

                    // Update the start and end dates for the next production
                    $startDate = $endDate;
                    $endDate = date('Y-m-d H:i:s', strtotime($startDate . " + $timeTaken minutes"));

                    break; // Exit the loop as the production is planned for the current tire
                }
            }
        }
    }

    // Close the database connection
    $conn->close();
}

// Process the button click
if (isset($_POST['startProduction'])) {
    // Retrieve the work order ID and other necessary details
    $workOrderId = $_POST['workOrderId'];
    $priority = $_POST['priority'];
    $startDate = $_POST['startDate'];
    $endDate = $startDate; // Initialize the end date as the start date
    // Call the production planning function
planProduction($conn, $workOrderId, $startDate, $endDate, $priority);

// Redirect or display a success message
header("Location: newnew.php?success=true");
exit();
}
?>

<!-- HTML form with the button code -->
<form method="post" action="newnew.php">
    <input type="text" name="workOrderId" placeholder="Work Order ID" required>
    <input type="number" name="priority" placeholder="Priority" required>
    <input type="datetime-local" name="startDate" required>
    <button type="submit" name="startProduction">Start Production</button>
</form>
```

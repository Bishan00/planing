<?php
// Assuming you have already established a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store";

// Connect to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a new work order
if (isset($_POST['create_work_order'])) {
    // Retrieve the tire IDs for production from the work_orders table
    $workOrderId = $_POST['work_order_id'];
    $sql = "SELECT tire_id FROM work_orders WHERE id = $workOrderId";
    $result = mysqli_query($conn, $sql);
    
    $tireIds = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tireIds[] = $row['tire_id'];
    }
    
    // Retrieve the production times for the tires from the production_times table
    $productionTimes = [];
    foreach ($tireIds as $tireId) {
        $sql = "SELECT time_taken FROM production_times WHERE tire_id = $tireId";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $productionTimes[$tireId] = $row['time_taken'];
    }
    
    // Retrieve the molds and presses required for production
    $moldPressMap = [];
    foreach ($tireIds as $tireId) {
        $sql = "SELECT mold_id FROM tires WHERE id = $tireId";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $moldId = $row['mold_id'];
        
        $sql = "SELECT press_id FROM molds WHERE id = $moldId";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $pressId = $row['press_id'];
        
        $moldPressMap[$tireId] = $pressId;
    }
    
    // Determine the number of molds each press can accommodate
    $pressMoldCapacity = [];
    foreach ($moldPressMap as $tireId => $pressId) {
        $sql = "SELECT mold_capacity FROM presses WHERE id = $pressId";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $pressMoldCapacity[$pressId] = $row['mold_capacity'];
    }
    
    // Plan the production schedule
    $completionDates = [];
    foreach ($moldPressMap as $tireId => $pressId) {
        $timeTaken = $productionTimes[$tireId];
        $moldCapacity = $pressMoldCapacity[$pressId];
        // Calculate the available press capacity
        $availablePressCapacity = $pressMoldCapacity[$pressId];
        
        // Check if the press has enough capacity for the current tire
        if ($availablePressCapacity > 0) {
            // Get the previous completion date, if any
            $previousCompletionDate = isset($completionDates[$pressId]) ? $completionDates[$pressId] : date('Y-m-d H:i:s');
            
            // Calculate the next available date for production
            $nextAvailableDate = date('Y-m-d H:i:s', strtotime($previousCompletionDate . " + $timeTaken minutes"));
            
            // Store the completion date for the current tire in the schedule
            $completionDates[$pressId] = $nextAvailableDate;
            
            // Store the planned production schedule in the production_schedule table
            $sql = "INSERT INTO production_schedule (press_id, tire_id, completion_date) VALUES ($pressId, $tireId, '$nextAvailableDate')";
            mysqli_query($conn, $sql);
            
            // Reduce the available press capacity by 1
            $pressMoldCapacity[$pressId]--;
        }
    }
    
    // Display the planned production schedule
    foreach ($completionDates as $pressId => $completionDate) {
        $sql = "SELECT * FROM presses WHERE id = $pressId";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $pressName = $row['press_name'];
        
        echo "Tires will be produced on $completionDate using press $pressName<br>";
    }
}
?>

<!-- HTML form with the button to create a work order -->
<form method="POST" action="">
    <input type="text" name="work_order_id" placeholder="Work Order ID">
    <button type="submit" name="create_work_order">Create Work Order</button>
</form>

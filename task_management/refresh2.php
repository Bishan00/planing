<?php
$sourceServername = "localhost";
$sourceUsername = "root";
$sourcePassword = "";
$sourceDbname = "task_management";

$destinationServername = "localhost";
$destinationUsername = "root";
$destinationPassword = "";
$destinationDbname = "task_management";

// Create source and destination connections
$sourceConn = new mysqli($sourceServername, $sourceUsername, $sourcePassword, $sourceDbname);
$destinationConn = new mysqli($destinationServername, $destinationUsername, $destinationPassword, $destinationDbname);

// Check connections
if ($sourceConn->connect_error) {
    die("Source connection failed: " . $sourceConn->connect_error);
}
if ($destinationConn->connect_error) {
    die("Destination connection failed: " . $destinationConn->connect_error);
}

// Select data from source table
$sqlSelect = "SELECT * FROM production_plan";
$result = $sourceConn->query($sqlSelect);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Insert data into destination table
        $plan_id = $row['plan_id'];
        $erp = $row['erp'];
        $icode = $row['icode'];
        $description = $row['description'];
        $press_id = $row['press_id'];
        $press_name = $row['press_name'];
        $mold_id = $row['mold_id'];
        $mold_name = $row['mold_name'];
        $cavity_id = $row['cavity_id'];
        $cavity_name = $row['cavity_name'];
        $cuing_group_id = $row['cuing_group_id'];
        $cuing_group_name = $row['cuing_group_name'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];

        $sqlInsert = "INSERT INTO copied_production_plan (plan_id, erp, icode, description, press_id, press_name, mold_id, mold_name, cavity_id, cavity_name, cuing_group_id, cuing_group_name, start_date, end_date) 
                      VALUES ($plan_id, '$erp', '$icode', '$description', $press_id, '$press_name', $mold_id, '$mold_name', $cavity_id, '$cavity_name', $cuing_group_id, '$cuing_group_name', '$start_date', '$end_date')";
        if ($destinationConn->query($sqlInsert) !== TRUE) {
            echo "Error copying data: " . $destinationConn->error;
        }
    }
} else {
    echo "No data to copy.";
}

// Close connections
$sourceConn->close();
$destinationConn->close();



//header("Location: tire_cavity.php");
//exit();
?>

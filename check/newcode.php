<?php
// Assuming you have already established a connection to your MySQL database
// Assuming you have already established a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store";

// Connect to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);
// Retrieve work order details based on the button click
if (isset($_POST['submit'])) {
    // Retrieve the work order ID from the form
    $orderId = $_POST['order_id'];
$orderId = $_POST['order_id']; // Assuming the order ID is submitted via a form post

// Retrieve tire IDs from the work order table
$query = "SELECT tire_id FROM work_orders WHERE order_id = $orderId";
$result = mysqli_query($connection, $query);

if ($result) {
  // Fetch tire IDs for the work order
  $tireIds = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $tireIds[] = $row['tire_id'];
  }

  // Get the time taken to make each tire from another table
  $tireTimeMap = [];
  foreach ($tireIds as $tireId) {
    $query = "SELECT time_taken FROM tire_times WHERE tire_id = $tireId";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $tireTimeMap[$tireId] = $row['time_taken'];
  }

  // Perform further operations based on the retrieved data
// Matching molds for tires
$matchingMolds = [];
foreach ($tireIds as $tireId) {
  // Retrieve mold information based on the tire ID
  $query = "SELECT mold_id FROM molds WHERE tire_id = $tireId";
  $result = mysqli_query($connection, $query);

  if ($result) {
    // Iterate through the retrieved molds
    while ($row = mysqli_fetch_assoc($result)) {
      $moldId = $row['mold_id'];
      // Check if the mold is already in the matching molds array
      if (!in_array($moldId, $matchingMolds)) {
        $matchingMolds[] = $moldId;
      }
    }
  }
}

// Selecting presses for molds
$selectedPresses = [];
foreach ($matchingMolds as $moldId) {
  // Retrieve press information based on the mold ID
  $query = "SELECT press_id FROM presses WHERE mold_id = $moldId";
  $result = mysqli_query($connection, $query);

  if ($result) {
    // Iterate through the retrieved presses
    while ($row = mysqli_fetch_assoc($result)) {
      $pressId = $row['press_id'];
      // Check if the press is already in the selected presses array
      if (!in_array($pressId, $selectedPresses)) {
        $selectedPresses[] = $pressId;
      }
    }
  }
}

// Getting mold cavity information
$moldCavities = [];
foreach ($selectedPresses as $pressId) {
  // Retrieve mold cavity information based on the press ID
  $query = "SELECT mold_cavities FROM mold_cavities WHERE press_id = $pressId";
  $result = mysqli_query($connection, $query);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $moldCavities[$pressId] = $row['mold_cavities'];
  }
}

// Planning production time and dates
foreach ($tireIds as $tireId) {
  $plannedDate = date('Y-m-d'); // Set the planned date based on your scheduling algorithm

  // Retrieve mold ID for the tire
  $query = "SELECT mold_id FROM molds WHERE tire_id = $tireId";
  $result = mysqli_query($connection, $query);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $moldId = $row['mold_id'];

    // Check if the mold is in the matching molds array
    if (in_array($moldId, $matchingMolds)) {
      // Retrieve press ID for the mold
      $query = "SELECT press_id FROM presses WHERE mold_id = $moldId";
      $result = mysqli_query($connection, $query);

      if ($result) {
        $row = mysqli_fetch_assoc($result);
        $pressId = $row['press_id'];

        // Check if the press is in the selected presses array
        if (in_array($pressId, $selectedPresses)) {
          // Calculate the production time based on the tire ID
          $timeTaken = $tireTimeMap[$tireId];

          // Calculate the planned end date based on the production time and mold cavities
          $moldCavity = $moldCavities[$pressId];
          $plannedEndDate = date('Y-m-d', strtotime($plannedDate . " + $timeTaken days * $moldCavity"));

                    // Update the production planning table with the planned date and end date
                    $query = "INSERT INTO production_planning (order_id, tire_id, mold_id, press_id, planned_date, end_date) 
                    VALUES ($orderId, $tireId, $moldId, $pressId, '$plannedDate', '$plannedEndDate')";
          mysqli_query($connection, $query);
        }
      }
    }
  }
}


  // Generate production planning entries and insert into the table
  foreach ($tireIds as $tireId) {
    $plannedDate = date('Y-m-d'); // Set the planned date based on your scheduling algorithm
    $query = "INSERT INTO production_planning (order_id, tire_id, planned_date) VALUES ($orderId, $tireId, '$plannedDate')";
    mysqli_query($connection, $query);
  }

  // Update the work order with the planned end date
  $endDate = date('Y-m-d'); // Set the end date based on your scheduling algorithm
  $query = "UPDATE work_orders SET end_date = '$endDate' WHERE order_id = $orderId";
  mysqli_query($connection, $query);

  // Close the database connection
  mysqli_close($connection);
}
}
?>

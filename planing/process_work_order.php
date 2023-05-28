<form action="process_work_order.php" method="post">
  <label for="tireid">Tire ID:</label>
  <input type="text" id="tireid" name="tireid">

  <label for="quantity">Quantity:</label>
  <input type="number" id="quantity" name="quantity">

  <label for="start_date">Start Date:</label>
  <input type="date" id="start_date" name="start_date">

  <label for="priority">Priority:</label>
  <select id="priority" name="priority">
    <option value="high">High</option>
    <option value="medium">Medium</option>
    <option value="low">Low</option>
  </select>

  <input type="submit" name="submit" value="Process Work Order">
</form>


<?php

// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "tiret");

// Check if the button was clicked
if (isset($_POST['submit'])) {

  // Retrieve the available tire types and quantities
  $tiresQuery = "SELECT tireid ,production_time FROM tires";
  $tiresResult = mysqli_query($connection, $tiresQuery);
  $tires = mysqli_fetch_all($tiresResult, MYSQLI_ASSOC);

  // Retrieve the molds that match the available tire types
  $moldsQuery = "SELECT molds.* FROM molds INNER JOIN mold_tire_mapping ON molds.moldid = mold_tire_mapping.moldid INNER JOIN tires ON mold_tire_mapping.tireid = tires.tireid";
  $moldsResult = mysqli_query($connection, $moldsQuery);
  $molds = mysqli_fetch_all($moldsResult, MYSQLI_ASSOC);

  // Retrieve the presses that can use the molds
  $pressesQuery = "SELECT presses.* FROM presses INNER JOIN press_mold_mapping ON presses.pressid = press_mold_mapping.pressid INNER JOIN molds ON press_mold_mapping.moldid = molds.moldid";
  $pressesResult = mysqli_query($connection, $pressesQuery);
  $presses = mysqli_fetch_all($pressesResult, MYSQLI_ASSOC);

  // Retrieve the number of molds that can be put into each press
  $capacityQuery = "SELECT pressid, capacity FROM press_capacity";
  $capacityResult = mysqli_query($connection, $capacityQuery);
  $capacities = mysqli_fetch_all($capacityResult, MYSQLI_ASSOC);
}

// Function to check if a mold is currently being used
function isMoldInUse($moldId, $connection)
{
  $inUseQuery = "SELECT COUNT(*) AS count FROM work_order_planning WHERE moldid = $moldId";
  $inUseResult = mysqli_query($connection, $inUseQuery);
  $inUseData = mysqli_fetch_assoc($inUseResult);

  return $inUseData['count'] > 0;
}

// Function to check if a press is currently being used
function isPressInUse($pressId, $connection)
{
  $inUseQuery = "SELECT COUNT(*) AS count FROM work_order_planning WHERE pressid = $pressId";
  $inUseResult = mysqli_query($connection, $inUseQuery);
  $inUseData = mysqli_fetch_assoc($inUseResult);

  return $inUseData['count'] > 0;
}

// Function to get the end date based on start date and production time
function calculateEndDate($startDate, $productionTime)
{
  $startDateObj = new DateTime($startDate);
  $endDateObj = clone $startDateObj;
  $endDateObj->add(new DateInterval("PT{$productionTime}H"));

  return $endDateObj->format('Y-m-d H:i:s');
}

// Function to plan a work order
function planWorkOrder($tireId, $quantity, $startDate, $molds, $presses, $capacities, $connection)
{
  foreach ($molds as $mold) {
    $moldId = $mold['moldid'];

    if (!isMoldInUse($moldId, $connection)) {
      foreach ($presses as $press) {
        $pressId = $press['pressid'];
        $pressCapacity = getPressCapacity($pressId, $capacities);

        if (!isPressInUse($pressId, $connection) && $pressCapacity > 0) {
          $moldsPlanned = min($pressCapacity, $quantity);

          // Insert the planned work order details into the work_order_planning table
          $endDate = calculateEndDate($startDate, $mold['production_time']);
          $insertQuery = "INSERT INTO work_order_planning (tireid, quantity, start_date, end_date, pressid, moldid) VALUES ('$tireId', $moldsPlanned, '$startDate', '$endDate', $pressId, $moldId)";
          mysqli_query($connection, $insertQuery);

          // Update the press capacity
          $newCapacity = $pressCapacity - $moldsPlanned;
          updatePressCapacity($pressId, $newCapacity, $connection);

          // Update the quantity for the next iteration
          $quantity -= $moldsPlanned;

          // If the required quantity is fulfilled, break the loop
          if ($quantity <= 0) {
            break;
          }
        }
      }

      // If the required quantity is fulfilled, break the loop
      if ($quantity <= 0) {
        break;
      }
    }
  }
}

// Function to get the capacity of a press
function getPressCapacity($pressId, $capacities)
{
  foreach ($capacities as $capacity) {
    if ($capacity['pressid'] == $pressId) {
      return $capacity['capacity'];
    }
  }

  return 0;
}

// Function to update the capacity of a press
function updatePressCapacity($pressId, $newCapacity, $connection)
{
$updateQuery = "UPDATE press_capacity SET capacity = $newCapacity WHERE pressid = $pressId";
mysqli_query($connection, $updateQuery);
}

// Retrieve the work order details from the form submission


$tireId = $_POST['tireid'];
 $quantity = $_POST['quantity'];
$startDate = $_POST['start_date'];
$priority = $_POST['priority'];
//Call the function to plan the work order
planWorkOrder($tireId, $quantity, $startDate, $molds, $presses, $capacities, $connection);

// Close the database connection
mysqli_close($connection);

?>



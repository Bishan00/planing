<html>


<button type="submit" name="submit">Start Production</button>

</html>
<?php

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=tire_production', 'root', '');

// Get the work order ID from the button click
$workOrderId = $_POST['workOrderId'];

// Get the details of the work order
$workOrder = $db->query("SELECT * FROM work_orders WHERE id = $workOrderId")->fetch();

// Get the details of the tires to be produced
$tires = $db->query("SELECT * FROM tires WHERE id IN ($workOrder['tires'])")->fetchAll();

// Get the time it takes to make each tire
$tireTimes = $db->query("SELECT time FROM tire_times WHERE id IN ($workOrder['tires'])")->fetchAll();

// Get the details of the molds that can be used to make the tires
$molds = $db->query("SELECT * FROM molds WHERE id IN (SELECT mold_id FROM tire_molds WHERE tire_id IN ($workOrder['tires']))")->fetchAll();

// Get the information of the presses that match those molds
$presses = $db->query("SELECT * FROM presses WHERE id IN (SELECT press_id FROM mold_presses WHERE mold_id IN ($workOrder['tires']))")->fetchAll();

// Get the number of molds that can be put in each press
$pressMoldCounts = $db->query("SELECT count FROM press_mold_counts WHERE press_id IN (SELECT id FROM presses WHERE id IN ($workOrder['presses']))")->fetchAll();

// Calculate the total time it will take to produce all the tires
$totalTime = 0;
foreach ($tires as $tire) {
  $totalTime += $tireTimes[$tire['id']]['time'];
}

// Calculate the date that the tires will be completed
$completionDate = new DateTime();
$completionDate->add(new DateInterval('PT' . $totalTime . 'S'));

// Insert the work order into the production_schedule table
$db->query("INSERT INTO production_schedule (work_order_id, start_date, completion_date) VALUES ($workOrderId, NOW(), '$completionDate')");

// Update the molds and presses to indicate that they are in use
foreach ($molds as $mold) {
  $db->query("UPDATE molds SET in_use = 1 WHERE id = $mold['id']");
}

foreach ($presses as $press) {
  $db->query("UPDATE presses SET in_use = 1 WHERE id = $press['id']");
}

// Assign the tires to the molds and presses
foreach ($tires as $tire) {
  $moldId = $molds[$tire['id']]['id'];
  $pressId = $presses[$moldId]['id'];
  $db->query("INSERT INTO tire_production (tire_id, mold_id, press_id) VALUES ($tire['id'], $moldId, $pressId)");
}

// Update the status of the work order to "In Production"
$db->query("UPDATE work_orders SET status = 'In Production' WHERE id = $workOrderId");

// Redirect to the work order page
header('Location: /work_orders.php');

?>

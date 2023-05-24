<?php
// Connect to the database
$host = 'localhost';
$db   = 'plan_new';
$user = 'root';
$pass = '';
$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

// Get the selected work order ID
$workOrderId = $_POST['work_order_id'];

// Retrieve the tire sizes for production by the work order ID
$query = "SELECT t.size, t.production_time
          FROM tires AS t
          INNER JOIN work_order_tires AS wt ON t.id = wt.tire_id
          WHERE wt.work_order_id = :work_order_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':work_order_id', $workOrderId);
$stmt->execute();
$tireSizes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retrieve the molds that match the tires for production
$query = "SELECT m.id, m.tire_id
          FROM molds AS m
          WHERE m.tire_id IN (SELECT tire_id FROM work_order_tires WHERE work_order_id = :work_order_id)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':work_order_id', $workOrderId);
$stmt->execute();
$molds = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retrieve the presses that match the molds
$query = "SELECT p.id, p.mold_id, p.mold_capacity
          FROM presses AS p
          WHERE p.mold_id IN (SELECT id FROM molds WHERE tire_id IN (SELECT tire_id FROM work_order_tires WHERE work_order_id = :work_order_id))";
$stmt = $conn->prepare($query);
$stmt->bindParam(':work_order_id', $workOrderId);
$stmt->execute();
$presses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Plan the tire production using the available presses and molds
$productionPlan = array();
foreach ($tireSizes as $tireSize) {
    $tireSize['production_time']; // Time taken to make the tire
    // Add your logic here to determine the optimal press and mold combination for each tire size
    // You can consider factors like mold availability, press capacity, etc.
    $productionPlan[] = array(
        'size' => $tireSize['size'],
        'press_id' => $pressId,
        'mold_id' => $moldId,
        'completion_date' => $completionDate // Determine the completion date based on the production time
    );
}


// Update the work order status and completion date
$status = 'In Progress'; // Set the initial status
$completionDate = null; // Set the initial completion date

// Get the current date
$currentDate = date('Y-m-d');

// Retrieve the work order priority
$query = "SELECT priority FROM work_orders WHERE id = :work_order_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':work_order_id', $workOrderId);
$stmt->execute();
$priority = $stmt->fetchColumn();

// Update the work order priority and completion date
$query = "UPDATE work_orders
          SET priority = :priority,
              status = :status,
              completion_date = :completion_date
          WHERE id = :work_order_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':priority', $priority);
$stmt->bindParam(':status', $status);

foreach ($productionPlan as $item) {
    $completionDate = date('Y-m-d', strtotime($completionDate . ' +' . $item['production_time'] . ' days'));
    $stmt->bindParam(':completion_date', $completionDate);
    $stmt->bindParam(':work_order_id', $workOrderId);
    $stmt->execute();
}

// Display the production plan and completion dates
echo '<h2>Production Plan for Work Order ' . $workOrderId . '</h2>';
echo '<table>';
echo '<tr><th>Tire Size</th><th>Press ID</th><th>Mold ID</th><th>Completion Date</th></tr>';
foreach ($productionPlan as $item) {
    echo '<tr>';
    echo '<td>' . $item['size'] . '</td>';
    echo '<td>' . $item['press_id'] . '</td>';
    echo '<td>' . $item['mold_id'] . '</td>';
    echo '<td>' . $item['completion_date'] . '</td>';
    echo '</tr>';
}
echo '</table>';


<?php
$erp_number = $_POST['erp_number'];
$select = $_POST['select'];
$dispatch_date = $_POST['dispatch_date'];

// Replace with your database connection details
$servername = "localhost";
$username = 'planatir_task_management';
$password = 'Bishan@1919';
$database = 'planatir_task_management';

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate inputs
if (empty($erp_number) || empty($select) || empty($dispatch_date)) {
    echo "All fields are required.";
    exit;
}

// Sanitize inputs
$erp_number = $conn->real_escape_string($erp_number);
$select = $conn->real_escape_string($select);
$dispatch_date = $conn->real_escape_string($dispatch_date);

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO pros (erp_number, select_option, dispatch_date) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $erp_number, $select, $dispatch_date);
$stmt->execute();
$stmt->close();

// Close the database connection
$conn->close();

// Redirect to another page
header('Location: import22b.php');
exit;
?>

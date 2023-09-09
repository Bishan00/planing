<!DOCTYPE html>
<html>
<head>
    <title>Insert Data</title>
</head>
<body>
    <h2>Insert Data into emp_login Table</h2>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
        <label for="emp_code">Employee Code:</label>
        <input type="text" name="emp_code" required><br>

        <label for="emp_name">Employee Name:</label>
        <input type="text" name="emp_name" required><br>

        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" required><br>

        <label for="pswd">Password:</label>
        <input type="password" name="pswd" required><br>

        <label for="status">Status:</label>
        <input type="number" name="status" required><br>

        <label for="user_role">User Role:</label>
        <input type="text" name="user_role" required><br>

        <label for="emp_pro_photo">Employee Profession Photo:</label>
        <input type="file" name="emp_pro_photo" accept="image/*"><br>

        <label for="email_id">Email ID:</label>
        <input type="email" name="email_id" required><br>

        <label for="emp_mob">Employee Mobile:</label>
        <input type="text" name="emp_mob" required><br>

        <input type="submit" value="Insert Data">
    </form>
</body>
</html>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $servername = "localhost"; // Replace with your database server name or IP address
    $username = "root";        // Replace with your database username
    $password = "";            // Replace with your database password
    $dbname = "task_management"; // Replace with your database name

    // Data from the form
    $emp_code = $_POST["emp_code"];
    $emp_name = $_POST["emp_name"];
    $user_id = $_POST["user_id"];
    $raw_password = $_POST["pswd"]; // Get the raw (unhashed) password
    $status = $_POST["status"];
    $created = date("Y-m-d H:i:s"); // Current date and time
    $user_role = $_POST["user_role"];
    $emp_pro = $_FILES["emp_pro_photo"]["name"]; // Get the uploaded file name
    $email_id = $_POST["email_id"];
    $emp_mob = $_POST["emp_mob"];

    // Hash the password
    $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);

    // Handle the uploaded file
    if (isset($_FILES["emp_pro_photo"]) && $_FILES["emp_pro_photo"]["error"] === UPLOAD_ERR_OK) {
        $upload_dir = "user_profile/"; // Specify the directory where you want to store uploaded files
        $file_name = $_FILES["emp_pro_photo"]["name"];
        $file_path = $upload_dir . $file_name;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["emp_pro_photo"]["tmp_name"], $file_path)) {
            // File upload was successful
        } else {
            echo "Error uploading file.";
        }
    }

    try {
        // Create a database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL INSERT query
        $sql = "INSERT INTO emp_login (emp_code, emp_name, user_id, pswd, status, created, user_role, emp_pro, email_id, emp_mob)
                VALUES (:emp_code, :emp_name, :user_id, :pswd, :status, :created, :user_role, :emp_pro, :email_id, :emp_mob)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':emp_code', $emp_code);
        $stmt->bindParam(':emp_name', $emp_name);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':pswd', $hashed_password); // Store the hashed password
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created', $created);
        $stmt->bindParam(':user_role', $user_role);
        $stmt->bindParam(':emp_pro', $emp_pro); // Store the file name
        $stmt->bindParam(':email_id', $email_id);
        $stmt->bindParam(':emp_mob', $emp_mob);

        // Execute the SQL statement
        $stmt->execute();

        echo "Data inserted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $conn = null;
}
?>

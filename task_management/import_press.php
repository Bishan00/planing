<!DOCTYPE html>
<html>
<head>
    <title>Excel Import</title>
</head>
<body>
    <h2>Import Excel Data</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="excel_file" accept=".xlsx, .xls">
        <input type="submit" name="import" value="Import">
    </form>
</body>
</html>
<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import'])) {
    // Database connection details
    $servername = "localhost";
    $username = "planatir_task_management";
    $password = "Bishan@1919";
    $database = "planatir_task_management";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if a file was uploaded
    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] === UPLOAD_ERR_OK) {
        // Get the uploaded file details
        $fileTmpName = $_FILES['excel_file']['tmp_name'];

        // Load the Excel file
        $spreadsheet = IOFactory::load($fileTmpName);

        // Select the first worksheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Define the target table name
        $tableName = "press_sheet";

  // Define the SQL query outside the if block
  $sql = "INSERT INTO $tableName (Presses1, Presses2, Presses3, Presses4, Presses5, Presses6, Presses7, Presses8, Presses9, Presses10, Presses11, Presses12, Presses13, Presses14, Presses15, Presses16, Presses17, Presses18, Presses19, Presses20, Presses21, Presses22)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


        // Loop through the rows in the worksheet
        foreach ($worksheet->getRowIterator() as $row) {
            $data = [];

            // Loop through the cells in the row
            foreach ($row->getCellIterator() as $cell) {
                $data[] = $cell->getValue();
            }

            // Prepare an SQL statement to insert the data into your table
            $stmt = $conn->prepare($sql);

            // Bind the parameters and set their values
            $stmt->bind_param("ssssssssssssssssssssss", ...$data); // Assuming all values are integers

            // Execute the statement
            $stmt->execute();

            // Check for errors
            if ($stmt->error) {
                echo "Error: " . $stmt->error . "<br>";
            }

            // Close the prepared statement
            $stmt->close();
        }

        echo "Data imported successfully.";

        // Close the database connection
        $conn->close();
    } else {
        echo "Please select a valid Excel file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import Excel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .result {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dispatch Work Order</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="excel_file">
            <input type="submit" value="Import">
        </form>

        <?php
        // Include the PhpSpreadsheet library
        require 'vendor/autoload.php'; // Path to PhpSpreadsheet autoload
        use PhpOffice\PhpSpreadsheet\IOFactory;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["excel_file"])) {
            $uploadedFile = $_FILES["excel_file"]["tmp_name"];

            // Create a new connection to your MySQL database
            $conn = new mysqli("localhost", "root", "", "task_management");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Load the Excel file using PhpSpreadsheet
            $spreadsheet = IOFactory::load($uploadedFile);
            $worksheet = $spreadsheet->getActiveSheet();

            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue();
                }
                if (!empty($data)) {
                    $icode = $data[5];
                    $amount = $data[14]; // Assuming the amount is in the third column
                    $erpNumber = $data[4];

                    // Update cstock based on icode for realstock table
                    $sqlRealStock = "UPDATE realstock SET cstock = cstock - ? WHERE icode = ?";
                    $stmtRealStock = $conn->prepare($sqlRealStock);
                    $stmtRealStock->bind_param("is", $amount, $icode);
                    $stmtRealStock->execute();
                
                    // Update stock based on icode for stock table
                    $sqlStock = "UPDATE stock SET cstock = cstock - ? WHERE icode = ?";
                    $stmtStock = $conn->prepare($sqlStock);
                    $stmtStock->bind_param("is", $amount, $icode);
                    $stmtStock->execute();

                     // Delete related entries from worder table based on ERP number
        $sqlDeleteWorder = "DELETE FROM worder WHERE erp = ?";
        $stmtDeleteWorder = $conn->prepare($sqlDeleteWorder);
        $stmtDeleteWorder->bind_param("s", $erpNumber);
        $stmtDeleteWorder->execute();
                    

                    

                }
            }

            $conn->close();

            echo '<div class="result">';
            echo '<h2>Import Result:</h2>';
            echo '<p>Data imported successfully!</p>';
            echo '</div>';

          
            header("Location: import22.php");
           exit();
        }
        ?>
    </div>
</body>
</html>

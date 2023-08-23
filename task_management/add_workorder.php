<?php
include './includes/data_base_save_update.php';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    // Retrieve form data
    $datetime = $_POST['datetime'];
    $erp = $_POST['erp'];

    // Perform data validation and sanitization

    // Extract date and time components
    $formattedDatetime = date("Y-m-d H:i:s", strtotime($datetime));

    // Save the data to the database
    $result = $AppCodeObj->addwork("work_order", $formattedDatetime, $erp);

    if ($result) {
        // Data saved successfully
        header('Location: work_order.php');
        exit();
    } else {
        // Handle the error
        $msg = "Error occurred while saving the data.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Work Order</title>
    <style>
           body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            text-align: center;
        }

        .container h5 {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group input[type="datetime-local"] {
            padding: 8px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #f5c6cb;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h5>Add Work Order</h5>
        <?php if (isset($msg)) : ?>
            <div class="alert">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="datetime">Date and Time</label>
                <input name="datetime" id="datetime" type="datetime-local" required>
            </div>
            <div class="form-group">
                <label for="erp">Ref.ERP CO.No</label>
                <input name="erp" id="erp" placeholder="" type="text" required>
            </div>
            <input type="submit" value="Submit Now" name="submit">
        </form>
    </div>
</body>
</html>

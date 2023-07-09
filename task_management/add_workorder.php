<?php
include './includes/data_base_save_update.php';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    // Retrieve form data
    $date = $_POST['date'];
    $erp = $_POST['erp'];

    // Perform data validation and sanitization

    // Save the data to the database
    $result = $AppCodeObj->addwork("work_order", $date, $erp);

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
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 120px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h5 {
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="date"],
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
        }

        input[type="date"],
        input[type="text"] {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            color: #333;
        }

        input[type="date"]:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: #5a9bd4;
        }

        input[type="submit"] {
            background-color: #5a9bd4;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4488c7;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
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
                <label for="date">Date</label>
                <input name="date" id="date" placeholder="" type="date" required>
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

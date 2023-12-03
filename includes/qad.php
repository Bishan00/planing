<?php
// Replace these variables with your actual database connection details
$host = 'localhost';
$username = 'planatir_task_management';
$password = 'Bishan@1919';
$database = 'planatir_task_management';

// Create a database connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to check if there is data in the daily_plan_data1 table
$query = "SELECT COUNT(*) as count, MAX(date) as max_date FROM template";
$result = $mysqli->query($query);

// Fetch the result
$row = $result->fetch_assoc();
$count = $row['count'];
$maxDate = $row['max_date'];

// Check if there is data in the daily_plan_data1 table
if ($count > 0) {
    echo '<style>
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }

        .blink {
            animation: blink 1s infinite;
        }

        .centered {
            display: flex;
            justify-content: center;
            align-items: center;
        }
      </style>';

    echo '<div class="centered">
            <span class="breadcrumb-item blink" style="cursor: pointer; background: #F28018; color: black;">
                <span style="font-weight: bold; color: black;">Please confirm the daily Reject. ' . date('Y-m-d', strtotime($maxDate)) . '</span>
            </span>
          </div>';
}


// Close the database connection
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Styling for the Dashboard elements */
        .element-content {
            background-color: #F28018;
            padding: 0;
            text-align: center;
            box-shadow: 2px 2px 4px rgba(0, 0, 10, 100);
            
            /* Make the element fill the full page */
            position: right;
            top: 0;
            left: 5px;
            width: 100%;
            height: 100%;
        }

        .element-box {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 60px;
            margin: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .element-header {
            color: #000000;
            font-size: 24px;
            font-weight: bold;
        }

        .element-box a {
            text-decoration: none;
            color: #F28018;
        }

        /* Styling for the specific elements with id="myDIV" */
        #myDIV {
            color: #000000;
            font-weight: bold;
            font-size: 20px;
            margin-top: 10px;
        }

        body {
            background-color: #FFFFFF;
        }
    </style>
    <title>Your Dashboard</title>
</head>
<body>
    <div class="element-content">
        <h6 style="background-color: #000000; color: #fff; border-radius: 50px; padding: 3px; text-align: center; font-weight: bold; font-family: 'Cantarell', sans-serif;">Dashboard - Reports</h6>

        <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="rejectbutton.php">
                    <div id="myDIV">Daily Reject</div>
                </a>
            </div>

            <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="bom_all.php">
                    <div id="myDIV">BOM</div>
                </a>
            </div>


        <div class="col-sm-4 col-xxxl-3">
            
        </div>
        <div>
            <p class="red-text">ddddddddddddddddddd</p>
            <p class="red-text">ddddddddd</p>
            <p class="blue-text">ddddddd</p>
            <p class="red-text">dddddddddddd</p>
            <p class="red-text">dddddddddddddddddd</p>
            <p class="red-text">dddddddddddddddddd</p>
            <p class="red-text">dddddddddddddddddd</p>
            <p class="red-text">dddddddddddddddddd</p>
            <p class="red-text">ddddddddddddddddddd</p>
        </div>
    </div>
</body>
</html>

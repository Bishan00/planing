<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Range Selection</title>
</head>
<body>
    <form action="test12345.php" method="post">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>

        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" required>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
<?php
// Replace these values with your actual database connection details
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database = "planatir_task_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $startTime = $_POST["start_time"];
    $endTime = $_POST["end_time"];

    // Combine date and time values
    $startDatetime = $startDate;
    $endDatetime = $endDate;

    $sql = "SELECT * FROM calculated_data WHERE DATE(?) BETWEEN DATE(found_time) AND DATE(user_time)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $startDatetime);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Display the details for each row
    if ($result->num_rows > 0) {

        
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row['id'] . "<br>";
            echo "Date: " . $row['date'] . "<br>";
            echo "Plan ID: " . $row['plan_id'] . "<br>";
            echo "ERP: " . $row['erp'] . "<br>";
            echo "ICode: " . $row['icode'] . "<br>";
            echo "Description: " . $row['description'] . "<br>";
            echo "Mold ID: " . $row['mold_id'] . "<br>";
            echo "Cavity ID: " . $row['cavity_id'] . "<br>";
            echo "system Start Date: " . $row['start_date'] . "<br>";
            echo "system End Date: " . $row['end_date'] . "<br>";
        
            echo "Tires Per Mold: " . $row['tires_per_mold'] . "<br>";
            echo "Time Difference (Minutes): " . $row['time_difference_minutes'] . "<br>";
           
            echo "Time Taken: " . $row['time_taken'] . "<br>";
            
        // Get "system Start Date" and "system End Date" from the database
        $systemStartDate = $row['start_date'];
        $systemEndDate = $row['end_date'];

        // Convert database start date and time to DateTime objects
        $systemStartDatetime = new DateTime($systemStartDate);
        $systemEndDatetime = new DateTime($systemEndDate);

        // Calculate time difference in minutes between system start and end dates
        $systemTimeDifferenceMinutes = $systemStartDatetime->diff($systemEndDatetime)->days * 24 * 60 +
            $systemStartDatetime->diff($systemEndDatetime)->h * 60 +
            $systemStartDatetime->diff($systemEndDatetime)->i;



  
    
    // Combine date and time values
    $startDatetime = $startDate . ' ' . $startTime;
    $endDatetime = $endDate . ' ' . $endTime;

    // Convert to DateTime objects
    $startDateTimeObj = new DateTime($startDatetime);
    $endDateTimeObj = new DateTime($endDatetime);

    // Calculate time difference in minutes
    $timeDifferenceMinutesss = $startDateTimeObj->diff($endDateTimeObj)->days * 24 * 60 +
                             $startDateTimeObj->diff($endDateTimeObj)->h * 60 +
                             $startDateTimeObj->diff($endDateTimeObj)->i;

    // Display user input
    echo "<h2>User Input:</h2>";
    echo "User Start Date and Time: " . $startDatetime . "<br>";
    echo "User End Date and Time: " . $endDatetime . "<br>";

    // Display time difference in minutes
    echo "<h2>Time Difference (Minutes):</h2>";
    echo "User time different ". $timeDifferenceMinutesss . "  <br>";
            // Display the time difference
            echo "System Time Difference (Minutes): " . $systemTimeDifferenceMinutes . "<br>";



     
   // Convert database start date and time to DateTime object
   $recordStartDatetime = new DateTime($row['start_date']);

   // Calculate time difference in minutes between user input and database start date
   $timeDifferenceMinutess =  $endDateTimeObj->diff($recordStartDatetime)->days * 24 * 60 +
                            $endDateTimeObj->diff($recordStartDatetime)->h * 60 +
                            $endDateTimeObj->diff($recordStartDatetime)->i;

   echo "user end start time diffenet: " . $timeDifferenceMinutess . "<br>";


       
   // Convert database start date and time to DateTime object
   $recordStartDatetime = new DateTime($row['end_date']);

   // Calculate time difference in minutes between user input and database start date
   $timeDifferenceMinutes =  $startDateTimeObj->diff($recordStartDatetime)->days * 24 * 60 +
                            $startDateTimeObj->diff($recordStartDatetime)->h * 60 +
                            $startDateTimeObj->diff($recordStartDatetime)->i;

   echo "user start end time diffenet: " . $timeDifferenceMinutes . "<br>";

   
   echo "Acctual start Date: " . $row['date'] . " 00:00:00" . "<br>";

   echo "Acctual start Date: " . $row['date'] .  " 23:59:59" . "<br>";



   // Extract date and time from the "Actual Date" column
   $actualDate = $row['date'] . " 00:00:00";

   // Create DateTime objects for the "Actual Date" and "System Start Date"
   $actualDateObj = new DateTime($actualDate);
   $systemStartDatetime = new DateTime($systemStartDate);

   // Calculate time difference in minutes between "Actual Date" and "System Start Date"
   $timeDifferenceActualVsSystem = $actualDateObj->diff($systemStartDatetime)->days * 24 * 60 +
       $actualDateObj->diff($systemStartDatetime)->h * 60 +
       $actualDateObj->diff($systemStartDatetime)->i;

   // Display the time difference
   echo "Time Difference between Actual start Date and System Start Date (Minutes): " . $timeDifferenceActualVsSystem . "<br>";



   // Extract date and time from the "Actual Date" column
   $actualDate = $row['date'] . " 00:00:00";

   // Create DateTime objects for the "Actual Date" and "System Start Date"
   $actualDateObj = new DateTime($actualDate);
   $systemEndDatetime = new DateTime($systemEndDate);

   // Calculate time difference in minutes between "Actual Date" and "System Start Date"
   $timeDifferenceActualVsSystemm = $actualDateObj->diff($systemEndDatetime)->days * 24 * 60 +
       $actualDateObj->diff($systemEndDatetime)->h * 60 +
       $actualDateObj->diff($systemEndDatetime)->i;

   // Display the time difference
   echo "Time Difference between Actual start Date and System end Date (Minutes): " . $timeDifferenceActualVsSystemm . "<br>";










 // Extract date and time from the "Actual Date" column
 $actuallDate = $row['date'] . " 23:59:59";

 // Create DateTime objects for the "Actual Date" and "System Start Date"
 $actuallDateObj = new DateTime($actuallDate);
 $systemStartDatetime = new DateTime($systemStartDate);

 // Calculate time difference in minutes between "Actual Date" and "System Start Date"
 $timeDifferenceActualVsSysteem = $actuallDateObj->diff($systemStartDatetime)->days * 24 * 60 +
     $actuallDateObj->diff($systemStartDatetime)->h * 60 +
     $actuallDateObj->diff($systemStartDatetime)->i;

 // Display the time difference
 echo "Time Difference between Actual end Date and System Start Date (Minutes): " . $timeDifferenceActualVsSysteem . "<br>";


 // Extract date and time from the "Actual Date" column
 $actuallDate = $row['date'] . " 23:59:59";

 // Create DateTime objects for the "Actual Date" and "System Start Date"
 $actuallDateObj = new DateTime($actuallDate);
 $systemEndDatetime = new DateTime($systemEndDate);

 // Calculate time difference in minutes between "Actual Date" and "System Start Date"
 $timeDifferenceActualVsSystemmm = $actuallDateObj->diff($systemEndDatetime)->days * 24 * 60 +
     $actuallDateObj->diff($systemEndDatetime)->h * 60 +
     $actuallDateObj->diff($systemEndDatetime)->i;

 // Display the time difference
 echo "Time Difference between Actual end Date and System end Date (Minutes): " . $timeDifferenceActualVsSystemmm . "<br>";












    // Display the time differences
    $minTimeDifference = min(
        $timeDifferenceMinutess,
        $timeDifferenceMinutes,
        $timeDifferenceMinutesss,
        $systemTimeDifferenceMinutes,
        $timeDifferenceActualVsSystem,
      
        $timeDifferenceActualVsSysteem
    );

    echo "min time: " . $minTimeDifference . "<br>";


    
            // Display the time_taken value for each icode
            echo "Time Taken for iCode " . $row['icode'] . ": " . $row['time_taken'] . "<br>";

            
            // Divide minTimeDifference by time_taken and display the result
            $divisionResult =($minTimeDifference > 0) ? ceil($minTimeDifference / $row['time_taken']) : 0;
            echo "plan: " . $divisionResult . "<br>";



        
            // Separate each record
            echo "<hr>";
        }
    } else {
        echo "No records found within the given date range";
    }

    


    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

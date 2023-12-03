
<?php

error_reporting(0);
ini_set('display_errors', 0);
// Database connection
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database = "planatir_task_management";

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to retrieve distinct ERP numbers
$query = "SELECT DISTINCT erp FROM plannew";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Display the distinct ERP numbers
    $erpCount = mysqli_num_rows($result); // Get the count of ERP numbers

   
}

// Close the database connection
mysqli_close($conn);
?>





<?php
// Database connection
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database = "planatir_task_management";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get today's date and set it as user_start_time
$user_start_time = date('Y-m-d'); // Get today's date

// Calculate the end of the day (e.g., 23:59:59) and set it as user_end_time
$user_end_time = date('Y-m-d') . ' 23:59:59'; // Set here as of 00:00:00 today


// SQL query to retrieve records from the database for today's date
// SQL query to retrieve records from the database in ascending order of cavity_id
$sql = "SELECT p.plan_id, p.icode, p.start_date, p.end_date, p.mold_id, p.cavity_id, t.time_taken
        FROM plannew p
        JOIN tire t ON p.icode = t.icode
        ORDER BY p.cavity_id ASC";
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $plan_id = $row['icode'];
            $found_start_time = $row['start_date'];
            $found_end_time = $row['end_date'];
            $icode = $row['icode'];
            $time_given = $row['time_taken'];
            $mold_id = $row['mold_id'];
            $cavity_id = $row['cavity_id'];

            // Query to fetch mold_name from the mold table
            $mold_query = "SELECT mold_name FROM mold WHERE mold_id = $mold_id";
            $mold_result = $conn->query($mold_query);
            $mold_row = $mold_result->fetch_assoc();
            $mold_name = $mold_row['mold_name'];

            // Query to fetch cavity_name from the cavity table
            $cavity_query = "SELECT cavity_name FROM cavity WHERE cavity_id = $cavity_id";
            $cavity_result = $conn->query($cavity_query);
            $cavity_row = $cavity_result->fetch_assoc();
            $cavity_name = $cavity_row['cavity_name'];

            if ($found_start_time >= $user_start_time && $found_end_time <= $user_end_time) {
                $user_end_timestamp = strtotime($user_end_time);
                $user_start_timestamp = strtotime($user_start_time);
                $found_start_timestamp = strtotime($found_start_time);
                
                // Ensure $found_end_timestamp is not greater than $user_end_timestamp
                $found_end_timestamp = min(strtotime($found_end_time), $user_end_timestamp);
            
                // Calculate the time difference in minutes
                if ($user_start_timestamp > $found_start_timestamp) {
                    // If user_start_time is less than found_start_time, calculate from user_start_time
                    $timeDifference = ($user_end_timestamp - $user_start_timestamp) / 60;
                } else {
                    // Otherwise, calculate from found_start_time
                    $timeDifference = ($found_end_timestamp - $found_start_timestamp) / 60;
                }
            
                // Calculate Time Taken / Time Difference
                $timeTaken = $time_given; // Assuming "time_given" should be used
                $timeTakenDividedByDifference = $timeDifference / $timeTaken;

                // Append the data to the results array
                $results[] = array(
                    'icode' => $icode,
                    'mold_id' => $mold_id,
                    'mold_name' => $mold_name,
                    'cavity_id' => $cavity_id,
                    'cavity_name' => $cavity_name,
                    'found_start_time' => $found_start_time,
                    'found_end_time' => $found_end_time,
                    'time_given' => $time_given,
                    'timeDifference' => $timeDifference,
                    'user_end_time' => $user_end_time,
                    'user_start_time' => $user_start_time,
                    'tobe' => $timeTakenDividedByDifference,
                    
                );
            } elseif ($found_start_time <= $user_start_time && $found_end_time >= $user_end_time) {
                $user_end_timestamp = strtotime($user_end_time);
                $user_start_timestamp = strtotime($user_start_time);
                $found_start_timestamp = strtotime($found_start_time);
                
                // Ensure $found_end_timestamp is not greater than $user_end_timestamp
                $found_end_timestamp = min(strtotime($found_end_time), $user_end_timestamp);
            
                // Calculate the time difference in minutes
                if ($user_start_timestamp > $found_start_timestamp) {
                    // If user_start_time is less than found_start_time, calculate from user_start_time
                    $timeDifference = ($user_end_timestamp - $user_start_timestamp) / 60;
                } else {
                    // Otherwise, calculate from found_start_time
                    $timeDifference = ($found_end_timestamp - $found_start_timestamp) / 60;
                }
            
                // Calculate Time Taken / Time Difference
                $timeTaken = $time_given; // Assuming "time_given" should be used
                $timeTakenDividedByDifference = $timeDifference / $timeTaken;
                // Append the data to the results array
                $results[] = array(
                    'icode' => $icode,
                    'mold_id' => $mold_id,
                    'mold_name' => $mold_name,
                    'cavity_id' => $cavity_id,
                    'cavity_name' => $cavity_name,
                    'found_start_time' => $found_start_time,
                    'found_end_time' => $found_end_time,
                    'time_given' => $time_given,
                    'timeDifference' => $timeDifference,
                    'user_end_time' => $user_end_time,
                    'user_start_time' => $user_start_time,
                    'tobe' => $timeTakenDividedByDifference,
                    
                );
            } elseif ($found_start_time <= $user_end_time && $found_end_time >= $user_start_time) {
                $user_end_timestamp = strtotime($user_end_time);
                $user_start_timestamp = strtotime($user_start_time);
                $found_start_timestamp = strtotime($found_start_time);
                
                // Ensure $found_end_timestamp is not greater than $user_end_timestamp
                $found_end_timestamp = min(strtotime($found_end_time), $user_end_timestamp);
            
                // Calculate the time difference in minutes
                if ($user_start_timestamp > $found_start_timestamp) {
                    // If user_start_time is less than found_start_time, calculate from user_start_time
                    $timeDifference = ($user_end_timestamp - $user_start_timestamp) / 60;
                } else {
                    // Otherwise, calculate from found_start_time
                    $timeDifference = ($found_end_timestamp - $found_start_timestamp) / 60;
                }
            
                // Calculate Time Taken / Time Difference
                $timeTaken = $time_given; // Assuming "time_given" should be used
                $timeTakenDividedByDifference = $timeDifference / $timeTaken;

                // Append the data to the results array
                $results[] = array(
                    'icode' => $icode,
                    'mold_id' => $mold_id,
                    'mold_name' => $mold_name,
                    'cavity_id' => $cavity_id,
                    'cavity_name' => $cavity_name,
                    'found_start_time' => $found_start_time,
                    'found_end_time' => $found_end_time,
                    'time_given' => $time_given,
                    'timeDifference' => $timeDifference,
                    'user_end_time' => $user_end_time,
                    'user_start_time' => $user_start_time,
                    'tobe' => $timeTakenDividedByDifference,
                   
                );
            }
        }

        // Initialize an array to store unique cavity names
$cavityNames = array();

// Iterate through the $results array to collect unique cavity names
foreach ($results as $result) {
    $cavityName = $result['cavity_name'];
    if (!in_array($cavityName, $cavityNames)) {
        $cavityNames[] = $cavityName;
    }
}
    } else {
        echo "No records found in the database.";
    }


    // Query to retrieve work orders data and calculate total quantity
$sql = "SELECT icode, SUM(new) AS total_quantity, t_size FROM worder GROUP BY icode";
$result = $conn->query($sql);
$workOrders = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $icode = $row['icode'];
        $totalQuantity = $row['total_quantity'];
        $tSize = $row['t_size'];

        $workOrders[$icode] = array(
            'total_quantity' => $totalQuantity,
            't_size' => $tSize
        );
    }
}
$conn->close();
?>







<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
include 'includes/App_Code.php';
$AppCodeObj = new App_Code();

// Initialize a variable to store the sum
$totalCStock = 0;

// Execute a SQL query to calculate the sum of cstock
$query = "SELECT SUM(cstock) AS total_cstock FROM realstock";
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalCStock = $row['total_cstock'];
    mysqli_free_result($result);
}

// Execute a SQL query to calculate the sum of cstock
$query = "SELECT SUM(cstock) AS total_cstockk FROM stock";
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalCStockk = $row['total_cstockk'];
    mysqli_free_result($result);
}


// Execute a SQL query to calculate the sum of cstock
$query = "SELECT count(id) AS total_count FROM work_order";
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalcount = $row['total_count'];
    mysqli_free_result($result);
}



// SQL query to get the total number of erp for the current month
$sql = "SELECT COUNT(DISTINCT erp_number) AS total_erp
        FROM pros
        WHERE MONTH(dispatch_date) = MONTH(CURDATE()) AND YEAR(dispatch_date) = YEAR(CURDATE())";

$result = $connection->query($sql);
if ($result) {
   
    $row = mysqli_fetch_assoc($result);
        $totalcountt= $row['total_erp'];
        mysqli_free_result($result);
      
} 

$query = "SELECT SUM(tobe) AS total_tobe FROM tobeplan1 WHERE  tobe> 0";
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totaltobe = $row['total_tobe'];
    mysqli_free_result($result);
}

$query = "SELECT SUM(new) AS total_new FROM worder";
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalnew = $row['total_new'];
    mysqli_free_result($result);
}


// Subtract On Hand Work Orders from Running Order
$result =$totalcount - $erpCount;



?>



<!--------------------
START - Breadcrumbs
-------------------->
<!--------------------
END - Breadcrumbs
-------------------->

<div class="content-i">
    <div class="content-box">
        <marquee direction="left" style="background: #000000;">
            <span class="breadcrumb-item">
            <img src="atire.png" alt="Logo" style="height: 50px; margin-right: 20px;">
                <?php
                $qry = mysqli_query($connection, "SELECT * FROM news_and_update where news_type='alert' order by created desc") or die("select query fail" . mysqli_error());
                while ($row = mysqli_fetch_assoc($qry)) {
                    $news_title = $row['news_title'];
                    ?>
                    <a href="#" style="color:#f28018; font-size: 10px;"><?php echo $news_title; ?>&nbsp;<strong></strong></a>
                <?php } ?>
               
            </span>
        </marquee>
        <marquee direction="right" style="background: #F28018; color: black;" onmouseover="this.stop();" onmouseout="this.start();">
    <span class="breadcrumb-item" style="cursor: pointer;">
    
        <span style="font-weight: bold; color: black;">FG Stock: <?php echo $totalCStock; ?></span> || 
        <span style="font-weight: bold; color: black;">Total Requirement: <?php echo $totalnew; ?></span> ||
        <span style="font-weight: bold; color: black;">Free Stock: <?php echo $totalCStockk; ?></span> || 
        <span style="font-weight: bold; color: black;">Tobe produce: <?php echo $totaltobe; ?></span> ||
        <span style="font-weight: bold; color: black;">On Hand Work Orders: <?php echo $totalcount; ?></span> || 
        <span style="font-weight: bold; color: black;">Production complete work orders: <?php echo $result; ?></span> || 
        <span style="font-weight: bold; color: black;">Tobe Produce Work Orders: <?php echo ($erpCount ); ?></span>  ||
        <span style="font-weight: bold; color: black;">Cavity Utilization: 69 </span> || 
        
        <span style="font-weight: bold; color: black;">Current Month Dispatched Order: <?php echo ($totalcountt );?></span> || 

    </span>
</marquee>





        <?php
        if ($_SESSION['User_type'] == 'admin') {
            include './includes/admin_dashboard.php';
        } elseif ($_SESSION['User_type'] == 'fmanager') {
            include './includes/fmanager.php';
        } elseif ($_SESSION['User_type'] == 'qmanager') {
            include './includes/qad_manager.php';
        }elseif ($_SESSION['User_type'] == 'qad') {
            include './includes/qad.php';
        }
        elseif ($_SESSION['User_type'] == 'stock') {
            include './includes/stockceper.php';
        }
        elseif ($_SESSION['User_type'] == 'Planning') {
            include './includes/planning_dashboard.php';
        }
        else {
            include './includes/emp_dashboard.php';
        }
        
        ?>
    </div>
</div>

<?php include './includes/Plugin.php'; ?>
<?php include './includes/admin_footer.php'; ?>

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'pdfHtml5'
        ]
    } );
});
</script>
<footer>
        <!-- Your website footer content -->
        <?php include('foter.php'); ?>
    </footer>
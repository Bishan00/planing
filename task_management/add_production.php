<?php
include './includes/admin_header.php';

$hostname = "localhost";
$username = "root";
$password = "";
$database = "task_management";

// Create a connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>




<!--------------------
START - Breadcrumbs
-------------------->
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><span>alert</span></li>
</ul>
<!--------------------
END - Breadcrumbs
-------------------->
<div class="content-panel-toggler"><i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span></div>
<div class="content-i">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box">
                <div class="row">
                    <div class="col-md-6" id >
                <form action="#" method="post" enctype="multipart/form-data">

                    
                            <div class="row">
                                 <div class="col-md-12">
                                    <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Add work order</h5>                                   
                                </div>  
                                <form method="POST" action="add_production.php">
                                <div class="col-sm-6">
                                <div class="form-group"><label for="id">Enter ID:</label>
                                <input class="form-control" type="text" name="pid" id="pid">
                                <input class="btn btn-primary" type="submit"  value="Submit">
                                </form>
                                
                                <?php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the ID from the form
    $pid = $_POST["pid"];

    // Query the database for the corresponding data
    $query = "SELECT * FROM bom WHERE pid = '$pid'";
    $result = $conn->query($query);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the data from the result set
        $row = $result->fetch_assoc();

        // Display the data in the form
        
        echo "Name: <input type='text' value='" . $row["Tsize"] . "'><br>";
        echo "Email: <input type='text' value='" . $row["brand"] . "'><br>";
        // Add more fields as needed
    } else {
        echo "No data found for the provided ID.";
    }
}
?>
                           
                            <div class="form-buttons-w text-right">
                                <input class="btn btn-primary" type="submit" value="Submit Now" name="submit">
                                

      
    </form>
                            </div>
                        </div>
                </form>
                    </div>
                      <div class="col-md-6">
                          <br>
               
                                                               
                </table>
                      </div>
            </div>
        </div></div>
<?php include './includes/Plugin.php'; ?>
        <?php include './includes/admin_footer.php'; ?>





         <div class="col-sm-6">
                                    <div class="form-group"><label for="">Ref.ERP CO.No</label>
                                        <input class="form-control" name="Rno" placeholder="" type="varchar">
                                    </div>
                                </div>
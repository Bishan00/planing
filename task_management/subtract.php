
<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
//include 'includes/App_Code.php';
include 'includes/App_Code.php';
$AppCodeObj=new App_Code();

   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "task_management";

   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);

   // Check connection
   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   }

   // Perform subtraction and insert result into result_table
   $sql = "INSERT INTO tobeplan (icode, tobe)
           SELECT t1.icode, t1.new - t2.cstock
           FROM worder t1
           INNER JOIN stock t2 ON t1.icode = t2.icode";

   if ($conn->query($sql) === TRUE) {
      echo "Subtraction performed successfully";
      
      
   } else {
      echo "Error performing subtraction: " . $conn->error;
   }

   $conn->close();

   
?>

<form method="POST" action="planning.php">
			<button name="submit">click next</button>
			</form>




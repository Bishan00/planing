<?php
if (isset($_POST['submit'])){
  include ("DBconnect.php");
  $conn= mysqli_connect( $dbhost, $dbuser, $dbpass, $db );
  if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
  }
  else{
    $insertNEQuery= "INSERT INTO newDataTable (Name, Date, Power) SELECT (Name, Date, Power) FROM oldDataTable WHERE ID = '2' ";
    //it should be a bunch of rows. I have data for every one minute. 

    mysqli_query($conn, $insertNEQuery);
    echo " data updated!";
    $conn->close();
  }
} else 
    echo " please click submit button!";
?>
```
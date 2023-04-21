<html>
    <head>        
        <title></title>
    </head>
    <body>
        <?php
        include './includes/db.php';
        include 'class.smtp.php';
require_once('class.phpmailer.php');
        if (isset($_POST["Import"])) {
            //First we need to make a connection with the database
//    $host='localhost';
//    $db_user= 'root'; 
//    $db_password= '';
//    $db= 'product_record';
//    $conn=mysql_connect($host,$db_user,$db_password) or die (mysql_error());
//    mysql_select_db($db) or die (mysql_error());
           $content= $_POST['content'];
            echo $filename = $_FILES["file"]["tmp_name"];
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");
//$sql_data = "SELECT * FROM prod_list_1 ";

                $count = 0;                                         // add this line
                while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                    //print_r($emapData);
                    //exit();
                    $count++;                                      // add this line

                    if ($count > 1) {                                  // add this line
//                        $sql = "INSERT into prod_list_1(p_bench,p_name,p_price,p_reason) values ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]')";
//                        mysqli_query($connection, $sql);
////                        mysql_query($sql);
                          $about="Kishan";//$_POST['about'];
    $websiteType="Kishan";//$_POST['websiteType'];
    $email="Kishan";//$_POST['email'];
    $mob="Kishan";//$_POST['mob'];
    $fname="Kishan";//$_POST['fname'];
    $buget="Kishan";//$_POST['buget'];

    $mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'mailservicesk2017@gmail.com';                 // SMTP username
    $mail->Password = '19kishan19';                           // SMTP password
    $mail->Port = 587;                                    // TCP port to connect to

// $mail->From = 'your@email.com';
// $mail->FromName = 'Test phpmailer';
// $mail->addAddress('kishankushwah54@gmail.com');               // Name is optional
    $mail->From = 'mailservicesk2017@gmail.com';
    $mail->FromName = 'kishan kushwah';
   // $mail->addAddress('kishankushwah54@gmail.com');
  $mail->addAddress($emapData[0]);
//  $mail->addAddress($emapData[1]);
  
  $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'logic web enquery';
    $mail->Body    =$content;//"Name :-". $fname ."<br> Mobile No.:-". $mob ."<br> email:-".$email."<br> about:-". $about ."<br> website Type:-". $websiteType ."<br> buget:-". $buget;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo "<script>alert('your request has been sent successfully');</script>";
      //  header("Location: index.html");
    }
                    }         
                    sleep(30);                    
// add this line
                }
                fclose($file);
                echo 'CSV File has been successfully Imported';
                //header('Location: index.php');
            } else
                echo 'Invalid File:Please Upload CSV File';
        }
        ?>
        <form enctype="multipart/form-data" method="post" role="form">
            <div class="form-group">
                <label for="exampleInputFile">File Upload</label>
                <input type="file" name="file" id="file" size="150">
                <input type="text" name="content" id="content">
                 </div>
                                 <script src="ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
		   CKEDITOR.replace('content',{
	width: "100%",
        height: "400px"
     }
);
	</script>
                <!--<p class="help-block">Only Excel/CSV File Import.</p>-->
            </div>
            <button type="submit" class="btn btn-default" name="Import" value="Import">Upload</button>
        </form>
    </body>
</html>
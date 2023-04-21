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
<!--------------------
START - Breadcrumbs
-------------------->
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><span>Send Bulk Email</span></li>
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
                                 <div class="col-md-12">
                                    <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Send Bulk Email</h5>                                   
                                </div>  
                            </div>
                                  <form class="container" action="#" method="post" enctype="multipart/form-data">


                            <div class="row">

<!--                          
                                <fieldset class="col-md-12">
                                    <legend>Company Details
                                        <hr></legend>
                                </fieldset>-->

                                <div class="col-sm-3">
                                    <div class="form-group"><label for="">Select CSV File <a href="Book1.csv">Download CSV File</a></label>
                           <input type="file" name="file" id="file" size="150">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group"><label for="">Task</label>
                                        <input class="form-control" name="content" id="content" placeholder="Enter Task" type="text">
                                    </div>
                                </div>
 <script src="ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
		   CKEDITOR.replace('content',{
	width: "100%",
        height: "400px"
     }
);
	</script>
  <div class="col-sm-3">
                                    <div class="form-group"><label for="">File Attachment</label>
                                        <input name="file_attachment" type="file">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <br>
                                         <input class="btn btn-primary" type="submit" value="Assign Task" name="submit">
                                        <!--<label for="">Conform Password</label>-->
                                        <!--<input class="form-control" name="CPSWD" placeholder="Conform Password" type="password">-->
                                    </div>
                                </div>




<!--                                <div class="form-buttons-w text-right">
                                    <input class="btn btn-primary" type="submit" value="Change Password" name="submit">
                                </div>-->
                            </div>
                        </form>
                            </div>
           
            </div>
        </div>
    </div>
</div>

                                
                                
<?php include './includes/Plugin.php'; ?>
        <?php include './includes/admin_footer.php'; ?>
                                
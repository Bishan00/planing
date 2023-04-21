<html>
    
    <head>
        <title></title>
    </head>
    <body>
<?php
$msg = '';
include './includes/db.php';

if (isset($_POST["submit"])) {

//     $content = $_POST['Content'];
//       $Subject = $_POST['Subject'];
     $filename = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        $count = 0;                                         // add this line
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {

            $count++;                                      // add this line

            if ($count > 1) {
                

// add this line
              $sno=$emapData[0];
              $name=$emapData[1];
              $fname=$emapData[2];
              $mobile=$emapData[3];
              $marks=$emapData[4];
             
              $query="INSERT INTO `result_show`(`sno`, `name`, `fname`, `mobileno`, `marks`, `created`)";
              $query .="VALUES ('$sno','$name','$fname','$mobile','$marks',now())";
              mysqli_query($connection, $query);
              
//                if (!$mail->send()) {
//                    echo 'Message could not be sent.';
//                    echo 'Mailer Error: ' . $mail->ErrorInfo;
//                } else {
//                    //  header("Location: index.html");
//                }
            }
           // sleep(30);
// add this line
        }
        fclose($file);
        echo 'CSV File has been successfully Imported';
                            echo "<script>alert('your request has been sent successfully');</script>";

//        header('Location: send_bulk_email.php');
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
                        <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Send Bulk Email&nbsp;&nbsp;<a style="font-size: 12px;" href="Book1.csv">Upload CSV File Format Download</a></h5>                                   
                    </div>  
                </div>
                <form class="container" action="#" method="post" enctype="multipart/form-data">


                    <div class="row">

                        <!--                          
                                                        <fieldset class="col-md-12">
                                                            <legend>Company Details
                                                                <hr></legend>
                                                        </fieldset>-->

                       
<!--                         <div class="col-sm-3">
                             <div class="form-group"><label for="">Email Subject</label>
                                <input type="text" name="Subject" class="form-control">
                            </div>
                        </div>-->
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Select CSV File</label>
                                <input type="file" name="file" id="file" size="150">
                            </div>
                        </div>
<!--                        <div class="col-sm-12">
                            <div class="form-group"><label for="">Email Content</label>
                                <textarea class="form-control" id="content" name="Content"></textarea> 
                            </div>
                        </div>-->

                        <div class="col-sm-3">
                            <div class="form-group">
                                <br>
                                <input class="btn btn-primary" type="submit" value="Send" name="submit">
                                <!--<label for="">Conform Password</label>-->
                                <!--<input class="form-control" name="CPSWD" placeholder="Conform Password" type="password">-->
                            </div>
                        </div>
                        <script src="ckeditor/ckeditor.js"></script>
                        <script type="text/javascript">
                            CKEDITOR.replace('content', {
                                width: "100%",
                                height: "400px"
                            }
                            );
                        </script>



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
</body>

</html>
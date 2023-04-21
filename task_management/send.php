<?php 

include 'class.smtp.php';
require_once('class.phpmailer.php');
if(isset($_POST['send']))
{
    $about=$_POST['about'];
    $websiteType=$_POST['websiteType'];
    $email=$_POST['email'];
    $mob=$_POST['mob'];
    $fname=$_POST['fname'];
    $buget=$_POST['buget'];

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
    $mail->addAddress('kishankushwah54@gmail.com');
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'logic web enquery';
    $mail->Body    ="Name :-". $fname ."<br> Mobile No.:-". $mob ."<br> email:-".$email."<br> about:-". $about ."<br> website Type:-". $websiteType ."<br> buget:-". $buget;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo "<script>alert('your request has been sent successfully');</script>";
        header("Location: index.html");
    }
}


?>
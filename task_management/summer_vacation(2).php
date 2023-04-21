<?php
include("header.php");
$link = mysqli_connect("localhost", "piit_piit", "JBU~)ebOqi1K", "piit_prateeek");

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $father = $_POST['father'];
    $mob1 = $_POST['mob1'];
    $mob2 = $_POST['mob2'];
    $quali = $_POST['quali'];
    $address = $_POST['address'];
    //$query = "INSERT INTO `aptitude_test`(`name`, `father_nm`, `dob`, `mobile1`, `mobile2`, `qualification`, `address`, `Status`, `created`) VALUES ('$name','$father','$dob','$mob1','$mob2','$quali','$address','1',now())";

    if (mysqli_query($link, $query) or die(mysqli_error())) {
        $msg = "Registration  successful your Roll No. 18. Your exam date 31-03-2019 at Prateek institution. Exam Timing 10:30AM-12:00PM. Bering your ID Proof. Call 9755562999";
        $message = urlencode($msg);
        $from = 'PRATIK';
        $api_url = "http://bulksms.piit.co/api/sendhttp.php?authkey=OWRmZWEwZTM1Nzk&mobiles=" . $mob1 . "&message=" . $message . "&sender=" . $from . "&type=1&route=2";
        $response = file_get_contents($api_url);

        //Enter your text message 
// $message="hello";
//Enter your Sender ID
// $sender="";
//Enter your receiver mobile number
// $mobile_number="XXXXXXXXXXX";
//Don't change below code use as it is
// $url="https://www.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&
// mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3');
//  $api_url="http://bulksms.piit.co/api/sendhttp.php?authkey=OWRmZWEwZTM1Nzk&mobiles=" . $mob1 . "&message=" . $msg . "&sender=" . $from . "&type=1&route=2";  
// $ch = curl_init($api_url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $curl_scraped_page = curl_exec($ch);
// curl_close($ch);
        $message = "Your Registration successful. Roll No 18, Exam date 31-03-2019 at Prateek institutute Timing 10:30AM-12:00PM. keep your Original Aadhaar Card Call 9755562999";
//$this->send_sms($mob1,$message);
        echo "<script>alert('success');</script>";
    } else {
//		echo "fail";
        echo "<script>alert('fail');</script>";
    }
}

function send_sms($mob1, $message) {
    $message = urlencode($message);
    $authkey = "OWRmZWEwZTM1Nzk"; // Go to your Roundsms panel to get your authkey
    $sender_id = "PRATIK";
    $type = 1;  //
    $route = 2; //
    $send = "http://roundsms.com/api/sendhttp.php?authkey=" . $authkey . "&mobiles=" . $mob1 . "&message=" . $message . "&sender=" . $sender_id . "&type=" . $type . "&route=" . $route;
    $res = file_get_contents($send);
    if ($res) {
        return $res;
    } else {
        return false;
    }
}
?>
<!-- Start main-content -->
<div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="images/bg3.jpg">
        <div class="container pt-70 pb-20">
            <!-- Section Content -->
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title text-white">Registration</h2>
                        <ol class="breadcrumb text-left text-black mt-10">
                            <li><a href="#">Home</a></li>

                            <li class="active text-gray-silver">Registration</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Divider: Contact -->
    <section class="divider layer-overlay overlay-white-9" data-bg-img="images/bg/bg15.jpg">
        <div class="container">
            <div class="row pt-30">
                <div class="col-md-12">
                    <h3 class="line-bottom mt-0 mb-20">Registration</h3>
                    <!-- Contact Form -->
<?php if (isset($_GET['success'])) {
    ?>
                        <div class="alert alert-error " align="center">
                            <button class="close" data-dismiss="alert"></button>
                            <span>Thank's Your Information Hasbeen Sent ! </span>
                        </div>
<?php } ?>
                    <form  name="contact_form" class="form-transparent" action="#" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="form_name">Name Of Candidate <small>*</small></label>
                                    <input name="name" class="form-control" type="text" placeholder="Enter Name" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="form_email">Date Of Birth <small>*</small></label>
                                    <input name="dob" class="form-control required email"  required="" type="date" placeholder="Enter DOB">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="form_name">Father's/Husband's Name <small>*</small></label>
                                    <input name="father" class="form-control required" type="text" required="" placeholder="Enter Subject">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="form_phone">Mobile 1</label>
                                    <input name="mob1" class="form-control" type="text" maxlength="10" minlength="10" required="" placeholder="Enter Phone">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="form_phone">Mobile 2</label>
                                    <input name="mob2" class="form-control" maxlength="10" minlength="10" type="text" required="" placeholder="Enter Phone">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="form_phone">Qualification</label>
                                    <input name="quali" class="form-control" type="text" placeholder="Enter Qualification">
                                    <!--<input name="phone" class="form-control" type="text" placeholder="Enter Phone">-->
                                </div>
                            </div>
                            <!--                   <div class="col-sm-6">
                                              <div class="form-group">
                                                <label for="form_phone">Address</label>
                                                <input name="phone" class="form-control" type="text" placeholder="Enter Phone">
                                              </div>
                                            </div>-->
                        </div>
                        <div class="form-group">
                            <label for="form_name">Address</label>
                            <textarea name="address" class="form-control required" rows="5" placeholder="Enter Address"></textarea>
                        </div>
                        <div class="form-group">

                            <button type="submit" name="submit" class="btn btn-dark btn-theme-colored btn-flat mr-5">Submit Now</button>
                            <!--<button type="reset" class="btn btn-default btn-flat btn-theme-colored">Reset</button>-->
                        </div>
                    </form>
                    <!-- Contact Form Validation-->

                </div>

            </div>
        </div>
    </section>


</div>
<!-- end main-content -->

<!-- Footer -->
<?php include("footer.php"); ?>
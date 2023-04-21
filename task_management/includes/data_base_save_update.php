
<?php

//include 'includes/checkauthenticator.php';
//include 'includes/db.php';

class databaseSave {


    function get_User_Details($user_ID) {
       // echo "<script>alert(".$user_ID.");</script>";
        $Name = '';
        $mobile = '';
        $User_type = '';
        $str='';
      // $this->$user_ID = $user_ID;
        $UID=$user_ID;
        $connection = mysqli_connect('localhost', 'root', '', 'task_management');
        $query = "SELECT * FROM `user_details` where User_ID='$UID'";
        $select_User_details = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_User_details)) {
            $Name = $row['FullName'];
            $mobile = $row['mobile1'];
            $User_type = $row['User_type'];
           
        }
       $str=$Name."/".$mobile."/".$User_type;
        return $str;
    }
    function download($tableNM) {
         $emp_id=  $_SESSION['user'];
        $this->table_name = $tableNM;
        $dname = $_POST['dname'];

        $download_file = $_FILES['download_file']['name'];
        $download_file_temp = $_FILES['download_file']['tmp_name'];
        move_uploaded_file($download_file_temp, "download/$download_file");
        $query = "INSERT INTO " . $this->table_name . "(`download_name`, `download_file`,empID) VALUES ('$dname','$download_file','$emp_id')";
        $connection = mysqli_connect('localhost', 'root', '', 'task_management');
        $insert_download_file = mysqli_query($connection, $query);
        if (!$insert_download_file) {
            die('QUERY FAILD' . mysqli_error($connection));
        } else {
            return 'pass';
        }
    }

    function alert($tableNM) {
        $news = $_POST['news'];
        $Remark = $_POST['Remark'];
        $this->table_name = $tableNM;
        $query = "INSERT INTO `news_and_update`(`news_title`, `remark`,created,news_type) VALUES ('$news','$Remark',now(),'alert')";
        $connection = mysqli_connect('localhost', 'root', '', 'task_management');
        $insert_service = mysqli_query($connection, $query);
        if (!$insert_service) {
            die('QUERY FAILD alert' . mysqli_error($connection));
        } else {
            return 'pass';
        }
    }

    function add_bank_details($tableNM) {
         $emp_id=  $_SESSION['user'];
        $this->table_name = $tableNM;
        $bname = $_POST['bname'];
        $acno = $_POST['acno'];
        $ifsc = $_POST['ifsc'];
        $acno = $_POST['acno'];
        $acHN=$_POST['acHN'];
        $Query = "INSERT INTO " . $this->table_name . "(`bank_name`, `ifscf_code`, `acno`, `acHN`, `createOn`, empID) VALUES ('$bname','$ifsc','$acno','$acHN',now(),'$emp_id')";
        $connection = mysqli_connect('localhost', 'root', '', 'task_management');
        $insert_bank_details = mysqli_query($connection, $Query);
        if (!$insert_bank_details) {
            die('QUERY FAILD' . mysqli_error($connection));
        } else {
            return 'pass';
        }
    }
       function update_bank_details($tableNM,$id) {
        $this->table_name = $tableNM;
        $bname = $_POST['bname'];
        //$acno = $_POST['acno'];
        $ifsc = $_POST['ifsc'];
        $acno = $_POST['acno'];
        $acHN=$_POST['acHN'];
       // $Query = "INSERT INTO " . $this->table_name . "(`bank_name`, `ifscf_code`, `acno`, `acHN`, `createOn`) VALUES ('$bname','$ifsc','$acno','$acHN',now())";
      
        $query="UPDATE `bank_details` SET `bank_name`='$bname',`ifscf_code`='$ifsc',`acno`='$acno',`acHN`='$acHN' WHERE id='$id' ";
        $connection = mysqli_connect('localhost', 'root', '', 'task_management');
        $insert_bank_details = mysqli_query($connection, $query);
        if (!$insert_bank_details) {
            die('QUERY FAILD' . mysqli_error($connection));
        } else {
            return 'pass';
        }
    }

    function gen_image_code_unique() {

        $today = date('YmdHi');
        $startDate = date('YmdHi', strtotime('-10 days'));
        $range = $today - $startDate;
        $rand = rand(0, $range);
        return ($startDate + $rand);
    }


function imageResize($imageResourceId,$width,$height) {


    $targetWidth =900;
    $targetHeight =548;


    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


    return $targetLayer;
}
  
}

?>
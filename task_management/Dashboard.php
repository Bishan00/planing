
<style>
    .marquee-container {
        display: flex;
        align-items: center;
        animation: marquee 1000s linear infinite;
    }

    .marquee-content {
        display: flex;
        align-items: center;
        background: #F28018;
    }
    body {
    background-image: url('atire3.jpg'); /* Specify the path to your image file */
    background-size: cover; /* Adjust the size of the background image */
    background-repeat: no-repeat; /* Prevent image from repeating */
    background-attachment: fixed; /* Fix the image while scrolling */
}
    
   
    .marquee-logo {
        height: 50px;
        margin-right: 20px;
        animation: marquee 30s linear infinite reverse;
    }

    @keyframes marquee {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
</style>

<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
//include 'includes/App_Code.php';
include 'includes/App_Code.php';
$AppCodeObj=new App_Code();

// found work

$msg = '';
$Genrate = new App_Code();
$appC0de = new databaseSave();
if (isset($_GET['UserID']) && isset($_GET['Status'])) {

    $userID = $_GET['UserID'];
    $Inactive = $_GET['Status'];
    $msg = $Inactive;
    if ($Inactive == '1') {

        $query = "UPDATE `user_details` SET `Inactive`='0' WHERE User_ID='$userID'";
        $Active_User = mysqli_query($connection, $query);
        if (!$Active_User) {
            die('QUERY FAILD' . mysqli_error($connection));
        }
    } else if ($Inactive == '0') {
        //   echo $Inactive;
        $query = "UPDATE `user_details` SET `Inactive`='1' WHERE User_ID='$userID'";
        $deactive_User = mysqli_query($connection, $query);
        if (!$deactive_User) {
            die('QUERY FAILD' . mysqli_error($connection));
        }
    }
    //  header("location:./admin/retailer_account_list.php");
}

?>
<!--------------------
START - Breadcrumbs
-------------------->

<!--------------------
END - Breadcrumbs
-------------------->
<div class="content-panel-toggler"><i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span></div>
<div class="content-i">
    <div class="content-box">
    <marquee direction="left" style="background: #000000;">
    <span class="breadcrumb-item">
       
        <?php
        $qry = mysqli_query($connection, "SELECT * FROM news_and_update where news_type='alert' order by created desc") or die("select query fail" . mysqli_error());
        while ($row = mysqli_fetch_assoc($qry)) {
            $news_title = $row['news_title'];
            ?>
            <a href="#" style="color:#f28018; font-size: 10px;"><?php echo $news_title; ?>&nbsp;<strong></strong></a>
        <?php } ?>
        <img src="atire.png" alt="Logo" style="height: 50px; margin-right: 20px;">
    </span>
</marquee>



                  <marquee direction="right" style="background: #F28018;">
<span class="breadcrumb-item">
       <?php
                                            $qry = mysqli_query($connection, "SELECT * FROM news_and_update2 where news_type='alert' order by created desc") or die("select query fail" . mysqli_error());
                                            //  $stateData = $AppCodeObj->select_state();
                                            while ($row = mysqli_fetch_assoc($qry)) {
                                                $news_title = $row['news_title'];
                                                ?>
    
    <a href="#" style="color:#000000;font-size: 18px;"><?php echo $news_title;?>&nbsp; <strong></strong> </a>


    
                                            <?php }?>
</span>
        
         
                  </marquee>



        <?php         
        if($_SESSION['User_type']=='admin')
        {
               include './includes/admin_dashboard.php';  
        } 
 else {
       include './includes/emp_dashboard.php';   
 }
    
        
        ?>
      
    </div>
       


    </div>


<?php include './includes/Plugin.php'; ?>
  
</div>


<?php include './includes/admin_footer.php'; ?>
        
        <script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'pdfHtml5'
        ]
    } );
} );
        </script>
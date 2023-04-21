
<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
//include 'includes/App_Code.php';
$retailer_account = "SELECT User_ID FROM user_details where User_type='Retailer' ";
$retailer_account_count_row = 0;
include 'includes/App_Code.php';
$AppCodeObj=new App_Code();
if ($result = mysqli_query($connection, $retailer_account)) {
    $retailer_account_count_row = mysqli_num_rows($result);
}

$distributor_account = "SELECT User_ID FROM user_details where User_type='Distributor' ";
$distributor_account_count_row = 0;
if ($result = mysqli_query($connection, $distributor_account)) {
    $distributor_account_count_row = mysqli_num_rows($result);
}


$pan_new_pan_card = "SELECT pan_id FROM pan_mst where pancardType='New Pan Card' ";
$pan_new_pan_card_pending_count_row = 0;
;
if ($result = mysqli_query($connection, $pan_new_pan_card)) {
    $pan_new_pan_card_pending_count_row = mysqli_num_rows($result);
}

$change_pan_card = "SELECT pan_id FROM pan_mst where pancardType='change pan card' ";
$change_pan_card_count_row = 0;
if ($result = mysqli_query($connection, $change_pan_card)) {
    $change_pan_card_count_row = mysqli_num_rows($result);
}


$pan_pending = "SELECT pan_id FROM pan_mst where Status='pending' ";
$pan_pending_count_row = 0;
;
if ($result = mysqli_query($connection, $pan_pending)) {
    $pan_pending_count_row = mysqli_num_rows($result);
}

$pan_Process = "SELECT pan_id FROM pan_mst where Status='Process' ";
$pan_Process_count_row = 0;
if ($result = mysqli_query($connection, $pan_Process)) {
    $pan_Process_count_row = mysqli_num_rows($result);
}



$pan_Approve = "SELECT pan_id FROM pan_mst where Status='Approve' ";
$pan_Approve_count_row = 0;
if ($result = mysqli_query($connection, $pan_Approve)) {
    $pan_Approve_count_row = mysqli_num_rows($result);
}


$pan_Error = "SELECT pan_id FROM pan_mst where Status='Error'";
$pan_Error_count_row = 0;
if ($result = mysqli_query($connection, $pan_Error)) {
    $pan_Error_count_row = mysqli_num_rows($result);
}


$pan_Complete = "SELECT pan_id FROM pan_mst where Status='Complete'";
$pan_Complete_count_row = 0;
if ($result = mysqli_query($connection, $pan_Complete)) {
    $pan_Complete_count_row = mysqli_num_rows($result);
}
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
if (isset($_GET['Found_id']) && isset($_GET['userID'])) {
    $a_total_amt = 0;
    $id = $_GET['Found_id'];

    $qry = mysqli_query($connection, "SELECT * FROM found_request where id='$id'") or die("select query fail" . mysqli_error());
    $remark = '';
    $payment_mode = '';
    $payproof = '';
    $Fund_id = '';
    while ($row = mysqli_fetch_assoc($qry)) {
        $Fund_id = $row['id'];
        $amount = $row['amount'];
        $remark = $row['remark'];
        $payment_mode = $row['pay_mode'];
        $payproof = $row['pay_proof'];
        $remaing_bal = $amount;
        $total_amt = $amount;
    }
    $userID = $_GET['userID'];
    $tranID = $Genrate->getTransaction();

    $sel_qry = mysqli_query($connection, "select * from wallet where UserID='$userID' order by wallet_ID desc limit 1 ") or die(mysqli_error());

    if ($wallet = mysqli_num_rows($sel_qry) > 0) {

        // $wallet = mysqli_query($con, $sel_qry);

        while ($row = mysqli_fetch_assoc($sel_qry)) {
            //     echo '<script> alert("aaaaaaaaaaaaa")</script>';
            $a_total_amt = $row['total_amt'];
            $re_amt = $row['remaing_bal'];
            $a_total_amt = $a_total_amt + $amount;
            $re_amt = $re_amt + $amount;
            $remaing_bal = $re_amt;
        }

        $main_balance = "UPDATE `user_details` SET `total_amt`='$a_total_amt',`rememig_amt`='$remaing_bal' WHERE User_ID='$userID'";
        $main_balance_wallet_data = mysqli_query($connection, $main_balance);
        if (!$main_balance_wallet_data) {
            die('QUERY FAILD' . mysqli_error($connection));
        }
        $wallet_query = "INSERT INTO wallet (wallet_amt, total_amt, remaing_bal, remark, UserID, payment_mode, pay_proof) VALUES ($amount, $a_total_amt, $re_amt, '$remark', $userID, '$payment_mode','$payproof')";
        $insert_wallet_data = mysqli_query($connection, $wallet_query);
        if (!$insert_wallet_data) {
            die('QUERY FAILD' . mysqli_error($connection));
        }
    } else {
        $main_balance = "UPDATE `user_details` SET `total_amt`='$total_amt',`rememig_amt`='$remaing_bal' WHERE User_ID='$userID'";
        $main_balance_wallet_data = mysqli_query($connection, $main_balance);
        if (!$main_balance_wallet_data) {
            die('QUERY FAILD' . mysqli_error($connection));
        }

        $wallet_query = "INSERT INTO wallet (wallet_amt, total_amt, remaing_bal, remark, UserID, payment_mode, pay_proof) VALUES ($amount, $total_amt, $remaing_bal, '$remark', $userID, '$payment_mode','$payproof')";
        $insert_wallet_data = mysqli_query($connection, $wallet_query);
        if (!$insert_wallet_data) {
            die('QUERY FAILD' . mysqli_error($connection));
        }
    }


    $tran_query = "INSERT INTO transaction(transaction_id, tran_amt, credit_amt, debit_amt, created, User_ID, remaing_Amt) VALUES ('$tranID', $amount, $amount,'', now(), '$userID', $remaing_bal)";
    $insert_Tran_data = mysqli_query($connection, $tran_query);
    if (!$insert_Tran_data) {
        die('QUERY FAILD' . mysqli_error($connection));
    }

    $update_fund_list = "UPDATE `found_request` SET `status`='compelet' WHERE `id`='$Fund_id'";
    $update_fund_record = mysqli_query($connection, $update_fund_list);
    if (!$update_fund_record) {
        die('QUERY FAILD' . mysqli_error($connection));
    }

    echo "<script>alert ('wallet amount transfer Successfull');
       window.location.href='admin/fund_request_list.php';
       </script>";
}
?>
<!--------------------
START - Breadcrumbs
-------------------->
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><span>Dashboard</span></li>
</ul>
<!--------------------
END - Breadcrumbs
-------------------->
<div class="content-panel-toggler"><i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span></div>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                <div class="col-md-8">
                <div class="element-wrapper">
                    <div class="element-actions">

                    </div>
                    <h6 class="element-header">Dashboard</h6>
                    <div class="element-content">
                        <div class="row">
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="#">
                                    <div class="label">Total Employee</div>
                                    <div class="value"><?php echo $pan_new_pan_card_pending_count_row; ?></div>
 </a>
                            </div>
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="#">
                                    <div class="label">Active Employee</div>
                                    <div class="value"><?php echo $pan_pending_count_row; ?></div>
                                    <!--                                                    <div class="trending trending-down-basic"><span>9%</span><i class="os-icon os-icon-arrow-down"></i></div>-->
                                </a>
                            </div>

                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="#">
                                    <div class="label">Deactivate Employee</div>
                                    <div class="value"><?php echo $pan_Error_count_row; ?></div>
                                </a>
                            </div>
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="#">
                                    <div class="label">Total Task</div>
                                    <div class="value"><?php echo $change_pan_card_count_row; ?></div>
 </a>
                            </div>
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="#">
                                    <div class="label">Open Task</div>
                                    <div class="value"><?php echo $retailer_account_count_row; ?></div>
 </a>
                            </div>
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="#">
                                    <div class="label">Close Task</div>
                                    <div class="value"><?php echo $distributor_account_count_row; ?></div>
 </a>
                            </div>
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="#">
                                    <div class="label">WIP Task</div>
                                    <div class="value"><?php echo $pan_Complete_count_row; ?></div>
                               </a>
                            </div>

                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="#">
                                    <div class="label">Cancel Task</div>
                                    <div class="value"><?php echo $pan_Process_count_row; ?></div>
                               </a>
                            </div>

<!--                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="#">
                                    <div class="label">Approve</div>
                                    <div class="value"><?php echo $pan_Approve_count_row; ?></div>
                                </a>
                            </div>-->
                    
                        </div>
                    </div>
                </div>
          </div> 
                <div class="col-md-4">
                      <!--------------------
    START - Sidebar
    -------------------->
    <div class="content-panel">
        <div class="content-panel-close"><i class="os-icon os-icon-close"></i></div>
        <div class="element-wrapper">
            <h6 class="element-header">Quick Links</h6>
            <div class="element-box-tp">
                <div class="el-buttons-list full-width">
                    <a class="btn btn-white btn-sm" href="#">
                        <i class="os-icon os-icon-delivery-box-2"></i><span>Add New Employee</span>
                    </a>
                    <a class="btn btn-white btn-sm" href="#">
                        <i class="os-icon os-icon-delivery-box-2"></i><span>Create New Task</span>
                    </a>
                    <a class="btn btn-white btn-sm" href="download.php">
                        <i class="os-icon os-icon-delivery-box-2"></i><span>Download</span>
                    </a>
                    <a class="btn btn-white btn-sm" href="add_alert.php">
                        <i class="os-icon os-icon-delivery-box-2"></i><span>Alert</span>
                    </a>
                   

                </div>
            </div>
        </div>

    </div>
    <!--------------------
    END - Sidebar
    -------------------->
                </div>
            </div>
            </div>
        </div>    
      
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
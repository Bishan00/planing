<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    if(isset($_GET['Pan_ID']))
    {
    $Pan_ID = $_GET['Pan_ID'];
    //$status = $_GET['status'];
    $pan_status=$_POST['pan_status']; 
    $error=$_POST['error'];
    $query="UPDATE `pan_mst` SET `Status`='$pan_status',`Error`='$error' WHERE pan_id='$Pan_ID'";
    $status_chnage=  mysqli_query($connection, $query);
         echo "<script>
       window.location.href='../admin/pan_card_list.php';
       </script>";//alert ('Login Successfull');
    }
}
?>
<!--------------------
START - Breadcrumbs
-------------------->
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><span>Status</span></li>
</ul>
<!--------------------
END - Breadcrumbs
-------------------->
<div class="content-panel-toggler"><i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span></div>
<div class="content-i">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box">
                <form action="#" method="post" enctype="multipart/form-data">


                    <div class="row">
                        <div class="col-md-12">
                            <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Status</h5>                                   
                        </div>  
                        <div class="col-sm-6">
                            <div class="form-group"><label for="">Status</label>
                                <select name="pan_status" class="form-control">  
                                   
                                    <?php
                                    $status = $_GET['status'];
                                    if ($status == "Pending") {
                                        echo "<option selected value='Pending'>Pending</option>";
                                    } else {
                                        echo "<option value='Pending'>Pending</option>";
                                    }
                                    if ($status == "Process") {
                                        echo " <option selected value='Process'>Process</option>";
                                    } else {
                                        echo " <option value='Process'>Process</option>";
                                    }
                                    if ($status == "Approve") {
                                        echo "<option selected value='Approve'>Approve</option>";
                                    } else {
                                        echo "<option value='Approve'>Approve</option>";
                                    }
                                    if ($status == "Error") {
                                        echo "<option selected value='Error'>Error</option>";
                                    } else {
                                        echo "<option value='Error'>Error</option>";
                                    }
                                    if ($status == "Complete") {
                                        echo "<option selected value='Complete'>Complete</option>";
                                    } else {
                                        echo "<option value='Complete'>Complete</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"><label for="">Error</label>
                                <input class="form-control" name="error" placeholder="error" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <input class="btn btn-primary" type="submit" value="Submit Now" name="submit">
                        </div>

                        <!--                            <div class="form-buttons-w text-right">
                                                        <input class="btn btn-primary" type="submit" value="Submit Now" name="submit">
                                                    </div>-->
                    </div>
                </form>
            </div>
        </div>
<?php include './includes/Plugin.php'; ?>
<?php include './includes/admin_footer.php'; ?>
<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    $msg = $AppCodeObj->add_bank_details("bank_details");
}
if (isset($_POST['update'])) {
    $msg = $AppCodeObj->update_bank_details("bank_details", $_GET['edit']);
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM `bank_details` WHERE id='$id'";
    mysqli_query($connection, $query);
}
?>
<!--------------------
START - Breadcrumbs
-------------------->
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><span>Bank Details</span></li>
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
                    <div class="col-md-6">
                        <?php
                        if (isset($_GET['edit'])) {
                            $id = $_GET['edit'];
                            $qry = mysqli_query($connection, "SELECT * FROM bank_details where id='$id'") or die("select query fail" . mysqli_error());
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($qry)) {
                                $count = $count + 1;
                                $id = $row['id'];
                                $bank_name = $row['bank_name'];
                                $ifscf_code = $row['ifscf_code'];
                                $acno = $row['acno'];
                                $acHN = $row['acHN'];
                                ?>
                                <form action="#" method="post" enctype="multipart/form-data">


                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Bank Details</h5>                                   
                                        </div>  
                                        <div class="col-sm-6">
                                            <div class="form-group"><label for="">Bank Name</label>
                                                <input class="form-control" name="bname" value="<?php echo $bank_name; ?>" placeholder="Bank Name" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group"><label for="">Account No.</label>
                                                <input class="form-control" name="acno" value="<?php echo $acno; ?>" placeholder="Account No" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group"><label for="">IFSC Code</label>
                                                <input class="form-control" name="ifsc" value="<?php echo $ifscf_code; ?>" placeholder="IFSC Code" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group"><label for="">Account Holder Name</label>
                                                <input class="form-control" name="acHN" value="<?php echo $acHN; ?>" placeholder="Account Holder Name" type="text">
                                            </div>
                                        </div>


                                        <div class="form-buttons-w text-right">
                                            <input class="btn btn-primary" type="submit" value="Update Now" name="update">
                                        </div>
                                    </div>
                                </form>   
                                <?php
                            }
                        } else {
                            ?>
                            <form action="#" method="post" enctype="multipart/form-data">


                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Bank Details</h5>                                   
                                    </div>  
                                    <div class="col-sm-6">
                                        <div class="form-group"><label for="">Bank Name</label>
                                            <input class="form-control" name="bname" placeholder="Bank Name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group"><label for="">Account No.</label>
                                            <input class="form-control" name="acno" placeholder="Account No" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group"><label for="">IFSC Code</label>
                                            <input class="form-control" name="ifsc" placeholder="IFSC Code" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group"><label for="">Account Holder Name</label>
                                            <input class="form-control" name="acHN" placeholder="Account Holder Name" type="text">
                                        </div>
                                    </div>


                                    <div class="form-buttons-w text-right">
                                        <input class="btn btn-primary" type="submit" value="Submit Now" name="submit">
                                    </div>
                                </div>
                            </form>             
    <?php }
?>



                    </div>
                    <div class="col-md-6">
                        <table class="table table-responsive" style="width: 100%;">
                            <tr>
                                <th>S No.</th>
                                <th>Bank Name</th>
                                <th>Account No.</th>
                                <th>IFSC Code</th> 
                                <th>Account Holder Name</th> 
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
<?php
$qry = mysqli_query($connection, "SELECT * FROM bank_details order by createOn desc ") or die("select query fail" . mysqli_error());
$count = 0;
while ($row = mysqli_fetch_assoc($qry)) {
    $count = $count + 1;
    $id = $row['id'];
    $bank_name = $row['bank_name'];
    $ifscf_code = $row['ifscf_code'];
    $acno = $row['acno'];
    $acHN = $row['acHN'];
    ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $bank_name; ?></td>
                                    <td><?php echo $acno; ?></td>
                                    <td><?php echo $ifscf_code; ?></td>
                                    <td><?php echo $acHN; ?></td>
                                    <td><a href="bank_details.php?edit=<?php echo $id; ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                    <td><a href="bank_details.php?delete=<?php echo $id; ?>" class="btn btn-sm btn-danger">Delete</a></td>
                                </tr>
<?php } ?>
                        </table>
                    </div>
                </div>

            </div>
        </div>
<?php include './includes/Plugin.php'; ?>
        <?php include './includes/admin_footer.php'; ?>
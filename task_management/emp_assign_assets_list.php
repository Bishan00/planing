<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
include './includes/App_Code.php';
$msg = '';
$app_code_obj=new App_Code();
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
$asset_tp=$_POST['asset_tp'];
        $csno=$_POST['csno'];
        $emp_id=$_POST['emp_id'];
       $issue_date= $_POST['issue_date'];
      $Issue_Dis=  $_POST['Issue_Dis'];
      $query="INSERT INTO `emp_assets`(`asset_id`, `emp_id`, `issue_date`, `des`, `status`, `created`) VALUES ('$csno','$emp_id','$issue_date','$Issue_Dis','1',now())";
   $insert_data= mysqli_query($connection, $query);
   $query_update="UPDATE `asset_tb` SET `status`='0' WHERE `assetID`='$csno'";
    $q_update= mysqli_query($connection, $query_update);
   
    if (!$insert_data) {
        die('QUERY FAILD change pashword' . mysqli_error($connection));
    } else {
        
        

        echo "<script>alert('Record Save Successfully');</script>";
        // return 'pass';
    }
}
?>
<!--------------------
START - Breadcrumbs
-------------------->
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><span>Add Assets</span></li>
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
                        <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Add Assets</h5>                                   
                    </div>  
                </div>
                <div class="container">
                     <table id="example" style="width: 100%;" class="display table table-bordered table-responsive" style="width:100%">
        <thead>
            <tr>
                <th>S No.</th>
                <th>Employee Name</th>
                <th>CSNO</th>
                <th>Assign Date</th>
                  <th>Description</th>
                
                <th>Status</th>
                <th>Return</th>
            </tr>
        </thead>
        <tbody>
                                     <?php
                 $qry = mysqli_query($connection, "SELECT * FROM emp_assets order by created desc") or die("select query fail" . mysqli_error());
$count = 0;
while ($row = mysqli_fetch_assoc($qry)) {
    $count = $count + 1;
$assign_id= $row['assign_id'];
    $asset_id     = $row['asset_id'];
        $emp_id = $row['emp_id'];
       $issue_date  = $row['issue_date']; 
       $des  = $row['des'];
       $status  = $row['status'];
        $created = $row['created'];
        $csno='';
           $qry2 = mysqli_query($connection, "SELECT * FROM asset_tb where assetID='$asset_id'") or die("select query fail" . mysqli_error());
                        while ($row = mysqli_fetch_assoc($qry2)) {
                            $csno = $row['csno'];
                        }
    ?>
                    <tr>
  <td><?php echo $count;?></td>
  <td> <?php echo $app_code_obj->getName($emp_id);?></td>
  <td><?php echo $csno;?></td>
  <td><?php echo $issue_date;?></td>  
    <td><?php echo $des;?></td>  
    <td><?php echo $status;?></td> 
  <td><a href="#" class="btn btn-success"> Return</a></td> 

                    </tr>
<?php }?>
        </tbody> </table>
                </div>
            </div>

        </div>
    </div>
</div>
</div>



<?php include './includes/Plugin.php'; ?>
<?php include './includes/admin_footer.php'; ?>
                                
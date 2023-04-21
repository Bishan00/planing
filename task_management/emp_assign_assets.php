<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
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
                <form class="container" action="#" method="post" enctype="multipart/form-data">


                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Asset Type</label>
                                <!--<input class="form-control" name="csno" placeholder="CSNO" type="text">-->
                                <select id="asset_id" name="asset_tp" class="form-control">
                                    <option>--Select--</option>   
                                      <option value="DES">Desktop</option>
                                    <option value="LAP">Laptop</option>                                     
                                    <option value="MON">Monitor</option>
                                    <option value="PRN">Printer</option>     
                                    <option value="NETM"> Modem</option>  
                                    <option value="NETS"> Switch</option>  
                                    <option value="NETW">WIFI</option>  
                                    <option value="NETR">Router</option>  
                                </select>
                            </div>
                        </div>
                         <div class="col-sm-3">
                            <div class="form-group"><label for="">CSNO</label>
                                <!--<input class="form-control" name="csno" placeholder="CSNO" type="text">-->
<!--                                <select name="csno" class="form-control">
                                    <option>--Select--</option>
                                    <?php                                     
                                    $qry1 = mysqli_query($connection, "SELECT * FROM asset_tb where delete_status='0' and status !='0'  order by created desc") or die("select query fail" . mysqli_error());
                        while ($row = mysqli_fetch_assoc($qry1)) {
                            $asset_count = $asset_count + 1;
                            $csno=$row['csno'];
                                $assetID=$row['assetID']; 
                            
                            ?>
                                    <option value="<?php echo $assetID;?>"><?php echo $csno;?></option> 
                                    <option value="<?php echo $csno;?>"><?php echo $csno;?></option>
                                    <?php
                        }
                                    ?>
                                   
                                    
                                </select>-->
                                   <select id="csnoID" name="csno" class="form-control">
                               
                          
                                   
                                    
                                </select>
                            </div>
                        </div>
                            <div class="col-sm-3">
                            <div class="form-group"><label for="">Employee</label>
                                <!--<input class="form-control" name="csno" placeholder="CSNO" type="text">-->
                                <select name="emp_id" class="form-control">
                                    <option>--Select--</option>
                                                <?php                                     
                                    $qry1 = mysqli_query($connection, "SELECT * FROM emp_login where status='1' order by emp_name asc") or die("select query fail" . mysqli_error());
                        while ($row = mysqli_fetch_assoc($qry1)) {
                            $asset_count = $asset_count + 1;
                            $emp_name=$row['emp_name'];
                            $id=$row['id'];
                            
                            ?>
                                    <option value="<?php echo $id;?>"><?php echo $emp_name;?></option>
                                    <?php
                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Issue Date</label>
                                <input class="form-control" name="issue_date" placeholder="Select Issue Date" type="date">
                            </div>
                        </div>
                       
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Description</label>
                           <textarea class="form-control" name="Issue_Dis"></textarea> <!--<input class="form-control" name="task" placeholder="Enter Task" type="date">-->
                            </div>
                        </div>
                        <!--                                      <div class="col-sm-3">
                                                            <div class="form-group"><label for="">Device Image</label>
                                                                <input class="form-control" name="task" placeholder="Enter Task" type="text">
                                                            </div>
                                                        </div>-->
<!--                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Device Image</label>
                                <input name="device_file" type="file">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for=""> Invoice</label>
                                <input name="invoice_file" type="file">
                            </div>
                        </div>-->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <br>
                                <input class="btn btn-primary" type="submit" value="Assign Now" name="submit">
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>



<?php include './includes/Plugin.php'; ?>
<?php include './includes/admin_footer.php'; ?>
                                
<div class="row">
            <div class="col-sm-12">
                <div class="row">
                <div class="col-md-8">
                <div class="element-wrapper">
                    <div class="element-actions">
<?php 
$retailer_account = "SELECT id FROM emp_login where user_role='employee' ";
$Total_emp = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $Total_emp = mysqli_num_rows($result);
}

$retailer_account = "SELECT id FROM emp_login where user_role='employee' and status='1' ";
$Active_emp = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $Active_emp = mysqli_num_rows($result);
}

$retailer_account = "SELECT id FROM emp_login where user_role='employee' and status='0' ";
$Deactive_emp = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $Deactive_emp = mysqli_num_rows($result);
}

$retailer_account = "SELECT task_id FROM assign_task";
$Total_task = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $Total_task = mysqli_num_rows($result);
}

$retailer_account = "SELECT task_id FROM assign_task where status='Open'";
$open_task = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $open_task = mysqli_num_rows($result);
}


$retailer_account = "SELECT task_id FROM assign_task where status='WIP'";
$WIP_task = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $WIP_task = mysqli_num_rows($result);
}

$retailer_account = "SELECT task_id FROM assign_task where status='Close'";
$close_task = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $close_task = mysqli_num_rows($result);
}

$retailer_account = "SELECT task_id FROM assign_task where status='Cancel'";
$cancel_task = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $cancel_task = mysqli_num_rows($result);
}?>
                    </div>
                    <h6 class="element-header">Dashboard</h6>
                    <div class="element-content">
                        <div class="row">
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="employee.php">
                                    <div class="label">Total Employee</div>
                                    <div class="value"><?php echo $Total_emp; ?></div>
 </a>
                            </div>
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="employee_active.php">
                                    <div class="label">Active Employee</div>
                                    <div class="value"><?php echo $Active_emp; ?></div>
                                    <!--                                                    <div class="trending trending-down-basic"><span>9%</span><i class="os-icon os-icon-arrow-down"></i></div>-->
                                </a>
                            </div>

                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="employee_deactive.php">
                                    <div class="label">Deactivate Employee</div>
                                    <div class="value"><?php echo $Deactive_emp; ?></div>
                                </a>
                            </div>
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="assign_task_list.php">
                                    <div class="label">Total Task</div>
                                    <div class="value"><?php echo $Total_task; ?></div>
 </a>
                            </div>
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="assign_task_open_list.php">
                                    <div class="label">Open Task</div>
                                    <div class="value"><?php echo $open_task; ?></div>
 </a>
                            </div>
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="assign_task_list_close.php">
                                    <div class="label">Close Task</div>
                                    <div class="value"><?php echo $close_task; ?></div>
 </a>
                            </div>
                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="assign_task_list_wip.php">
                                    <div class="label">WIP Task</div>
                                    <div class="value"><?php echo $WIP_task; ?></div>
                               </a>
                            </div>

                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="assign_task_list_cancel.php">
                                    <div class="label">Cancel Task</div>
                                    <div class="value"><?php echo $cancel_task; ?></div>
                               </a>
                            </div>

<!--                            <div class="col-sm-4 col-xxxl-3">
                                <a class="element-box el-tablo" href="#">
                                    <div class="label">Approve</div>
                                    <div class="value"><?php echo $pan_Approve_count_row; ?></div>
                                </a>
                            </div>-->
                    
                        </div>
                           <div class="element-box">
<table class="dataTable table table-responsive">
                    <tr>
                        <th>S No.</th>
                        <!--<th>Emp Code</th>-->
                        <th>Emp Name</th>
                         <th>Mobile No</th>
                        <th>Total</th>    
                        <th>Open</th>                          
                            <th>WIP</th>                            
                            <th>Close</th>
                             <th>Cancel</th>
                              <!--<th>Date</th>-->
                              <!--<th>Status</th>-->
                               <!--<th>Edit</th>-->
                          <!--<th>Delete</th>-->
                    </tr>
                                                               <?php
                 $qry = mysqli_query($connection, "SELECT * FROM emp_login where user_role='employee'") or die("select query fail" . mysqli_error());
$count = 0;
while ($row = mysqli_fetch_assoc($qry)) {
    $count = $count + 1;
  
    $id = $row['id'];
            $emp_code = $row['emp_code'];
            $emp_name = $row['emp_name'];
            $user_id = $row['user_id'];
            $pswd = $row['pswd'];
            $status = $row['status'];
            $created = $row['created'];
            $user_role = $row['user_role'];
            $emp_pro = $row['emp_pro'];
            $email_id = $row['email_id'];
            $emp_mob = $row['emp_mob'];
     $status = '';
    $btnClass = '';
    if ($row['status'] == '1') {
        $btnClass = "btn  btn-success btn-sm";
        $status = "Active";
    } else {
        $status = "Deactive";
        $btnClass = "btn btn-danger btn-sm";
    }
        $retailer_account = "SELECT task_id FROM assign_task where emp_id='$id'";
$Total_task = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $Total_task = mysqli_num_rows($result);
}

    
    $retailer_account = "SELECT task_id FROM assign_task where status='Open' and  emp_id='$id'";
$open_task = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $open_task = mysqli_num_rows($result);
}


$retailer_account = "SELECT task_id FROM assign_task where status='WIP' and  emp_id='$id'";
$WIP_task = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $WIP_task = mysqli_num_rows($result);
}

$retailer_account = "SELECT task_id FROM assign_task where status='Close' and  emp_id='$id'";
$close_task = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $close_task = mysqli_num_rows($result);
}

$retailer_account = "SELECT task_id FROM assign_task where status='Cancel' and  emp_id='$id'";
$cancel_task = 0;
if ($result = mysqli_query($connection, $retailer_account)) {
    $cancel_task = mysqli_num_rows($result);
}
    ?>
                    <tr>
  <td><?php echo $count;?></td>
<!--  <td><?php echo $emp_code;?></td>-->
  <td><?php echo  $emp_code."/".$emp_name;?></td>
  <td><?php echo $emp_mob;?></td> 
<!--  <td><?php echo $email_id;?></td> -->
   <td><a href="#" class="btn btn-primary"><?php echo $Total_task;?></a></td> 
  <td><a href="admin_assign_task_list.php?status=Open&Emp_ID=<?php echo $id;?>" class="btn btn-primary"><?php echo $open_task;?></a></td> 
  <td><a href="admin_assign_task_list.php?status=WIP&Emp_ID=<?php echo $id;?>" class="btn btn-primary"><?php echo $WIP_task;?></a></td> 

    <td><a href="admin_assign_task_list.php?status=Close&Emp_ID=<?php echo $id;?>" class="btn btn-primary"><?php echo $close_task;?></a></td> 
        <td><a href="admin_assign_task_list.php?status=Cancel&Emp_ID=<?php echo $id;?>" class="btn btn-primary"><?php echo $cancel_task;?></a></td> 
    <!--<td> <img src="user_profile/<?php echo $emp_pro;?>" height="80px" width="80px"></td>--> 
      <!--<td><?php echo $created;?></td>--> 
      <!--<td><a href="employee.php?id=<?php echo $row['id']; ?>&Status=<?php echo $row['status']; ?>" class="<?php echo $btnClass; ?> " ><?php echo $status; ?></a></td>-->
    <!--<td><a class="btn btn-primary" href="employee.php?source=update_emp&emp_id=<?php echo $id;?>">Edit</a></td>-->
                              <!--<td><a class="btn btn-danger" href="employee.php?delete=<?php echo $id;?>">Delete</a></td>-->
                    </tr>
<?php }?>
                </table>
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
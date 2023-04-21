   <div class="element-box">
              <table id="example" style="width: 100%;" class="display table table-bordered table-responsive" style="width:100%">
        <thead>
                    <tr>
                        <th>S No.</th>
                        <th>Emp Code</th>
                        <th>Name</th>
                         <th>Mobile No</th>
                          <th>Email ID</th>
                           <th>User ID</th>
                            <th>PSWD</th>
                             <th>Profile</th>
                              <th>Date</th>
                              <th>Status</th>
                               <th>Edit</th>
                          <th>Delete</th>
                    </tr>
        </thead>   <tbody>
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
    ?>
                    <tr>
  <td><?php echo $count;?></td>
  <td><?php echo $emp_code;?></td>
  <td><?php echo $emp_name;?></td>
  <td><?php echo $emp_mob;?></td> 
  <td><?php echo $email_id;?></td> 
  
    <td><?php echo $user_id;?></td> 
  <td><?php echo $pswd;?></td> 

    <!--<td><?php echo $emp_pro;?></td>--> 
    <td> <img src="user_profile/<?php echo $emp_pro;?>" height="80px" width="80px"></td> 
      <td><?php echo $created;?></td> 
      <td><a href="employee.php?id=<?php echo $row['id']; ?>&Status=<?php echo $row['status']; ?>" class="<?php echo $btnClass; ?> " ><?php echo $status; ?></a></td>
    <td><a class="btn btn-primary" href="employee.php?source=update_emp&emp_id=<?php echo $id;?>">Edit</a></td>
                              <td><a class="btn btn-danger" href="employee.php?delete=<?php echo $id;?>">Delete</a></td>
                    </tr>
<?php }?>
        </tbody>     </table>
   </div>
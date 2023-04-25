<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
$AppCodeObj = new databaseSave();




?>
<!--------------------
START - Breadcrumbs
-------------------->
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><span>Employee</span></li>
</ul>
<!--------------------
END - Breadcrumbs
-------------------->
<div class="content-panel-toggler"><i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span></div>
<div class="content-i">
    <div class="content-box">
        <div class="element-wrapper">
              <div class="element-box">
<table class="dataTable table table-responsive">
<tr>

            <th>To be produced</th>
			<th>Compound Type</th>
	        <th>Week1 Day1</th>
            <th>Week2 Day2</th>
            <th>day3</th>

			
		</tr>
                                                               <?php
               $qry=mysqli_query($connection, "SELECT * FROM `compound_planning` LEFT JOIN `torder` ON torder.pid = compound_planning.pid") or die(mysqli_error());
while ($row = mysqli_fetch_assoc($qry)) {

  
   
            $date = $row['date'];
            $pid = $row['pid'];
            $Description = $row['Description'];
            $corder = $row['corder'];
    
    ?>
                    <tr>
  <td><?php echo $date;?></td>
  <td><?php echo $pid;?></td>
  <td><?php echo $Description;?></td>
  <td><?php echo $corder;?></td> 

  


    
                    </tr>
<?php }?>
                </table>
   </div>
        </div>
    </div>
</div>
</div>



<?php include './includes/Plugin.php'; ?>
<?php include './includes/admin_footer.php'; ?>
                                
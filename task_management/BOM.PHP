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
			<th>PID</th>
			<th>Description</th>
            <th>Tire Size</th>
            <th>Brand</th>
            <th>Colour</th>
            <th>Rim Width</th>
            <th>Compound Weight</th>
            <th>Total Weigth</th>
			<th>Finished tire weight</th>
            <th>Steel band type</th>
            <th>Steel band weight</th>
            <th>Bead type</th>
            <th>Noof Bead</th>
            <th>Profile Type</th>
            <th>Profile weight</th>
            <th>Base type</th>
            <th>Base weight</th>
            <th>Bonding Type</th>
            

		</tr>
                                                               <?php
               $qry=mysqli_query($connection, "SELECT * FROM bom");
while ($row = mysqli_fetch_assoc($qry)) {

  
   
            
            $pid = $row['pid'];
            $Description = $row['Description'];
        
    
    ?>
                    <tr>

  <td><?php echo $pid;?></td>
  <td><?php echo $Description;?></td>


  


    
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
                                
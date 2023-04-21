 <?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    $msg = $AppCodeObj->download("download");
}
if(isset($_GET['delete']))
{
    $id=$_GET['delete'];
    $query="delete from download where dID='$id'";
   $delete_record= mysqli_query($connection, $query);
}
?>
<!--------------------
START - Breadcrumbs
-------------------->
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><span>Document Upload</span></li>
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
                                    <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Document Upload</h5>                                   
                                </div>  
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Document Name</label>
                                        <input class="form-control" name="dname" placeholder="Download Name" type="text">
                                    </div> 
                                    <div class="form-group"><label for="">Upload</label>
                                        <input name="download_file" type="file">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                  <table class="dataTable table table-responsive">
                    <tr>
                        <th>S No.</th>
                        <th>Name</th>
                         <th>Document File</th>
                   
                          <th>Delete</th>
                    </tr>
                                                               <?php
                                                                $emp_id=  $_SESSION['user'];
                 $qry = mysqli_query($connection, "SELECT * FROM download where empID='$emp_id'") or die("select query fail" . mysqli_error());
$count = 0;
while ($row = mysqli_fetch_assoc($qry)) {
    $count = $count + 1;
    $dID = $row['dID'];
    $download_name = $row['download_name']; 
    $download_file = $row['download_file']; 

    ?>
                    <tr>
                        <td><?php echo $count;?></td>
                          <td><?php echo $download_name;?></td>
                          <td><a target="_blank" href="../download/<?php echo $download_file;?>">Download</a></td>
                              <!--<td><?php echo $created;?></td>--> 
                              <td><a href="download.php?delete=<?php echo $dID;?>">Delete</a></td>
                    </tr>
<?php }?>
                </table>
                                </div>
                        
                     
                           
                            <div class="form-buttons-w text-right">
                                <input class="btn btn-primary" type="submit" value="Submit Now" name="submit">
                            </div>
                        </div>
                </form>
                <div class="col-md-12">
          
                </div>
            </div>
        </div>
<?php include './includes/Plugin.php'; ?>
        <?php include './includes/admin_footer.php'; ?>
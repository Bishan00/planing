<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    $msg = $AppCodeObj->addstock("stock");
}


/*if(isset($_GET['delete']))
{
    $id=$_GET['delete'];
    $delete= mysqli_query($connection, "delete from news_and_update where news_id='$id'");
}
*/


?>
<!--------------------
START - Breadcrumbs
-------------------->
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><span>alert</span></li>
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
                <form action="#" method="post" enctype="multipart/form-data">

                    
                            <div class="row">
                                 <div class="col-md-12">
                                    <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Add Stock</h5>                                   
                             
                                
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Item Code</label>
                                        <input class="form-control" name="icode" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Tyre Size</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Brand</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Colour</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">FIT</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">RIM</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Construction</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Average Finish Tyre Weight - kgs</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Per Tyre Volume / cbm</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                    </div>
                                </div>
                               
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Total Volume - cbm</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Total Tonage - kgs</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Qty stock</label>
                                        <input class="form-control" name="cstock" placeholder="" type="varchar">
                                  
</div>
                            <div class=" text-right">
                                <input class="btn btn-primary" type="submit" value="Submit Now" name="submit">
</div>
            
                 
            
        
<?php include './includes/Plugin.php'; ?>
        <?php include './includes/admin_footer.php'; ?>

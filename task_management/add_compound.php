<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    $msg = $AppCodeObj->addcom("compound_planning");
}


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
                                    <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Add Compound plan</h5>                                   
                                </div>  
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Date</label>
                                        <input class="form-control" name="date" placeholder="" type="date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Compound Type</label>
                                        <input class="form-control" name="Ctype" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Plan Compound</label>
                                        <input class="form-control" name="plan" placeholder="" type="text">
                                    </div>
                                </div>
                           
                            <div class="form-buttons-w text-right">
                                <input class="btn btn-primary" type="submit" value="Submit Now" name="submit">
                            </div>
                        </div>
                </form>
                    </div>
                      <div class="col-md-6">
                          <br>
               
                                                               
                </table>
                      </div>
            </div>
        </div></div>
<?php include './includes/Plugin.php'; ?>
        <?php include './includes/admin_footer.php'; ?>
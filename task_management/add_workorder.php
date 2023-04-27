<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    $msg = $AppCodeObj->addwork("work_order");
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
                                    <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Add work order</h5>                                   
                                </div>  

                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Date</label>
                                        <input class="form-control" name="date" placeholder="" type="date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Ref.ERP CO.No</label>
                                        <input class="form-control" name="Rno" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Customer</label>
                                        <input class="form-control" name="Customer" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Order Ref</label>
                                        <input class="form-control" name="ref" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">W.O. NO</label>
                                        <input class="form-control" name="wono" placeholder="" type="varchar">
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

<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    $msg = $AppCodeObj->add_bom("bom");
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
                                    <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Add order</h5>                                   
                                </div>  
                             
                                
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">pid</label>
                                        <input class="form-control" name="pid" placeholder="" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Description</label>
                                        <input class="form-control" name="Description" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Tsize</label>
                                        <input class="form-control" name="Tsize" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">brand</label>
                                        <input class="form-control" name="brand" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">type</label>
                                        <input class="form-control" name="type" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">colour</label>
                                        <input class="form-control" name="colour" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Rim width</label>
                                        <input class="form-control" name="rwidth" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">comweight</label>
                                        <input class="form-control" name="comweight" placeholder="" type="varchar">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">tweight/label>
                                        <input class="form-control" name="tweight" placeholder="" type="varchar">
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">brand</label>
                                        <input class="form-control" name="withsteel" placeholder="" type="varchar">
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">withsteel</label>
                                        <input class="form-control" name="withsteel" placeholder="" type="varchar">
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">bead</label>
                                        <input class="form-control" name="bead" placeholder="" type="varchar">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">finishweight</label>
                                        <input class="form-control" name="finishweight" placeholder="" type="varchar">
                                    </div>
                                </div>
                           
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">sbtype</label>
                                        <input class="form-control" name="sbtype" placeholder="" type="varchar">
                                    </div>
                                </div>

                           
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">sbweight</label>
                                        <input class="form-control" name="sbweight" placeholder="" type="varchar">
                                    </div>
                                </div>
                           
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">beadtype</label>
                                        <input class="form-control" name="beadtype" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Nbead</label>
                                        <input class="form-control" name="Nbead" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">ptype</label>
                                        <input class="form-control" name="ptype" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">pweight</label>
                                        <input class="form-control" name="pweight" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">bontype</label>
                                        <input class="form-control" name="bontype" placeholder="" type="varchar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">bonweight</label>
                                        <input class="form-control" name="bonweight" placeholder="" type="varchar">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">ctype</label>
                                        <input class="form-control" name="ctype	" placeholder="" type="varchar">
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">cweight</label>
                                        <input class="form-control" name="cweight" placeholder="" type="varchar">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">threat</label>
                                        <input class="form-control" name="threat" placeholder="" type="varchar">
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

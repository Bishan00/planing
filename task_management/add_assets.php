<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    
    $device_file = $_FILES['device_file']['name'];
    $device_file_temp = $_FILES['device_file']['tmp_name'];
    move_uploaded_file($device_file_temp, "invoice_img/$device_file");

    $invoice_file = $_FILES['invoice_file']['name'];
    $invoice_file_temp = $_FILES['invoice_file']['tmp_name'];
    move_uploaded_file($device_file_temp, "invoice_img/$invoice_file");

     $asset_tp = $_POST['asset_tp'];
    $CP_nm = "PIIT";
    $asset_count = 1;
    $asset_tp_count = 1;
    
    $getID = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM asset_tb where delete_status='0' order by created desc"));
$asserID = $getID['assetID'];


if($asserID !='')
{
  $qry1 = mysqli_query($connection, "SELECT * FROM asset_tb where delete_status='0' order by created desc") or die("select query fail" . mysqli_error());
                        while ($row = mysqli_fetch_assoc($qry1)) {
                            $asset_count = $asset_count + 1;
                        }
}
 else {
    $asset_count=1;
}
            
  $get_at_ID = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM asset_tb where delete_status='0' and  asset_tp='$asset_tp' order by created desc"));
$asser_tp_ID = $get_at_ID['assetID'];    
//$asserID = $getID['assetID'];    
if($asser_tp_ID !='')
{
                         $qry2 = mysqli_query($connection, "SELECT * FROM asset_tb where asset_tp='$asset_tp' order by created desc") or die("select query fail" . mysqli_error());
                        while ($row = mysqli_fetch_assoc($qry2)) {
                            $asset_tp_count = $asset_tp_count + 1;
                        }
}
 else {
    $asset_tp_count=1;
}
     $asset_code = $CP_nm . "/" . $asset_count . "/" . $asset_tp . "/" . $asset_tp_count;
//    $csno = $_POST['csno'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $mac = $_POST['mac'];
    $sn = $_POST['sn'];
    $pro = $_POST['pro'];
    $ram = $_POST['ram'];
    $rom = $_POST['rom'];
    $hdd = $_POST['hdd'];
    $cdrom = $_POST['cdrom'];
    $os = $_POST['os'];
    $vendor = $_POST['vendor'];
    $invoice = $_POST['invoice'];
    $size = $_POST['size'];
    $invoice_date = $_POST['invoice_date'];
    $price = $_POST['price'];
    $guty_warty = $_POST['guty_warty'];
    $guty_warty_yr = $_POST['guty_warty_yr'];
    $ProDis = $_POST['ProDis'];
    $query = "INSERT INTO `asset_tb`(`csno`, `make`, `model`, `mac`, `sn`, `pro`, `ram`, `rom`, `hdd`, `cdrom`, `size`, `os`, `vendor`, `invoice`, `invoice_date`, `price`, `gur_warty`, `gur_warty_yr`, `pro_dis`, `device_img`, `invoice_img`, `status`, `delete_status`, `created`,asset_tp)";
    $query .= " VALUES ('$asset_code','$make','$model','$mac','$sn','$pro','$ram','$rom','$hdd','$cdrom','$size','$os','$vendor','$invoice','$invoice_date','$price','$guty_warty','$guty_warty_yr','$ProDis','$device_file','$invoice_file','1','0',now(),'$asset_tp')";
    $insert_data = mysqli_query($connection, $query);
    if (!$insert_data) {
        die('QUERY FAILD change pashword' . mysqli_error($connection));
    } else {
        $msg="Record Save Successfully. Company serial number is ".$asset_code;

        echo "<script>alert('".$msg."');</script>";
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
                                <select name="asset_tp" class="form-control">
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
                        <!--                        <div class="col-sm-3">
                                                    <div class="form-group"><label for="">CSNO</label>
                                                        <input class="form-control" name="csno" placeholder="CSNO" type="text">
                                                    </div>
                                                </div>-->
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">MAKE</label>
                                <input class="form-control" name="make" placeholder="Enter MAKE" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Model</label>
                                <input class="form-control" name="model" placeholder="Enter Model" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">MAC</label>
                                <input class="form-control" name="mac" placeholder="Enter MAC" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">S.N.</label>
                                <input class="form-control" name="sn" placeholder="Enter SN" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Processor</label>
                                <input class="form-control" name="pro" placeholder="Enter Processor" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">RAM</label>
                                <input class="form-control" name="ram" placeholder="Enter RAM" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">ROM</label>
                                <input class="form-control" name="rom" placeholder="Enter ROM" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">HDD</label>
                                <input class="form-control" name="hdd" placeholder="Enter HDD" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">CDROM</label>
                                <input class="form-control" name="cdrom" placeholder="Enter CDROM" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">SIZE</label>
                                <input class="form-control" name="size" placeholder="Enter SIZE" type="text">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group"><label for="">OS</label>
                                <input class="form-control" name="os" placeholder="Enter OS" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Vendor</label>
                                <input class="form-control" name="vendor" placeholder="Enter Vendor" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Invoice</label>
                                <input class="form-control" name="invoice" placeholder="Enter Invoice" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Invoice Date</label>
                                <input class="form-control" name="invoice_date" placeholder="Enter Task" type="date">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Price</label>
                                <input class="form-control" name="price" placeholder="Enter Price" type="number">
                            </div>
                        </div>  
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Guarantee/Warranty</label>
                                <input class="form-control" name="guty_warty" placeholder="Enter Task" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Guarantee/Warranty Year</label>
                                <input class="form-control" name="guty_warty_yr" placeholder="Enter Task" type="date">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Product Description</label>
                           <textarea class="form-control" name="ProDis"></textarea> <!--<input class="form-control" name="task" placeholder="Enter Task" type="date">-->
                            </div>
                        </div>
                        <!--                                      <div class="col-sm-3">
                                                            <div class="form-group"><label for="">Device Image</label>
                                                                <input class="form-control" name="task" placeholder="Enter Task" type="text">
                                                            </div>
                                                        </div>-->
                        <div class="col-sm-3">
                            <div class="form-group"><label for="">Device Image</label>
                                <input name="device_file" type="file">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"><label for=""> Invoice</label>
                                <input name="invoice_file" type="file">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <br>
                                <input class="btn btn-primary" type="submit" value="Add Assets" name="submit">
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
                                
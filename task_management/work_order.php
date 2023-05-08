
<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
$msg = '';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    $msg = $AppCodeObj->addw("worder");
}


?>
<!--------------------
START - Breadcrumbs
-------------------->
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><span>alert</span></li>
</ul>


<html lang="en">
<div class="content-panel-toggler"><i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span></div>
<div class="content-i">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box">
                <div class="row">
                    <div class="col-md-6">


                    <div class="row">
                                 <div class="col-md-12">
                                    <h5 style="color: blue;border-bottom: 1px solid blue;padding: 10px;">Add work order</h5>                                   
                                </div> 

                                
<body>
    <form method="post" action="import.php" enctype="multipart/form-data">
    <input type="file" name="excel_file" accept=".csv">
    <input type="submit" name="import" value="Import work order">
   
   
    </table>
    
</body>
</html>














<?php
include './includes/data_base_save_update.php';
$AppCodeObj = new databaseSave();
if (isset($_POST['submit'])) {
    // Retrieve form data
    $date = $_POST['date'];
    $erp = $_POST['erp'];

    // Perform data validation and sanitization

    // Save the data to the database
    $result = $AppCodeObj->addwork("work_order", $date, $erp);

    if ($result) {
        // Data saved successfully
        header('Location: work_order.php');
        exit();
    } else {
        // Handle the error
        $msg = "Error occurred while saving the data.";
    }
}
?>
<!-- Add the necessary HTML code for displaying the success message or error message -->

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
                                        <input class="form-control" name="date" placeholder="" type="date"><br>
                                    </div></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label for="">Ref.ERP CO.No</label>
                                        <input class="form-control" name="erp" placeholder="" type="varchar">
                                    </div>
                                </div>
                             
                            
                            <div class="form-buttons-w text-right">
                                <input class="btn btn-primary" type="submit" value="Submit Now" name="submit">
                                

      
    </form>
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

        

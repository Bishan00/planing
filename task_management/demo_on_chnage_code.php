<?php
include './includes/db.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['asset_tp']))
{
    $asset_count =0;
    $asset_tp=$_POST['asset_tp'];
                                  
                                    $qry1 = mysqli_query($connection, "SELECT * FROM asset_tb where delete_status='0' and status !='0' and asset_tp='$asset_tp'  order by created desc") or die("select query fail" . mysqli_error());
                        while ($row = mysqli_fetch_assoc($qry1)) {
                            $asset_count = $asset_count + 1;
                            $csno=$row['csno'];
                                $assetID=$row['assetID']; 
                            
                            ?>
                                    <option value="<?php echo $assetID;?>"><?php echo $csno;?></option> 
                                    <?php
                        }
}
                            
?>
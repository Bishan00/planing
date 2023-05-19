<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Funda Of Web IT</title>
</head>
<body>



    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Check work Order</h4>

                        <form action="comparee.php" method="POST">
    <button type="submit" name="compare">Comparee Data</button>
  </form>

</a>


              

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">

                               

                            </div>
                        </div>
                    </div>
                </div>
            </div>


                
                    <div class="card-body">
                        <table class="table table-bordered">
                        <tr class="header">
                        <th>Item code</th>
                        <th>Tire Size</th>
    <th>Brand</th>
    <th>Colour</th>
    <th>Fit</th>
    <th>Rim</th>

    <th>Construction</th>
    <th>Average Finish
    Tyre weight - kgs</th>
    <th>Per Voloume/cbm</th>
    <th>Qty New pcs</th>
    <th>Total Volume cbm</th>
    <th>Total Tones kgs</th>


                        

		</tr>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","","task_management");

                                 
                                    
                                       
                                    $query = "SELECT * FROM worder";
                                        $query_run = mysqli_query($con, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $items)
                                            {
                                                ?>
                                                <tr>
                                                <td><?= $items['icode']; ?></td>
                                                    <td><?= $items['t_size']; ?></td>
                                                    <td><?= $items['brand']; ?></td>
                                                    <td><?= $items['col']; ?></td>
                                                    <td><?= $items['fit']; ?></td>
                                                    <td><?= $items['rim']; ?></td>
                                                    <td><?= $items['cons']; ?></td>
                                                    <td><?= $items['fweight']; ?></td>
                                                    <td><?= $items['ptv']; ?></td>
                                                    <td><?= $items['new']; ?></td>
                                                    <td><?= $items['cbm']; ?></td>
                                                    <td><?= $items['kgs']; ?></td>
                                                  
                                                    

                                                <?php
                                            }
                                        }
                                        
                                    
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
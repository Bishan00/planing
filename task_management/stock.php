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
                        <h4>Stock</h4>

                        <a href="stocklist.PHP">
  <button>Search</button>
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
                        <th>item code</th>
			<th>Tyre name</th>
			<th>brand</th>
            <th>Colour</th>
			<th>FIT</th>
            <th>RIM</th>
			
			<th>Qty stock</th>


            
            

		</tr>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","","task_management");

                                 
                                    
                                       
                                        $query = "SELECT * FROM stock";
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
                                                   
                                                    <td><?= $items['cstock']; ?></td>

                                                    
                                                  
                                            
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
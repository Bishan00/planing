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
                        <h4>Press List</h4>

                        <a href="press_list_search.PHP">
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
                        <th>icode</th>
			<th>Tire Name</th>
			<th>brand</th>
            <th>col</th>
			<th>Curing Time</th>
            <th>Curing group</th>
			<th>Presses1</th>
            <th>Presses2</th>
            <th>Presses3</th>
            <th>Presses4</th>
            <th>Presses5</th>
            <th>Presses6</th>
            <th>Presses7</th>
            <th>Presses8</th>
            <th>Presses9</th>
            <th>Presses10</th>
            <th>Presses11</th>
            <th>Presses12</th>
            <th>Presses13</th>
            <th>mold</th>


            
            

		</tr>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","","task_management");

                                 
                                    
                                       
                                        $query = "SELECT * FROM selectpress";
                                        $query_run = mysqli_query($con, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $items)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?= $items['icode']; ?></td>
                                                    <td><?= $items['Tire Name']; ?></td>
        
                                                    <td><?= $items['brand']; ?></td>
                                                    <td><?= $items['col']; ?></td>
                                                    <td><?= $items['Curing Time']; ?></td>
                                                    <td><?= $items['Curing group']; ?></td>
                                                    <td><?= $items['Presses1']; ?></td>
                                                    <td><?= $items['Presses2']; ?></td>
                                                    <td><?= $items['Presses3']; ?></td>
                                                    <td><?= $items['Presses4']; ?></td>
                                                    <td><?= $items['Presses5']; ?></td>
                                                    <td><?= $items['Presses6']; ?></td>
                                                    <td><?= $items['Presses7']; ?></td>
                                                    <td><?= $items['Presses8']; ?></td>
                                                    <td><?= $items['Presses9']; ?></td>
                                                    <td><?= $items['Presses10']; ?></td>
                                                    <td><?= $items['Presses11']; ?></td>
                                                    <td><?= $items['Presses12']; ?></td>
                                                    <td><?= $items['Presses13']; ?></td>

                                                    <td><?= $items['mold']; ?></td>
                                                    
                                                  
                                            
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
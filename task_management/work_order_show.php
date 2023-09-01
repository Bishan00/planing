<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Funda Of Web IT</title>
</head><style>
    body {
        background-color: #f0f5fe;
        color: #333;
        font-family: Arial, sans-serif;
    }

    .card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #007bff;
        color: #ffffff;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .table th {
        background-color: #007bff;
        color: #ffffff;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-bordered thead th,
    .table-bordered thead td {
        border-bottom-width: 2px;
    }

    .table-bordered tbody + tbody {
        border-top: 2px solid #dee2e6;
    }

    .header th,
    .header td {
        font-weight: bold;
    }

    .header th {
        background-color: #0056b3;
        color: #ffffff;
    }
</style>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Work Order</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">

                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Enter pid">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mt-4">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr class="header">
                            <th>NO</th> <!-- Column number -->
                            <th>Item Code</th>
                            <th>Tire Size</th>
                            <th>Brand</th>
                            <th>Colour</th>
                            <th>FIT</th>
                            <th>Rim</th>
                            <th>Construction</th>
                            <th>Average Finish Tyre weight - kgs</th>
                            <th>Per Volume/cbm</th>
                            <th>Qty New pcs</th>
                            <th>Total Volume cbm</th>
                            <th>Total Tones kgs</th>
                        </tr>
                        <tbody>
                            <?php
                            $con = mysqli_connect("localhost","root","","task_management");

                            if(isset($_GET['search']) && !empty($_GET['search']))
                            {
                                $filtervalues = $_GET['search'];
                                $query = "SELECT * FROM worder WHERE CONCAT(erp) LIKE '%$filtervalues%' ";
                                $query_run = mysqli_query($con, $query);

                                if(mysqli_num_rows($query_run) > 0)
                                {
                                    $columnNumber = 1; // Variable to store the column number

                                    foreach($query_run as $items)
                                    {
                                        ?>
                                        <tr>
                                            <td><?= $columnNumber++; ?></td> <!-- Display column number -->
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
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <tr>
                                        <td colspan="4">No Record Found</td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                $query = "SELECT DISTINCT erp FROM worder";
                                $query_run = mysqli_query($con, $query);

                                if(mysqli_num_rows($query_run) > 0)
                                {
                                    while($erpRow = mysqli_fetch_assoc($query_run))
                                    {
                                        $erp = $erpRow['erp'];

                                        $subQuery = "SELECT * FROM worder WHERE erp = '$erp'";
                                        $subQuery_run = mysqli_query($con, $subQuery);

                                        if(mysqli_num_rows($subQuery_run) > 0)
                                        {
                                            $columnNumber = 1; // Variable to store the column number

                                            echo '<tr><td colspan="13">ERP: '.$erp.'</td></tr>';

                                            foreach($subQuery_run as $items)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?= $columnNumber++; ?></td> <!-- Display column number -->
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
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    ?>
                                    <tr>
                                        <td colspan="4">No Record Found</td>
                                    </tr>
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

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#showAllButton').click(function() {
                $('input[name="search"]').val('');
                $('form').submit();
            });
        });
    </script>
</body>
</html>

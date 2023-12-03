<!DOCTYPE html>
<html lang="en">
<head>
<style>       /* Your CSS styles */
        .container {
            margin: 0 auto;
            max-width: 1200px;
            padding: 20px;
            background-color: #f0f0f0;
            font-family: 'Cantarell', sans-serif; /* Use Cantarell as the default font */
        }

        .stock-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stock-table th,
        .stock-table td {
            border: 1px solid #000000;
            padding: 10px;
            text-align: left;
        }

        .stock-table th {
            background-color: #F28018;
            color: #000000;
            font-family: 'Cantarell', sans-serif;
            font-weight: bold;
        }

        .button-container {
            text-align: left;
            margin: 10px;
            border-radius: 4px;
        }

        .button-container button {
            background-color: #000000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 40px;
        }

        .search-form {
            text-align: center;
            margin: 10px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            width: 200px;
            border: 1px solid #CCCCCC;
            border-radius: 4px;
        }

        .search-form button {
            background-color: #000000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        body {
            background-color: #f0f0f0;
            font-family: 'Cantarell', sans-serif; /* Set the default font for the entire page */
            text-align: center;
        }

        h4 {
            color: #F28018;
            font-family: 'Cantarell', sans-serif; /* Apply the Cantarell font to the h4 element */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000000;
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #F28018;
            color: #000000;
            font-weight: bold;
        }
        .button-container button {
            background-color: #000000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            transition: background-color 0.3s; /* Add a smooth transition for the background color change */
        }

        .button-container button:hover {
            background-color: #333333; /* Change the background color on hover */
        }

    </style>
 
</head>

<body>

     <!-- Button container in the top-left corner -->
     <div class="button-container">
    <button>
        <a href="dashboard.php" style="text-decoration: none; color: #FFFFFF;">Click To dashboard</a>
    </button>
</div>

    <h4>Dispatch Work Order</h4>
    <form action="" method="GET" class="search-form">
        <input type="text" name="search" required value="<?php if (isset($_GET['search'])) {
            echo $_GET['search'];
        } ?>" class="form-control" placeholder="Enter ERP Number">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <table class="table">
        <thead>
            <tr class="header">
                <th>NO</th>
                <th>Item Code</th>
                <th>Tire Size</th>
                <th>Brand</th>
                <th>Colour</th>
                <th>FIT</th>
                <th>Rim</th>
                <th>Construction</th>
                <th>Avg Finish Tyre Weight (kgs)</th>
                <th>Per Volume (cbm)</th>
                <th>Qty New pcs</th>
                <th>Total Volume (cbm)</th>
                <th>Total Tones (kgs)</th>
                <th>Actual Pcs</th>
            </tr>
        </thead>
        <tbody>
            <?php
              
               $con = mysqli_connect("localhost", "planatir_task_management", "Bishan@1919", "planatir_task_management");

               if (isset($_GET['search']) && !empty($_GET['search'])) {
                   $filtervalues = $_GET['search'];
                   $query = "SELECT * FROM dwork2 WHERE CONCAT(erp) LIKE '%$filtervalues%' ";
                   $query_run = mysqli_query($con, $query);

                   if (mysqli_num_rows($query_run) > 0) {
                       $columnNumber = 1;

                       foreach ($query_run as $items) {
                           ?>
                           <tr>
                               <td><?= $columnNumber++; ?></td>
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
                               <td><?= $items['quantity']; ?></td>
                           </tr>
                           <?php
                       }
                   } else {
                       ?>
                       <tr>
                           <td colspan="13">No Record Found</td>
                       </tr>
                       <?php
                   }
               } else {
                   $query = "SELECT DISTINCT erp FROM dwork2";
                   $query_run = mysqli_query($con, $query);

                   if (mysqli_num_rows($query_run) > 0) {
                       while ($erpRow = mysqli_fetch_assoc($query_run)) {
                           $erp = $erpRow['erp'];

                           $subQuery = "SELECT * FROM dwork2 WHERE erp = '$erp'";
                           $subQuery_run = mysqli_query($con, $subQuery);

                           if (mysqli_num_rows($subQuery_run) > 0) {
                               $columnNumber = 1;

                               echo '<tr class="highlight"><td colspan="13" class="center-enlarge">ERP: ' . $erp . '</td></tr>';

                               foreach ($subQuery_run as $items) {
                                   ?>
                                   <tr>
                                       <td><?= $columnNumber++; ?></td>
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
                                       <td><?= $items['quantity']; ?></td>
                                   </tr>
                                   <?php
                               }
                           }
                       }
                   } else {
                       ?>
                       <tr>
                           <td colspan="13">No Record Found</td>
                       </tr>
                       <?php
                   }
               }
               ?>
           </tbody>
       </table>
   </div>
</body>
</html>
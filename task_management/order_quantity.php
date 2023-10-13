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
                        <h4>Order Quantity</h4>

                        <a href="order_quantity_search.php">
  <button>Search</button>
</a>
<?php
// Database connection details
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve work orders data and calculate total quantity
$sql = "SELECT icode, SUM(new) AS total_quantity, t_size FROM worder GROUP BY icode";
$result = $conn->query($sql);

// Check if any records were found
if ($result->num_rows > 0) {
    // Output table header

    echo "<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>";

    echo "<table>
            <tr>
                <th>Work Order</th>
                <th>t_size</th>
                <th>Total Quantity (pcs)</th>
            </tr>";

    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $icode = $row['icode'];
        $totalQuantity = $row['total_quantity'];
        $otherData = $row['t_size'];

        echo "<tr>
                <td>$icode</td>
                <td>$otherData</td>
                <td>$totalQuantity</td>
            </tr>";
    }

    // Close table
    echo "</table>";
} else {
    echo "No work orders found.";
}

// Close the connection
$conn->close();
?>

              

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">

                               

                            </div>
                        </div>
                    </div>
                </div>
            </div>


                
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



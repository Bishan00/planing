<!DOCTYPE html>
<html>
<head>


    <title>Work Order Management</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
        }

        h2 {
            background-color: #0074d9;
            color: white;
            padding: 15px;
            margin: 0;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
            background-color: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        input[type="datetime-local"], input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #0074d9;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 3px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>



    <h2>Work Order Management</h2>
    <?php
    $servername = "localhost";
    $username = "planatir_task_management";
    $password = "Bishan@1919";
    $dbname = "planatir_task_management";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $work_order_id = $_POST["work_order_id"];
        $new_date = $_POST["new_date"];
        $new_erp_value = $_POST["new_erp"];

        // Update data
        $sql = "UPDATE work_order SET datetime = '$new_date', erp = '$new_erp_value' WHERE id = $work_order_id";

        if ($conn->query($sql) === TRUE) {
            echo "Data updated successfully.";
        } else {
            echo "Error updating data: " . $conn->error;
        }
    }

     // Fetch data
     $sql = "SELECT * FROM work_order";
     $result = $conn->query($sql);
 
     if ($result->num_rows > 0) {
         echo "<table>
             <tr>
               
                 <th>Datetime</th>
                 <th>ERP</th>
                 <th>Action</th>
             </tr>";
 
         while ($row = $result->fetch_assoc()) {
             echo "<tr>
                
                 <td>
                     <input type='datetime-local' id='date_" . $row["id"] . "' value='" . date("Y-m-d\TH:i", strtotime($row["datetime"])) . "'>
                 </td>
                 <td>
                     <input type='text' id='erp_" . $row["id"] . "' value='" . $row["erp"] . "'>
                 </td>
                 <td>
                     <button onclick='updateData(" . $row["id"] . ")'>Save</button>
                 </td>
             </tr>";
         }
 
         echo "</table>";
     } else {
         echo "No results found.";
     }
 
     // Close connection
     $conn->close();
     ?>
 
     <script>
     function updateData(id) {
         var newDate = document.getElementById('date_' + id).value;
         var newERP = document.getElementById('erp_' + id).value;
 
         $.ajax({
             type: "POST",
             url: "updatedate.php",
             data: { work_order_id: id, new_date: newDate, new_erp: newERP },
             success: function() {
                 alert("Data updated successfully.");
             }
         });
     }

     function goToAnotherPage() {
        window.location.href = "import22.php"; // Replace with the actual PHP page URL
    }
     </script>

<button onclick="goToAnotherPage()">Re generate Plan</button>
 </body>
 </html>

 
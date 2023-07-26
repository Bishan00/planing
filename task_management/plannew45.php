<!DOCTYPE html>
<html>
<head>
    <title>Task Management Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        #searchForm {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #searchResult {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .custom-button {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        /* Add some hover effect */
        .custom-button:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>
    
<div id="searchForm">
    <form id="searchForm">
    <h4 style="background-color:powderblue;">Do You want to update plan please input icode and press search button.</h4>
        <label for="icode">Enter Icode:</label>
        <input type="text" id="icode" name="icode">
        <input type="submit" value="Search">
    </form>
    <h5 style="background-color: powderblue;">Please click the Generate Plan button</h5>
    <a href="plannew56.php">
        <button class="custom-button">Generate Plan</button>
    </a>
</div>
<div id="searchResult"></div>

    <script>
        
        function updateData(icode, moldName, press, cavity, checked) {
            // AJAX request to update data on the server
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4000 && xhr.status === 200) {
                    // Refresh the search results after successful update
                    document.getElementById("searchForm").submit();
                }
            };

            // Prepare the data to be sent to the server
            const data = new FormData();
            data.append("icode", icode);
            data.append("moldName", moldName);
            data.append("press", press);
            data.append("cavity", cavity);
            data.append("checked", checked);

            // Send the AJAX request
            xhr.open("POST", "update_data.php", true);
            xhr.send(data);
        }

        document.getElementById("searchForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const icodeInput = document.getElementById("icode").value;
            const searchResultDiv = document.getElementById("searchResult");
            searchResultDiv.innerHTML = `Searching for Icode: ${icodeInput} ...`;

            // AJAX request to fetch the search results
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    searchResultDiv.innerHTML = xhr.responseText;
                }
            };

            // Send the AJAX request
            xhr.open("GET", "fetch_data.php?icode=" + icodeInput, true);
            xhr.send();
        });
    </script>



<!DOCTYPE html>
<html>
<head>
    <title>Task Management - Process Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f9f9;
        }
    </style>
</head>
<body>

<h1>Task Management - Process Data</h1>

<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'task_management';

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

function displayProcessData($connection)
{
    $selectQuery = "SELECT * FROM `process`";
    $result = mysqli_query($connection, $selectQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>
                <tr>
                    <th>ICODE</th>
                    <th>Tires per Mold</th>
                    <th>Mold Name</th>
                    <th>Cavity Name</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['icode']}</td>
                    <td>{$row['tires_per_mold']}</td>
                    <td>{$row['mold_name']}</td>
                    <td>{$row['cavity_name']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No records found.";
    }

    mysqli_free_result($result);
}

displayProcessData($connection);

mysqli_close($connection);
?>

</body>
</html>

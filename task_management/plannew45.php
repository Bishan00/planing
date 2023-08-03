<!DOCTYPE html>
<html>


<head>
    <title>Task Management - Process Data</title>

    <style>

          /* Styles for the button */
          .custom-button {
            background-color: powderblue;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Hover effect */
        .custom-button:hover {
            background-color: skyblue;
        }

        /* Active (clicked) effect */
        .custom-button:active {
            background-color: deepskyblue;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Custom styled select box */
        .select-box {
            position: relative;
            display: inline-block;
            margin: 5px 0;
            width: 100%;
        }

        .select-box select {
            width: 100%;
            padding: 12px;
            border: 2px solid #3498db;
            border-radius: 5px;
            background-color: #fff;
            appearance: none; /* Remove default arrow for Chrome/Safari/Edge */
            -moz-appearance: none; /* Remove default arrow for Firefox */
            text-indent: 1px;
            text-overflow: '';
            font-size: 16px;
            font-weight: bold;
            color: #555;
            cursor: pointer;
        }

        .select-box select:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .select-box::after {
            content: '\25BC';
            font-size: 20px;
            color: #3498db;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
        }

        .select-box label {
            display: block;
            margin-top: 10px;
            color: #666;
        }

        .select-box label span {
            color: #ff0000;
        }

        /* Hover effect for options */
        .select-box select option:hover {
            background-color: #3498db;
            color: #fff;
        }

        /* Selected option style */
        .select-box select option[selected] {
            background-color: #3498db;
            color: #fff;
        }

        /* Disabled option style */
        .select-box select option[disabled] {
            color: #999;
        }

        /* Styling for the update button */
        .update-button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .update-button:hover {
            background-color: #2184c3;
        }

        /* Styling for the table and table rows */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Task Management - Process Data</h1>

    <a href="plannew56.php">
        <button class="custom-button">Generate Plan</button>
    </a>

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
    $selectQuery = "SELECT p.icode, p.tires_per_mold, p.mold_name, p.cavity_name, m.availability_date
                    FROM `process` p
                    LEFT JOIN `mold` m ON p.mold_name = m.mold_name";
    $result = mysqli_query($connection, $selectQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>
                <tr>
                    <th>ICODE</th>
                    <th>Tires per Mold</th>
                    <th>Mold Name</th>
                    <th>Mold Availability</th>
                    <th>Cavity Name</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['icode']}</td>
                    <td>{$row['tires_per_mold']}</td>
                    <td>{$row['mold_name']}</td>
                    <td>{$row['availability_date']}</td>"; // Display the mold availability date

            // Fetch the available cavity names and their availability_date
            $cavityNameQuery = "SELECT cavity_name, availability_date FROM cavity";
            $cavityNameResult = mysqli_query($connection, $cavityNameQuery);
            $cavities = array();
            while ($cavityNameRow = mysqli_fetch_assoc($cavityNameResult)) {
                $cavities[] = $cavityNameRow;
            }

            // Display select box for Cavity Name
            echo "<td class='select-box'>";
            echo "<select name='cavity_select[{$row['icode']}]' onchange='updateData(\"{$row['icode']}\", \"{$row['mold_name']}\", this.value, false)'>";
            echo "<option value=''>-- Select Cavity Name --</option>";

            foreach ($cavities as $cavity) {
                $selected = $cavity['cavity_name'] === $row['cavity_name'] ? 'selected' : '';
                echo "<option value='{$cavity['cavity_name']}' data-availability='{$cavity['availability_date']}' {$selected}>{$cavity['cavity_name']} (Availability: {$cavity['availability_date']})</option>";
            }

            echo "</select>";
            echo "</td>";

            echo "</tr>";
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

<script>
    function updateData(icode, moldName, cavity, isMold) {
        // AJAX request to update data on the server
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Refresh the page after successful update
                location.reload();
            }
        };

        // Prepare the data to be sent to the server
        const data = new FormData();
        data.append("icode", icode);
        data.append("moldName", moldName);
        data.append("cavity", cavity);
        data.append("isMold", isMold);

        // Send the AJAX request
        xhr.open("POST", "update_data.php", true);
        xhr.send(data);
    }
</script>

</body>
</html>
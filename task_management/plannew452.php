
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
                    <td>{$row['availability_date']}</td>";

            // Fetch the available cavities for the specific icode from the tire_cavity table
            $tireCavityQuery = "SELECT cavity_name, availability_date FROM cavity WHERE cavity_name IN (SELECT cavity_name FROM production_plan WHERE icode = '{$row['icode']}')";
            $tireCavityResult = mysqli_query($connection, $tireCavityQuery);
            $cavities = array();
            while ($tireCavityRow = mysqli_fetch_assoc($tireCavityResult)) {
                $cavities[] = $tireCavityRow;
            }

            // Display select box for Cavity Name
            echo "<td class='select-box'>";
            echo "<select name='cavity_select[{$row['icode']}]' onchange='updateData(\"{$row['icode']}\", \"{$row['mold_name']}\", this.value, false)'>";
            echo "<option value=''>-- Select Cavity Name --</option>";

            foreach ($cavities as $cavity) {
                $selected = $cavity['cavity_name'] === $row['cavity_name'] ? 'selected' : '';
                $cavityId = getCavityIdFromCavityName($connection, $cavity['cavity_name']);
                $highlightClass = isCavityIdInPlanNewTable($connection, $cavityId) ? 'highlight' : '';
                echo "<option value='{$cavity['cavity_name']}' {$selected} class='{$highlightClass}'>{$cavity['cavity_name']} (Availability Date: {$cavity['availability_date']})</option>";
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


  

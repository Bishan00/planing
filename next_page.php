<!DOCTYPE html>
<html>
<head>
    <title>Inventory Input Form</title>
    <style>
        /* Your CSS styles */

        .container {
            margin: 0 auto;
            max-width: 1200px;
            padding: 20px;
            background-color: #f0f0f0;
            font-family: 'Cantarell', sans-serif;
        }

        h1 {
            color: #F28018;
            font-family: 'Cantarell', sans-serif;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="date"],
        select {
            padding: 10px;
            width: 200px;
            border: 1px solid #CCCCCC;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000000;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #F28018;
            color: #000000;
            font-weight: bold;
        }

        .btn-container {
            margin-top: 20px;
            text-align: center;
        }

        input[type="button"],
        input[type="submit"] {
            background-color: #000000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="button"]:hover,
        input[type="submit"]:hover {
            background-color: #333333;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Enter More Daily Production</h1>
    <form id="data-form" action="adinsert2.php" method="post">
        <label for="inputDate">Date:</label>
        <input type="date" id="inputDate" name="inputDate" required>
        
        <label for="shift">Shift:</label>
        <select name="shift" id="shift">
        <option value="DAY A">DAY A</option>
            <option value="DAY B">DAY B</option>
            <option value="DAY C">DAY C</option>

            <option value="NIGHT A">NIGHT A</option>
            <option value="NIGHT B">NIGHT B</option>
            <option value="NIGHT C">NIGHT C</option>
        </select>

        <table id="data-table">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Number Of tire</th>
                    <th>Press Name</th> <!-- New column for Cavity Name -->
                   
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="icode[]" onchange="fetchDescription(this)">
                            <option value="">Select an Item Code</option>
                            <?php
                            // PHP code to fetch item codes from the 'tire' table
                            $hostname = 'localhost';
                            $username = 'planatir_task_management';
                            $password = 'Bishan@1919';
                            $database = 'planatir_task_management';
                            
                            $conn = new mysqli($hostname, $username, $password, $database);

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT icode FROM tire";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $itemCode = $row['icode'];
                                    echo "<option value='$itemCode'>$itemCode</option>";
                                }
                            }

                            $conn->close();
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="description[]" readonly></td>
                    <td><input type="text" name="cstock[]" required></td>
                    <td><input type="text" name="cavity_name[]"></td> <!-- New input field for Cavity Name -->
                    
               
            </td>


                </tr>
            </tbody>
        </table>
        <div class="btn-container">
            <input type="button" value="Add Row" onclick="addRow()">
            <input type="submit" value="Submit">
        </div>
    </form>

    <script>
        // Function to add a new row to the table
        // Function to add a new row to the table
function addRow() {
    const table = document.getElementById("data-table").getElementsByTagName('tbody')[0];
    const newRow = table.insertRow(table.rows.length);
    const cell1 = newRow.insertCell(0);
    const cell2 = newRow.insertCell(1);
    const cell3 = newRow.insertCell(2);
   
    const cell4 = newRow.insertCell(3); // New Cavity Name column cell

    const itemCodeSelect = document.createElement("select");
    itemCodeSelect.name = "icode[]";
    itemCodeSelect.onchange = function() {
        fetchDescription(itemCodeSelect);
    }

    // Clone the options from the existing item code select dropdown
    const existingSelect = document.querySelector("select[name='icode[]']");
    for (const option of existingSelect.options) {
        const clonedOption = option.cloneNode(true);
        itemCodeSelect.appendChild(clonedOption);
    }

    cell1.appendChild(itemCodeSelect);

    const descriptionInput = document.createElement("input");
    descriptionInput.type = "text";
    descriptionInput.name = "description[]";
    descriptionInput.readOnly = true;
    cell2.appendChild(descriptionInput);

    const tireInput = document.createElement("input");
    tireInput.type = "text";
    tireInput.name = "cstock[]";
    tireInput.required = true;
   
    cell3.appendChild(tireInput);

const cavityNameInput = document.createElement("input");
cavityNameInput.type = "text";
cavityNameInput.name = "cavity_name[]";
cell4.appendChild(cavityNameInput);

}


        // Function to fetch and update the description based on the selected item code
        function fetchDescription(itemCodeSelect) {
            const selectedOption = itemCodeSelect.options[itemCodeSelect.selectedIndex];
            const descriptionInput = itemCodeSelect.parentElement.parentElement.cells[1].getElementsByTagName('input')[0];
            const selectedItemCode = selectedOption.value;

            if (selectedItemCode === "") {
                descriptionInput.value = "";
            } else {
                // Make an AJAX request to fetch the description from your server
                // Replace 'fetch_description.php' with the actual endpoint
                fetch(`fetch_description.php?icode=${selectedItemCode}`)
                    .then(response => response.text())
                    .then(data => {
                        descriptionInput.value = data;
                    })
                    .catch(error => console.error("Error fetching description: " + error));
            }
        }
    </script>
</body>
</html>





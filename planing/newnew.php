<!DOCTYPE html>
<html>
<head>
    <title>Item Form</title>
</head>
<body>
    <h1>Item Form</h1>
    <form method="POST" action="">
        <label for="item_code">Item Code:</label>
        <input type="text" name="item_code" id="item_code" required>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $item_code = $_POST['item_code'];

        // Connect to MySQL database
        $conn = mysqli_connect("localhost", "root", "", "production");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch item details from the 'items' table
        $sql = "SELECT tire_size, brand, color, fit, rim FROM items WHERE item_code = '$item_code'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Display the fetched item details
            echo '<form method="POST" action="store_data.php">';
            echo '<label for="tire_size">Tire Size:</label>';
            echo '<input type="text" name="tire_size" id="tire_size" value="' . $row['tire_size'] . '" required><br>';
            echo '<label for="brand">Brand:</label>';
            echo '<input type="text" name="brand" id="brand" value="' . $row['brand'] . '" required><br>';
            echo '<label for="color">Color:</label>';
            echo '<input type="text" name="color" id="color" value="' . $row['color'] . '" required><br>';
            echo '<label for="fit">FIT:</label>';
            echo '<input type="text" name="fit" id="fit" value="' . $row['fit'] . '" required><br>';
            echo '<label for="rim">RIM:</label>';
            echo '<input type="text" name="rim" id="rim" value="' . $row['rim'] . '" required><br>';
            echo '<label for="qtystock">Quantity in Stock:</label>';
            echo '<input type="text" name="qtystock" id="qtystock" required><br>';
            echo '<input type="hidden" name="item_code" value="' . $item_code . '">';
            echo '<input type="submit" name="submit" value="Submit">';
            echo '</form>';
        } else {
            echo 'Item not found!';
        }

        mysqli_close($conn);
    }
    ?>
</body>
</html>

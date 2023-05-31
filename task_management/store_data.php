<?php
if (isset($_POST['submit'])) {
    $icode = $_POST['icode'];
    $t_size = $_POST['t_size'];
    $brand = $_POST['brand'];
    $col = $_POST['col'];
    $fit = $_POST['fit'];
    $rim = $_POST['rim'];
    $cstock = $_POST['cstock'];

    // Connect to MySQL database
    $conn = mysqli_connect("localhost", "root", "", "task_management");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Insert the form data into the 'stock' table
    $sql= "UPDATE stock
        SET t_size = '$t_size',
            brand = '$brand',
            col = '$col',
            fit = '$fit',
            rim = '$rim',
            cstock = '$cstock'
        WHERE icode = '$icode'";

    if (mysqli_query($conn, $sql)) {
        echo "Data stored successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
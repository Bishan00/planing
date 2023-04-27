<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="import.php" enctype="multipart/form-data">
    <input type="file" name="excel_file" accept=".csv">
    <input type="submit" name="import" value="Import">
    </form>
    <table border=1>
    <tr>
    <th>Item Code</th>
    <th>Tyre Size</th>
    <th>Brand</th>
    <th>Colour</th>
    <th>FIT</th>
    <th>RIM</th>
    <th>Construsction</th>
    <th>Average Finish<br>
               Tyre weight - kgs</th>
    <th>Per Voloume/cbm</th>
    <th>Qty New pcs</th>
    <th>Total Volume cbm</th>
    <th>Total Tones-<br> kgs</th>
    </tr>

    <?php
    $db = mysqli_connect('localhost','root','',' task_management');
    $query="SELECT * FROM ";
    $row = mysqli_query($db,$query);

    while($data = mysqli_fetch_array($row)){
        ?>
<tr>
<td><?=$data['roll_no']?></td>
<td><?=$data['name']?></td>
<td><?=$data['email']?></td>
<td><?=$data['mobile']?></td>

</tr>
        <?php
    }



    ?>
    </table>
</body>
</html>
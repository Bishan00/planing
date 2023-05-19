<?php require't4tutorials_database_connection.php'?>
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
		<h3>PLAN </h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<div class="col-md-6">
			
        </div>
                        </div>
                    </div>
                </div>
            </div>

		<div class="col-md-6">
			<br><form method="POST" action="">
			
			</form>
			<br />
			<?php include'merge_tables.php'?>
		</div>
	</div>
</body>	
</html>

<?php
	if(ISSET($_POST['submit'])){
?>
<table class="table table-bordered">
	<thead class="alert-info">
		<tr>
        <th>Item code</th>
                        <th>Tire Size</th>
    <th>Brand</th>
    <th>Colour</th>
    <th>Fit</th>
    <th>Rim</th>
    <th>Construction</th>
    <th>Average Finish
    Tyre weight - kgs</th>
    <th>Per Voloume/cbm</th>
    <th>Total Volume cbm</th>
    <th>Total Tones kgs</th>
    <th>Qty New pcs</th>
    <th>Order quentity</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$query=mysqli_query($conn, "SELECT * FROM `worder` LEFT JOIN `tobeplan` ON worder.icode = tobeplan.icode") or die(mysqli_error());
			while($fetch=mysqli_fetch_array($query)){
		?>
		<tr>
			<td><?php echo $fetch['icode']?></td>
			<td><?php echo $fetch['t_size']?></td>
			<td><?php echo $fetch['brand']?></td>
            <td><?php echo $fetch['col']?></td>
			<td><?php echo $fetch['fit']?></td>
			<td><?php echo $fetch['rim']?></td>
            <td><?php echo $fetch['cons']?></td>
			<td><?php echo $fetch['fweight']?></td>
			<td><?php echo $fetch['ptv']?></td>
			<td><?php echo $fetch['cbm']?></td>
			<td><?php echo $fetch['kgs']?></td>
            <td><?php echo $fetch['new']?></td>
            <td><?php echo $fetch['tobe']?></td>


		</tr>
		<?php
			}
		?>
	</tbody>
</table>
<?php
	}
?>
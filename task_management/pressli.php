<?php
	$conn=mysqli_connect("localhost", "planatir_task_management", "Bishan@1919", "planatir_task_management");
 
	if(!$conn){
		die(mysqli_error());
	}
?>

<table class="table table-bordered">
	<thead class="alert-info">
		<tr>
			<th>icode</th>
			<th>Tire Name</th>
			<th>brand</th>
            <th>col</th>
			<th>Curing Time</th>
            <th>Curing group</th>
			<th>Press</th>
            <th>mold</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$query=mysqli_query($conn, "SELECT * FROM `selectpress`");
			while($fetch=mysqli_fetch_array($query)){
		?>
		<tr>
			<td><?php echo $fetch['icode']?></td>
			<td><?php echo $fetch['Tire Name']?></td>
			<td><?php echo $fetch['brand']?></td>
            <td><?php echo $fetch['col']?></td>
            <td><?php echo $fetch['Curing Time']?></td>
			<td><?php echo $fetch['Curing group']?></td>
            <td><?php echo $fetch['Press']?></td>
            <td><?php echo $fetch['mold']?></td>
            

		</tr>
		<?php
			}
		?>
	</tbody>
</table>


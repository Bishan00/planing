<?php
	$conn=mysqli_connect("localhost", "root", "", "task_management");

	if(!$conn){
		die(mysqli_error());
	}
?>
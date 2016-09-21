<?php
	include("connect.php");   	
	$link=Connection();
	$name=$_POST['name'];
	$surname=$_POST['surname'];
	$sid=$_POST['SID'];
	$date=date("Y-m-d");
	$uid=$_POST['UID'];
	$class=$_POST['class'];
	$query = "INSERT INTO `Persons`(`name`, `surname`, `SID`, `reg_date`, `uid`, `class`) VALUES ('$name','	$surname','$sid','$date','$uid','$class')";
	mysqli_query($link,$query);
	mysqli_close($link);
	header("Location: testform.html");
?>
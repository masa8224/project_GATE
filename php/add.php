<?php
   	include("connect.php");   	
   	$link=Connection();
	$date=$_POST['date'];
	$time=$_POST['time'];
	$uid1=$_POST['uid'];
	$query = "INSERT INTO RFID (date,time,UID) VALUES ('$date','$time','$uid1')";    	
   	mysqli_query($link,$query);
	mysqli_close($link);
   	header("Location: index.php");
?>
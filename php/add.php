<?php
   	include("connect.php");   	
   	$link=Connection();
	$date=$_GET['date'];
	$time=$_GET['time'];
	$uid1=$_GET['uid'];
	$queryCheck = "SELECT * FROM Persons WHERE uid='".$uid1."'";
	$res = mysqli_query($link,$queryCheck);
	if (mysqli_num_rows($res)){
		echo "AGFQR";
		$query = "INSERT INTO RFID (date,time,UID) VALUES ('$date','$time','$uid1')";
		mysqli_query($link,$query);		
	}else{
		echo "ADCBN";
	}	   	
   		
	mysqli_close($link);	
	
?>
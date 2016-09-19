<?php
   	include("connect.php");   	
   	$link=Connection();
	$uid1=$POST_["uid"];
	$query = "INSERT INTO RFID (UID) VALUES ("$uid1")";    	
   	mysql_query($query,$link);
	mysql_close($link);
   	header("Location: index.php");
?>

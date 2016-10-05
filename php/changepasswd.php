<?php
	if(!$_COOKIE["user"]){
		header("Location: login.php;");
	}
	include("connect.php");
	$passwd=$_POST("passwd");
	$con=Connection();
	$query="SELECT * FROM User
			WHERE passwd=$passwd"
	$result = mysqli_query($con,$query);
	
?>
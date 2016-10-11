<?php
	if(!$_COOKIE["user"]){
		header("Location: login.php;");
	}
	include("connect.php");
	$passwd=$_REQUEST("passwd");
	$con=Connection();
	$query="SELECT * FROM User
			WHERE passwd=$passwd"
	$result = mysqli_query($con,$query);
	if (mysqli_num_rows($result)){
		$gr = true;
	}else{
		$gr = false;
	}	
?>
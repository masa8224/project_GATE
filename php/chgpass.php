<?php	
	include("connect.php"); 
	$con=Connection();	
	$usr = 	$_POST['usr'];
	$pawd = $_POST['pass'];	
	$npass = $_POST['npas'];
	$query="SELECT * FROM Users WHERE username='".$usr."' and passwd='".$pawd."'";
	$result = mysqli_query($con,$query);
	if (mysqli_num_rows($result)){
		echo "1";
		$chquery = "UPDATE `Users` SET `passwd`=\"".$npass."\" WHERE username='".$usr."'";
		mysqli_query($con,$chquery);
	}else{
		echo "0";
	}
	mysqli_close($con);	
?>
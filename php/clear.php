<?php
	$randomString = '';
	include("connect.php");
	$link = Connection();
	$acode = $_POST['acode'];
	$usr = $_POST['usr'];
	$pawd = $_POST['passwd'];	
	$query = "SELECT * FROM Users WHERE username='".$usr."' and passwd='".$pawd."'";
	$result = mysqli_query($link,$query);
	if (mysqli_num_rows($result)){
		$query2 = "SELECT * FROM ACODE WHERE acode = '".$acode."'";
		$veri = mysqli_query($link,$query2);
		if (mysqli_num_rows($veri)){
			$Delquery = "DELETE FROM `RFID` WHERE 1";
			mysqli_query($link,$Delquery);			
			echo "Your new Administrative Passcode is ";
			$length = 30;
			$randomString = '';
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);		
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			echo $randomString;
			$delacode = "DELETE FROM ACODE WHERE 1";
			mysqli_query($link,$delacode);
			$addacode = "INSERT INTO `ACODE`(`acode`) VALUES ('".$randomString."')";
			mysqli_query($link,$addacode);
		}else{
			echo "Wrong Administrative Passcode";
		}
	}else{
		echo "Wrong Password";
	}
	
?>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
	<div class="login">
			<div class="header">
			<img src="nts-logo.png" class="logo">
			<font>Narathiwat School RFID System</font>
			</div>
			<br><br><br>		
			<div style="display: block;text-align: left;">			
			<form method="post">				
				<br>
				<input name="usr" type="text" placeholder="Username" required autofocus>				
				<br>
				<input name="passwd" type="password" placeholder="Password" required>
				<br>				
				<input type="submit" value="Login" style="width: 100%;margin:5px 0px 5px 0px;">
			</form>
			</div>
			<div class="loginend">
				<span style="font-family:OpenSans;float: right;">Forgot your password? Please contact Administrator.</span>
			</div>
	</div>
	
<?php 
	$cookie_name = "user";
	if (isset($_COOKIE[$cookie_name])){
		header("Location: index.php");
	}
	if ($_POST["usr"]){
		include ("connect.php");
		$con = Connection();
		$user = $_POST["usr"];
		$pass = $_POST["passwd"];
		$query = "SELECT * 
		FROM Users
		WHERE `username` = '$user'
		AND `passwd` = '$pass'";
		$result= mysqli_query($con,$query);
		if (mysqli_num_rows($result)){
			setcookie($cookie_name,$user,time()+10800);
			header("Location: index.php");
		}else{
			echo "user not found";
		}
	}
?>
<body>
<html>
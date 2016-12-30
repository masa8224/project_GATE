<?php
	session_start();
?>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style>
		.loginend a{
			text-decoration: none;
			border: 2px solid lightcoral;
			padding: 10px;
			border-radius: 3px;
			background: lightcoral;
			color: black;
		}
	</style>
</head>
	<div class="login" style="width: 650px;">
			<div class="header">
			<img src="nts-logo.png" class="logo">
			<font>Narathiwat School RFID System</font>
			</div>
			<br><br><br>
			<div class="loginend" style="display:none;" id="failed">
				<span style="font-family:OpenSans;">Your username or password does not match our record</span>
			</div>
			<div style="display: block;text-align: left;">			
			<form method="post">				
				<br>
				<input name="usr" type="text" id="slot1" placeholder="Username" autocomplete="off" required autofocus>				
				<br>
				<input name="passwd" type="password" placeholder="Password" required>
				<br>				
				<input type="submit" value="Login" style="width: 100%;margin:5px 0px 5px 0px;">
			</form>
			</div>
			<div class="loginend" style="font-family: OpenSans;padding-left: 5px;">
				<span style="float: right;padding-rigth: 5px;">Forgot your password? Please contact Administrator. &nbsp;</span>
				<span style="float: left;"><a href="guest.php">Guest Mode</a></spam>
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
			setcookie($cookie_name,$user,time()+1800);			
			$_SESSION['Auser'] = $user;
            $_SESSION['start'] = time();             
            $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);	
			header("Location: index.php");
		}else{
			echo "<script>";
			echo "document.getElementByID('slot1').style.border='2px solid red';";
			echo "</script>";
			exit(0);
		}
	}
?>
<body>
<html>

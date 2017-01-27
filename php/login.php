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
		.header{
			margin-bottom: 1em;
			background-color: yellow;
			border: none;
		}
		.error{
			display:none;
			text-align:center;
			border: 2px solid red;
			background-color: lightcoral;
			font-family:OpenSans;
			margin-top: 1em;
			padding: 6px;
		}
	</style>
	
</head>
	<div class="login" style="width: 650px;">
			<div class="header">
			<img src="nts-logo.png" class="logo">
			<font>Narathiwat School RFID System</font>
			</div>					
			<div style="display: block;text-align: left;">			
			<form method="post">
				<div class="error" id="failed">
					<font>Your username or password does not match our record<font>
				</div>	
				<div class="error" id="expire">
					<font>Your session has been expired<font>
				</div>	
				<?php
					$q = $_GET['q'];
					switch($q){
						case 1:
							echo "<script>document.getElementById('failed').style.display = 'block';</script>";
							break;
						case 2:
							echo "<script>document.getElementById('expire').style.display = 'block';</script>";
					}
				?>				
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
			header("Location: login.php?q=1");
			exit(0);
		}
	}
?>
<body>
<html>

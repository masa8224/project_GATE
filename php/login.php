<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
	<table class="login">
		<tr>
			<th>
			<div class="header">
			<img src="nts-logo.png" class="logo">
			<font>NTS Parking lot RFID System</font>
			</div>
			<br><br><br><br><br><br><br>
			<div style="display: block;text-align: left;">
			<form method="post">				
				<br>
				<input name="usr" type="text" placeholder="Username" required autofocus>				
				<br>
				<input name="passwd" type="password" placeholder="Password" required>
				<br>
				<input type="submit" value="Login">
			</form>
			</div>
			</th>
		</tr>
	</table>
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
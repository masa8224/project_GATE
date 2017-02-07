<?php 
	session_start();
	
	$cookie_name = "user";
	
	if (isset($_COOKIE[$cookie_name])){
		header("Location: index.php");
	}
	if ($_POST["usr"]){
		//echo "login";
		include ("db.php");
		$con = Connection();
		$user = $_POST["usr"];
		$pass = $_POST["passwd"];
		$query = "SELECT * FROM Users WHERE `username` = '$user' AND `passwd` = '$pass'";
		$result= mysqli_query($con,$query);
		if (mysqli_num_rows($result)){
			setcookie($cookie_name,$user,time()+1800);			
			$_SESSION['Auser'] = $user;
            $_SESSION['start'] = time();             
            $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
			
			header("Location: index.php");
		}else{
			header("Location: index.php?q=1");
			exit(0);
		}
	}
?>
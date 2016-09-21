<?php
	function Connection(){
		$server="localhost";
		$user="root";
		$pass="00125410";
		$db="arduino";	   	
		$connection = mysqli_connect($server, $user, $pass, $db);
		if (!$connection) {
	    	die('MySQL ERROR: ' . mysqli_error());
		}		
		return $connection;
	}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>RFID REGISTRATION</title>
</head>
<h1>RFID REGISTRATION FROM</h1>
<hr>
<form method="get" action="<?php getsql() ?>">
    <p>Name</p>
    <input type="text" name="getsql()">
    <p>Surname</p>
    <input type="text" name="surname">
    <p>SID</p>
    <input type="number" name="SID">
	<p>UID</p>
    <input type="number" name="UID">
	<p>class</p>
    <select name="class">
		<option value="master">MASTER</option>
		<option value="normal">NORMAL</option>
	</select>
    <br>    
    <input type="submit">
</form>
<?php	
	include("connect.php");   	
	$link=Connection();	
	$name=$_GET['name'];
	$surname=$_GET['surname'];
	$sid=$_GET['SID'];
	$date=date("Y-m-d");
	$uid=$_GET['UID'];
	$class=$_GET['class'];
	function getsql(){	
	if($name and $surname and $sid){			
		$query = "INSERT INTO `Persons`(`name`, `surname`, `SID`, `reg_date`, `uid`, `class`) VALUES ('$name','$surname','$sid','$date','$uid','$class')";
		mysqli_query($link,$query);
	}else{		
	}
	mysqli_close($link);
	}
?>
<body>
</html>
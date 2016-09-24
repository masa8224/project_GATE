<?php
	if (!isset($_COOKIE[user])){
		header("Location: login.php;");
	}
?>
<html>
<head>
	<title>Setting</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<ul>
	<li class="name">NTS RFID System</li> 	
	<li class="dropdown">
    <a href="#" class="dropbtn">MAIN</a>
    <div class="dropdown-content">
      <a href="index.php">LOG</a>
      <a href="stu.php">Student Database</a>
      <a href="reg.php">RFID Registration</a>      
    </div>
<li><a>></a></li>
  </li>
	<li><a>SETTING</a></li>   
	<div style="float: right;">
	<li class="logout"><a onclick="logout()" href="login.php">logout</a></li>
	<li><a>Login as <?php echo $_COOKIE[user];?></a></li>  
	</div>
</ul>
<div class="content">
</div>
<body>
</html>


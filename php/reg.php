<?php 
	if (!isset($_COOKIE[user])){
		header("Location: login.php");
	}	
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>RFID REGISTRATION</title>
</head>
<ul>
	<li class="name">NTS RFID System</li> 	
	<li class="dropdown">
    <a href="#" class="dropbtn">MAIN</a>
    <div class="dropdown-content">
	  <a href="index.php">LOG</a>
      <a href="stu.php">Student Database</a>      
	  <a href="setting.php">Setting</a>
    </div>
  </li>
	<li><a>></a></li>
	<li><a>RFID REGISTRATION FORM</a></li>   
	<div style="float: right;">
	<li class="logout"><a href="logout.php">logout</a></li>
	<li><a>Login as <?php echo $_COOKIE[user];?></a></li>  
	</div>
</ul>

<div class="conreg">
<form action="post.php" method="post">
    <p>Name</p>
    <input type="text" name="name" required autofocus>
    <p>Surname</p>
    <input type="text" name="surname" required>
    <p>SID</p>
    <input type="number" name="SID" required>
	<p>UID</p>
    <input type="number" name="UID" required>
	<p>class</p>
    <select name="class">
		<option value="master">MASTER</option>
		<option value="normal">NORMAL</option>
	</select>
    <br>    
    <input type="submit">
</form>
</script>
<body>
</html>

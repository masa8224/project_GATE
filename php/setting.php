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
	<li class="logout"><a href="logout.php">logout</a></li>
	<li><a>Login as <?php echo $_COOKIE[user];?></a></li>  
	</div>
</ul>
<div class="content">
	<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Change Password</button>
	<div id="id01" class="modal" style="widht:30%;">
  <div class="modal-content animate" >
  <h1>Change Password</h1>
  <form action="changepasswd.php" method="post">
    <br>				
	<input name="passwd" type="password" placeholder="old password" required>
	<input name="newpasswd" type="password" placeholder="new password" required>
	<input name="repasswd" type="password" placeholder="retype new password" required>
	<br>
	<input type="submit" value="Change Password">    
	<span><button onclick="document.getElementById('id01').style.display='none'" style="float:right;">Cancle</button></span>
  </form>  	
  </div>
</div>
</div>
<body>
</html>


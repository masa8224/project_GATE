<?php
	if (!isset($_COOKIE[user])){
		header("Location: login.php;");
	}
	echo "<script>document.getElementById(\"pass\").style.border=\"2px solid #ccc\";</script>";
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
  <form method="post">
    <br>				
	<input id="pass" name="passwd" type="password" placeholder="old password" required>
	<input name="newpasswd" type="password" placeholder="new password" required>
	<input name="repasswd" type="password" placeholder="retype new password" required>
	<br>
	<!--><input type="submit" value="Change Password"><-->    
	<span><button onclick="check(document.getElementById('id01').value);">Check</button></span>
	<span><button onclick="document.getElementById('id01').style.display='none'" style="float:right;">Cancle</button></span>
  </form>  	
  </div>
</div>
</div>
<?php
	if($_POST["passwd"]){
	include("connect.php");
	$passwd = $_POST["passwd"];
	$con = Connection();
	$query="SELECT * FROM Users
			WHERE passwd= '$passwd'";
	$result = mysqli_query($con,$query);
	if(mysqli_num_rows($result)){
		
	}else{
		echo "<script>document.getElementById(\"pass\").style.border=\"2px solid red\";</script>";
	}
	}
?>
<body>
<script>
	function check(){
		var xhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("pass").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "changepasswd.php?passwd=" + str, true);
        xmlhttp.send();
	}
	}
</script>
</html>


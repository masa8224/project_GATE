<?php
	session_start();
	if (!isset($_SESSION['Auser'])) {
        header("Location: login.php");
    }
    else {
        $now = time(); 
        if ($now > $_SESSION['expire']) {
            header("Location: login.php");
        }
	}
	
?>
<html>
<head>
	<title>Setting</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
	function check(){
		var xhr = new XMLHttpRequest();
		var str = document.getElementById('slot1').value;
		var slot2 = document.getElementById('slot2').value;
		var slot3 = document.getElementById('slot3').value;
		var user = <?php echo "\""; echo $_COOKIE[user]; echo "\"";?>;		
		if (slot2==slot3){
		xhr.open('POST', 'chgpass.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function () {
			var res = this.responseText;					
			if (res=="0"){
					document.getElementById('slot1').style.border = "2px solid red";
					alert("Incorrect old password!");
			}
			if (res=="1"){
					alert("Password Change!");					
			}				
		};
		var sendstr = 'usr='+user+'&pass='+str+'&npas='+slot2;				
		xhr.send(sendstr);		
	}else{
		alert("new password does not match each other");
	}
	}
	function closeModal(id){
		document.getElementById(id).style.display='none';
		if (id=='id01'){
		if (!document.getElementById('slot1').value==""){
		document.getElementById('slot1').value	= "";	
		document.getElementById('slot2').value	= "";	
		document.getElementById('slot3').value	= "";	
		document.getElementById('slot1').style.border = "2px solid #ccc";
		}
		}
		if (id=='id02'){
			document.getElementById('admin').value	= "";	
			document.getElementById('pass').value	= "";
			document.getElementById('acode').innerHTML = "";
		}
	}
	function clearlog(){
		document.getElementById('cl').disabled = true;
		document.getElementById('clo').disabled = true;
		var xhr2 = new XMLHttpRequest();
		var acode = document.getElementById('admin').value;
		var passwd = document.getElementById('pass').value;
		var user = <?php echo "\""; echo $_COOKIE[user]; echo "\"";?>;	
		xhr2.open('POST', 'clear.php', true);
		xhr2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr2.onload = function(){
			var res = this.responseText;
			document.getElementById('acode').innerHTML = res;
			document.getElementById('admin').value = "";	
			document.getElementById('pass').value	= "";	
			document.getElementById('cl').disabled = false;
			document.getElementById('clo').disabled = false;			
		}
		var sendstr2 = 'acode='+acode+'&usr='+user+'&passwd='+passwd;		
		xhr2.send(sendstr2);
	}
	
</script>
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
<div class="content" style="font-family: OpenSans;padding-top: 50px;">
	<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Change Password</button>
	<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Clear Log History</button>
	
	<div id="id02" class="modal" style="widht:30%;">
	<div class="modal-content animate" >
	<h1>Clear Log History</h1>
	<p>Are you sure about clearing parking lot usage history?</p>
	<p>If you are sure about your action. Type Administrative Passcode and click "Clear History".</p>
	<h4 id="acode"></h4>
	<form>
		<input id="admin" type="text" style="width: 100%; padding-left: 0.5em;" autocomplete="off" placeholder="Administrative Passcode" required>					
		<input id="pass" type="password" placeholder="Password" required>		
	</form>
		<span><button id="cl" onclick="clearlog();">Clear History!</button></span>
		<span><button id="clo" onclick="closeModal('id02');" style="float:right;">Cancle</button></span>
	</div>
	</div>
	
	<div id="id01" class="modal" style="widht:30%;">
  <div class="modal-content animate" >
  <h1>Change Password of <?php echo $_COOKIE[user];?></h1>
  
  <form method="post">
    <br>				
	<input id="slot1" name="passwd" type="password" placeholder="old password" required>
	<input id="slot2" name="newpasswd" type="password" placeholder="new password" required>
	<input id="slot3" name="repasswd" type="password" placeholder="retype new password" required>
	<br>
  </form>  	
  <span><button onclick="check(document.getElementById('id01').value);">Change Password!</button></span>
	<span><button onclick="closeModal('id01');" style="float:right;">Cancle</button></span>
  </div>
</div>
</div>

</body>

</html>


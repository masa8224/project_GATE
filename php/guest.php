<html>
<head>
	<title>RFID LOG</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="script.js"></script>
	
</head>
<body>
<ul>	
	<li class="name">NTS RFID System</li> 	
	<li class="dropdown">    
	<li><a>GUEST MODE</a></li>	
    <div style="float: right;">
	<li class="logout"><a href="login.php">login</a></li>	  
	</div>	
	
</ul>
<div class="container" style="font-family: OpenSans;margin-top:25px;padding-top: 50px;">
<div>
<div class="card" >
<table style="width:100%;margin:0 auto 0 auto;border:none;">
<form method="get">  
    <tr>
      <th class="nobd">FILTER > NAME:
      <input class="search" name="filter" type="text" id="filter" value="<?php echo $_GET["filter"];?>">
      <input type="submit" value="Search">	  	  
	  </th>
	  <th class="nobd" style="line-height: 6px;">
		<?php echo date("d F Y");?><br>
		<p id="time"></p>
	  </th>
    </tr>  
</form>
<tr>
<th>
<font id="count" style="font-size: 50px;"></font>
	<span style="margin: 1em;">Students was enter today.</span>
</th>
</tr>
</table>
</div>

<div id="Log"class="card cardtable" style="display: block;" >
<?php
include("connect.php");   	
$con=Connection();
if($_GET["filter"] or $_GET["date"]){
	$filter=$_GET["filter"];	
	$query="SELECT RFID.UID,RFID.date,RFID.time,Persons.name,Persons.surname,Persons.reg_date,Persons.SID
	FROM RFID 
	INNER JOIN Persons
	WHERE Persons.name LIKE '%".$filter."%'
	AND Persons.uid=RFID.UID
	ORDER BY date DESC, time DESC;";
	$result = mysqli_query($con,$query);
	if (mysqli_num_rows($result)) {
		$rowcount=mysqli_num_rows($result);		
		echo "<table>
		<tr><td class=\"re\" colspan=\"7\">Found ".$rowcount." result</td></tr>
		<tr>
		<th>Login DATE</th>
		<th>Login TIME</th>
		<th>Login UID</th>
		<th>NAME</th>
		<th>SURNAME</th>
		<th>Student ID</th>
		<th>REGISTRATION DATE</th>
		</tr>";
		while($row = mysqli_fetch_array($result)){
			echo "<tr>";			
			echo "<td class=\"center\">" . $row['date'] . "</td>";
			echo "<td class=\"center\">" . $row['time'] . "</td>";
			echo "<td class=\"center\">" . $row['UID'] . "</td>";			
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['surname'] . "</td>";
			echo "<td class=\"center\">" . $row['SID'] . "</td>";
			echo "<td class=\"center\">" . $row['reg_date'] . "</td>";
			echo "</tr>";
		}		
		echo "</table>";
	}else{
		echo "<h1 class=\"center\">No result</h1>";				
	}	
	mysqli_close($con);
}
?>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function SQLTable(){
		var xhr = new XMLHttpRequest();	
		console.log("Hello");
		xhr.open('GET', 'table.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function () {
			var res = this.responseText;
			var entries = res.slice(8,12);
			str = entries.replace(/\s/g, '');
			document.getElementById('count').innerHTML= str;
			var ta = res.slice(14);	
			document.getElementById('Log').innerHTML = ta;				
		};	
		
		xhr.send("a");	
	}
setInterval(Timer(),500);	
setInterval(SQLTable,1000);	
</script>
</body>
</html>

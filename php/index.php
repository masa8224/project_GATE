<?php 
	if (!isset($_COOKIE[user])){
		header("Location: login.php");
	}	
?>
<html>
<head>
	<title>RFID LOG</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<ul>
  <li class="name">NTS RFID System</li>  
  <div style="float: right;">
  <li class="logout"><a onclick="logout()" href="login.php">logout</a></li>
  <li><a>Login as <?php echo $_COOKIE[user];?></a></li>  
  </div>
</ul>

<div class="content">
<br>
<form method="get">
  <table style="width:40%;">
    <tr>
      <th>FILTER > NAME:
      <input class="search" name="filter" type="text" id="filter" value="<?php echo $_GET["filter"];?>">
      <input type="submit" value="Search">	  
	  <label class="advance" for="_1">Advance Filter</label>
	  <input id="_1" type="checkbox"> 
	  <div class="normal">
			<input type="date" name="date" value="<?php echo $_GET["date"];?>">
      </div>
	  </th>
    </tr>
  </table>
</form>
<hr style="height: 4px;">
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
}else{
	$query="SELECT RFID.UID,RFID.date,RFID.time,Persons.name,Persons.surname,Persons.reg_date,Persons.SID
	FROM RFID 
	LEFT JOIN Persons
	ON RFID.UID=Persons.uid
	ORDER BY date DESC, time DESC;";
	$result = mysqli_query($con,$query);
	if (mysqli_num_rows($result)) {		
		echo "<table>
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
			if($row['name'] !== null){
				echo "<td>" . $row['name'] . "</td>";
				echo "<td>" . $row['surname'] . "</td>";
				echo "<td class=\"center\">" . $row['SID'] . "</td>";
				echo "<td class=\"center\">" . $row['reg_date'] . "</td>";
			}else{
				echo "<td class=\"unkn\" colspan=\"4\">Unknown</td>";
			}			
			echo "</tr>";
		}
		echo "</table>";
	}else{
		echo "<h1 class=\"center\">No result</h1>";		
	}	
	mysqli_close($con);
}
?>
<script type="text/javascript">
function logout(){
	document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
}
</script>
</body>
</html>

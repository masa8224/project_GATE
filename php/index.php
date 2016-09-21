<html>
<head>
	<title>RFID LOG</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<h1>Parking lot RFID Identification</h1>
<hr>
<form method="get">
  <table style="width:40%;">
    <tr>
      <th>FILTER > NAME:
      <input class="search" name="filter" type="text" id="filter" value="<?php echo $_GET["filter"];?>">
      <input type="submit" value="Search"></th>
    </tr>
  </table>
</form>
<hr style="height: 4px;">
<?php
include("connect.php");   	
$con=Connection();
if($_GET["filter"] != ""){
	$filter=$_GET["filter"];	
	$query="SELECT RFID.UID,RFID.date,RFID.time,Persons.name,Persons.surname,Persons.reg_date,Persons.SID
	FROM RFID 
	INNER JOIN Persons
	WHERE Persons.name LIKE '%".$filter."%'
	AND Persons.uid=RFID.UID
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
<body>
</html>

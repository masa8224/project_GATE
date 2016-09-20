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
      <th>SEARCH NAME:
      <input name="txtKeyword" type="text" id="txtKeyword" value="<?php echo $_GET["txtKeyword"];?>">
      <input type="submit" value="Search"></th>
    </tr>
  </table>
</form>
<hr style="height: 4px;">
<?php
$con=mysqli_connect("localhost","root","00125410","arduino");
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if($_GET["txtKeyword"] != ""){
	$word=$_GET["txtKeyword"];	
	$result = mysqli_query($con,"SELECT RFID.UID,RFID.date,RFID.time,Persons.name,Persons.surname,Persons.reg_date,Persons.SID
	FROM RFID 
	INNER JOIN Persons
	WHERE Persons.name LIKE '$word'
	AND Persons.uid=RFID.UID;");
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
		echo "<td>" . $row['date'] . "</td>";
		echo "<td style=\"text-align:center;\">" . $row['time'] . "</td>";
		echo "<td>" . $row['UID'] . "</td>";			
		echo "<td>" . $row['name'] . "</td>";
		echo "<td>" . $row['surname'] . "</td>";
		echo "<td style=\"text-align:center;\">" . $row['SID'] . "</td>";
		echo "<td style=\"text-align:center;\">" . $row['reg_date'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	mysqli_close($con);
}else{
	$result = mysqli_query($con,"SELECT RFID.UID,RFID.date,RFID.time,Persons.name,Persons.surname,Persons.reg_date,Persons.SID
	FROM RFID 
	LEFT JOIN Persons
	ON RFID.UID=Persons.uid");
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
	while($row = mysqli_fetch_array($result))
	{
		echo "<tr>";			
		echo "<td>" . $row['date'] . "</td>";
		echo "<td style=\"text-align:center;\">" . $row['time'] . "</td>";
		echo "<td>" . $row['UID'] . "</td>";			
		echo "<td>" . $row['name'] . "</td>";
		echo "<td>" . $row['surname'] . "</td>";
		echo "<td style=\"text-align:center;\">" . $row['SID'] . "</td>";
		echo "<td style=\"text-align:center;\">" . $row['reg_date'] . "</td>";
	echo "</tr>";
	}
	echo "</table>";
	mysqli_close($con);
}
?>
<body>
</html>

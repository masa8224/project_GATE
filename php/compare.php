<html>
   <head>
      <title>RFID</title>
	  <link rel="stylesheet" type="text/css" href="style.css">
   </head>
   <h1>RFID UID Compare</h1>
   <hr>
   <?php
		$con=mysqli_connect("localhost","root","00125410","arduino");
		if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$result = mysqli_query($con,"SELECT RFID.UID,RFID.date,RFID.time,Persons.name,Persons.surname,Persons.reg_date
		FROM RFID 
		LEFT JOIN Persons
		ON RFID.UID=Persons.uid");
		echo "<table>
		<tr>
		<th>Login UID</th>
		<th>Login DATE</th>
		<th>Login TIME</th>
		<th>NAME</th>
		<th>SURNAME</th>
		<th>REGISTRATION DATE</th>
		</tr>";
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";		
			echo "<td>" . $row['UID'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['time'] . "</td>";			
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['surname'] . "</td>";
			echo "<td>" . $row['reg_date'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
		mysqli_close($con);
	?>
   </table>
<body>
</html>

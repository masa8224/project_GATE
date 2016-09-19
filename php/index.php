<html>
   <head>
      <title>Sensor Data</title>
   </head>
<body>
   <h1>RFID UID</h1>
   <br>
   <?php
		$con=mysqli_connect("localhost","root","00125410","arduino");
		if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$result = mysqli_query($con,"SELECT * FROM `RFID` WHERE 1");
		echo "<table border='1'>
		<tr>
		<th>UID</th>
		</tr>";
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";				
			echo "<td>" . $row['UID'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
		mysqli_close($con);
	?>
   </table>
</body>
</html>

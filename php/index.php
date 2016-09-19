<html>
   <head>
      <title>RFID</title>
	  <link rel="stylesheet" type="text/css" href="style.css">
   </head>

   <h1>RFID UID</h1>
   <a href="compare.php">for identity version</a>
   <hr>
   <?php
		$con=mysqli_connect("localhost","root","00125410","arduino");
		if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$result = mysqli_query($con,"SELECT * FROM `RFID` WHERE 1");
		echo "<table border='1'>
		<tr>
		<th>DATE</th>
		<th>TIME</th>
		<th>UID</th>
		</tr>";
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";		
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['time'] . "</td>";			
			echo "<td>" . $row['UID'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
		mysqli_close($con);
	?>
   </table>
<body>
</html>

<?php
//if($_GET["txtKeyword"] != ""){
	//$word=$_GET["txtKeyword"];
	$con=mysqli_connect("localhost","root","00125410","arduino");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$result = mysqli_query($con,"SELECT * FROM Persons WHERE Persons.name LIKE \"ponsakorn\"");
	while($row = mysqli_fetch_array($result)){
		$newuid=$row['uid'];
	}
	$result2 = mysqli_query($con,"SELECT RFID.UID,RFID.date,RFID.time,Persons.name,Persons.surname,Persons.reg_date,Persons.SID
	FROM RFID 
	INNER JOIN Persons
	WHERE '$newuid' = RFID.UID 
	AND RFID.UID=Persons.uid;");
	echo "<table width=\"600\" border=\"1\">
		<tr>
		<th>Login DATE</th>
		<th>Login TIME</th>
		<th>Login UID</th>
		<th>NAME</th>
		<th>SURNAME</th>
		<th>Student ID</th>
		<th>REGISTRATION DATE</th>
	  </tr>";
	while($row = mysqli_fetch_array($result2)){
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
//}
?>
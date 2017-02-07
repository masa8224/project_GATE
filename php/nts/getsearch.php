<?php
	include("connect.php");
	$con=Connection();	
	$filter=$_GET['filter'];
	mysqli_query($con,"SET character_set_results=utf8");
	mysqli_query($con,"SET character_set_client=utf8");
	mysqli_query($con,"SET character_set_connection=utf8");	
	$query="SELECT RFID.UID,RFID.date,RFID.time,Persons.name,Persons.surname,Persons.class,Persons.SID,
	Plate.brand,Plate.Model, Plate.color,Plate.plate, Plate.POI
	FROM RFID 
	LEFT JOIN Persons
	ON Persons.uid=RFID.UID	
	LEFT JOIN Plate 
	ON Persons.SID = Plate.SID
	WHERE Persons.SID LIKE '".$filter."'	
	ORDER BY date DESC, time DESC;";
	
	$result = mysqli_query($con,$query);
	if (mysqli_num_rows($result)) {
		$rowcount=mysqli_num_rows($result);		
		echo "<table>
		<tr><td class=\"re\" colspan='8'>Found ".$rowcount." result</td></tr>
		<tr>
		<th>Enter DATE</th>
		<th>Enter TIME</th>		
		<th>NAME</th>		
		<th>Class</th>
		<th>Student ID</th>
		<th>License Plate Number</th>		
		<th>View Data</th>
		</tr>";
		while($row = mysqli_fetch_array($result)){
			echo "<tr>";			
			echo "<td class=\"center\">" . $row['date'] . "</td>";
			echo "<td class=\"center\">" . $row['time'] . "</td>";				
			
				echo "<td>" . $row['name'] . "";
				echo "  " . $row['surname'] . "</td>";
				echo "<td class=\"center\">" . $row['class'] . "</td>";				
				echo "<td class=\"center\">" . $row['SID'] . "</td>";				
				echo "<td class=\"center\">" . $row['plate'] . "</td>";								
				echo "<td class=\"center\"><button class='nothing' onclick=\"data('".$row['name']."','".$row['surname']."','".$row['class']."','".$row['SID']."')\">Data</a></td>";						
			echo "</tr>";
		}		
		echo "</table>";
	}else{
		echo "<h1 class=\"center\">No result</h1>";				
	}	
	mysqli_close($con);


?>
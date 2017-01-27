<?php
	include("connect.php");
	$a = $_POST['a'];
	$con = Connection();
	$date = date("Y-m-d");
	mysqli_query($con,"SET character_set_results=utf8");
	mysqli_query($con,"SET character_set_client=utf8");
	mysqli_query($con,"SET character_set_connection=utf8");
	$query3 ="SELECT COUNT(1) AS entries, DATE(date) as date FROM RFID WHERE date='".$date."' GROUP BY DATE(date)";
	$stu = mysqli_query($con,$query3);
	if (mysqli_num_rows($stu)){
	while($row = mysqli_fetch_array($stu)){
		$entries = $row['entries'];
		echo "entries=";
		echo $entries;
	}
	}else{
		echo "entries=";
		echo "No";
	}	
	echo "       ";
	$query="SELECT RFID.date,RFID.time,Persons.name,Persons.surname,Persons.reg_date,Persons.SID,Persons.class,Plate.plate
	FROM RFID 
	LEFT JOIN Persons
	ON RFID.UID=Persons.uid
	LEFT JOIN Plate 
	ON Persons.SID = Plate.SID
	WHERE date='".$date."'	
	ORDER BY date DESC, time DESC;";
	$result = mysqli_query($con,$query);
	if (mysqli_num_rows($result)) {		
		echo "<table>
		<tr>
		<th>Enter DATE</th>
		<th>Enter TIME</th>		
		<th>NAME</th>		
		<th>Class</th>
		<th>Student ID</th>
		<th>License Plate Number</th>
		<th>REGISTRATION DATE</th>
		<th>View Data</th>
		</tr>";
		while($row = mysqli_fetch_array($result)){
			echo "<tr>";			
			echo "<td class=\"center\">" . $row['date'] . "</td>";
			echo "<td class=\"center\">" . $row['time'] . "</td>";				
			if($row['name'] !== null){
				echo "<td>" . $row['name'] . "";
				echo "  " . $row['surname'] . "</td>";
				echo "<td class=\"center\">" . $row['class'] . "</td>";
				echo "<td class=\"center\">" . $row['SID'] . "</td>";				
				echo "<td class=\"center\">" . $row['plate'] . "</td>";				
				echo "<td class=\"center\">" . $row['reg_date'] . "</td>";
				echo "<td class=\"center\"><button class='nothing' onclick=\"data('".$row['name']."','".$row['surname']."','".$row['class']."','".$row['SID']."')\">Data</a></td>";	
			}else{
				echo "<td class=\"unkn\" colspan=\"4\">Unknown</td>";
			}			
			echo "</tr>";
		}
		echo "</table>";
	}else{
		echo "<h1 class=\"center\">No Data</h1>";		
	}	
	
	mysqli_close($con);
?>
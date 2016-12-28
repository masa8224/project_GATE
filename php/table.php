<?php
	include("connect.php");
	$a = $_POST['a'];
	$con = Connection();
	$date = date("Y-m-d");
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
	$query="SELECT RFID.UID,RFID.date,RFID.time,Persons.name,Persons.surname,Persons.reg_date,Persons.SID
	FROM RFID 
	LEFT JOIN Persons
	ON RFID.UID=Persons.uid
	WHERE date='".$date."'
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
		echo "<h1 class=\"center\">No Data</h1>";		
	}	
	
	mysqli_close($con);
?>
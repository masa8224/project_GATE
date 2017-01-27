<?php
include("connect.php");
$con = Connection();
mysqli_query($con,"SET character_set_results=utf8");
mysqli_query($con,"SET character_set_client=utf8");
mysqli_query($con,"SET character_set_connection=utf8");
$date = date("Y-m-d");
$query = "SELECT * FROM RFID WHERE date = '".$date."' ORDER BY time DESC";
$res=mysqli_query($con,$query);
while($row = mysqli_fetch_array($res)){
	$UID = $row['UID'];
	break;
}
$queryData = "SELECT Persons.name, Persons.surname, Persons.SID, Persons.class, 
			Persons.reg_date, Plate.brand, Plate.Model, Plate.color,Plate.plate, Plate.POI
			FROM Persons 
			INNER JOIN RFID ON Persons.UID = '".$UID."' 
			LEFT JOIN Plate ON Persons.SID = Plate.SID";
$resdata=mysqli_query($con,$queryData);
if (mysqli_num_rows($resdata)){
	while($row = mysqli_fetch_array($resdata)){
		$name = $row['name'];
		$surname = $row['surname'];
		$SID = $row['SID'];
		$class = $row['class'];
		$reg_date = $row['reg_date'];
		if ($row['brand']){
		$brand = $row['brand'];
		$model = $row['Model'];
		$color = $row['color'];
		$plate = $row['plate'];
		$poi = $row['POI'];
		}else{
			$brand = "Unknown";
			$model = "Unknown";
			$color = "Unknown";
			$plate = "Unknown";
			$poi = "Unknown";
		}
		break;
	}
}else{
	$name = "Unknown";
	$surname = "Unknown";
	$SID = "Unknown";
	$reg_date = "Unknown";
	$brand = "Unknown";
	$model = "Unknown";
	$color = "Unknown";
	$plate = "Unknown";
	$poi = "Unknown";
}
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
echo "data:".$SID."               ";
echo "<table><tr><th class='imgth'><div class='imgdash' id='stimg'></div></th>";
echo "<th align='left'style='vertical-align: top;'><font>Name: ".$name." ".$surname." <br> SID: ".$SID."<br>Class: ".$class."<br> Registration date: ".$reg_date."<hr><h3>Vehicle data</h3><hr>Brand: ".$brand."<br>Model: ".$model."<br>Color: ".$color."<br>License Plate Number: ".$plate."<br>Point of Interest: ".$poi."</font></th>";
echo "</tr></table>\n\n";

flush();
?>
<?php 
	if (!isset($_COOKIE[user])){
		header("Location: login.php");
	}	
?>
<html>
<head>
	<title>RFID LOG</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	</head>
<body>
<ul>
	<li class="name">NTS RFID System</li> 	
	<li class="dropdown">
    <a href="#" class="dropbtn">MAIN</a>
    <div class="dropdown-content">
      <a href="stu.php">Student Database</a>
      <a href="reg.php">RFID Registration</a> 
	  <a href="setting.php">Setting</a>	  
    </div>
	</li>
	<li><a>></a></li>
	<li><a>LOG</a></li>
    <div style="float: right;">
	<li class="logout"><a href="logout.php">logout</a></li>
	<li><a>Login as <?php echo $_COOKIE[user];?></a></li>  
	</div>
</ul>

<div class="content">
<div class="card">
<table style="width:100%;margin:0 auto 0 auto;border:none;">
<form method="get">  
    <tr>
      <th class="nobd">FILTER > NAME:
      <input class="search" name="filter" type="text" id="filter" value="<?php echo $_GET["filter"];?>">
      <input type="submit" value="Search">	  	  
	  </th>
	  <th class="nobd" style="line-height: 6px;">
		<?php echo date("d F Y");?><br>
		<p id="time"></p>
	  </th>
    </tr>  
</form>
</table>
</div>
<<<<<<< HEAD
=======
<div class="card">
	<div id="chart"></div>
</div>
>>>>>>> 08632652b502f5ef84719b6e79b25dbfc701b8af
<div class="card cardtable">
<?php
include("connect.php");   	
$con=Connection();
if($_GET["filter"] or $_GET["date"]){
	$filter=$_GET["filter"];	
	$query="SELECT RFID.UID,RFID.date,RFID.time,Persons.name,Persons.surname,Persons.reg_date,Persons.SID
	FROM RFID 
	INNER JOIN Persons
	WHERE Persons.name LIKE '%".$filter."%'
	AND Persons.uid=RFID.UID
	ORDER BY date DESC, time DESC;";
	$result = mysqli_query($con,$query);
	if (mysqli_num_rows($result)) {
		$rowcount=mysqli_num_rows($result);		
		echo "<table>
		<tr><td class=\"re\" colspan=\"7\">Found ".$rowcount." result</td></tr>
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
	//mysqli_close($con);	
	$query ="SELECT COUNT(1) AS entries, DATE(date) as date FROM RFID GROUP BY DATE(date) LIMIT 0 , 30";
	$graph = mysqli_query($con,$query);
	echo "<script type=\"text/javascript\">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
      data.addColumn('date', 'Day');
      data.addColumn('number', 'Students');
      data.addRows([";
	while($row = mysqli_fetch_array($graph)){
		$sqldate = $row['date'];
		$dateraw = strtotime($sqldate);
		$date = date("Y m d",$dateraw);
		echo "[new Date('".$date."'),".$row['entries']."],";
	}
    echo "]);
	var options = {
        chart: {
          title: 'Students that use the parking lot',
        },
        width: 900,
        height: 500
		
      };

      var chart = new google.charts.Line(document.getElementById('chart'));

      chart.draw(data, options);
      }
    </script>";
	
}
<<<<<<< HEAD
?></div></div>
=======
?>
</div>
>>>>>>> 08632652b502f5ef84719b6e79b25dbfc701b8af
<script type="text/javascript">
setInterval(Timer(),1000);
function Timer() {
   var dt=new Date()
   var hours = dt.getHours();
   var min = dt.getMinutes();
   var sec = dt.getSeconds();
   if (min < 10) {
    min = "0" + min;
   }
   if (sec<10){
	sec = "0" + sec;	
   }
   document.getElementById('time').innerHTML=hours+":"+min+":"+sec;
   setTimeout("Timer()",1000);
}
</script>
</body>
</html>

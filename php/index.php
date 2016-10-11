<?php 
	if (!isset($_COOKIE[user])){
		header("Location: login.php");
	}	
	$pageid = "page1";
?>
<html>
<head>
	<title>RFID LOG</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="script.js"></script>	
</head>
<body onload="load()">
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
	<li><a id="pagename"></a></li>	
    <div style="float: right;">
	<li class="logout"><a href="logout.php">logout</a></li>
	<li><a>Login as <?php echo $_COOKIE[user];?></a></li>  
	</div>
	<?php
		$xml=simplexml_load_file("page.xml") or die("Error: Cannot create object");		
		echo "<script>document.getElementById('pagename').innerHTML='".$xml->$pageid."';</script>";
	?>
</ul>
<div class="content">
<div class="tabsheader">
<ul>
	<li><a class="tabOn" onclick="opentabs(event,'dashboard');">Dashboard</a></li>
	<li><a class="tabOn" onclick="opentabs(event,'log');">Log</a></li>	
</ul>
</div>
<div id="dashboard" class="tabs">
<div style="display: flex;">
<div class="card animate" style="width: 58%;margin: 1em;display: block;">
	<font id="count" style="font-size: 50px;"></font>
	<span style="margin: 1em;">Students was enter today.</span>
	<hr>
</div>
<div class="card animate" style="width: 38%;margin: 1em; padding: 6px;">
	<div id="chart" class="animate">
</div>
</div>
</div>
</div>
<div id="log" class="tabs" style="display:none;">
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
<div class="card cardtable" style="-webkit-animation-timing-function: ease-in-out;">
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
	$query ="SELECT COUNT(1) AS entries, DATE(date) as date FROM RFID GROUP BY DATE(date) LIMIT 0 , 30";
	$graph = mysqli_query($con,$query);
	echo "<script type=\"text/javascript\">      
		var rows=[";
	while($row = mysqli_fetch_array($graph)){
		$num = mysqli_num_rows($graph);
		$rownum = $num - 1;
		$sqldate = $row['date'];
		$dateraw = strtotime($sqldate);
		$date = date("Y m d",$dateraw);
		echo "[new Date('".$date."'),".$row['entries']."]";
		if($num >0){
			echo ",";
		}
	}
    echo "];		
		drawchart(rows);
		</script>";
	$date2 = date("Y-m-d");
	$query3 ="SELECT COUNT(1) AS entries, DATE(date) as date FROM RFID WHERE date='".$date2."' GROUP BY DATE(date) LIMIT 0 , 30";
	$stu = mysqli_query($con,$query3);
	if (mysqli_num_rows($stu)){
	while($row = mysqli_fetch_array($stu)){
		$entries = $row['entries'];
		echo "<script>";
		echo "document.getElementById('count').innerHTML=".$entries.";";	
		echo "</script>";
	}
	}else{
		echo "<script>";
		echo "document.getElementById('count').innerHTML= 0;";
		echo "</script>";
	}
	$week = date("W");
	mysqli_close($con);
	
}
?>
</div>
</div>
</div>
<script type="text/javascript">
		setInterval(Timer(),1000);		
		function load(){
			opentabs(event,'dashboard');
		}
</script>
</body>
</html>

<?php 
	if (!isset($_COOKIE[user])){
		header("Location: login.php");
	}	
?>
<html>
<head>
	<title>STUDENT Database</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<ul>
	<li class="name">NTS RFID System</li> 	
	<li class="dropdown">
    <a href="#" class="dropbtn">MAIN</a>
    <div class="dropdown-content">
      <a href="index.php">LOG</a>
      <a href="reg.php">RFID Registration</a>
	  <a href="setting.php">Setting</a>
    </div>
	</li>
	<li><a>></a></li>
	<li><a>STUDENT DATABASE</a></li>   
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
	<th style="width: 72%;border:none;">
			FILTER > NAME:
			<input class="search" name="filter" type="text" id="filter" value="<?php echo $_GET["filter"]?>">
			<input type="submit" value="Search">
	</th>	
	<th style="width: 14%;text-align:left;border:none;">
			<label>Sort by</label><br>	
			<input id="_1" type="radio" name="sort" value="name" > Name		<br>	
			<input id="_2" type="radio" name="sort" value="SID" > Student ID <br>
	</th>		 
	<th style="width: 14%;text-align:left;border:none;">	
			<label>Sort by</label><br>	
			<input id="_3" type="radio" name="by" value="ASC"> Ascend <br>
			<input id="_4" type="radio" name="by" value="DESC" > Descend <br>			
	</th>
	</tr>
	</form>
	</table>	
</div>
<div class="card">
<table><tr><th style="width:10%">
	<div><font style="font-size:1.2em;;">Stat</font></div>
	</th><th>
		<label id="stat"></label>
		<label>&nbsp;Student</label>
	</th></tr></table>
</div>
<?php
include("connect.php");   	
$con=Connection();
if ($_GET["sort"]){
	if ($_GET["sort"]=='name'){
		echo "<script>document.getElementById(\"_1\").checked = true;</script>";
	}else if ($_GET["sort"]=='SID'){
		echo "<script>document.getElementById(\"_2\").checked = true;</script>";
	}
	if ($_GET["by"]=='ASC'){
		echo "<script>document.getElementById(\"_3\").checked = true;</script>";
	}else if ($_GET["by"]=='DESC'){
		echo "<script>document.getElementById(\"_4\").checked = true;</script>";
	}
}else{
	echo "<script>document.getElementById(\"_1\").checked = true;</script>";
	echo "<script>document.getElementById(\"_3\").checked = true;</script>";
}
if($_GET["filter"] or $_GET["date"] or $_GET["sort"]){
	$filter=$_GET["filter"];
	$sort=$_GET["sort"];
	$by=$_GET["by"];
	$query="SELECT *
	FROM Persons	
	WHERE Persons.name LIKE '%".$filter."%'	
	ORDER BY $sort $by;";
	$result = mysqli_query($con,$query);
	if (mysqli_num_rows($result)) {
		$rowcount=mysqli_num_rows($result);		
		echo "<table>
		<tr><td class=\"re\" colspan=\"7\">Found ".$rowcount." result</td></tr>
		<tr>		
		<th>UID</th>
		<th>NAME</th>
		<th>SURNAME</th>
		<th>Student ID</th>
		<th>REGISTRATION DATE</th>
		</tr>";
		while($row = mysqli_fetch_array($result)){
			echo "<tr>";			
			echo "<td class=\"center\">" . $row['uid'] . "</td>";			
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
	$sort="SID";
	$query="SELECT *
	FROM Persons	
	ORDER BY name ASC;";
	$result = mysqli_query($con,$query);
	if (mysqli_num_rows($result)) {	
		$rowcount=mysqli_num_rows($result);
		echo "<script>document.getElementById(\"stat\").innerHTML=\"".$rowcount."\";</script>";
		echo "<table>
		<tr>		
		<th>UID</th>
		<th>NAME</th>
		<th>SURNAME</th>
		<th>Student ID</th>
		<th>REGISTRATION DATE</th>
		</tr>";
		while($row = mysqli_fetch_array($result)){
			echo "<tr>";			
			echo "<td class=\"center\">" . $row['uid'] . "</td>";			
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
}
?>
</div>
<script type="text/javascript">
</script>
</body>
</html>

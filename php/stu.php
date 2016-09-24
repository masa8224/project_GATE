<?php 
	if (!isset($_COOKIE[user])){
		header("Location: login.php");
	}	
?>
<html>
<head>
	<title>RFID LOG</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<ul>
	<li class="name">NTS RFID System</li> 	
	<li class="dropdown">
    <a href="#" class="dropbtn">MAIN ></a>
    <div class="dropdown-content">
      <a href="index.php">LOG</a>
      <a href="reg.php">RFID Registration</a>
    </div>
  </li>
	<li><a>STUDENT DATABASE</a></li>   
	<div style="float: right;">
	<li class="logout"><a onclick="logout()" href="login.php">logout</a></li>
	<li><a>Login as <?php echo $_COOKIE[user];?></a></li>  
	</div>
</ul>

<div class="content">
<form method="get">
  <table style="width:40%;">
    <tr>
      <th>FILTER > NAME:
      <input class="search" name="filter" type="text" id="filter" value="<?php echo $_GET["filter"];?>">
      <input type="submit" value="Search">	  
	  <div class="normal">
	  <label>Sort by</label><br>
			 <input type="radio" name="sort" value="name" checked> Name<br>
			 <input type="radio" name="sort" value="SID" > Student ID<br>
      </div>
	  </th>
    </tr>
  </table>
</form>
<hr style="height: 4px;">
<?php
include("connect.php");   	
$con=Connection();
if($_GET["filter"] or $_GET["date"] or $_GET["sort"]){
	$filter=$_GET["filter"];
	$sort="name";
	$query="SELECT *
	FROM Persons	
	WHERE Persons.name LIKE '%".$filter."%'	
	ORDER BY $sort DESC;";
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
<script type="text/javascript">
function logout(){
	document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
}
</script>
</body>
</html>

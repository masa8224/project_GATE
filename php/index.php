<?php 
	session_start();
	if (!isset($_SESSION['Auser'])) {
        header("Location: login.php");
    }
    else {
        $now = time(); 
        if ($now > $_SESSION['expire']) {
            header("Location: login.php");
        }
	}
	$pageid = "page1";
?>
<html>
<head>
	<title>RFID LOG</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="Chart.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
		
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
</div>

<div>
<div class="container" style="font-family: OpenSans;padding-top: 20px;">
<div class="card" >
<table style="width:100%;margin:0 auto 0 auto;border:none;">
<form method="get">  
    <tr>
      <th class="nobd">FILTER > NAME:
      <input class="search" name="filter" type="text" id="filter" value="">
      <input type="submit" value="Search">	  	  
	  </th>
	  <th class="nobd" style="line-height: 6px;">
		<?php 			
			echo date("l d F Y");
		?>
		<br>
		<p id="time"></p>
	  </th>
    </tr>  
</form>
<tr>
<th>
<font id="count" style="font-size: 50px;"></font>
	<span style="margin: 1em;">Students was enter today.</span>
</th>
</tr>
</table>
</div>
<div class="card cardtable" style="display: block;">
<div class="card" style="width: 100%;margin: 0;padding: 0;border:none;border-radius:0;z-index: -100;">
<ul style="position: relative;width: 100%;">
  <li><a href="javascript:void(0)" style="color: lightsalmon;" onclick="openCity('Graph')">Graph</a></li>
  <li><a href="javascript:void(0)" style="color: lightsalmon;" onclick="openCity('Log')">Log</a></li>  
</ul>
</div>
<hr>
<div id="Graph" class="city">
<canvas id="mychart" width="400" height="200"></canvas>
</div>
<div id="Log" class="city" style="display:none">
<button>
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
}		
	$dateGr = array();
	$count = array();
	$queryGr ="SELECT date , count(uid) as con FROM RFID GROUP BY date";
		$graph = mysqli_query($con,$queryGr);	
		while($row = mysqli_fetch_array($graph)){			
			$sqldate = strtotime($row["date"]);
			$d = date ("D d M Y",$sqldate);
			array_push($dateGr,$d);
			array_push($count,$row["con"]);	
			
		}   	
		
	mysqli_close($con);

?>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function SQLTable(){
		console.log("GET Table");
		var xhr = new XMLHttpRequest();				
		xhr.open('GET', 'table.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function () {
			var res = this.responseText;
			var entries = res.slice(8,12);
			str = entries.replace(/\s/g, '');
			document.getElementById('count').innerHTML=str;
			var ta = res.slice(14);	
			document.getElementById('Log').innerHTML = ta;				
		};	
		
		xhr.send("a");			
}


setInterval(Timer(),1000);
setInterval(SQLTable,1000);
var ctx = document.getElementById("mychart");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php				
				echo "[";
				foreach ($dateGr as $dt){
					echo "\"";
					echo $dt;
					echo "\"";
					echo ",";
				}				
				echo "]";
			?>,
        datasets: [{
            label: '# of student enter parking lot',
            data: <?php echo "[";
				foreach ($count as $cn){
					echo "\"";
					echo $cn;
					echo "\"";
					echo ",";
				}
				echo "]";?>,
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

function openCity(cityName) {
    var i;
    var x = document.getElementsByClassName("city");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none"; 
    }
    document.getElementById(cityName).style.display = "block"; 
}
</script>

</body>
</html>

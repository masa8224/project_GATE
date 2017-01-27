<<<<<<< HEAD
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
	<li><a>LOG</a></li>
    <div style="float: right;">
	<li class="logout"><a href="logout.php">logout</a></li>
	<li><a>Login as <?php echo $_COOKIE[user];?></a></li>  
	</div>
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
<div id="log" class="tabs">
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
	while($row = mysqli_fetch_array($stu)){
		$entries = $row['entries'];
		echo "<script>";
		echo "document.getElementById('count').innerHTML=".$entries.";";
		echo "console.log($entries);";
		echo "console.log(\"shit\");";
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
		function opentabs(evt,name) {
			var i;
			var x = document.getElementsByClassName("tabs");
			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none"; 
			}
			tabOn = document.getElementsByClassName("tabOn");
			for (i = 0; i < x.length; i++) {
				tabOn[i].className = tabOn[i].className.replace(" yellow", "");
			}
			document.getElementById(name).style.display = "block"; 
			evt.currentTarget.className += " yellow";
		}
		function load(){
			opentabs(event,'dashboard');
		}
	</script>
</body>
</html>
=======
<?php 
	session_start();
	if (!isset($_SESSION['Auser'])) {
        header("Location: login.php");
    }
    else {
        $now = time(); 
        if ($now > $_SESSION['expire']) {
            header("Location: login.php?q=2");
        }
	}
	$pageid = "page1";
?>
<html>
<head>
	<title>RFID LOG</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="UTF-8">
	<script type="text/javascript" src="Chart.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<style>
		img {
			max-width: 200px;
			max-height: 300px;
		}
		.imgdash{
			width: 200px;
			height: 280px;
			overflow: hidden;
			border: 2px solid #ccc;
			vertical-align: bottom;
			background-color: #d3d3d3;
		}
		.imgth{
			vertical-align: top;
			width: 205px;
		}
		.nobd th{
			border: none;
		}
	</style>
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


<div class="container" style="font-family: OpenSans;padding-top: 20px;">
<div class="card" >
<table style="width:100%;height: 100px;margin:0 auto 0 auto;border:none;">
    <tr>
	
      <th class="nobd">
		<font id="count" style="font-size: 50px;"></font>
	<span style="margin: 1em;">Students was enter today.</span>
	  </th>	  
	  <th class="nobd" style="line-height: 6px;">
		<?php 			
			echo date("l d F Y");
		?>
		<br>
		<p id="time"></p>
	  </th>
    </tr>  
</table>
</div>
<div class="card" style="display: block;">
<div class="card" style="width: 100%;margin: 0;padding: 0;border:none;border-radius:0;z-index: -100;">
<ul style="position: relative;width: 100%;">
  <li><a href="javascript:void(0)" style="color: lightsalmon;" onclick="openCity('Dashboard')">Data</a></li>
  <li><a href="javascript:void(0)" style="color: lightsalmon;" onclick="openCity('Graph')">Graph</a></li>
  <li><a href="javascript:void(0)" style="color: lightsalmon;" onclick="openCity('tabLog')">Log</a></li>  
</ul>
</div>
<hr>
<div id="Dashboard" class="city" >
	<h1>Student Data</h1>
	<hr>
	<div id="result" style="display: inline;"></div>
</div>
<div id="Graph" class="city" style="display:none">
<canvas id="mychart" width="400" height="200"></canvas>
</div>
<div id="tabLog"  class="city cardtable" style="display:none">
	FILTER > NAME:
	<input class="search" name="filter" type="text" id="filter" style="width: 400px;">
	<button id="apply" type="button">Apply Filter</button>
	<button onclick='Clear()' type="button">Clear Filter</button>
	  
	<div id="Log">
	</div>
</div>
</div>
<div id="id01" class="modal" style="widht:30%;">
 
  <div class="modal-content animate" >
  <h1>Log data</h1>
  <hr>
  <font id="Sid"></font><hr>
 <button onclick="document.getElementById('id01').style.display='none';">Close</button>
</div>
</div>
</div>


<?php
include("connect.php");   	
$con=Connection();	
	$dateGr = array();
	$count = array();
	$queryGr ="SELECT date , count(uid) as con FROM RFID WHERE date >= DATE_FORMAT(CURDATE(), '%Y-%m-01') - INTERVAL 2 MONTH GROUP BY date";
		$graph = mysqli_query($con,$queryGr);	
		while($row = mysqli_fetch_array($graph)){			
			$sqldate = strtotime($row["date"]);
			$d = date ("D d M Y",$sqldate);
			array_push($dateGr,$d);
			array_push($count,$row["con"]);	
			
		}   	
		
	mysqli_close($con);

?>
<script type="text/javascript">
var oldsrc;
function Clear(){
	var GetTable = setInterval(function(){ SQLTable() }, 1000);
	SQLTable();
	document.getElementById('filter').value="";
}
function SQLTable(){		
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
	
	xhr.send('a');			
}
function CheckUrl(url){      
    var http=new XMLHttpRequest();    
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
}
if(typeof(EventSource) !== "undefined") {
		var source = new EventSource("server_event.php");
		source.onmessage = function(event) {
		var res = event.data;
		var picstr = res.slice(0,8);		
		var stdata = res.slice(10);
		picsrc = picstr.replace(/\s/g, '')		
        document.getElementById("result").innerHTML = stdata;
		if (oldsrc!=picsrc){
		oldsrc=picsrc;
		var ch = '/pic/'+picsrc+'.jpg';		
		var url = CheckUrl(ch);
		if(url==true){
			document.getElementById("stimg").innerHTML = "<img src='/pic/"+picsrc+".jpg'>";	 
		}
		else{
			document.getElementById("stimg").innerHTML = '<img src="/pic/Unknown.jpg">';	
		}		
		}else{
			document.getElementById("stimg").innerHTML = "<img src='/pic/"+picsrc+".jpg'>";
		}
	};
} else {
    document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
}
function data(name,surname,classroom,sid){	
	document.getElementById('id01').style.display='block';
	document.getElementById('Sid').innerHTML="<table class='nobd'><tr><th ><div id='stimg2'></div></th><th align='left'style='vertical-align: top;'>"+"Name: "+name+" "+surname+'<br>Class: '+classroom+'<br>SID: '+sid+'</th>';
	var ch = '/pic/'+sid+'.jpg';		
	var url = CheckUrl(ch);
	if(url==true){
		document.getElementById("stimg2").innerHTML = "<img src='/pic/"+sid+".jpg'>";	 
	}
	else{
		document.getElementById("stimg2").innerHTML = '<img src="/pic/Unknown.jpg">';	
	}	
}
setInterval(Timer(),1000);
var GetTable = setInterval(function(){ SQLTable() }, 1000);
$(document).ready(function(){
	$("#filter").keyup(function(event){
    if(event.keyCode == 13){
        $("#apply").click();
    }
	});
    $("#apply").click(function(){
		clearInterval(GetTable);
		var filter = $("#filter").val();
		if (filter){
        $.ajax({url: "getsearch.php?filter="+filter, success: function(result){
            $("#Log").html(result);
	}})};
    });	
});
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
>>>>>>> a2ddd81ab3cfa82dd50c3c11f751286d95fe7075

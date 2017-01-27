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

function drawchart(row1){
	google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('date', 'Day');
    data.addColumn('number', 'Students');
	data.addRows(row1);
	var options = {
        chart: {
          title: 'Students that use the parking lot',
        },
        width: 700,
        height: 500		
		};
	var chart = new google.charts.Line(document.getElementById('chart'));
		chart.draw(data, options);
		}
}
<<<<<<< HEAD
=======
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
>>>>>>> a2ddd81ab3cfa82dd50c3c11f751286d95fe7075

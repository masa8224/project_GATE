<?php
			//include('db.php');
		  $con=Connection();
		  $d = date('Y-m-d');
				$Qcount_in ="SELECT count(*) FROM RFID inner join tb_student59 on RFID.UID = tb_student59.uid inner join Plate on tb_student59.student_id = Plate.sid where date(RFID.datetime) = '$d' and status = 1 ";
				$count_in = mysqli_query($con,$Qcount_in);	
				$rs_count_in = mysqli_fetch_assoc($count_in);
				echo $rs_count_in['count(*)'];
			//echo $Qcount_in;
				
				$Qcount_out ="SELECT count(*) FROM RFID inner join tb_student59 on RFID.UID = tb_student59.uid inner join Plate on tb_student59.student_id = Plate.sid where date(RFID.datetime) = '$d' and status = 2";
				$count_out = mysqli_query($con,$Qcount_out);	
				$rs_count_out = mysqli_fetch_assoc($count_out);
				echo $rs_count_out['count(*)'];
			
?>
<!doctype html>
<html>

<head>
    <title>Bar Chart</title>
    <script src="Chart.bundle.js"></script>
    <script src="utils.js"></script>
    <style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>
</head>

<body>
    <div id="container" style="width: 100%;height: 100%;">
        <canvas id="canvas"></canvas>
    </div>
    
    <script>
        var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var color = Chart.helpers.color;
        var barChartData = {
            labels: ["สถิติปริมาณรถมอเตอร์ไซต์"],
            datasets: [{
                label: 'รถจักรยานยนต์เข้า',
                backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
                borderColor: window.chartColors.green,
                borderWidth: 1,
                data: [
                    <?php echo $rs_count_in['count(*)'];  ?>
                    
                ]
            }, {
                label: 'รถจักรยานยนต์ออก',
                backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                borderColor: window.chartColors.red,
                borderWidth: 1,
                data: [
                   <?php echo $rs_count_out['count(*)']; ?>
                ]
            }]

        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'สถิติการเข้า-ออกรถวันที่<?php echo datethaifull($d); ?>'
                    }
                }
            });

        };

       

        var colorNames = Object.keys(window.chartColors);
        document.getElementById('addDataset').addEventListener('click', function() {
            var colorName = colorNames[barChartData.datasets.length % colorNames.length];;
            var dsColor = window.chartColors[colorName];
            var newDataset = {
                label: 'Dataset ' + barChartData.datasets.length,
                backgroundColor: color(dsColor).alpha(0.5).rgbString(),
                borderColor: dsColor,
                borderWidth: 1,
                data: []
            };

            for (var index = 0; index < barChartData.labels.length; ++index) {
                newDataset.data.push(randomScalingFactor());
            }

            barChartData.datasets.push(newDataset);
            window.myBar.update();
        });

        

        

      
    </script>
</body>

</html>

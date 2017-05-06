<?php include("db.php");    ?>


<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<title>Narathiwat School RFID System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>      
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>  
<script type="text/javascript" src="Chart.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
	<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/pepper-grinder/jquery-ui.css">
<link rel="stylesheet" href="w3.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
 <style type="text/css">
    body {
        font-family:tahoma, "Microsoft Sans Serif", sans-serif, Verdana;
        font-size:12px;
    }
    #input_q{
               
    }
    /*   css ส่วนของรายการที่แสดง  */ 
    .ui-autocomplete {  
        padding-right: 5px;
        max-height:200px !important;
        overflow: auto !important;
    }  
    /*  css  ส่วนปุ่มคลิกเลือกแสดงรายการทั้งหมด*/ 
    .showAll_btn{  
        position: relative;
        top: -2px;    
        border:0px solid;  
        font-size: 10px;
        height: 23px;
        width: 25px;
    }  
    </style>   
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>    
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

 
<script type="text/javascript">
    $(function() {
         
        $( "#input_q" ).autocomplete({ // ใช้งาน autocomplete กับ input text id=tags
            minLength: 0, // กำหนดค่าสำหรับค้นหาอย่างน้อยเป็น 0 สำหรับใช้กับปุ่ใแสดงทั้งหมด
            source: "src_sid.php", // กำหนดให้ใช้ค่าจากการค้นหาในฐานข้อมูล
            open:function(){ // เมื่อมีการแสดงรายการ autocomplete
                var valInput=$(this).val(); // ดึงค่าจาก text box id=tags มาเก็บที่ตัวแปร
                if(valInput!=""){ // ถ้าไม่ใช่ค่าว่าง
                    $(".ui-menu-item a").each(function(){ // วนลูปเรียกดูค่าทั้งหมดใน รายการ autocomplete
                        var matcher = new RegExp("("+valInput+")", "ig" ); // ตรวจสอบค่าที่ตรงกันในแต่ละรายการ กับคำค้นหา
                        var s=$(this).text();
                        var newText=s.replace(matcher, "<b>$1</b>");    //      แทนค่าที่ตรงกันเป็นตัวหนา
                        $(this).html(newText); // แสดงรายการ autocomplete หลังจากปรับรูปแบบแล้ว
                    }); 
                }
            },
            select: function( event, ui ) {
                // สำหรับทดสอบแสดงค่า เมื่อเลือกรายการ
//              console.log( ui.item ?
//                  "Selected: " + ui.item.label :
//                  "Nothing selected, input was " + this.value);
                $("#h_input_q").val(ui.item.id); // เก็บ id ไว้ใน hiden element ไว้นำค่าไปใช้งาน
//                setTimeout(function(){
//                  $("#h_input_q").parents("form").submit(); // เมื่อเลือกรายการแล้วให้ส่งค่าฟอร์ม ทันที
//                },500);
            }
        });
 
        $(".showAll_btn").click(function(){
            // ตรวจสอบถ้ามีการแสดงรายการทั้งหมดอยู่แล้ว  
            if ($( "#input_q" ).autocomplete( "widget" ).is( ":visible" ) ) {  
                $( "#input_q" ).autocomplete( "close" ); // ปิดการแสดงรายการทั้งหมด  
                return;  
            }  
            // ส่งค่าว่างปล่าวไปทำการค้นหา จะได้ผลลัพธ์เป็นรายการทั้งหมด  
            $( "#input_q" ).autocomplete( "search", "" );  
 
            $( "#input_q" ).focus(); //ให้ cursor ไปอยู่ที่ input text id=tags              
        });


		
			

 
         
    });
</script>
<body class="w3-light-grey">

<!-- Top container -->

<div class="w3-container w3-top w3-teal w3-large w3-padding" style="z-index:4">
  <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();"><i class="fa fa-bars"></i> Menu</button>
  <span class="w3-left">โรงเรียนนราธิวาส      <i class="fa fa-calendar w3-large"></i>
 
  <?php 			
			echo "วันนี้ :  ";
			echo datethaifull(date('Y-m-d'));
		?>
	
	<span id="time"></span>
	
	
 </span><span class="w3-right">

 <?php if(!$_SESSION['Auser']){ ?>
   <button onclick="document.getElementById('id01').style.display='block'" class="w3-btn w3-green w3-large">Login</button></span>
 <?php }else{ ?>
  <button onclick="JavaScript:window.location='logout.php';" class="w3-btn w3-red w3-large">Logout</button></span>

 <?php } ?>
   </div>   

<!-- Sidenav/menu -->
<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="user.jpg" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8">
      <span>ยินดีต้อนรับ, <strong> <?php echo $_SESSION['Auser']; ?></strong></span><br>
      <a href="#" class="w3-hover-none w3-hover-text-red w3-show-inline-block"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-hover-none w3-hover-text-green w3-show-inline-block"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <?php if($_SESSION['Auser']){?>
  <div class="w3-container">
  
   <a href="index.php" class="w3-padding w3-blue" ><h4 >เมนูหลัก</h4></a>
  </div>
  <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i> Close Menu</a>
  <a href="index.php?p=stu" class="w3-padding "><i class="	fa fa-user-plus fa-fw"></i> ข้อมูลนักเรียน/ลงทะเบียนนักเรียน</a>
  <a href="index.php?p=src" class="w3-padding"><i class="fa fa-search fa-fw"></i> ค้นหาข้อมูล</a>
  <a href="index.php?p=report" class="w3-padding"><i class="	fa fa-area-chart fa-fw"></i> รายงานนักเรียน </a>
  <a href="index.php?p=log" class="w3-padding"><i class="	fa fa-file-text-o fa-fw"></i>  ข้อมูล Log </a>
 <!-- <a href="#" class="w3-padding"><i class="fa fa-bullseye fa-fw"></i> </a>
  <a href="#" class="w3-padding"><i class="fa fa-diamond fa-fw"></i> Orders</a>
  <a href="#" class="w3-padding"><i class="fa fa-bell fa-fw"></i> News</a>
  <a href="#" class="w3-padding"><i class="fa fa-bank fa-fw"></i> General</a>
  <a href="#" class="w3-padding"><i class="fa fa-history fa-fw"></i> History</a> -->
  <a href="index.php?p=set" class="w3-padding"><i class="fa fa-cog fa-fw"></i> ตั้งค่า</a>
   <a href="logout.php" class="w3-padding w3-red"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a><br><br>
  <?php }else{ ?>
  <center>กรุณาเข้าสู่ระบบ  <br>
  <button onclick="document.getElementById('id01').style.display='block'" class="w3-btn w3-green w3-large">Login</button>
  <?php } ?>
  </nav>


<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  
  <header class="w3-container" style="padding-top:22px">
    <h3><b><i class="fa fa-motorcycle w3-xxxlarge"></i> ข้อมูลระบบบันทึกการจอดรถจักรยานยนต์</b></h3>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-sign-in w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
		  <?php
		  $con=Connection();
		  $d = date('Y-m-d');
				$Qcount_in ="SELECT count(*) FROM RFID inner join tb_student59 on RFID.UID = tb_student59.uid inner join Plate on tb_student59.student_id = Plate.sid where date(RFID.datetime) = '$d' and RFID.status = 1 ";
				$count_in = mysqli_query($con,$Qcount_in);	
				$rs_count_in = mysqli_fetch_assoc($count_in);
				echo $rs_count_in['count(*)'];
				//echo $Qcount_in;
			?>
		  
		  </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>จำนวนนักเรียนเข้า</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-sign-out w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
		   <?php
		  $con=Connection();
		  $d = date('Y-m-d');
				$Qcount_out ="SELECT count(*) FROM RFID inner join tb_student59 on RFID.UID = tb_student59.uid inner join Plate on tb_student59.student_id = Plate.sid where date(RFID.datetime) = '$d' and RFID.status = 2 ";
				$count_out = mysqli_query($con,$Qcount_out);	
				$rs_count_out = mysqli_fetch_assoc($count_out);
				echo $rs_count_out['count(*)'];
			?>
		  </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>จำนวนนักเรียนออก</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
		   <?php
		  $con=Connection();
		  $d = date('Y-m-d');
				$Qcount_in ="SELECT count(*) FROM sms inner join tb_student59 on sms.SID = tb_student59.student_id where date(datetime) = '$d' and sms.status = 'success' ";
				$count_in = mysqli_query($con,$Qcount_in);	
				$rs_count_in = mysqli_fetch_assoc($count_in);
				echo $rs_count_in['count(*)'];
			?>
		  </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>ส่ง SMS</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
		  <?php
			$con = Connection();
			$Std = "select count(*) from tb_student59 inner join Plate on tb_student59.student_id = Plate.SID  ";
			$Qstd = mysqli_query($con,$Std);
			$rs_count_all = mysqli_fetch_assoc($Qstd);
			echo $rs_count_all['count(*)']-$rs_count_in['count(*)'];;
			?>
		  </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>จำนวนนักเรียนที่ขาด/ไม่มา</h4>
      </div>
    </div>
  </div>

		<?php 
		include('content.php');
		
		
		?>
  
  <!--
  <div class="w3-container">
    <h5>General Stats</h5>
    <p>New Visitors</p>
    <div class="w3-progress-container w3-grey">
      <div id="myBar" class="w3-progressbar w3-green" style="width:25%">
        <div class="w3-center w3-text-white">+25%</div>
      </div>
    </div>

    <p>New Users</p>
    <div class="w3-progress-container w3-grey">
      <div id="myBar" class="w3-progressbar w3-orange" style="width:50%">
        <div class="w3-center w3-text-white">50%</div>
      </div>
    </div>

    <p>Bounce Rate</p>
    <div class="w3-progress-container w3-grey">
      <div id="myBar" class="w3-progressbar w3-red" style="width:75%">
        <div class="w3-center w3-text-white">75%</div>
      </div>
    </div>
  </div>
  <hr>

  <div class="w3-container">
    <h5>Countries</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <tr>
        <td>United States</td>
        <td>65%</td>
      </tr>
      <tr>
        <td>UK</td>
        <td>15.7%</td>
      </tr>
      <tr>
        <td>Russia</td>
        <td>5.6%</td>
      </tr>
      <tr>
        <td>Spain</td>
        <td>2.1%</td>
      </tr>
      <tr>
        <td>India</td>
        <td>1.9%</td>
      </tr>
      <tr>
        <td>France</td>
        <td>1.5%</td>
      </tr>
    </table><br>
    <button class="w3-btn">More Countries <i class="fa fa-arrow-right"></i></button>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Recent Users</h5>
    <ul class="w3-ul w3-card-4 w3-white">
      <li class="w3-padding-16">
        <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>
        <img src="/w3images/avatar2.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Mike</span><br>
      </li>
      <li class="w3-padding-16">
        <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>
        <img src="/w3images/avatar5.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Jill</span><br>
      </li>
      <li class="w3-padding-16">
        <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>
        <img src="/w3images/avatar6.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Jane</span><br>
      </li>
    </ul>
  </div>
  <hr>

  <div class="w3-container">
    <h5>Recent Comments</h5>
    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="/w3images/avatar3.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
        <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="/w3images/avatar1.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>
  </div>
  -->
  <!-- Login -->
   <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
  
      <div class="w3-center"><br>
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright" title="Close Modal">×</span>
        <img src="user.png" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
      </div>

      <form class="w3-container" method="post" action="chk_login.php">
        <div class="w3-section">
		
				<?php
					$q = $_GET['q'];
					switch($q){
						case 1:
							echo "<script>document.getElementById('failed').style.display = 'block';</script>";
							break;
						case 2:
							echo "<script>document.getElementById('expire').style.display = 'block';</script>";
					}
				?>				
				<br>
		
          <label><b>Username</b></label>
          <input id="usr" class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="usr" required autofocus>
          <label><b>Password</b></label>
          <input id="passwd" class="w3-input w3-border" type="text" placeholder="Enter Password" name="passwd" required>
          <button id="btnLogin" class="w3-btn-block w3-green w3-section w3-padding" type="submit">Login</button>
         <!-- <input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me -->
        </div>
      </form>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>
       <!-- <span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span> -->
      </div>

    </div>
  </div>

  
  
  
  <!------------->
  <br>
  <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-green">Demographic</h5>
        <p>Language</p>
        <p>Country</p>
        <p>City</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-red">System</h5>
        <p>Browser</p>
        <p>OS</p>
        <p>More</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-orange">Target</h5>
        <p>Users</p>
        <p>Active</p>
        <p>Geo</p>
        <p>Interests</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-light-grey">
    <h4>FOOTER</h4>
    <p>Powered by <a href="http://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
  </footer>

  <!-- End page content -->
</div>

<script type="text/javascript">

setInterval(Timer(),1000);

// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
    if (mySidenav.style.display === 'block') {
        mySidenav.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidenav.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidenav with the close button
function w3_close() {
    mySidenav.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>
<?php include("db.php");    ?>


<?php
	session_start();
	
		
	
	
	
?>

<!DOCTYPE html>
<html>
<title>Narathiwat School RFID System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="Chart.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
	
<link rel="stylesheet" href="w3.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>

<body class="w3-light-grey">

<!-- Top container -->

<div class="w3-container w3-top w3-teal w3-large w3-padding" style="z-index:4">
  <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();"><i class="fa fa-bars"></i> Menu</button>
  <span class="w3-left">โรงเรียนนราธิวาส      <i class="fa fa-calendar w3-large"></i>
 
  <?php 			
			echo "วันนี้ :  ";
			echo datethaifull(date('Y-m-d'));
		?>
	
	<span id="time"></span>
	
	
 </span><span class="w3-right">

 <?php if(!$_SESSION['Auser']){ ?>
   <button onclick="document.getElementById('id01').style.display='block'" class="w3-btn w3-green w3-large">Login</button></span>
 <?php }else{ ?>
  <button onclick="JavaScript:window.location='logout.php';" class="w3-btn w3-red w3-large">Logout</button></span>

 <?php } ?>
   </div>   

<!-- Sidenav/menu -->
<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="user.jpg" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8">
      <span>ยินดีต้อนรับ, <strong> <?php echo $_SESSION['Auser']; ?></strong></span><br>
      <a href="#" class="w3-hover-none w3-hover-text-red w3-show-inline-block"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-hover-none w3-hover-text-green w3-show-inline-block"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <?php if($_SESSION['Auser']){?>
  <div class="w3-container">
  
    <h5>เมนูหลัก</h5>
  </div>
  <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>� Close Menu</a>
  <a href="index.php?p=stu" class="w3-padding "><i class="fa fa-users fa-fw"></i> ข้อมูลนักเรียน</a>
  <a href="index.php?p=src" class="w3-padding"><i class="fa fa-eye fa-fw"></i> ค้นหาข้อมูล</a>
  <a href="index.php?p=regis" class="w3-padding"><i class="fa fa-users fa-fw"></i> ลงทะเบียนนักเรียน</a>
 <!-- <a href="#" class="w3-padding"><i class="fa fa-bullseye fa-fw"></i> </a>
  <a href="#" class="w3-padding"><i class="fa fa-diamond fa-fw"></i> Orders</a>
  <a href="#" class="w3-padding"><i class="fa fa-bell fa-fw"></i> News</a>
  <a href="#" class="w3-padding"><i class="fa fa-bank fa-fw"></i> General</a>
  <a href="#" class="w3-padding"><i class="fa fa-history fa-fw"></i> History</a> -->
  <a href="index.php?p=set" class="w3-padding"><i class="fa fa-cog fa-fw"></i> ตั้งค่า</a>
   <a href="logout.php" class="w3-padding"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a><br><br>
  <?php }else{ ?>
  <center>กรุณาเข้าสู่ระบบ  <br>
  <button onclick="document.getElementById('id01').style.display='block'" class="w3-btn w3-green w3-large">Login</button>
  <?php } ?>
  </nav>


<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  
  <header class="w3-container" style="padding-top:22px">
    <h3><b><i class="fa fa-motorcycle w3-xxxlarge"></i> ข้อมูลระบบบันทึกการจอดรถจักรยานยนต์</b></h3>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-sign-in w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
		  <?php
		  $con=Connection();
		  $d = date('Y-m-d');
				$Qcount_in ="SELECT count(*) FROM RFID inner join Persons on RFID.UID = Persons.UID inner join Plate on Persons.SID = Plate.sid where date(RFID.datetime) = '$d' and status = 1 ";
				$count_in = mysqli_query($con,$Qcount_in);	
				$rs_count_in = mysqli_fetch_assoc($count_in);
				echo $rs_count_in['count(*)'];
				//echo $Qcount_in;
			?>
		  
		  </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>จำนวนนักเรียนเข้า</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-sign-out w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
		   <?php
		  $con=Connection();
		  $d = date('Y-m-d');
				$Qcount_in ="SELECT count(*) FROM RFID inner join Persons on RFID.UID = Persons.UID inner join Plate on Persons.SID = Plate.sid where date(RFID.datetime) = '$d' and status = 2 ";
				$count_in = mysqli_query($con,$Qcount_in);	
				$rs_count_in = mysqli_fetch_assoc($count_in);
				echo $rs_count_in['count(*)'];
			?>
		  </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>จำนวนนักเรียนออก</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
		   <?php
		  $con=Connection();
		  $d = date('Y-m-d');
				$Qcount_in ="SELECT count(*) FROM sms inner join Persons on sms.SID = Persons.SID where date(datetime) = '$d' and status = 'success' ";
				$count_in = mysqli_query($con,$Qcount_in);	
				$rs_count_in = mysqli_fetch_assoc($count_in);
				echo $rs_count_in['count(*)'];
			?>
		  </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>ส่ง SMS</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
		  <?php
			$con = Connection();
			$Std = "select count(*) from tb_student59 inner join Plate on tb_student59.student_id = Plate.SID  ";
			$Qstd = mysqli_query($con,$Std);
			$rs_count_all = mysqli_fetch_assoc($Qstd);
			echo $rs_count_all['count(*)'];
			?>
		  </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>จำนวนนักเรียนทั้งหมด</h4>
      </div>
    </div>
  </div>

		<?php 
		include('content.php');
		
		
		?>
  
  <!--
  <div class="w3-container">
    <h5>General Stats</h5>
    <p>New Visitors</p>
    <div class="w3-progress-container w3-grey">
      <div id="myBar" class="w3-progressbar w3-green" style="width:25%">
        <div class="w3-center w3-text-white">+25%</div>
      </div>
    </div>

    <p>New Users</p>
    <div class="w3-progress-container w3-grey">
      <div id="myBar" class="w3-progressbar w3-orange" style="width:50%">
        <div class="w3-center w3-text-white">50%</div>
      </div>
    </div>

    <p>Bounce Rate</p>
    <div class="w3-progress-container w3-grey">
      <div id="myBar" class="w3-progressbar w3-red" style="width:75%">
        <div class="w3-center w3-text-white">75%</div>
      </div>
    </div>
  </div>
  <hr>

  <div class="w3-container">
    <h5>Countries</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <tr>
        <td>United States</td>
        <td>65%</td>
      </tr>
      <tr>
        <td>UK</td>
        <td>15.7%</td>
      </tr>
      <tr>
        <td>Russia</td>
        <td>5.6%</td>
      </tr>
      <tr>
        <td>Spain</td>
        <td>2.1%</td>
      </tr>
      <tr>
        <td>India</td>
        <td>1.9%</td>
      </tr>
      <tr>
        <td>France</td>
        <td>1.5%</td>
      </tr>
    </table><br>
    <button class="w3-btn">More Countries �<i class="fa fa-arrow-right"></i></button>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Recent Users</h5>
    <ul class="w3-ul w3-card-4 w3-white">
      <li class="w3-padding-16">
        <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>
        <img src="/w3images/avatar2.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Mike</span><br>
      </li>
      <li class="w3-padding-16">
        <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>
        <img src="/w3images/avatar5.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Jill</span><br>
      </li>
      <li class="w3-padding-16">
        <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>
        <img src="/w3images/avatar6.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Jane</span><br>
      </li>
    </ul>
  </div>
  <hr>

  <div class="w3-container">
    <h5>Recent Comments</h5>
    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="/w3images/avatar3.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
        <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="/w3images/avatar1.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>
  </div>
  -->
  <!-- Login -->
   <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
  
      <div class="w3-center"><br>
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright" title="Close Modal">×</span>
        <img src="user.png" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
      </div>

      <form class="w3-container" method="post" action="chk_login.php">
        <div class="w3-section">
		
				<?php
					$q = $_GET['q'];
					switch($q){
						case 1:
							echo "<script>document.getElementById('failed').style.display = 'block';</script>";
							break;
						case 2:
							echo "<script>document.getElementById('expire').style.display = 'block';</script>";
					}
				?>				
				<br>
		
          <label><b>Username</b></label>
          <input id="usr" class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="usr" required autofocus>
          <label><b>Password</b></label>
          <input id="passwd" type="password" class="w3-input w3-border" type="text" placeholder="Enter Password" name="passwd" required>
          <button id="btnLogin" class="w3-btn-block w3-green w3-section w3-padding" type="submit">Login</button>
         <!-- <input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me -->
        </div>
      </form>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>
       <!-- <span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span> -->
      </div>

    </div>
  </div>

  
  
  
  <!------------->
  <br>
  <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
 
    </div>
  </div>

  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-light-grey">
    <h4>โรงเรียนยนราธิวาส</h4>
    <p> <a href="http://192.168.88.250/nts/" target="_blank"></a></p>
  </footer>

  <!-- End page content -->
</div>

<script type="text/javascript">

setInterval(Timer(),1000);

// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
    if (mySidenav.style.display === 'block') {
        mySidenav.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidenav.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidenav with the close button
function w3_close() {
    mySidenav.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>

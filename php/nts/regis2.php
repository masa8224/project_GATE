<?php
include('db.php');
$con = Connection();
echo $_POST['tMode'];
$strMode = $_POST['strMode'];
if($strMode == "add")
{
	
	
	if($_POST["strMode"]=="" or  $_POST["plate"]=="" or $_POST["sid"]=="" or $_POST["province"]==""   ){
		
		?> 
			<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>ผิดพลาด!</strong> กรุณากรอกข้อมูลให้ครบถ้วน ก่อน--- บันทึก.
			</div>
			
		<?php
		
	}else{
		
		
		

	$strSQL1 = "INSERT INTO Plate ";
	$strSQL1 .="( `SID`, `brand`, `Model`, `color`,  `plate`, `province`, `tel` ,`sms`) ";
	$strSQL1 .="VALUES ";
	$strSQL1 .="('".$_POST['sid']."', '".$_POST['brand']."', '".$_POST['model']."', 
	'".$_POST['color']."', '".$_POST['plate']."', '".$_POST['province']."', '".$_POST['tel']."' ,'".$_POST['sms']."' ) " ;

	$objQuery = mysqli_query($con,$strSQL1);
	echo $strSQL1;
if($objQuery){

	echo "Insert Done..";
	
}else { echo "Insert Error !!!!!";}
	
}
}
if($strMode == "edit")
{echo $_POST['sms'];
	
	
	if($_POST["strMode"]=="" or  $_POST["plate"]=="" or $_POST["sid"]=="" or $_POST["province"]==""   ){
		
		?> 
			<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>ผิดพลาด!</strong> กรุณากรอกข้อมูลให้ครบถ้วน ก่อน--- บันทึก.
			</div>
			
		<?php
		
	}else{
		
		
		

	$strSQL1 = "UPDATE Plate SET ";
	$strSQL1 .="`SID`='".$_POST['sid']."', `brand`='".$_POST['brand']."', `Model`='".$_POST['model']."', `color`='".$_POST['color']."'
	,  `plate`='".$_POST['plate']."' , `province`='".$_POST['province']."' , `tel`='".$_POST['tel']."', `sms`='".$_POST['sms']."' 
		 where `sid`='".$_POST['sid']."' ";
	
	
	
	$objQuery = mysqli_query($con,$strSQL1);
	echo $strSQL1;
if($objQuery){

	echo "Insert Done..";
	
}else { echo "Insert Error !!!!!";}
	
}
}
?>
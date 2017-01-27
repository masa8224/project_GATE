<?php
   	include("connect.php"); 	
   	echo 'This page is for arduino. ';
	echo 'You have nothing to do here.';
	$mode=$_GET['mode'];
	$date=$_GET['date'];
	$time=$_GET['time'];
	$uid=$_GET['uid'];
	switch ($mode){
		case 1:
			In($date,$time,$uid);
			break;
		case 2:
			Out($date,$time,$uid);
			break;
	}
	function In($date,$time,$adduid){
		$link=Connection();
		$dateCheck = date("Y-m-d");
		$queryCheck = "SELECT * FROM Persons WHERE uid='".$adduid."'";
		$res = mysqli_query($link,$queryCheck);
		if (mysqli_num_rows($res)){
			$queryDateCheck = "SELECT * FROM RFID WHERE UID='".$adduid."' AND date='".$dateCheck."'";
			$check = mysqli_query($link,$queryDateCheck);	
			if (!mysqli_num_rows($check)){
				echo "AGFQR";
				$queryAdd = "INSERT INTO RFID (date,time,UID) VALUES ('$date','$time','$adduid')";
				mysqli_query($link,$queryAdd);
			}else{
				echo "AMUIP";
			}		
		}else{
			echo "ADCBN";
		}
		mysqli_close($link);	
	}	
	function Out($date,$time,$outuid){
		$link=Connection();
		$dateCheck = date("Y-m-d");
		$queryCheck = "SELECT * FROM Persons WHERE uid='".$outuid."'";
		$res = mysqli_query($link,$queryCheck);
		if (mysqli_num_rows($res)){
			$queryDateCheck = "SELECT * FROM RFID WHERE UID='".$outuid."' AND date='".$dateCheck."'";
			$check = mysqli_query($link,$queryDateCheck);	
			if (mysqli_num_rows($check)){
				$queryIsOut = "SELECT * FROM Out WHERE UID='".$outuid."' AND date='".$dateCheck."'";
				$IsOUT = mysqli_query($link,$queryIsOut);
				if (!mysqli_num_rows($IsOUT)){
					echo "AGFQR";
					$queryOut = "INSERT INTO Out (date,time,UID) VALUES ('$date2','$time2','$outuid')";
					mysqli_query($link,$queryOut);
				}else{
					echo "AMUIP";
				}				
			}else{
				echo "AMUIP";
			}		
		}else{
			echo "ADCBN";
		}
		mysqli_close($link);
	}
	
   			
?>
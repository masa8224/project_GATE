ข้อมูลสืบค้นนักเรียนรายคน

<?php include('db.php'); echo $_POST['sid'];?>
<table class="w3-table-all w3-hoverable w3-bordered w3-centered" >
<thead>
  <tr >
   <th > <div align="center">ลำดับ</div></th>
    <th > <div align="center">รหัสนักเรียน</div></th>
	
      <th > <div align="center">ชื่อ-นามสกุล</div></th>
   

	<th > <div align="center">ระดับชั้น</div></th>
	<th > <div align="center">เบอร์โทรผู้ปกครอง</div></th>
	<th > <div align="center">สถานะส่ง SMS</div></th>
	    <th > <div align="center">วันที่ เวลา</div></th>
		<th > <div align="center">สถานะ</div></th>
		
		 
		 <th > <div align="center">เครื่องมือ</div></th>

  </tr>
<?php
$con = Connection();
		$src = "select *, RFID.status as in_out from tb_present, RFID inner join tb_student59 on RFID.UID = tb_student59.uid 
		where student_id = '".$_POST['sid']."' order by RFID.datetime desc ";
		$Qsrc = mysqli_query($con,$src);
	 //echo $src;
		while( $rs = mysqli_fetch_array($Qsrc)){
			$i =1;
?>
 <tr>
  <td><?php echo $i; ?></td>
  <td><?php echo $rs['student_id']; ?></td>
 
  <td class="w3-left"><?php echo $rs['title_name'].$rs['s_firstname']." ".$rs['s_lastname'];; ?></td>
  <td><?php echo "ม.".($rs['present']-$rs['year_in']+$rs['class'])."/".$rs['room']; ?></td>
  <td><?php echo $rs['guard_tel']; ?></td>
  <td><?php if($rs['sms']==1){ echo "ส่งSMS"; }   ?></td>
  <td><?php echo $rs['datetime']; ?></td>
  <td><?php echo $rs['in_out']; ?></td>

  <td></td>
  </tr>
  <?php $i++; } ?>

</table>

<?php	//echo "stu"; ?>
<script>
$('document').ready(function(){
	$('#form_add').hide();
$('#show_form_add').click(function(){
				$('#form_add').slideDown();
			});
			$('#btn_close').click(function(){
				$('#form_add').slideUp();
			});
			});
</script>
<?php 
	$con = Connection();
	$Std = "select * from tb_present, log inner join tb_student59 
	on log.uid = tb_student59.uid order by datetime desc";
	$Qstd = mysqli_query($con,$Std);
	//echo $Std;
	
	$count = mysqli_num_rows($Qstd);
	
?>
<center>
<h2>ข้อมูลที่บันทึกเข้าสู่ระบบเรียงลำดับล่าสุด <span class="w3-badge w3-teal">  </h2>

<div id="form_add"><?php include('regis.php'); ?> </div></div>
<p>
<table class="w3-table-all w3-hoverable w3-bordered w3-centered" >
<thead>
  <tr >
   <th > <div align="center">ลำดับ</div></th>
    <th > <div align="center">รหัสนักเรียน</div></th>
	
      <th > <div align="center">ชื่อ-นามสกุล</div></th>
   

	<th > <div align="center">ระดับชั้น</div></th>
	<th > <div align="center">UID</div></th>
	<th > <div align="center">วันที่  เวลา</div></th>
	    <th > <div align="center">เข้า-ออก</div></th>


  </tr>
  <?php
  
  while($rs = mysqli_fetch_array($Qstd)){
	$i++;    
	  
  ?>
  <tr>
  <td><?php echo $i; ?></td>
  <td><?php echo $rs['student_id']; ?></td>
 
  <td class="w3-left"><?php echo $rs['title_name'].$rs['s_firstname']." ".$rs['s_lastname'];; ?></td>
  <td><?php echo "ม.".($rs['present']-$rs['year_in']+$rs['class'])."/".$rs['room']; ?></td>
  <td><?php echo $rs['uid']; ?></td>
  <td><?php echo $rs['datetime'];   ?></td>
  <td><?php  if($rs['status']==2){ echo "ออก"; }else{ echo "เข้า"; } ?></td>

  <td></td>
  </tr>
  <?php } ?>
  </table>